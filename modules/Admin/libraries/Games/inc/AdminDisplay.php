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

require_once 'modules/Admin/libraries/Games/inc/functions.php';

/**
 * Gestion de l'affichage de l'admin
 */
function GamesDisplayAdmin () {

    if (!($op = nkGetValue('op')) || $op === 'index') {
        $op = "games";
    }

    if (!$action = nkGetValue('action')) {
        $action = "list";
    }

    $id = null;

    if(($action === 'edit' || $action === 'del') && preg_match("#^[0-9]+$#isD", nkGetValue('id'))) {
        $id = nkGetValue('id');
    }


    // Message de process
    echo '<div class="nNote nWarning nNoteHideabl"><p>En cours de développement</p></div>';
    ?>

    <div class="content-box">
        <div class="tab-content">
            <?php
                GamesDisplayMenu($op, $action);
                if ($conf = nkGetValue('conf')) {
                    nkDisplayConf($conf);
                }
                GamesPostProcess($op, $action, $id);
                GamesDisplayContent($op, $action, $id);
            ?>
        </div>
    </div>
    <?php
}

/**
 * Process
 * @param string  $op     Operation
 * @param string  $action Action
 * @param integer $id     Identifier
 */
function GamesPostProcess ($op, $action, $id) {
    if ($op === 'games') {

        $path = dirname(__FILE__) . '/../../../../../Upload/Games/';
        if (($action === 'add' || $action === 'edit') && nkGetValue('btnSubmit')) {
            if (!nkGetValue('name')) {
                ?>
                    <div class="nNote nFailure nNoteHideable">
                        <p>
                            <?php
                                echo 'Merci de remplir correctement le formulaire';
                            ?>
                        </p>
                    </div>
                <?php
            }
            else {

                $dbsExists = 'SELECT COUNT(name) AS total, id, icon FROM ' . GAMES_TABLE . ' WHERE name = "' . mysql_real_escape_string(nkGetValue('name')) . '" ';
                $dbeExists = mysql_query($dbsExists);
                $dbaExists = mysql_fetch_assoc($dbeExists);

                if ($dbaExists['total'] == 0 || ($id && $id == $dbaExists['id'] && $dbaExists['total'] == 1)) {
                    $icon = nkUploadImage('icon', $path);
                    if (!$id && ($icon === true || $icon === false)) {
                        ?>
                            <div class="nNote nFailure nNoteHideable">
                                <p>
                                    <?php
                                        echo 'Merci d\'insérer une image';
                                    ?>
                                </p>
                            </div>
                        <?php
                        return;
                    }

                    if ($id) {
                        $dbrSetGame = "UPDATE " . GAMES_TABLE . " SET name = '".nkGetValue('name')."'".($icon ? ", icon = '".$icon."' " : "") ." WHERE id = '".(int)$id."' ";
                    }
                    else {
                        $dbrSetGame = "INSERT INTO " . GAMES_TABLE . " (name, icon) VALUES ('".nkGetValue('name')."', '".$icon."') ";
                    }

                    if (mysql_query($dbrSetGame)) {
                        header('Refresh:0, url='.nkGetLink(true));
                    }
                }
                else {
                    ?>
                        <div class="nNote nFailure nNoteHideable">
                            <p>
                                <?php
                                    echo 'Le jeu que vous souhaitez enregistrer existe déjà';
                                ?>
                            </p>
                        </div>
                    <?php
                    return;
                }
            }
        }
        else if ($action === 'del') {
            $game = nkGetGames($id);
            if ($game && sizeof($game)) {
                $dbdRanks = 'DELETE FROM ' . GAMES_TABLE . ' WHERE id = ' . (int) $id . ' ';
                $dbdRanksMaps = 'DELETE FROM ' . GAMES_MAP_TABLE . ' WHERE game_id = ' . (int) $id . ' ';

                if (file_exists($path . $game['icon'])) {
                    unlink($path . $game['icon']);
                }

                // execution de la requete
                if (mysql_query($dbdRanks) && mysql_query($dbdRanksMaps)) {
                    header('Refresh:0, url='.nkGetLink(true, 2));
                }
                else {

                    ?>
                        <div class="nNote nFailure nNoteHideable">
                            <p>
                                <?php
                                echo TEAM_QUERY . ' ' . $dbdRanks ;
                                ?>
                            </p>
                        </div>
                    <?php
                }
            }
        }

    }
    else if ($op === 'maps') {

        $path = dirname(__FILE__) . '/../../../../../Upload/Maps/';
        if (($action === 'add' || $action === 'edit') && nkGetValue('btnSubmit')) {
            if (!nkGetValue('name') || !nkGetValue('game')) {
                ?>
                    <div class="nNote nFailure nNoteHideable">
                        <p>
                            <?php
                                echo 'Merci de remplir correctement le formulaire';
                            ?>
                        </p>
                    </div>
                <?php
            }
            else {
                $dbsExists = 'SELECT COUNT(name) AS total, id FROM ' . GAMES_MAP_TABLE . ' WHERE name = "' . mysql_real_escape_string(nkGetValue('name')) . '" AND game_id = "'.(int)nkGetValue('game').'" ';
                $dbeExists = mysql_query($dbsExists);
                $dbaExists = mysql_fetch_assoc($dbeExists);

                if ($dbaExists['total'] == 0 || ($id && $id == $dbaExists['id'] && $dbaExists['total'] == 1)) {
                    $picture = nkUploadImage('picture', $path);
                    if (!$id && ($picture === true || $picture === false)) {
                        ?>
                            <div class="nNote nFailure nNoteHideable">
                                <p>
                                    <?php
                                        echo 'Merci d\'insérer une image';
                                    ?>
                                </p>
                            </div>
                        <?php
                        return;
                    }

                    if ($id) {
                        $dbrSetMap = "UPDATE " . GAMES_MAP_TABLE . " SET name = '".nkGetValue('name')."', game_id = '".nkGetValue('game')."'".($picture ? ", picture = '".$picture."' " : "") ." WHERE id = '".(int)$id."' ";
                    }
                    else {
                        $dbrSetMap = "INSERT INTO " . GAMES_MAP_TABLE . " (name, game_id, picture) VALUES ('".nkGetValue('name')."', '".nkGetValue('game')."', '".$picture."') ";
                    }

                    if (mysql_query($dbrSetMap)) {
                        header('Refresh:0, url='.nkGetLink(true));
                    }
                }
                else {
                    ?>
                        <div class="nNote nFailure nNoteHideable">
                            <p>
                                <?php
                                    echo 'Le jeu que vous souhaitez enregistrer existe déjà';
                                ?>
                            </p>
                        </div>
                    <?php
                    return;
                }
            }
        }
        else if ($action === 'del') {
            $game = nkGetGames($id);
            if ($game && sizeof($game)) {
                $dbdRanksMaps = 'DELETE FROM ' . GAMES_MAP_TABLE . ' WHERE id = ' . (int) $id . ' ';

                if (file_exists($path . $game['picture'])) {
                    unlink($path . $game['picture']);
                }

                // execution de la requete
                if (mysql_query($dbdRanks) && mysql_query($dbdRanksMaps)) {
                    header('Refresh:0, url='.nkGetLink(true, 2));
                }
                else {

                    ?>
                        <div class="nNote nFailure nNoteHideable">
                            <p>
                                <?php
                                echo TEAM_QUERY . ' ' . $dbdRanks ;
                                ?>
                            </p>
                        </div>
                    <?php
                }
            }
        }

    }
}

