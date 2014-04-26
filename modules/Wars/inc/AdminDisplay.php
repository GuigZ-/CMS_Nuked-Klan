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
                                    <a class="tablectrl_medium bDefault tipS nkIcons icon-edit" href="<?php echo nkGetLink(false, null, array("op" => "edit", "id" => $value['id'])); ?>"></a>
                                    <a class="tablectrl_medium bDefault tipS nkIcons icon-delete"  href="<?php echo nkGetLink(false, null, array("op" => "del", "id" => $value['id'])); ?>"></a>
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
                // Create component
                var content = document.createElement('div');
                content.setAttribute('class', 'formRow last map');

                // Maps
                // Create first col
                var maps = document.createElement('div');
                maps.setAttribute('class', 'grid2 searchDrop');
                // Create select
                var selectMaps = document.createElement('select');
                selectMaps.setAttribute('name', 'map['+maps_nb+'][map]');
                // Add element to select
                for (k in jsonTab) {
                    if (k == game_id) {
                        var listMaps = jsonTab[k].maps;

                        var option = document.createElement('option');
                        option.setAttribute('value', '');

                        var text = document.createTextNode('<?php echo CHOOSE; ?>');
                        option.appendChild(text);
                        selectMaps.appendChild(option);

                        for (j in listMaps) {
                            var option = document.createElement('option');
                            option.setAttribute('value', j);
                            // If map selected
                            if (typeof(d) !== 'undefined' && d.map === j) {
                                option.setAttribute('selected', true);
                            }

                            var text = document.createTextNode(listMaps[j].name);
                            option.appendChild(text);
                            selectMaps.appendChild(option);
                        }
                    }
                }

                maps.appendChild(selectMaps);

                var t = $("#team").val();
                // Players
                var players = document.createElement('div');
                players.setAttribute('class', 'grid2');
                // Add element to select
                for (i in jsonTab) {
                    if (i == game_id) {
                        // While teams
                        for (j in jsonTab[i].teams) {
                            // If teams
                            if (j == t) {
                                var team = jsonTab[i].teams[j];
                                var num = 0;

                                var nb_players = Object.keys(team.players).length;

                                var cols = parseFloat(nb_players / 3);
                                var grid;

                                if (cols <= 1) {
                                    grid = '12';
                                }
                                else if (cols <= 2) {
                                    grid = '6';
                                }
                                else {
                                    grid = '4';
                                }

                                // While players
                                for (k in team.players) {
                                    var player = document.createElement('div');
                                    player.setAttribute('class', 'grid6');
                                    var checkbox = document.createElement('input');
                                    checkbox.setAttribute('name', 'map['+maps_nb+'][players][]');
                                    checkbox.setAttribute('id', 'player_'+maps_nb+'_'+k);
                                    checkbox.setAttribute('type', 'checkbox');
                                    checkbox.setAttribute('value', k);
                                    if (typeof(d) !== 'undefined' && typeof(d.players) === 'object' && inArray(k, d.players)) {
                                        checkbox.setAttribute('checked', true);
                                    }

                                    var label = document.createElement('label');
                                    label.setAttribute('for', 'player_'+maps_nb+'_'+k);

                                    var text = document.createTextNode(team.players[k]);

                                    label.appendChild(text);

                                    player.appendChild(checkbox);
                                    player.appendChild(label);

                                    num++;
                                    if (num % 2 === 0 && nb_players > num) {
                                        var clearBoth = document.createElement('div');
                                        clearBoth.setAttribute('class', 'clear both');
                                        player.appendChild(clearBoth);
                                    }
                                    players.appendChild(player);
                                }

                            }
                        }
                    }
                }

                // substitute
                var substitute = document.createElement('div');
                substitute.setAttribute('class', 'grid2');
                // Add element to select
                for (i in jsonTab) {
                    if (i == game_id) {
                        // While teams
                        for (j in jsonTab[i].teams) {
                            // If teams
                            if (j == t) {
                                var team = jsonTab[i].teams[j];
                                var num = 0;

                                var nb_substitute = Object.keys(team.players).length;

                                var cols = parseFloat(nb_substitute / 3);
                                var grid;

                                if (cols <= 1) {
                                    grid = '12';
                                }
                                else if (cols <= 2) {
                                    grid = '6';
                                }
                                else {
                                    grid = '4';
                                }

                                // While substitute
                                for (k in team.players) {
                                    var player = document.createElement('div');
                                    player.setAttribute('class', 'grid6');
                                    var checkbox = document.createElement('input');
                                    checkbox.setAttribute('name', 'map['+maps_nb+'][substitute][]');
                                    checkbox.setAttribute('id', 'substitute_'+maps_nb+'_'+k);
                                    checkbox.setAttribute('type', 'checkbox');
                                    checkbox.setAttribute('value', k);
                                    if (typeof(d) !== 'undefined' && typeof(d.substitute) === 'object' && inArray(k, d.substitute)) {
                                        checkbox.setAttribute('checked', true);
                                    }

                                    var label = document.createElement('label');
                                    label.setAttribute('for', 'substitute_'+maps_nb+'_'+k);

                                    var text = document.createTextNode(team.players[k]);

                                    label.appendChild(text);

                                    player.appendChild(checkbox);
                                    player.appendChild(label);

                                    num++;
                                    if (num % 2 === 0 && nb_substitute > num) {
                                        var clearBoth = document.createElement('div');
                                        clearBoth.setAttribute('class', 'clear both');
                                        player.appendChild(clearBoth);
                                    }
                                    substitute.appendChild(player);
                                }

                            }
                        }
                    }
                }

                // Score
                var score = document.createElement('div');
                score.setAttribute('class', 'grid1');
                var inputScore = document.createElement('input');
                inputScore.setAttribute('name', 'map['+maps_nb+'][score]');
                inputScore.setAttribute('type', 'text');
                inputScore.setAttribute('placeholder', 'Score');
                inputScore.setAttribute('value', (typeof(d) !== 'undefined' && d.score ? d.score : ''));
                score.appendChild(inputScore);

                // Mod de jeu
                var mod = document.createElement('div');
                mod.setAttribute('class', 'grid1');
                var inputMod = document.createElement('input');
                inputMod.setAttribute('name', 'map['+maps_nb+'][mod]');
                inputMod.setAttribute('type', 'text');
                inputMod.setAttribute('placeholder', 'Mode de jeu');
                inputMod.setAttribute('value', (typeof(d) !== 'undefined' && d.mod ? d.mod : ''));
                mod.appendChild(inputMod);

                // Adversaire
                var opponent = document.createElement('div');
                opponent.setAttribute('class', 'grid2');
                var inputOpponent = document.createElement('textarea');
                inputOpponent.setAttribute('name', 'map['+maps_nb+'][opponent]');
                inputOpponent.setAttribute('placeholder', 'Adversaires : Séparer les adversaires par une virgule');
                inputOpponent.innerHTML = (typeof(d) !== 'undefined' && d.opponent ? d.opponent : '');
                inputOpponent.setAttribute('rows', 4);
                opponent.appendChild(inputOpponent);

                // time
                var time = document.createElement('div');
                time.setAttribute('class', 'grid1');
                var inputTime = document.createElement('input');
                inputTime.setAttribute('name', 'map['+maps_nb+'][time]');
                inputTime.setAttribute('type', 'text');
                inputTime.setAttribute('placeholder', 'Durée de la map');
                inputTime.setAttribute('value', (typeof(d) !== 'undefined' && d.time ? d.time : ''));
                time.appendChild(inputTime);

                var btnDelete = document.createElement('div');
                btnDelete.setAttribute('class', 'grid2 center btnDelete');
                var buttonDelete = document.createElement('a');
                buttonDelete.setAttribute('class', 'nkIcons icon-delete bDefault tablectrl_medium tipS floatR');
                btnDelete.appendChild(buttonDelete);

                maps_nb++;

                // Create .clear
                var clearBoth = document.createElement('div');
                clearBoth.setAttribute('class', 'clear both');
                // Insert elements
                content.appendChild(maps);
                content.appendChild(mod);
                content.appendChild(time);
                content.appendChild(players);
                content.appendChild(substitute);
                content.appendChild(opponent);
                content.appendChild(score);
                content.appendChild(btnDelete);
                content.appendChild(clearBoth);

                $("#mapsbutton").before(content);
                $("#maps .last select").chosen().uniform();
                $("#maps .last input:checkbox").uniform();
                $("#maps .last").removeClass('last');

                $("#maps .btnDelete a").click(function(){
                    $(this).parents('.formRow').remove();
                });

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
        <div class="fluid">
            <!-- Maps -->
            <div class="widget grid12" id="maps">
                <div class="whead">
                    <h6>Cartes</h6>
                    <div class="clear both"></div>
                </div>
                <div class="whead center">
                    <div class="grid2">
                        Carte
                    </div>
                    <div class="grid1">
                        Mode de jeu
                    </div>
                    <div class="grid1">
                        Durée
                    </div>
                    <div class="grid2">
                        Joueurs
                    </div>
                    <div class="grid2">
                        Remplaçants
                    </div>
                    <div class="grid2">
                        Adversaires
                    </div>
                    <div class="grid1">
                        Score
                    </div>
                    <div class="clear both"></div>
                </div>
                <div id="mapsbutton" class="formRow center">
                    <div class="grid12">
                        <a class="buttonM bDefault" href="#mapsbutton">Ajouter une carte</a>
                    </div>
                    <div class="clear both"></div>
                </div>
            </div>
            <!-- /Maps -->
        </div>
        <div class="fluid">
            <div class="widget grid12 center">
                <div class="whead">
                    <h6>Actions</h6>
                    <div class="clear both"></div>
                </div>
                <div class="formRow">
                    <input type="submit" name="btnSubmit" class="buttonM bBlue">
                    <a class="buttonM bDefault" href="<?php echo nkGetLink(); ?>"><?php echo BACK; ?></a>
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

            header('Refresh:0, url='.nkGetLink(true, null, array('op' => 'matchs')));

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
