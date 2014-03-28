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
function GamesDisplayAdmin()
{

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

function GamesPostProcess($op, $action, $id)
{
    if ($op === 'games')
    {

        $path = dirname(__FILE__) . '/../../../../../Upload/Games/';
        if (($action === 'add' || $action === 'edit') && nkGetValue('btnSubmit'))
        {
            if (!nkGetValue('name'))
            {
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
            else
            {

                $dbsExists = 'SELECT COUNT(name) AS total, id, icon FROM ' . GAMES_TABLE . ' WHERE name = "' . mysql_real_escape_string(nkGetValue('name')) . '" ';
                $dbeExists = mysql_query($dbsExists);
                $dbaExists = mysql_fetch_assoc($dbeExists);

                if ($dbaExists['total'] == 0 || ($id && $id == $dbaExists['id'] && $dbaExists['total'] == 1))
                {
                    $icon = nkUploadImage('icon', $path);
                    if (!$id && ($icon === true || $icon === false))
                    {
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

                    if ($id)
                    {
                        $dbrSetGame = "UPDATE " . GAMES_TABLE . " SET name = '".nkGetValue('name')."'".($icon ? ", icon = '".$icon."' " : "") ." WHERE id = '".(int)$id."' ";
                    }
                    else
                    {
                        $dbrSetGame = "INSERT INTO " . GAMES_TABLE . " (name, icon) VALUES ('".nkGetValue('name')."', '".$icon."') ";
                    }

                    if (mysql_query($dbrSetGame))
                    {
                        header('Refresh:0, url='.nkGetLink(true));
                    }
                }
                else
                {
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
        else if ($action === 'del')
        {
            $game = nkGetGames($id);
            if ($game && sizeof($game)) {
                $dbdRanks = 'DELETE FROM ' . GAMES_TABLE . ' WHERE id = ' . (int) $id . ' ';
                $dbdRanksMaps = 'DELETE FROM ' . GAMES_MAP_TABLE . ' WHERE game_id = ' . (int) $id . ' ';

                if (file_exists($path . $game['icon']))
                {
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
                                echo nk_debug_bt() . '<br />' . TEAM_QUERY . ' ' . $dbdRanks ;
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
function GamesDisplayMenu ($op, $action)
{
    $menus = array(
        'games'        => array('name' => 'Jeux', 'icon' => ''),
        'maps'           => array('name' => 'Cartes', 'icon' => ''),
        'settings'      => array('name' => 'Préférences', 'icon' => 'settings'),
    );

    GamesdisplayContentMenu($menus, $op);
    GamesDisplaySubMenu($op, $action);
}

/**
 * Affiche le submenu
 * @param string $op     Operation
 * @param string $action Action
 */
function GamesDisplaySubMenu($op, $action)
{

    switch ($op) {
        case 'games':
            $menus = array(
                'list' => array('name' => 'Liste', 'icon' => ''),
                'add'  => array('name' => 'Ajouter' ,'icon' => 'add' )
                );
            GamesDisplayContentMenu($menus, $action, 'action', $op);
            break;
        case 'maps':
            $menus = array(
                'list' => array('name' => 'Liste', 'icon' => ''),
                'add'  => array('name' => 'Ajouter' ,'icon' => 'add' )
                );
            GamesDisplayContentMenu($menus, $action, 'action', $op);
            break;

        default:
            break;
    }
}

/**
 *  Affiche le contenu d'un menu
 *  @param array $menus Liste des menus
 *  @param string $search Valeur à chercher pour le liens courant
 *  @param string $op Type d'action op|action
 *  @param string $op Si c'est pas le menu principal, c'est la valeur du op
 */
function GamesDisplayContentMenu ($menus, $search, $type = "op", $op = null)
{
    if(is_array($menus)) {
    ?>
        <ul class="middleNavR">
    <?php
            foreach ($menus as $key => $menu) {

                $isNotOp = null;

                if($type !== "op") {
                    $isNotOp = "op=" . $op . "&";
                }
    ?>
                <li>
                    <a class="tipN" href="index.php?file=<?php echo nkGetValue('file'); ?>&page=<?php echo nkGetValue('page'); ?>&<?php echo $isNotOp.$type; ?>=<?php echo $key; ?>" original-title="<?php echo $menu['name']; ?>">
                        <span class="nkIcons icon-<?php echo (isset($menu['icon']) && !empty($menu['icon']) ? $menu['icon'] : 'help' ) ?>"></span>
                    </a>
                </li>
    <?php

            }
    ?>
        </ul>
    <?php
    }
}

/**
 * Affiche le contenu
 * @param string $op     Operation
 * @param string $action Action
 * @param integer $id     DEscription
 */
function GamesDisplayContent($op, $action, $id = null)
{
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
        default:
            break;
    }
}

/**
 * Display list in BO
 */
function GamesDisplayList($op)
{

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
                if (isset($games) && is_array($games) && count($games))
                {
                    foreach ($games as $game)
                    {
                        ?>
                            <tr>
                                <td>
                                    <?php
                                        echo printSecuTags($game['name']);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        echo printSecuTags($game['maps']);
                                    ?>
                                </td>
                                <td class="center">
                                    <a class="tablectrl_medium bDefault tipS nkIcons icon-edit" href="index.php?file=<?php echo nkGetValue('file'); ?>&page=<?php echo nkGetValue('page'); ?>&op=<?php echo $op; ?>&action=edit&id=<?php echo $game['id'];?>"></a>
                                    <a class="tablectrl_medium bDefault tipS nkIcons icon-delete"  href="index.php?file=<?php echo nkGetValue('file'); ?>&page=<?php echo nkGetValue('page'); ?>&op=<?php echo $op; ?>&action=del&id=<?php echo $game['id'];?>"></a>
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
 * Affiche le formulaire
 * @param integer $id Identifier
 */
function GamesDisplayForm($id = false)
{
    if ($id)
    {
        $game = nkGetGames($id);
        $name = nkGetValue('name', $game['name']);
    }
    else
    {
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
                    <div class="grid9 noSearch">
                        <input type="text" name="name" id="name" value="<?php echo $name; ?>" />
                    </div>
                    <div class="clear both"></div>
                </div>
                <div class="formRow">
                    <div class="grid3">
                        <label for="icon">Icône :</label>
                    </div>
                    <div class="grid9 noSearch">
                        <input type="file" name="icon" id="icon" />
                    </div>
                    <div class="clear both"></div>
                </div>
                <div class="body center">
                    <input type="submit" name="btnSubmit" class="buttonM bBlue">
                    <a class="buttonM bDefault" href="index.php?file=<?php echo $_REQUEST['file']; ?>&page=<?php echo $_REQUEST['page'] . (isset($_REQUEST['op']) ? '&op='.$_REQUEST['op'] : ''); ?>"><?php echo BACK; ?></a>
                </div>
                <div class="clear both"></div>
            </div>
        </div>
    </form>
    <?php
}

?>