/**
 * Affiche le menu
 * @param  string $op
 */
function GamesDisplayMenu  ($op, $action) {
    $menus = array(
        'games'        => array('name' => 'Jeux', 'icon' => ''),
        'maps'         => array('name' => 'Cartes', 'icon' => '')
    );

    nkDisplayContentMenu($menus, $op);
    GamesDisplaySubMenu($op, $action);
}

/**
 * Affiche le submenu
 * @param string $op     Operation
 * @param string $action Action
 */
function GamesDisplaySubMenu ($op, $action) {

    switch ($op) {
        case 'games':
            $menus = array(
                'list' => array('name' => 'Liste', 'icon' => ''),
                'add'  => array('name' => 'Ajouter' ,'icon' => 'add' )
                );
            nkDisplayContentMenu($menus, $action, 'action', $op);
            break;
        case 'maps':
            $menus = array(
                'list' => array('name' => 'Liste', 'icon' => ''),
                'add'  => array('name' => 'Ajouter' ,'icon' => 'add' )
                );
            nkDisplayContentMenu($menus, $action, 'action', $op);
            break;

        default:
            break;
    }
}

/**
 * Affiche le contenu
 * @param string $op     Operation
 * @param string $action Action
 * @param integer $id     DEscription
 */
function GamesDisplayContent ($op, $action, $id = null) {
    switch ($op) {
        case "games":
            switch ($action) {
                case "edit":
                case "add":
                    GamesDisplayForm($id);
                break;
                default:
                    GamesDisplayList($op);
                break;
            }
            break;
        case "maps":
            switch ($action) {
                case "edit":
                case "add":
                    GamesMapsDisplayForm($id);
                break;
                default:
                    GamesMapsDisplayList($op);
                break;
            }
        break;
        default:
            break;
    }
}

