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

require_once 'modules/Games/inc/functions.php';

/**
 * Gestion de l'affichage de l'admin
 */
function GamesDisplayAdmin()
{

    if (!($op = GamesGetValue('op')) || $op === 'index') {
        $op = "games";
    }

    if (!$action = GamesGetValue('action')) {
        $action = "list";
    }

    $id = null;

    if(($action === 'edit' || $action === 'del') && preg_match("#^[0-9]+$#isD", GamesGetValue('id'))) {
        $id = GamesGetValue('id');
    }


    // Message de process
    echo '<div class="nNote nWarning nNoteHideabl"><p>En cours de développement</p></div>';
    ?>

    <div class="content-box">
        <div class="tab-content">
            <?php
                GamesDisplayMenu($op, $action);
                GamesDisplayContent($op, $action, $id);
            ?>
        </div>
    </div>
    <?php
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
                    <a class="tipN" href="index.php?file=<?php echo GamesGetValue('file'); ?>&page=<?php echo GamesGetValue('page'); ?>&<?php echo $isNotOp.$type; ?>=<?php echo $key; ?>" original-title="<?php echo $menu['name']; ?>">
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

    $games = GamesGetGames();

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
                                <td class="center">
                                    <a class="tablectrl_medium bDefault tipS nkIcons icon-edit" href="index.php?file=Games&page=admin&op=<?php echo $op; ?>&action=edit&id=<?php echo $game['id'];?>"></a>
                                    <a class="tablectrl_medium bDefault tipS nkIcons icon-delete"  href="index.php?file=Games&page=admin&op=<?php echo $op; ?>&action=del&id=<?php echo $game['id'];?>"></a>
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
        $game = GamesGetGames($id);
        $name = GamesGetValue('name', $game['name']);
    }
    else
    {
        $name = GamesGetValue('name');
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
