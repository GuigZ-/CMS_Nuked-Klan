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
 {
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

function WarsDisplayForm ($id = fale) {
    $games = nkGetGames();
    $countries = nkGetCountries();
    if ($id) {
        $match = getMatchs((int)$id);
        $versus = nkGetValue('versus', $match['versus']);
        $game_id = nkGetValue('game_id', $match['game_id']);
        $link = nkGetValue('link', $match['link']);
        $country = nkGetValue('country', $match['country']);
        $status = nkGetValue('status', $match['status']);
        $date = nkGetValue('date', $match['date']);
    }
    else {
        $versus = nkGetValue('versus');
        $game_id = nkGetValue('game_id');
        $link = nkGetValue('link');
        $country = nkGetValue('country');
        $status = nkGetValue('status');
        $date = nkGetValue('date');
    }

    ?>
    <form action="" method="POST" class="form" autocomplete="off" enctype="multipart/form-data">
        <div class="fluid">
            <div class="widget grid6">
                <div class="whead">
                    <h6>Informations générales</h6>
                    <div class="clear both"></div>
                </div>
                <div class="formRow">
                    <div class="grid3">
                        <label for="game">Jeu :</label>
                    </div>
                    <div class="grid9 searchDrop">
                        <select name="jeu" id="game" class="select">
                            <option value="0">=== CHOISIR ===</option>
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
                        <label for="status">Statut :</label>
                    </div>
                    <div class="grid9 searchDrop">
                        <select name="jeu" id="status" class="select">
                            <option value="">=== CHOISIR ===</option>
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
                    <div class="grid2 searchDrop">
                        <input type="text" name="date" id="date" class="datetimepicker" value="<?php echo strftime('%Y-%m-%d %H:%M'); ?>" />
                    </div>
                    <div class="clear both"></div>
                </div>
            </div>
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
                        <input type="text" id="name" name="versus" value="<?php echo $versus; ?>"/>
                    </div>
                    <div class="clear both"></div>
                </div>
                <div class="formRow">
                    <div class="grid3">
                        <label for="link">Site web :</label>
                    </div>
                    <div class="grid9">
                        <input type="text" id="link" name="versus" value="<?php echo $link; ?>"/>
                    </div>
                    <div class="clear both"></div>
                </div>
                <div class="formRow">
                    <div class="grid3">
                        <label for="country">Pays :</label>
                    </div>
                    <div class="grid9 searchDrop">
                        <select name="jeu" id="country" class="select">
                            <option value="0">=== CHOISIR ===</option>
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
        </div>
    </form>
    <script type="text/javascript">
        $(function(){
            $(".datetimepicker").datetimepicker({controlType : 'select', showTime : false, dateFormat : 'yy-mm-dd'});
        });
    </script>
    <?php
}
?>