/**
 * Display list in BO
 */
function GamesDisplayList ($op) {

    $games = nkGetGames();

    ?>
    <div class="widget">
        <div class="whead">
            <h6>Jeux</h6>
            <div class="clear both"></div>
        </div>
        <table class="tDefault" data-table="<?php echo TEAM_TABLE; ?>">
            <thead>
                <tr>
                    <td>
                        <strong>Nom :</strong>
                    </td>
                    <td>
                        <strong>Cartes :</strong>
                    </td>
                    <td>
                        <strong>Actions :</strong>
                    </td>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($games) && is_array($games) && count($games)) {
                    foreach ($games as $value) {
                        ?>
                            <tr>
                                <td>
                                    <?php
                                        echo printSecuTags($value['name']);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        echo printSecuTags($value['maps']);
                                    ?>
                                </td>
                                <td class="center">
                                    <a class="tablectrl_medium bDefault tipS nkIcons icon-edit" href="<?php echo nkGetLink(false, null, array("action" => "edit", "id" => $value['id'])); ?>"></a>
                                    <a class="tablectrl_medium bDefault tipS nkIcons icon-delete"  href="<?php echo nkGetLink(false, null, array("action" => "del", "id" => $value['id'])); ?>"></a>
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
                                    Il n'y a pas de jeu pour le moment
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
 * Affiche le formulaire
 * @param integer $id Identifier
 */
function GamesDisplayForm ($id = false) {
    if ($id) {
        $game = nkGetGames($id);
        $name = nkGetValue('name', $game['name']);
    }
    else {
        $name = nkGetValue('name');
    }

    ?>
    <form action="" method="POST" class="form" autocomplete="off" enctype="multipart/form-data">
        <div class="fluid">
            <div class="widget">
                <div class="whead">
                    <h6>Formulaire</h6>
                    <div class="clear both"></div>
                </div>
                <div class="formRow">
                    <div class="grid3">
                        <label for="name">Nom :</label>
                    </div>
                    <div class="grid9 searchDrop">
                        <input type="text" name="name" id="name" value="<?php echo $name; ?>" />
                    </div>
                    <div class="clear both"></div>
                </div>
                <div class="formRow">
                    <div class="grid3">
                        <label for="icon">Icône :</label>
                    </div>
                    <div class="grid9 searchDrop">
                        <input type="file" name="icon" id="icon" />
                    </div>
                    <div class="clear both"></div>
                </div>
                <div class="body center">
                    <input type="submit" name="btnSubmit" class="buttonM bBlue">
                    <a class="buttonM bDefault" href="<?php echo nkGetLink(); ?>"><?php echo BACK; ?></a>
                </div>
                <div class="clear both"></div>
            </div>
        </div>
    </form>
    <?php
}

/**
 * Display Map list in BO
 */
function GamesMapsDisplayList () {
    $maps = nkGetMaps();
    ?>
        <div class="widget">
            <div class="whead">
                <h6>Jeux</h6>
                <div class="clear both"></div>
            </div>
            <table class="tDefault" data-table="<?php echo TEAM_TABLE; ?>">
                <thead>
                    <tr>
                        <td>
                            <strong>Nom :</strong>
                        </td>
                        <td>
                            <strong>Jeu :</strong>
                        </td>
                        <td>
                            <strong>Actions :</strong>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($maps) && is_array($maps) && count($maps)) {
                        foreach ($maps as $value) {
                            ?>
                                <tr>
                                    <td>
                                        <?php
                                            echo printSecuTags($value['name']);
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo printSecuTags($value['game']);
                                        ?>
                                    </td>
                                    <td class="center">
                                        <a class="tablectrl_medium bDefault tipS nkIcons icon-edit" href="<?php echo nkGetLink(false, null, array("action" => "edit", "id" => $value['id'])); ?>"></a>
                                        <a class="tablectrl_medium bDefault tipS nkIcons icon-delete"  href="<?php echo nkGetLink(false, null, array("action" => "del", "id" => $value['id'])); ?>"></a>
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
                                        Il n'y a pas de carte pour le moment
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
 * Affiche le formulaire
 * @param integer $id Identifier
 */
function GamesMapsDisplayForm ($id = false) {

    $games = nkGetGames();
    if ($id) {
        $map = nkGetMaps($id);
        $name = nkGetValue('name', $map['name']);
        $game_id = nkGetValue('name', $map['game_id']);
    }
    else {
        $name = nkGetValue('name');
        $game_id = nkGetValue('game');
    }

    ?>
    <form action="" method="POST" class="form" autocomplete="off" enctype="multipart/form-data">
        <div class="fluid">
            <div class="widget">
                <div class="whead">
                    <h6>Formulaire</h6>
                    <div class="clear both"></div>
                </div>
                <div class="formRow">
                    <div class="grid3">
                        <label for="name">Nom :</label>
                    </div>
                    <div class="grid9 searchDrop">
                        <input type="text" name="name" id="name" value="<?php echo $name; ?>" />
                    </div>
                    <div class="clear both"></div>
                </div>
                <div class="formRow">
                    <div class="grid3">
                        <label for="jeu">Jeu :</label>
                    </div>
                    <div class="grid9 searchDrop">
                        <select name="game" class="select validate[required]">
                            <option value=""><?php echo CHOOSE; ?></option>
                            <?php
                                foreach ($games as $game) {
                                    ?>
                                        <option value="<?php echo $game['id']; ?>"<?php echo ($game_id == $game['id'] ? ' selected' : ''); ?>><?php echo $game['name']; ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="clear both"></div>
                </div>
                <div class="formRow">
                    <div class="grid3">
                        <label for="picture">Image :</label>
                    </div>
                    <div class="grid9 searchDrop">
                        <input type="file" name="picture" id="picture" />
                    </div>
                    <div class="clear both"></div>
                </div>
                <div class="body center">
                    <input type="submit" name="btnSubmit" class="buttonM bBlue">
                    <a class="buttonM bDefault" href="<?php echo nkGetLink(); ?>"><?php echo BACK; ?></a>
                </div>
                <div class="clear both"></div>
            </div>
        </div>
    </form>
    <?php
}

?>
