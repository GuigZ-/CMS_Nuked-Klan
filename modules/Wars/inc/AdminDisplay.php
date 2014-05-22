<?php
/**
 * Admin page of Team Mod
 *
 * @version     1.8
 * @link http://www.nuked-klan.org Clan Clan Management System for Gamers
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @copyright 2001-2013 Nuked-Klan (Registred Trademark)
 */
defined('INDEX_CHECK') or die('You can\'t run this file alone.');

require_once 'modules/Wars/inc/functions.php';

/**
 * Afficheur
 */
function WarsDisplayAdmin () {

    if (!($op = nkGetValue('op')) || $op === 'index') {
        $op = "matchs";
    }

    if (!$action = nkGetValue('action')) {
        $action = "list";
    }

    $id = null;

    if (($op === 'edit' || $op === 'del') && preg_match("#^[0-9]+$#isD", nkGetValue('id'))) {
        $id = nkGetValue('id');
    }


    // Message de process
    echo '<div class="nNote nWarning nNoteHideabl"><p>En cours de développement</p></div>';
    ?>

    <div class="content-box">
        <div class="tab-content">
            <?php
                WarsDisplayMenu($op);
                if ($conf = nkGetValue('conf')) {
                    nkDisplayConf($conf);
                }
                postProcess($op, $action, $id);
                WarsDisplayContent($op, $action, $id);
            ?>
        </div>
    </div>
    <?php
}

/**
 * Affiche le menu
 * @param  string $op
 */
function WarsDisplayMenu ($op) {
    $menus = array(
        'matchs'        => array('name' => 'Matches', 'icon' => ''),
        'add'           => array('name' => 'Ajouter', 'icon' => 'add'),
        'settings'      => array('name' => 'Préférences', 'icon' => 'settings'),
    );

    nkDisplayContentMenu($menus, $op);
}

/**
 * Switch content
 * @param string  $op     operator
 * @param string  $action action
 * @param integer $id     identifier
 */
function WarsDisplayContent ($op, $action, $id = null) {
    switch ($op) {
        case 'matchs':
            WarsDisplayList();
            break;
        case 'add':
        case 'edit':
            WarsDisplayForm($id);
            break;
        case 'settings':
            WarsDisplaySettings();
            break;
        default:
            break;
    }
}

/**
 * Display list in BO
 */
function WarsDisplayList () {

    $wars = getMatchs();

    ?>
    <div class="widget">
        <div class="whead">
            <h6>&nbsp;</h6>
            <div class="clear both"></div>
        </div>
        <table class="tDefault" data-table="<?php echo TEAM_TABLE; ?>">
            <thead>
                <tr>
                    <td>
                        <strong>Date :</strong>
                    </td>
                    <td>
                        <strong>Adversaire :</strong>
                    </td>
                    <td>
                        <strong>Pays :</strong>
                    </td>
                    <td>
                        <strong>Actions :</strong>
                    </td>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($wars) && is_array($wars) && count($wars)) {
                    foreach ($wars as $value) {
                        ?>
                            <tr>
                                <td>
                                    <?php
                                    echo nkDate($value['date']);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        echo printSecuTags($value['versus']);
                                    ?>
                                </td>
                                <td>
                                    <img src="assets/images/flags/<?php echo printSecuTags($value['country']); ?>" alt="<?php echo strstr(printSecuTags($value['country']), '.', true); ?>" />
                                    <?php echo strstr(printSecuTags($value['country']), '.', true);
                                    ?>
                                </td>
                                <td class="center">
                                    <a class="tablectrl_medium bDefault tipS nkIcons icon-edit" href="<?php echo NkSetLink(false, null, array("op" => "edit", "id" => $value['id'])); ?>"></a>
                                    <a class="tablectrl_medium bDefault tipS nkIcons icon-delete"  href="<?php echo NkSetLink(false, null, array("op" => "del", "id" => $value['id'])); ?>"></a>
                                </td>
                            </tr>
                        <?php
                    }
                }
                else {
                ?>
                    <tr>
                        <td colspan="4">
                            <div class="nNote nWarning nNoteHideable">
                                <p>
                                    Il n'y a pas de match pour le moment
                                </p>
                            </div>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
}

/**
 * Display form
 * @param integer $id Identifier
 */
function WarsDisplayForm ($id = fale) {

    $json = MatchGetJsonTab();
    $games = nkGEtGames();

    $countries = nkGetCountries();
    if ($id) {
        $match = getMatchs((int)$id);
        $versus = nkGetValue('versus', $match['versus']);
        $game_id = nkGetValue('game', $match['game_id']);
        $link = nkGetValue('link', $match['link']);
        $country = nkGetValue('country', $match['country']);
        $status = nkGetValue('status', $match['status']);
        $date = nkGetValue('date', strftime('%Y-%m-%d %H:%M', $match['date']));
        $type = nkGetValue('type', $match['type']);
        $report = nkGetValue('report', $match['report']);
        $tournament = nkGetValue('tournament', $match['tournament']);
        $url_tournament = nkGetValue('url_tournament', $match['url_tournament']);
        $team = nkGetValue('team', $match['team_id']);
        $map = nkGetValue('map', $match['map']);
    }
    else {
        $versus = nkGetValue('versus');
        $game_id = nkGetValue('game', '0');
        $link = nkGetValue('link');
        $country = nkGetValue('country', 'France.gif');
        $status = nkGetValue('status');
        $date = nkGetValue('date', strftime('%Y-%m-%d %H:%M'));
        $type = nkGetValue('type');
        $report = nkGetValue('report');
        $tournament = nkGetValue('tournament');
        $url_tournament = nkGetValue('url_tournament');
        $team = nkGetValue('team', 0);
        $map = nkGetValue('map');
    }

    ?>
    <script type="text/javascript">
        var jsonTab = <?php echo $json; ?>;
        var game_id = <?php echo (int) $game_id; ?>;
        var defaultOption = '<option value=""><?php echo CHOOSE; ?></option>';
        var maps_nb = 0;
        var files_nb = 0;

        Object.size = function() {
            return keys(this).array;
        }

        $(function(){

            maps_nb = $('#maps > .formRow').not('.center').length;
            files_nb = $('#files > .formRow').not('.center').length;

            $(".datetimepicker").datetimepicker(
                {
                    controlType : 'select',
                    showTime : false,
                    dateFormat : 'yy-mm-dd'
                }
            );

            $("#game").change(function(){
                game_id = $(this).val();
                setSelectTeam();
            });

            $("#mapsbutton a").click(function(e, d){
                if (!parseInt($("#game").val()))
                {
                    alert('Merci de sélectionner un jeu');
                    return false;
                }
                if (!parseInt($("#team").val()))
                {
                    alert('Merci de sélectionner une équipe');
                    return false;
                }

                var div = $('<div class="fluid"><div class="widget map last grid12"><div class="whead hand collapsible" id="map_collapsible_'+ (maps_nb + 1) +'"><h6>Map n°'+ (maps_nb + 1) +'</h6><a href="#" class="headIcon icon-delete nkIcons tipS" original-title="download"></a><div class="clear both"></div></div><div class="body nopadding"></div></div></div>');

                // Insertion
                $("#mapsbutton").before(div);
                // On récupère pour travailler dessus
                var map = $(".map.last > .body");

                // Création des tabs
                map.append('<ul class="tabs"><li><a href="#map_'+maps_nb+'_tab_1">Informations</a></li><li><a href="#map_'+maps_nb+'_tab_2">Joueurs</a></li></ul><a href="#" class="headIcon icon-download tipS" original-title="download"></a>');

                // Création de la tab des informations
                var tab_content = '<div id="map_'+maps_nb+'_tab_1" class="tab_content">';

                var options = '<option value=""></option>';

                for (k in jsonTab) {
                    if (k == game_id) {
                        var listMaps = jsonTab[k].maps;

                        for (j in listMaps) {
                            var selected = false;
                            if (typeof(d) !== 'undefined' && typeof(d.map) === 'string' && d.map === j) {
                                selected = true;
                            }

                            options += '<option value="'+j+'"'+ (selected === true ? ' selected' : '') +'>'+listMaps[j].name+'</option>';
                        }

                    }
                }

                var local = (typeof(d) !== "undefined" && typeof(d.score) !== "undefined" && typeof(d.score.local) !== "undefined" && d.score.local != "" ? d.score.local : '');
                var visitor = (typeof(d) !== "undefined" && typeof(d.score) !== "undefined" && typeof(d.score.visitor) !== "undefined" && d.score.visitor != "" ? d.score.visitor : '');

                // Choix de la map
                tab_content += '<div class="formRow"><div class="grid3"><label for="map_'+maps_nb+'_map">Choisir la carte :</label></div><div class="grid9 searchDrop"><select class="select" name="map['+maps_nb+'][map]" id="map_'+maps_nb+'_map">'+options+'</select></div><div class="clear both"></div></div>';
                // Score
                tab_content += '<div class="formRow"><div class="grid3"><label>Score de la carte :</label></div><div class="grid9 moreFields"><ul class="rowData"><li><input type="text" value="' + local + '" placeholder="Local" name="map['+maps_nb+'][score][local]" /></li><li class="sep">-</li><li><input type="text" value="' + visitor + '" placeholder="Visiteur" name="map['+maps_nb+'][score][visitor]" /></li></ul></div><div class="clear both"></div></div>';
                // Mode de jeu
                tab_content += '<div class="formRow"><div class="grid3"><label for="map_'+maps_nb+'_mod">Mode de la carte :</label></div><div class="grid9"><input type="text" name="map['+maps_nb+'][mod]" id="map_'+maps_nb+'_mod" /></div><div class="clear both"></div></div>';
                // Mode de jeu
                tab_content += '<div class="formRow"><div class="grid3"><label for="map_'+maps_nb+'_time">Temps de la carte :</label></div><div class="grid9"><input type="text" name="map['+maps_nb+'][time]" id="map_'+maps_nb+'_time" /></div><div class="clear both"></div></div>';

                // Fin de la tab des informations
                tab_content += '</div>';

                // Début tab des joueurs
                tab_content += '<div id="map_'+maps_nb+'_tab_2" class="tab_content">';
                var players_content = '';

                // List players
                var t = $("#team").val();
                for (i in jsonTab) {
                    if (i == game_id) {
                        // While teams
                        for (j in jsonTab[i].teams) {
                            // If teams
                            if (j == t) {
                                var team = jsonTab[i].teams[j];
                                for (k in team.players) {
                                    var playerChecked = substituteChecked = false;
                                    if (typeof(d) !== 'undefined' && typeof(d.players) === 'object' && inArray(k, d.players)) {
                                        playerChecked = true;
                                    }
                                    if (typeof(d) !== 'undefined' && typeof(d.substitute) === 'object' && inArray(k, d.substitute)) {
                                        substituteChecked = true;
                                    }
                                    players_content += '<tr><td>'+team.players[k]+'</td><td><input type="checkbox" value="'+k+'" name="map['+maps_nb+'][players][]"'+ (playerChecked === true ? ' checked' : '') +' /></td><td><input type="checkbox" value="'+k+'" name="map['+maps_nb+'][substitute][]"'+ (substituteChecked === true ? ' checked' : '') +' /></td></tr>';
                                }
                            }
                        }
                    }
                }

                // table contenant les joueurs
                tab_content += '<table class="tDefault"><thead><td>Joueur</td><td width="20px">J</td><td width="20px">R</td></thead><tbody>'+players_content+'</tbody></table>';

                // Fin tab des joueurs
                tab_content += '</div>';

                map.append('<div class="tab_container">'+tab_content+'</div>');

                map.contentTabs();
                map.find("select").chosen().uniform();
                map.find("input:checkbox").uniform();
                map.parent().removeClass('last');

               //===== Collapsible elements management =====//

                $('#map_collapsible_'+ (maps_nb + 1)).collapsible({
                    defaultOpen: 'map_collapsible_'+ (maps_nb + 1),
                    cssOpen: 'inactive',
                    cssClose: 'normal',
                    speed: 200
                });

                map.parent('.map').find('.whead > .icon-delete').unbind('click').click(function(){
                   $(this).parents('.fluid').remove();
                    return false;
                });

                maps_nb++;

                return false;
            });

            $("#filebutton a").click(function(){
                var content = document.createElement('div');
                content.setAttribute('class', 'formRow last');

                var contentLabel = document.createElement('div');
                contentLabel.setAttribute('class', 'grid3');

                var label = document.createElement('label');
                label.setAttribute('for', 'file_' + files_nb);

                var name = document.createTextNode('Fichier n°' + (files_nb + 1));
                label.appendChild(name);

                contentLabel.appendChild(label);

                var contentInput = document.createElement('div');
                contentInput.setAttribute('class', 'grid6');

                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('name', 'file[]');
                input.setAttribute('id', 'file_' + files_nb);

                contentInput.appendChild(input);

                var contentDelete = document.createElement('div');
                contentDelete.setAttribute('class', 'grid3 center btnDelete');

                var buttonDelete = document.createElement('a');
                buttonDelete.setAttribute('class', 'nkIcons icon-delete bDefault tablectrl_medium tipS floatR');
                contentDelete.appendChild(buttonDelete);

                content.appendChild(contentLabel);
                content.appendChild(contentInput);
                content.appendChild(contentDelete);

                var clearBoth = document.createElement('div');
                clearBoth.setAttribute('class', 'clear both');

                content.appendChild(clearBoth);

                $('#filebutton').before(content);
                $('#files .last input:file').uniform();

                $("#files .btnDelete a").click(function(){
                    $(this).parents('.formRow').remove();
                });

                $("#files .last").removeClass('last');
                files_nb++;

                return false;
            });

            setSelectTeam(<?php echo $team; ?>);

            <?php

            if (is_array($map) && sizeof($map)) {
                ?>
                    var jsonMap = <?php echo json_encode($map); ?>;
                    for (key in jsonMap) {
                        $("#mapsbutton a").trigger('click', {
                            map : jsonMap[key].map,
                            players : jsonMap[key].players,
                            substitute : jsonMap[key].substitute,
                            score : jsonMap[key].score,
                            mod : jsonMap[key].mod,
                            opponent : jsonMap[key].opponent,
                            time : jsonMap[key].time
                        });
                    }
                <?php
            }

            ?>
        });

        function setSelectTeam (t) {
            var element = $("div[data-form=team]");
            element.html('<select name="team" id="team" class="select">'+defaultOption+'</select>');
            for (i in jsonTab) {
                if (i == game_id) {
                    var teams = jsonTab[i].teams;
                    for (j in teams) {
                        element.find('select').append('<option value="'+j+'"'+(parseInt(t) && parseInt(j) === parseInt(t) ? ' selected' : '')+'>'+teams[j].name+'</option>');
                    }
                }
            }
            element.find('select').chosen().uniform();
        }

        function inArray(needle, haystack) {
            var length = haystack.length;
            for(var i = 0; i < length; i++) {
                if(haystack[i] == needle) {
                    return true;
                }
            }
            return false;
        }
    </script>
    <form action="" method="POST" class="form" autocomplete="off" enctype="multipart/form-data">
        <div class="fluid">
            <!-- Information -->
            <div class="widget grid6">
                <div class="whead">
                    <h6>Informations générales</h6>
                    <div class="clear both"></div>
                </div>
                <div class="formRow">
                    <div class="grid3">
                        <label for="status">Statut :</label>
                    </div>
                    <div class="grid9 searchDrop">
                        <select name="status" id="status" class="select">
                            <option value=""><?php echo CHOOSE; ?></option>
                            <option value="0"<?php echo ($status == 0 ? ' selected' : ''); ?>>A jouer</option>
                            <option value="1"<?php echo ($status == 1 ? ' selected' : ''); ?>>Terminé</option>
                        </select>
                    </div>
                    <div class="clear both"></div>
                </div>
                <div class="formRow">
                    <div class="grid3">
                        <label for="date">Date :</label>
                    </div>
                    <div class="grid2">
                        <input type="text" name="date" id="date" class="datetimepicker" value="<?php echo $date; ?>" />
                    </div>
                    <div class="clear both"></div>
                </div>
                <div class="formRow">
                    <div class="grid3">
                        <label for="game">Jeu :</label>
                    </div>
                    <div class="grid9 searchDrop">
                        <select name="game" id="game" class="select">
                            <option value=""><?php echo CHOOSE; ?></option>
                            <?php
                            if (isset($games) && is_array($games) && sizeof($games)) {
                                foreach ($games as $game) {
                                    ?>
                                        <option value="<?php echo printSecuTags($game['id']); ?>"<?php echo ($game['id'] == $game_id ? ' selected' : ''); ?>><?php echo printSecuTags($game['name']); ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="clear both"></div>
                </div>
                <div class="formRow">
                    <div class="grid3">
                        <label for="team">&Eacute;quipe</label>
                    </div>
                    <div class="grid9 searchDrop" data-form="team">
                        <select name="team" id="team" class="select">
                            <option value=""><?php echo CHOOSE; ?></option>
                        </select>
                    </div>
                    <div class="clear both"></div>
                </div>
                <div class="formRow">
                    <div class="grid3">
                        <label for="type">Type :</label>
                    </div>
                    <div class="grid9 searchDrop">
                        <input type="text" name="type" id="type" value="<?php echo $type; ?>" />
                    </div>
                    <div class="clear both"></div>
                </div>
                <div class="formRow">
                    <div class="grid3">
                        <label for="report">Rapport :</label>
                    </div>
                    <div class="grid9 searchDrop">
                        <textarea name="report" id="report" class="editor"><?php echo $report; ?></textarea>
                    </div>
                    <div class="clear both"></div>
                </div>
            </div>
            <!-- /Information -->
            <!-- Versus informations -->
            <div class="widget grid6">
                <div class="whead">
                    <h6>Adversaire</h6>
                    <div class="clear both"></div>
                </div>
                <div class="formRow">
                    <div class="grid3">
                        <label for="name">Adversaire :</label>
                    </div>
                    <div class="grid9">
                        <input type="text" id="versus" name="versus" value="<?php echo $versus; ?>"/>
                    </div>
                    <div class="clear both"></div>
                </div>
                <div class="formRow">
                    <div class="grid3">
                        <label for="link">Site web :</label>
                    </div>
                    <div class="grid9">
                        <input type="text" id="link" name="link" value="<?php echo $link; ?>"/>
                    </div>
                    <div class="clear both"></div>
                </div>
                <div class="formRow">
                    <div class="grid3">
                        <label for="icon">Logo :</label>
                    </div>
                    <div class="grid9">
                        <input type="file" id="icon" name="icon"/>
                    </div>
                    <div class="clear both"></div>
                </div>
                <div class="formRow">
                    <div class="grid3">
                        <label for="country">Pays :</label>
                    </div>
                    <div class="grid9 searchDrop">
                        <select name="country" id="country" class="select">
                            <option value=""><?php echo CHOOSE; ?></option>
                            <?php
                            if (isset($countries) && is_array($countries) && sizeof($countries)) {
                                foreach ($countries as $flag) {
                                    ?>
                                        <option value="<?php echo $flag; ?>"<?php echo ($flag == $country ? ' selected' : ''); ?>>
                                            <?php echo strstr($flag, '.', true); ?>
                                        </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="clear both"></div>
                </div>
            </div>
            <!-- /Versus informations -->
            <!-- Tournament -->
            <div class="widget grid6">
                <div class="whead">
                    <h6>Compétition</h6>
                    <div class="clear both"></div>
                </div>
                <div class="formRow">
                    <div class="grid3">
                        <label for="tournament">Comp&eacute;tition :</label>
                    </div>
                    <div class="grid9 searchDrop">
                        <input type="text" name="tournament" id="tournament" value="<?php echo $tournament; ?>" />
                    </div>
                    <div class="clear both"></div>
                </div>
                <div class="formRow">
                    <div class="grid3">
                        <label for="url_tournament">Site web de la comp&eacute;tition :</label>
                    </div>
                    <div class="grid9 searchDrop">
                        <input type="text" name="url_tournament" id="url_tournament" value="<?php echo $url_tournament; ?>" />
                    </div>
                    <div class="clear both"></div>
                </div>
            </div>
            <!-- /Tournament -->
            <!-- File -->
            <div class="widget grid6" id="files">
                <div class="whead">
                    <h6>Fichiers</h6>
                    <div class="clear both"></div>
                </div>
                <div id="filebutton" class="formRow center">
                    <div class="grid12">
                        <a class="buttonM bDefault" href="#filebutton">Ajouter un fichier</a>
                    </div>
                    <div class="clear both"></div>
                </div>
            </div>
            <!-- /File -->
        </div>
        <div class="divider">
            <span></span>
        </div>
        <div class="fluid" id="mapsbutton">
            <!-- Maps -->
            <div class="widget grid12">
                <div class="formRow center">
                    <div class="grid12">
                        <a class="buttonM bDefault" href="#mapsbutton">Ajouter une carte</a>
                    </div>
                    <div class="clear both"></div>
                </div>
            </div>
            <!-- /Maps -->
        </div>
        <div class="divider">
            <span></span>
        </div>
        <div class="fluid">
            <div class="widget grid12 center">
                <div class="whead">
                    <h6>Actions</h6>
                    <div class="clear both"></div>
                </div>
                <div class="formRow">
                    <input type="submit" name="btnSubmit" class="buttonM bBlue">
                    <a class="buttonM bDefault" href="<?php echo NkSetLink(); ?>"><?php echo BACK; ?></a>
                </div>
            </div>
        </div>
    </form>
    <?php
}

/**
 * Processus
 * @param  string $op     Opération
 * @param  string $action Action
 * @param  string $id     Identifier
 * @return mixed          Données retournées
 */
function postProcess ($op, $action, $id) {
    if ($op === 'add' || ($op === 'edit' && $id)) {
        if (nkGetValue('btnSubmit')) {
            // Champs requis
            if (!nkGetValue('game')) {
                ?>
                    <div class="nNote nFailure nNoteHideable">
                        <p>
                            <?php
                            echo 'Merci de choisir un jeu';
                            ?>
                        </p>
                    </div>
                <?php
                return;
            }
            if (!nkGetValue('team')) {
                ?>
                    <div class="nNote nFailure nNoteHideable">
                        <p>
                            <?php
                            echo 'Merci de choisir une équipe';
                            ?>
                        </p>
                    </div>
                <?php
                return;
            }
            if (!nkGetValue('versus')) {
                ?>
                    <div class="nNote nFailure nNoteHideable">
                        <p>
                            <?php
                            echo 'Merci de choisir un adversaire';
                            ?>
                        </p>
                    </div>
                <?php
                return;
            }
            if (($link = nkGetValue('link')) && !nkIsLink($link)) {
                ?>
                    <div class="nNote nFailure nNoteHideable">
                        <p>
                            <?php
                            echo 'Le lien du site de votre adversaire n\'est pas valide';
                            ?>
                        </p>
                    </div>
                <?php
                return;
            }
            if (($url_tournament = nkGetValue('url_tournament')) && !nkIsLink($url_tournament)) {
                ?>
                    <div class="nNote nFailure nNoteHideable">
                        <p>
                            <?php
                            echo 'Le lien du site de la compétition n\'est pas valide';
                            ?>
                        </p>
                    </div>
                <?php
                return;
            }

            $maps = nkGetValue('map');

            $sqlMaps = array();

            // Check des maps si on est passé à terminer
            if (!$maps && nkGetValue('status') == '1') {
                ?>
                    <div class="nNote nFailure nNoteHideable">
                        <p>
                            <?php
                            echo 'Merci de remplir au moins une carte';
                            ?>
                        </p>
                    </div>
                <?php
                return;
            }
            else {
                // Check les maps
                if ($maps && is_array($maps)) {
                    $i = 0;
                    foreach ($maps as $map) {
                        // Une map sera rempli que si l
                        if (!empty($map['map'])) {
                            $sqlMaps[] = "(NULL, %d, '".printSecuTags($map['map'])."', '".(isset($map['players']) && is_array($map['players']) && sizeof($map['players']) ? printSecuTags(implode(',', $map['players'])) : '')."', '".(isset($map['substitute']) && is_array($map['substitute']) && sizeof($map['substitute']) ? printSecuTags(implode(',', $map['substitute'])) : '')."', '".printSecuTags($map['score'])."', '".printSecuTags($map['mod'])."', '".printSecuTags($map['opponent'])."', '".printSecuTags($map['time'])."')";
                            $i++;
                        }
                    }
                }
            }
            // Si nous avons parcouru les maps et que celles-ci sont mals informés
            if (isset($i) && $i === 0) {
                ?>
                    <div class="nNote nFailure nNoteHideable">
                        <p>
                            <?php
                                echo 'Merci de remplir correctement les informations pour les maps';
                            ?>
                        </p>
                    </div>
                <?php
                return;
            }

            if ($id) {
                // Groups
                $dbdMatchMap = "DELETE FROM " . MATCH_MAP_TABLE . " WHERE match_id = " . $id ;
                mysql_query($dbdMatchMap);
                $dbrSetMatchMap = "UPDATE " . MATCH_TABLE . " SET date = '".strtotime(nkGetValue('date'))."', status = '".printSecuTags(nkGetValue('status'))."', team_id = '".printSecuTags(nkGetValue('team'))."', game_id = '".printSecuTags(nkGetValue('game'))."', versus = '".printSecuTags(nkGetValue('versus'))."', link = '".printSecuTags(nkGetValue('link'))."', country = '".printSecuTags(nkGetValue('country'))."', type = '".printSecuTags(nkGetValue('type'))."', report = '".printSecuTags(nkGetValue('report'))."', tournament = '".printSecuTags(nkGetValue('tournament'))."', url_tournament = '".printSecuTags(nkGetValue('url_tournament'))."' WHERE id = '".$id."'  ";
            }
            else {
                $dbrSetMatchMap = "INSERT INTO " . MATCH_TABLE . " (date, status, team_id, game_id, versus, link, country, type, report, tournament, url_tournament) VALUES ('".strtotime(nkGetValue('date'))."', '".printSecuTags(nkGetValue('status'))."', '".printSecuTags(nkGetValue('team'))."', '".printSecuTags(nkGetValue('game'))."', '".printSecuTags(nkGetValue('versus'))."', '".printSecuTags(nkGetValue('link'))."', '".printSecuTags(nkGetValue('country'))."', '".printSecuTags(nkGetValue('type'))."', '".printSecuTags(nkGetValue('report'))."', '".printSecuTags(nkGetValue('tournament'))."', '".printSecuTags(nkGetValue('url_tournament'))."')";
            }

            mysql_query($dbrSetMatchMap) or die(nk_debug_bt());

            if (!$id) {
                $id = mysql_insert_id();
            }

            if ($sqlMaps && sizeof($sqlMaps)) {
                $dbrSetMatchMap = "INSERT INTO " . MATCH_MAP_TABLE . " VALUES " . preg_replace('#%d#isD', $id, implode(',', $sqlMaps));
                mysql_query($dbrSetMatchMap) or die(nk_debug_bt());
            }

            header('Refresh:0, url='.NkSetLink(true, null, array('op' => 'matchs')));

        }
    }
}

function WarsDisplaySettings() {

    $config = getMatchPrefs();

    ?>
    <form action="" method="POST" class="form" autocomplete="off">
        <div class="fluid">
            <div class="formRow">
                <div class="grid3">
                    <input type="text" name="wars_page" id="wars_page" value="<?php echo $config['match_page'];?>">
                </div>
            </div>
            <div class="grid9">

            </div>
            <div class="clear both"></div>
        </div>
    </form>
    <?php
}

?>
