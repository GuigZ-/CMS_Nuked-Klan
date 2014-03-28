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

translate('modules/Team/lang/' . $GLOBALS['language'] . '.lang.php');
include 'modules/Admin/design.php';
require_once dirname(__FILE__).'/inc/constants.php';
require_once dirname(__FILE__).'/inc/db.php';
require_once dirname(__FILE__).'/inc/functions.php';

/**a
 * Affiche l'admin
 */
function displayAdmin () {

    if (isset($_REQUEST['op']) === false || empty($_REQUEST['op']) === true || $_REQUEST['op'] === 'index') {
        $op = "teams";
    }
    else {
        $op = $_REQUEST['op'];
    }

    if (isset($_REQUEST['action']) === false || empty($_REQUEST['action']) === true) {
        $action = "list";
    }
    else {
        $action = $_REQUEST['action'];
    }

    $id = null;

    if(isset($_REQUEST['action']) && ($_REQUEST['action'] == 'edit' || $_REQUEST['action'] == 'del' || $_REQUEST['action'] == 'edit_user' || $_REQUEST['action'] == 'del_user') && isset($_REQUEST['id']) !== false && preg_match("#^[0-9]+$#isD", $_REQUEST['id'])) {
        $id = $_REQUEST['id'];
    }
    /**
     * @TODO DELETE NEXT LINE
     */
	?>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<div class="content-box">
		<div class="content-box-header">
			<h3><?php echo TEAM_ADMIN_TITLE; ?></h3>
		</div>
		<div class="tab-content">
			<div style="text-align:center;">
	<?php
				displayMenu($op);
	?>
			</div>
            <br />
			<div style="text-align:center;">
                <br />
	<?php
				displaySubMenu($op, $action);
	?>
			</div>
			<br />
    <?php
                postProcess($op, $action, $id);

                if (isset($_REQUEST['conf'])) {
                    displayConf($_REQUEST['conf']);
                }

                displayContent($op, $action, $id);
    ?>
            <div class="back">
                <br />
                [ <a href="index.php?file=Admin" class="boldCenter"><?php echo _BACK; ?></a> ]
            </div>
            <br />
		</div>
	</div>
	<?php
}

/**
 * Affiche le menu
 * @param  string $op
 */
function displayMenu ($op) {
	$menus = array(
		"teams"        => TEAM_MANAGEMENT_TEAMS,
		"manage_users" => TEAM_MANAGEMENT_USERS,
		"status"       => TEAM_MANAGEMENT_STATUS,
        "ranks"        => TEAM_MANAGEMENT_RANKS,
		"settings"     => TEAM_PREFERENCES,
	);

    displayContentMenu($menus, $op);
}

/**
 * Affiche un sous menu
 * @param  string $op
 */
function displaySubMenu ($op, $action) {

    switch ($op) {
        case 'teams':
            echo "[ ";
            $menus = array(
                "list" => TEAM_ADMIN_LIST,
                "add"  => TEAM_ADMIN_ADD_TEAM
                );
            displayContentMenu($menus, $action, "action", $op);
            echo " ]";
            break;

        case 'manage_users':
            echo "[ ";
            $menus = array(
                "list" => TEAM_ADMIN_LIST,
                "add"  => TEAM_ADMIN_ADD_COMBINAISON,
                "list_status"  => TEAM_ADMIN_LIST_STATUS
                );
            displayContentMenu($menus, $action, "action", $op);
            echo " ]";
            break;

        case 'status':
            echo "[ ";
            $menus = array(
                "list" => TEAM_ADMIN_LIST,
                "add"  => TEAM_ADMIN_ADD_STATUS
                );
            displayContentMenu($menus, $action, "action", $op);
            echo " ]";
            break;

        case 'ranks':
            echo "[ ";
            $menus = array(
                "list" => TEAM_ADMIN_LIST,
                "add"  => TEAM_ADMIN_ADD_RANK
                );
            displayContentMenu($menus, $action, "action", $op);
            echo " ]";
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
function displayContentMenu ($menus, $search, $type = "op", $op = null) {
    if(is_array($menus)) {

        $i = 0;

        foreach ($menus as $key => $menu) {

            // Si ce n'est pas l'onglet en cours
            if ($key !== $search) {
                echo "<strong>";
            }
            // if not first while
            if ($i > 0) {
	?>
                |
	<?php
            }
            // Si c'est l'onglet en cours
            if ($key === $search) {
                echo $menu;
            }
            else {

                $isNotOp = null;

                if($type !== "op") {
                    $isNotOp = "op=" . $op . "&";
                }
	?>
                <a href="index.php?file=Team&page=admin&<?php echo $isNotOp.$type; ?>=<?php echo $key; ?>">
	<?php
                    echo $menu;
	?>
                </a>
	<?php
            }

            // Si ce n'est pas l'onglet en cours
            if ($key !== $search) {
                echo "</strong>";
            }


            $i++;
        }
    }
}

/**
 * Affiche le contenu
 * @param  string $op
 * @param  string $action
 */
function displayContent ($op, $action, $id = null) {
    switch($op){
        case 'teams':
                switch ($action) {
                    case 'add':
                    case 'edit':
                        formTeams($id);
                        break;

                    default:
                        listTeams();
                        break;
                }
            break;

        case 'manage_users':
                switch ($action) {
                    case 'add':
                    case 'edit':
                        formUsers($id);
                        break;
                    case 'list_status';
                        listUsersStatus();
                        break;
                    case 'edit_user';
                        formUsersStatus($id);
                        break;
                    default:
                        listUsers();
                        break;
                }
            break;

        case 'status':
                switch ($action) {
                    case 'add':
                    case 'edit':
                        formStatus($id);
                        break;

                    default:
                        listStatus();
                        break;
                }
            break;

        case 'ranks':
                switch ($action) {
                    case 'add':
                    case 'edit':
                        formRanks($id);
                        break;

                    default:
                        listRanks();
                        break;
                }
            break;

        case 'settings':
            formPreferences();
            break;

        default:
            ?>
            <div class="error notification">
                <div>
                    <?php echo TEAM_404; ?>
                </div>
            </div>
            <?php
            break;
    }
}

/**
 * Affiche la liste des équipes
 */
function listTeams () {
    ?>
    <script type="text/javascript">
          $(function() {
            $( "#sortable" ).sortable({
                cursor : "move",
                stop : function (event, ui) {
                    // @TODO Drag and Drop (defined)
                    // table : TEAM_TABLE
                    // field : order
                }
            });
            $( "#sortable" ).disableSelection();
          });
    </script>
    <div class="tableWidth100 lineHeight1_3 table">
        <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
            <!-- Nom -->
            <div class="tableWidth20 inlineBlock boldCenter tableCell">
                <?php
                    echo TEAM_NAME;
                ?>
            </div>
            <!-- Prefix -->
            <div class="tableWidth20 inlineBlock boldCenter tableCell">
                <?php
                    echo TEAM_PREFIX;
                ?>
            </div>
            <!-- Suffix -->
            <div class="tableWidth20 inlineBlock boldCenter tableCell">
                <?php
                    echo TEAM_SUFFIX;
                ?>
            </div>
            <!-- Ordre -->
            <div class="tableWidth20 inlineBlock boldCenter tableCell">
                <?php
                    echo TEAM_ORDER;
                ?>
            </div>
            <!-- Action -->
            <div class="tableWidth20 inlineBlock boldCenter tableCell">
                <?php
                    echo TEAM_ACTIONS;
                ?>
            </div>
            <div class="clear both"></div>
        </div>
    </div>
    <div id="sortable" class="tableWidth100 lineHeight1_3 table">
        <!-- Equipes -->
        <?php
                $teams = getTeams();
                if ($teams !== false && is_array($teams) && sizeof($teams)) {
                    foreach ($teams as $team) {
                        ?>
                            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                                <!-- Nom -->
                                <div class="tableWidth20 inlineBlock center tableCell">
                                    <?php
                                        echo printSecuTags($team['name']);
                                    ?>
                                </div>
                                <!-- Prefix -->
                                <div class="tableWidth20 inlineBlock center tableCell">
                                    <?php
                                        if (isset($team['prefix']) && empty($team['prefix']) === false) {
                                            echo printSecuTags($team['prefix']);
                                        }
                                        else {
                                            echo "-";
                                        }
                                    ?>
                                </div>
                                <!-- Suffix -->
                                <div class="tableWidth20 inlineBlock center tableCell">
                                    <?php
                                        if (isset($team['suffix']) && empty($team['suffix']) === false) {
                                            echo printSecuTags($team['suffix']);
                                        }
                                        else {
                                            echo "-";
                                        }
                                    ?>
                                </div>
                                <!-- Ordre -->
                                <div class="tableWidth20 inlineBlock center tableCell">
                                    <?php
                                        echo printSecuTags($team['order']);
                                    ?>
                                </div>
                                <!-- Action -->
                                <div class="tableWidth20 inlineBlock center tableCell">
                                    <a href="index.php?file=Team&page=admin&op=teams&action=edit&id=<?php echo $team['id'];?>"><img src="images/edit.gif" alt=""/></a>
                                    <a href="index.php?file=Team&page=admin&op=teams&action=del&id=<?php echo $team['id'];?>"><img src="images/del.gif" alt=""/></a>
                                </div>
                                <div class="clear both"></div>
                            </div>
                        <?php
                    }
                }
                else {
                    ?>
                    <br />
                    <div class="margin0-10 borderBox">
                        <div class="notification information widthAuto ">
                            <div>
                                <?php
                                    echo TEAM_NO_TEAM_REGISTERED;
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
        ?>
        <!-- /Equipes -->
    </div>
    <div class="clear both"></div>
    <br />
    <?php
}

/**
 * Formulaire de gestion des équipes
 * @param  boolean $id ID à éditer
 */
function formTeams ($id = false) {
    if ($id) {
        $team        = getTeams((int) $id);
        $team        = $team[0];
        $name        = getValue('name',        $team['name']);
        $image       = getValue('image',       $team['image']);
        $description = getValue('description', $team['description']);
        $suffix      = getValue('suffix',      $team['suffix']);
        $prefix      = getValue('prefix',      $team['prefix']);
        $teamGroups  = getValue('groups',      $team['groups']);
        $teamGames   = getValue('games',       $team['games']);
    } else {
        $name        = getValue('name');
        $image       = getValue('image');
        $description = getValue('description');
        $suffix      = getValue('suffix');
        $prefix      = getValue('prefix');
        $teamGroups  = getValue('groups');
        $teamGames   = getValue('games');
    }

    if ($teamGroups != null && is_array($teamGroups) === false)
        $teamGroups = explode(',', $teamGroups);

    if ($teamGames != null && is_array($teamGames) === false)
        $teamGames = explode(',', $teamGames);

    if ($teamGroups && sizeof($teamGroups))
        $teamGroups = array_unique($teamGroups);
    if ($teamGames && sizeof($teamGames))
        $teamGames = array_unique($teamGames);

    ?>
    <form action="" method="POST" class="form" autocomplete="off" enctype="multipart/form-data">
        <div class="tableWidth100 lineHeight1_3 table">
            <!-- Name -->
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock bold">
                    <label for="name">
                        <?php
                            echo TEAM_NAME . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="tableWidth80 tableCell inlineBlock bold">
                    <input type="text" name="name" id="name" value="<?php echo $name; ?>">
                    <sup>*</sup>
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Name -->
            <!-- Image -->
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock bold quarter">
                    <label for="name">
                        <?php
                            echo TEAM_IMAGE . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="tableWidth80 tableCell inlineBlock bold">
                    <input type="file" name="image" id="image" value="<?php echo $image; ?>" />
                    <?php echo ($id ? '' : '<sup>*</sup>'); ?>
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Image -->
            <!-- Description -->
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock bold quarter">
                    <label for="name">
                        <?php
                            echo TEAM_DESCRIPTION . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="tableWidth80 tableCell inlineBlock bold">
                    <textarea type="text" name="description" id="description" class="editor"><?php echo $description; ?></textarea>
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Description -->
            <!-- Prefix -->
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock bold">
                    <label for="prefix">
                        <?php
                            echo TEAM_PREFIX . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="tableWidth80 tableCell inlineBlock bold">
                    <input type="text" name="prefix" id="prefix" value="<?php echo $prefix; ?>">
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Prefix -->
            <!-- Suffix -->
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock bold">
                    <label for="suffix">
                        <?php
                            echo TEAM_SUFFIX . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="tableWidth80 tableCell inlineBlock bold">
                    <input type="text" name="suffix" id="suffix" value="<?php echo $suffix; ?>">
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Suffix -->
            <!-- Groups -->
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock bold">
                    <label for="suffix">
                        <?php
                            echo TEAM_GROUPS . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="tableWidth80 tableCell inlineBlock bold">
                    <?php
                        $groups = getNkGroups();
                        if ($groups)
                            foreach ($groups as $id => $name)
                                echo '<input type="checkbox" name="groups[]" value="'.$id.'" id="group_' . $id . '" ' . ( is_array($teamGroups) && in_array($id, $teamGroups) ? 'checked="checked"' : '') . ' /> <label for="group_' . $id . '" class="inlineBlock">' . ucfirst(strtolower($name)) . '</label><br />';
                    ?>
                </div>
            </div>
            <!-- /Groups -->
            <!-- Games -->
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock bold">
                    <label for="suffix">
                        <?php
                            echo TEAM_GAMES . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="tableWidth80 tableCell inlineBlock bold">
                    <?php
                        $games = getNkGames();
                        if ($games)
                            foreach ($games as $id => $name) {
                                echo '<input type="checkbox" name="games[]" value="'.$id.'" id="game_' . $id . '" ' . ( is_array($teamGames) && in_array($id, $teamGames) ? 'checked="checked"' : '') . ' /> <label for="game_' . $id . '" class="inlineBlock">' . ucfirst(strtolower($name)) . '</label><br />';
                            }
                    ?>
                </div>
            </div>
            <!-- /Games -->
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock">
                    <input type="submit" name="btnSubmit" class="button">
                </div>
                <div></div>
            </div>
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock">
                    <small>
                        <sup>*</sup> <?php echo FIELDS_REQUIRE; ?>
                    </small>
                </div>
                <div></div>
            </div>
            <div class="clear both"></div>
        </div>
    </form>
    <?php
}

/**
 * Affiche la liste des utilisateurs associés
 */
function listUsers () {
    ?>
    <div class="tableWidth100 lineHeight1_3 table">
        <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
            <!-- Name -->
            <div class="tableWidth25 inlineBlock boldCenter tableCell">
                <?php
                    echo TEAM_NICKAME;
                ?>
            </div>
            <!-- Team -->
            <div class="tableWidth25 inlineBlock boldCenter tableCell">
                <?php
                    echo TEAM_TEAM;
                ?>
            </div>
            <!-- Team -->
            <div class="tableWidth25 inlineBlock boldCenter tableCell">
                <?php
                    echo TEAM_RANKS;
                ?>
            </div>
            <!-- Action -->
            <div class="tableWidth25 inlineBlock boldCenter tableCell">
                <?php
                    echo TEAM_ACTIONS;
                ?>
            </div>
            <div class="clear both"></div>
        </div>
        <!-- Status -->
        <?php
            $users = getUsers();
            if ($users !== false && is_array($users) && sizeof($users)) {
                foreach ($users as $value) {
                    ?>
                        <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                            <!-- Name -->
                            <div class="tableWidth25 inlineBlock boldCenter tableCell">
                                <?php
                                    if (isset($value['pseudo']) && empty($value['pseudo']) === false) {
                                        echo printSecuTags($value['pseudo']);
                                    }
                                    else {
                                        echo "-";
                                    }
                                ?>
                            </div>
                            <!-- Team -->
                            <div class="tableWidth25 inlineBlock center tableCell">
                                <?php
                                    if (isset($value['team_name']) && empty($value['team_name']) === false) {
                                        echo printSecuTags($value['team_name']);
                                    }
                                    else {
                                        echo "-";
                                    }
                                ?>
                            </div>
                            <!-- Team -->
                            <div class="tableWidth25 inlineBlock center tableCell">
                                <?php
                                    if (isset($value['ranks_name']) && empty($value['ranks_name']) === false) {
                                        echo printSecuTags($value['ranks_name']);
                                    }
                                    else {
                                        echo "-";
                                    }
                                ?>
                            </div>
                            <!-- Action -->
                            <div class="tableWidth25 inlineBlock boldCenter tableCell">
                                <a href="index.php?file=Team&page=admin&op=manage_users&action=edit&id=<?php echo $value['id'];?>"><img src="images/edit.gif" alt=""/></a>
                                <a href="index.php?file=Team&page=admin&op=manage_users&action=del&id=<?php echo $value['id'];?>"><img src="images/del.gif" alt=""/></a>
                            </div>
                            <div class="clear both"></div>
                        </div>
                    <?php
                }
            }
            else {
                ?>
                <br />
                <div class="margin0-10 borderBox">
                    <div class="notification information widthAuto ">
                        <div>
                            <?php
                                echo TEAM_NO_USERS_REGISTERED;
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            }
        ?>
        <!-- /Status -->
    </div>
    <div class="clear both"></div>
    <br />
    <?php
}

/**
 * Affiche la liste des utilisateurs avec leur statut
 */
function listUsersStatus() {
    ?>
    <div class="tableWidth100 lineHeight1_3 table">
        <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
            <!-- Name -->
            <div class="tableWidth33 inlineBlock boldCenter tableCell">
                <?php
                    echo _LOGIN;
                ?>
            </div>
            <!-- Team -->
            <div class="tableWidth33 inlineBlock boldCenter tableCell">
                <?php
                    echo TEAM_STATUS;
                ?>
            </div>
            <!-- Action -->
            <div class="tableWidth33 inlineBlock boldCenter tableCell">
                <?php
                    echo TEAM_ACTIONS;
                ?>
            </div>
            <div class="clear both"></div>
        </div>
        <!-- Status -->
        <?php
            $users = getUsersStatus();
            if ($users !== false && is_array($users) && sizeof($users)) {
                foreach ($users as $value) {
                    ?>
                        <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                            <!-- Name -->
                            <div class="tableWidth33 inlineBlock boldCenter tableCell">
                                <?php
                                    if (isset($value['pseudo']) && empty($value['pseudo']) === false) {
                                        echo printSecuTags($value['pseudo']);
                                    }
                                    else {
                                        echo "-";
                                    }
                                ?>
                            </div>
                            <!-- Team -->
                            <div class="tableWidth33 inlineBlock center tableCell">
                                <?php
                                    if (isset($value['status_name']) && empty($value['status_name']) === false) {
                                        echo printSecuTags($value['status_name']);
                                    }
                                    else {
                                        echo "-";
                                    }
                                ?>
                            </div>
                            <!-- Action -->
                            <div class="tableWidth33 inlineBlock boldCenter tableCell">
                                <a href="index.php?file=Team&page=admin&op=manage_users&action=edit_user&id=<?php echo $value['id'];?>"><img src="images/edit.gif" alt=""/></a>
                                <a href="index.php?file=Team&page=admin&op=manage_users&action=del_user&id=<?php echo $value['id'];?>"><img src="images/del.gif" alt=""/></a>
                            </div>
                            <div class="clear both"></div>
                        </div>
                    <?php
                }
            }
            else {
                ?>
                <br />
                <div class="margin0-10 borderBox">
                    <div class="notification information widthAuto ">
                        <div>
                            <?php
                                echo TEAM_NO_USERS_REGISTERED;
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            }
        ?>
        <!-- /Status -->
    </div>
    <div class="clear both"></div>
    <br />
    <?php
}

/**
 * Formulaire d'utilisateur
 * @param integer $id id à éditer
 */
function formUsers ($id = false) {
    $users = getNkUsers();
    $teams = getTeams();
    $ranks = getRanks();
    if ($id) {
        $associations = getUsers($id);
        $association = $associations[0];
        $user_id = getValue('user', $association['user_id']);
        $team_id = getValue('team', $association['team_id']);
        $description = getValue('description', $association['description']);
        $rank_ids = getValue('ranks', explode(',', $association['ranks']));
    }
    else {
        $user_id = getValue('user');
        $team_id = getValue('team');
        $description = getValue('description');
        $rank_ids = getValue('ranks', array());
    }

    if ($teams === false || (int) sizeof($teams) === 0){
        ?>
        <div class="margin0-10 borderBox">
            <div class="notification error widthAuto">
                <div>
                    <?php echo TEAM_NO_TEAM_REGISTERED; ?>
                </div>
            </div>
        </div>
        <?php
        return;
    }

    ?>
    <form action="" method="POST" class="form" autocomplete="off">
        <div class="tableWidth100 lineHeight1_3 table">
            <!-- Membre -->
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock bold">
                    <label for="name">
                        <?php
                            echo _MEMBER . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="tableWidth80 tableCell inlineBlock bold">
                    <select name="user">
                        <option value=""><?php echo TEAM_CHOOSE; ?></option>
                        <?php
                            foreach ($users as $user) {
                                ?>
                                    <option value="<?php echo $user['id']; ?>"<?php echo ($user_id == $user['id'] ? ' selected' : ''); ?>><?php echo $user['pseudo']; ?></option>
                                <?php
                            }
                        ?>
                    </select>
                    <sup>*</sup>
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Membre -->
            <!-- Team -->
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock bold">
                    <label for="name">
                        <?php
                            echo _TEAM . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="tableWidth80 tableCell inlineBlock bold">
                    <select name="team">
                        <option value=""><?php echo TEAM_CHOOSE; ?></option>
                        <?php
                            foreach ($teams as $team) {
                                ?>
                                    <option value="<?php echo $team['id']; ?>"<?php echo ($team_id == $team['id'] ? ' selected' : ''); ?>><?php echo $team['name']; ?></option>
                                <?php
                            }
                        ?>
                    </select>
                    <sup>*</sup>
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Team -->
            <!-- Description -->
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock bold quarter">
                    <label for="name">
                        <?php
                            echo TEAM_DESCRIPTION . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="tableWidth80 tableCell inlineBlock bold">
                    <textarea type="text" name="description" id="description" class="editor"><?php echo $description; ?></textarea>
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Description -->
            <!-- Ranks -->
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock bold">
                    <label for="name">
                        <?php
                            echo TEAM_RANK . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="tableWidth80 tableCell inlineBlock bold">
                    <div class="table tableWidth100">
                        <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                            <?php
                                $i = 0;
                                foreach ($ranks as $rank) {
                                    ?>
                                    <div class="tableWidth10 tableCell inlineBlock bold">
                                            <input name="ranks[<?php echo $rank['id']; ?>]" value="<?php echo $rank['id']; ?>" type="checkbox" id="rank_<?php echo $rank['id']; ?>"<?php echo (in_array($rank['id'], $rank_ids) ? ' checked' : ''); ?> />
                                    </div>
                                    <div class="tableWidth20 tableCell inlineBlock bold">
                                        <label for="rank_<?php echo $rank['id']; ?>"><?php echo $rank['name']; ?></label>
                                    </div>
                                    <?php
                                    $i++;
                                    if($i % 3 === 0){
                                        echo '
                                        </div>
                                        <div class="borderBox clear both tableWidth100 padding0-10 tableRow">';
                                    }
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Ranks -->
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock">
                    <input type="submit" name="btnSubmit" class="button">
                </div>
                <div></div>
            </div>
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock">
                    <small>
                        <sup>*</sup> <?php echo FIELDS_REQUIRE; ?>
                    </small>
                </div>
                <div></div>
            </div>
            <div class="clear both"></div>
        </div>
    </form>
    <?php
}

/**
 * Formulaire de statut utilisateur
 * @param integer $id id à éditer
 */
function formUsersStatus ($id = false) {
    $status = getStatus();
    if ($id) {
        $associations = getUsersStatus($id);
        $association = $associations[0];
        $pseudo = $association['pseudo'];
        $status_id = getValue('status', $association['status']);
    }

    ?>
    <form action="" method="POST" class="form" autocomplete="off">
        <div class="tableWidth100 lineHeight1_3 table">
            <!-- Membre -->
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock bold">
                    <label for="name">
                        <?php
                            echo _MEMBER . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="tableWidth80 tableCell inlineBlock bold">
                    <?php echo $pseudo; ?>
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Membre -->
            <!-- Team -->
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock bold">
                    <label for="name">
                        <?php
                            echo TEAM_STATUS . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="tableWidth80 tableCell inlineBlock bold">
                    <select name="status">
                        <option value=""><?php echo TEAM_CHOOSE; ?></option>
                        <?php
                            foreach ($status as $state) {
                                ?>
                                    <option value="<?php echo $state['id']; ?>"<?php echo ($status_id == $state['id'] ? ' selected' : ''); ?>><?php echo $state['name']; ?></option>
                                <?php
                            }
                        ?>
                    </select>
                    <sup>*</sup>
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Team -->
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock">
                    <input type="submit" name="btnSubmit" class="button">
                </div>
                <div></div>
            </div>
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock">
                    <small>
                        <sup>*</sup> <?php echo FIELDS_REQUIRE; ?>
                    </small>
                </div>
                <div></div>
            </div>
            <div class="clear both"></div>
        </div>
    </form>
    <?php
}

/**
 * Affiche la liste des statuts
 */
function listStatus () {
    ?>
    <div class="tableWidth100 lineHeight1_3 table">
        <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
            <!-- Name -->
            <div class="tableWidth50 inlineBlock boldCenter tableCell">
                <?php
                    echo TEAM_NAME;
                ?>
            </div>
            <!-- Action -->
            <div class="tableWidth50 inlineBlock boldCenter tableCell">
                <?php
                    echo TEAM_ACTIONS;
                ?>
            </div>
            <div class="clear both"></div>
        </div>
        <!-- Status -->
        <?php
            $status = getStatus();
            if ($status !== false && is_array($status) && sizeof($status)) {
                foreach ($status as $value) {
                    ?>
                        <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                            <!-- Name -->
                            <div class="tableWidth50 inlineBlock boldCenter tableCell">
                                <?php
                                    if (isset($value['name']) && empty($value['name']) === false) {
                                        echo printSecuTags($value['name']);
                                    }
                                    else {
                                        echo "-";
                                    }
                                ?>
                            </div>
                            <!-- Action -->
                            <div class="tableWidth50 inlineBlock boldCenter tableCell">
                                <a href="index.php?file=Team&page=admin&op=status&action=edit&id=<?php echo $value['id'];?>"><img src="images/edit.gif" alt=""/></a>
                                <a href="index.php?file=Team&page=admin&op=status&action=del&id=<?php echo $value['id'];?>"><img src="images/del.gif" alt=""/></a>
                            </div>
                            <div class="clear both"></div>
                        </div>
                    <?php
                }
            }
            else {
                ?>
                <br />
                <div class="margin0-10 borderBox">
                    <div class="notification information widthAuto ">
                        <div>
                            <?php
                                echo TEAM_NO_STATUS_REGISTERED;
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            }
        ?>
        <!-- /Status -->
    </div>
    <div class="clear both"></div>
    <br />
    <?php
}
/**
 * Formulaire de statut
 * @param integer $id id à éditer
 */
function formStatus ($id = false) {

    if ($id) {
        $status = getStatus((int) $id);
        $status = $status[0];
        $name = getValue('name', $status['name']);
    } else {
        $name =  getValue('name');
    }

    ?>
    <form action="" method="POST" class="form" autocomplete="off">
        <div class="tableWidth100 lineHeight1_3 table">
            <!-- Name -->
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock bold">
                    <label for="name">
                        <?php
                            echo TEAM_NAME . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="tableWidth80 tableCell inlineBlock bold">
                    <input type="text" name="name" id="name" value="<?php echo $name; ?>">
                    <sup>*</sup>
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Name -->
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock">
                    <input type="submit" name="btnSubmit" class="button">
                </div>
                <div></div>
            </div>
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock">
                    <small>
                        <sup>*</sup> <?php echo FIELDS_REQUIRE; ?>
                    </small>
                </div>
                <div></div>
            </div>
            <div class="clear both"></div>
        </div>
    </form>
    <?php
}

/**
 * Affiche la liste des rangs
 */
function listRanks () {
    ?>
    <script type="text/javascript">
          $(function() {
            $( "#sortable" ).sortable({
                cursor : "move",
                stop : function (event, ui) {
                    // @TODO Drag and Drop (defined)
                    // table : TEAM_RANK_TABLE
                    // Field : order
                }
            });
            $( "#sortable" ).disableSelection();
          });
    </script>
    <div class="tableWidth100 lineHeight1_3 table">
        <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
            <!-- Name -->
            <div class="tableWidth33 inlineBlock boldCenter tableCell">
                <?php
                    echo TEAM_NAME;
                ?>
            </div>
            <!-- Ordre -->
            <div class="tableWidth33 inlineBlock boldCenter tableCell">
                <?php
                    echo TEAM_ORDER;
                ?>
            </div>
            <!-- Action -->
            <div class="tableWidth33 inlineBlock boldCenter tableCell">
                <?php
                    echo TEAM_ACTIONS;
                ?>
            </div>
            <div class="clear both"></div>
        </div>
    </div>
    <div id="sortable" class="tableWidth100 lineHeight1_3 table">
        <!-- ranks -->
        <?php
                $ranks = getRanks();
                if ($ranks !== false && is_array($ranks) && sizeof($ranks)) {
                    foreach($ranks as $value) {
                        ?>
                            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                                <!-- Name -->
                                <div class="tableWidth33 inlineBlock boldCenter tableCell">
                                    <?php
                                        if (isset($value['name']) && empty($value['name']) === false) {
                                            echo printSecuTags($value['name']);
                                        }
                                        else {
                                            echo "-";
                                        }
                                    ?>
                                </div>
                                <!-- Ordre -->
                                <div class="tableWidth33 inlineBlock center tableCell">
                                    <?php
                                        echo (int) $value['order'];
                                    ?>
                                </div>
                                <!-- Action -->
                                <div class="tableWidth33 inlineBlock boldCenter tableCell">
                                    <a href="index.php?file=Team&page=admin&op=<?php echo $_REQUEST['op']; ?>&action=edit&id=<?php echo $value['id'];?>"><img src="images/edit.gif" alt=""/></a>
                                    <a href="index.php?file=Team&page=admin&op=<?php echo $_REQUEST['op']; ?>&action=del&id=<?php echo $value['id'];?>"><img src="images/del.gif" alt=""/></a>
                                </div>
                                <div class="clear both"></div>
                            </div>
                        <?php
                    }
                }
                else {
                    ?>
                    <br />
                    <div class="margin0-10 borderBox">
                        <div class="notification information widthAuto ">
                            <div>
                                <?php
                                    echo TEAM_NO_RANK_REGISTERED;
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
        ?>
        <!-- /Ranks -->
    </div>
    <div class="clear both"></div>
    <br />
    <?php
}

/**
 * Formulaire de rank
 * @param integer $id id à éditer
 */
function formRanks ($id = false) {

    if ($id) {
        $ranks = getRanks((int) $id);
        $ranks = $ranks[0];
        $name = getValue('name', $ranks['name']);
    } else {
        $name =  getValue('name');
    }

    ?>
    <form action="" method="POST" class="form" autocomplete="off">
        <div class="tableWidth100 lineHeight1_3 table">
            <!-- Name -->
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock bold">
                    <label for="name">
                        <?php
                            echo TEAM_NAME . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="tableWidth80 tableCell inlineBlock bold">
                    <input type="text" name="name" id="name" value="<?php echo $name; ?>">
                    <sup>*</sup>
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Name -->
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock">
                    <input type="submit" name="btnSubmit" class="button">
                </div>
                <div></div>
            </div>
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock">
                    <small>
                        <sup>*</sup> <?php echo FIELDS_REQUIRE; ?>
                    </small>
                </div>
                <div></div>
            </div>
            <div class="clear both"></div>
        </div>
    </form>
    <?php
}

/**
 * Préférences
 */
function formPreferences() {

    $dbsGetConfig = "SELECT name, value FROM " . TEAM_SETTINGS_TABLE . "  ";
    $dbeGetConfig = mysql_query($dbsGetConfig);

    $config = array();

    while ($dbaGetConfig = mysql_fetch_assoc($dbeGetConfig)) {
        $config[$dbaGetConfig['name']] = $dbaGetConfig['value'];
    }

    ?>
    <form action="" method="POST" class="form" autocomplete="off">
        <div class="tableWidth100 lineHeight1_3 table">
            <!-- Team par page -->
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock bold">
                    <label for="team_page">
                        <?php
                            echo TEAM_SETTINGS_TEAM_PAGE . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="tableWidth80 tableCell inlineBlock bold">
                    <input type="number" name="team_page" id="team_page" value="<?php echo $config['team_page']; ?>">
                    <sup>*</sup>
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Team par page -->
            <!-- Affichage -->
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock bold">
                    <label for="display_type">
                        <?php
                            echo TEAM_SETTINGS_DISPLAY_TYPE . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="tableWidth80 tableCell inlineBlock bold">
                    <select name="display_type" id="display_type">
                        <option value="table"<?php echo ($config['display_type']  == 'table' ? ' selected' : ''); ?>><?php echo TEAM_DISPLAY_TYPE_TABLE; ?></option>
                        <option value="alternate"<?php echo ($config['display_type']  == 'alternate' ? ' selected' : ''); ?>><?php echo TEAM_DISPLAY_TYPE_ALT; ?></option>
                        <option value="bloc"<?php echo ($config['display_type']  == 'bloc' ? ' selected' : ''); ?>><?php echo TEAM_DISPLAY_TYPE_BLOC; ?></option>
                    </select>
                    <sup>*</sup>
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Affichage -->
            <!-- Choose photo -->
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock bold">
                    <label for="picture">
                        <?php
                            echo TEAM_SETTINGS_PICTURE . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="tableWidth80 tableCell inlineBlock bold">
                    <input type="checkbox" value="1" name="picture" id="picture" <?php echo ($config['picture']  == 1 ? ' checked' : ''); ?>/>
                    <sup>*</sup>
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Choose photo -->
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock">
                    <input type="submit" name="btnSubmit" class="button">
                </div>
                <div></div>
            </div>
            <div class="borderBox clear both tableWidth100 padding0-10 tableRow">
                <div class="tableWidth20 tableCell inlineBlock">
                    <small>
                        <sup>*</sup> <?php echo FIELDS_REQUIRE; ?>
                    </small>
                </div>
                <div></div>
            </div>
            <div class="clear both"></div>
        </div>
    </form>
    <?php
}

/**
 * Gestion des formulaires
 * @param  String $op     Page en cours
 * @param  String $action Action en cours
 * @param  integer $id     id en cours
 */
function postProcess ($op, $action, $id) {
    // Formulaire team
    if ($op === 'teams') {
        if (isset($_REQUEST['btnSubmit']) && ($action === 'add' || $action === 'edit')) {
            // Si tous les champs ne sont pas remplis
            if(!isset($_REQUEST['name']) || empty($_REQUEST['name']) || (!$id && empty($_FILES['image']['tmp_name']))) {
                ?>
                <div class="borderBox margin0-10">
                    <div class="notification error widthAuto">
                        <div>
                            <?php
                            echo TEAM_FORM_EMPTY;
                            ?>
                        </div>
                    </div>
                </div>
                <?php
                return;
            }

            $dbsExists = 'SELECT COUNT(name) AS total, id FROM ' . TEAM_TABLE . ' WHERE name = "' . $_REQUEST['name'] . '" ';
            $dbeExists = mysql_query($dbsExists);
            $dbaExists = mysql_fetch_assoc($dbeExists);
            if ($dbaExists['total'] == 0 || ($id && $id == $dbaExists['id'] && $dbaExists['total'] == 1)) {

                $dir = dirname(__FILE__) .'/upload/';

                $image = uploadImage($_FILES['image'], $dir, $_REQUEST['name'] );

                // si c'est un update
                if ($id) {
                    $dbrSetTeam = 'UPDATE ' . TEAM_TABLE . ' SET name = "' . mysql_real_escape_string($_REQUEST['name']) . '", description = "' . mysql_real_escape_string($_REQUEST['description']) . '", suffix =  "' . $_REQUEST['suffix'] . '", prefix = "' . $_REQUEST['prefix'] . '"'.($image ? ', image = "'.$image.'" ' : '').' WHERE id = "' . (int) $id . '"';
                }
                // Si c'est une insertion
                else {
                    $dbrSetTeam = 'INSERT INTO ' . TEAM_TABLE . ' (id, name, description, suffix, prefix, `order`, image) SELECT NULL, "' . $_REQUEST['name'] . '", "' . $_REQUEST['description'] . '", "' . $_REQUEST['suffix'] . '", "' . $_REQUEST['prefix'] . '", (MAX(`order`) + 1), "'.$image.'" FROM ' . TEAM_TABLE . ' ';
                }

                // execution de la requete
                if (mysql_query($dbrSetTeam)) {
                    if (!$id)
                        $id = mysql_last_insert();
                    else {
                        // Groups
                        $dbdTeamGroup = 'DELETE FROM ' . TEAM_GROUPS_TABLE . ' WHERE team_id = ' . $id ;
                        mysql_query($dbdTeamGroup);
                        // Games
                        $dbdTeamGroup = 'DELETE FROM ' . TEAM_GAMES_TABLE . ' WHERE team_id = ' . $id ;
                        mysql_query($dbdTeamGroup);
                    }
                    // Groups
                    $dbrTeamGroup = 'INSERT INTO ' . TEAM_GROUPS_TABLE . ' (team_id, groups_id) VALUES ';

                    $groups = $_REQUEST['groups'];

                    if (sizeof($groups)) {
                        $i = 0;
                        foreach($groups as $group) {
                            if ($i > 0)
                                $dbrTeamGroup .= ', ';
                            $dbrTeamGroup .= ' ( '. (int)$id .', ' . (int)$group . ' ) ';
                            $i++;
                        }
                        mysql_query($dbrTeamGroup);
                    }

                    // Games
                    $dbrTeamGame = 'INSERT INTO ' . TEAM_GAMES_TABLE . ' (team_id, game_id) VALUES ';

                    $games = $_REQUEST['games'];

                    if (sizeof($games)) {
                        $i = 0;
                        foreach($games as $game) {
                            if ($i > 0)
                                $dbrTeamGame .= ', ';
                            $dbrTeamGame .= ' ( '. (int)$id .', ' . (int)$game . ' ) ';
                            $i++;
                        }
                        mysql_query($dbrTeamGame);
                    }


                    header('Refresh:0, url=index.php?file=Team&page=admin&op='.$op.'&conf=1');
                }
                // Si la requete n'a pas réussi
                else {
                    ?>
                    <div class="borderBox margin0-10">
                        <div class="notification error widthAuto">
                            <div>
                                <?php
                                echo nk_debug_bt() . '<br />' . TEAM_QUERY . ' ' . $dbrSetTeam ;
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            else {
                ?>
                <div class="borderBox margin0-10">
                    <div class="notification error widthAuto">
                        <div>
                            <?php
                            echo TEAM_EXISTS;
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        else if ($action === 'del') {

            $team = getTeams($id);
            if ($team && sizeof($team)) {
                $dbdTeam = 'DELETE FROM ' . TEAM_TABLE . ' WHERE id = ' . (int) $id . ' ';

                // execution de la requete
                if (mysql_query($dbdTeam)) {
                    header('Refresh:0, url=index.php?file=Team&page=admin&op='.$op.'&conf=2');
                }
                else {

                    ?>
                    <div class="borderBox margin0-10">
                        <div class="notification error widthAuto">
                            <div>
                                <?php
                                echo nk_debug_bt() . '<br />' . TEAM_QUERY . ' ' . $dbdTeam ;
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }

        }
    }
    else if ($op === 'status') {
        // Si le formulaire est envoyé
        if (isset($_REQUEST['btnSubmit']) && ($action === 'add' || $action === 'edit')) {

            // Si tous les champs ne sont pas remplis
            if (!isset($_REQUEST['name']) || empty($_REQUEST['name'])) {
                ?>
                <div class="borderBox margin0-10">
                    <div class="notification error widthAuto">
                        <div>
                            <?php
                            echo TEAM_FORM_EMPTY;
                            ?>
                        </div>
                    </div>
                </div>
                <?php
                return;
            }

            $dbsExists = 'SELECT COUNT(name) AS total, id FROM ' . TEAM_STATUS_TABLE . ' WHERE name = "' . $_REQUEST['name'] . '" ';
            $dbeExists = mysql_query($dbsExists);
            $dbaExists = mysql_fetch_assoc($dbeExists);

            if ($dbaExists['total'] == 0 || ($id && $id == $dbaExists['id'] && $dbaExists['total'] == 1)) {
                // si c'est un update
                if ($id) {
                    $dbrSetStatus = 'UPDATE ' . TEAM_STATUS_TABLE . ' SET name = "' . mysql_real_escape_string($_REQUEST['name']) . '" WHERE id = "' . (int) $id . '"';
                }
                // Si c'est une insertion
                else {
                    $dbrSetStatus = 'INSERT INTO ' . TEAM_STATUS_TABLE . ' (id, name) VALUES (NULL, "'. mysql_real_escape_string($_REQUEST['name']).'") ';
                }
                // execution de la requete
                if (mysql_query($dbrSetStatus)) {
                    header('Refresh:0, url=index.php?file=Team&page=admin&op='.$op.'&conf=3');
                }
                // Si la requete n'a pas réussi
                else {
                    ?>
                    <div class="borderBox margin0-10">
                        <div class="notification error widthAuto">
                            <div>
                                <?php
                                echo nk_debug_bt() . '<br />' . TEAM_QUERY . ' ' . $dbrSetStatus ;
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
        }
        else if ($action === 'del') {

            $status = getStatus($id);
            if ($status && sizeof($status)) {
                $dbdStatus = 'DELETE FROM ' . TEAM_STATUS_TABLE . ' WHERE id = ' . (int) $id . ' ';

                // execution de la requete
                if (mysql_query($dbdStatus)) {
                    header('Refresh:0, url=index.php?file=Team&page=admin&op='.$op.'&conf=4');
                }
                else {

                    ?>
                    <div class="borderBox margin0-10">
                        <div class="notification error widthAuto">
                            <div>
                                <?php
                                echo nk_debug_bt() . '<br />' . TEAM_QUERY . ' ' . $dbdStatus ;
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }

        }
    }
    else if ($op === 'ranks') {
        // Si le formulaire est envoyé
        if (isset($_REQUEST['btnSubmit']) && ($action === 'add' || $action === 'edit')) {

            // Si tous les champs ne sont pas remplis
            if (!isset($_REQUEST['name']) || empty($_REQUEST['name'])) {
                ?>
                <div class="borderBox margin0-10">
                    <div class="notification error widthAuto">
                        <div>
                            <?php
                            echo TEAM_FORM_EMPTY;
                            ?>
                        </div>
                    </div>
                </div>
                <?php
                return;
            }

            $dbsExists = 'SELECT COUNT(name) AS total, id, ((SELECT MAX(`order`) FROM ' . TEAM_RANK_TABLE . ') + 1) AS max_order FROM ' . TEAM_RANK_TABLE . ' WHERE name = "' . $_REQUEST['name'] . '" ';
            $dbeExists = mysql_query($dbsExists);
            $dbaExists = mysql_fetch_assoc($dbeExists);


            if ($dbaExists['total'] == 0 || ($id && $id == $dbaExists['id'] && $dbaExists['total'] == 1)) {
                // si c'est un update
                if ($id) {
                    $dbrSetRanks = 'UPDATE ' . TEAM_RANK_TABLE . ' SET name = "' . mysql_real_escape_string($_REQUEST['name']) . '" WHERE id = "' . (int) $id . '"';
                }
                // Si c'est une insertion
                else {
                    $dbrSetRanks = 'INSERT INTO ' . TEAM_RANK_TABLE . ' (id, name, `order`) VALUES (NULL, "'. mysql_real_escape_string($_REQUEST['name']).'", "' . (int) $dbaExists['max_order'] . '") ';
                }
                // execution de la requete
                if (mysql_query($dbrSetRanks)) {
                    header('Refresh:0, url=index.php?file=Team&page=admin&op='.$op.'&conf=5');
                }
                // Si la requete n'a pas réussi
                else {
                    ?>
                    <div class="borderBox margin0-10">
                        <div class="notification error widthAuto">
                            <div>
                                <?php
                                echo nk_debug_bt() . '<br />' . TEAM_QUERY . ' ' . $dbrSetRanks ;
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
        }
        else if ($action === 'del') {

            $ranks = getRanks($id);
            if ($ranks && sizeof($ranks)) {
                $dbdRanks = 'DELETE FROM ' . TEAM_RANK_TABLE . ' WHERE id = ' . (int) $id . ' ';

                // execution de la requete
                if (mysql_query($dbdRanks)) {
                    header('Refresh:0, url=index.php?file=Team&page=admin&op='.$op.'&conf=6');
                }
                else {

                    ?>
                    <div class="borderBox margin0-10">
                        <div class="notification error widthAuto">
                            <div>
                                <?php
                                echo nk_debug_bt() . '<br />' . TEAM_QUERY . ' ' . $dbdRanks ;
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }

        }
    }
    else if ($op === 'manage_users') {

        if (isset($_REQUEST['btnSubmit']) && ($action === 'add' || $action === 'edit')) {
            // Si tous les champs ne sont pas remplis
            if (!isset($_REQUEST['user']) || empty($_REQUEST['user']) || !isset($_REQUEST['team']) || empty($_REQUEST['team']) || !isset($_REQUEST['ranks']) || sizeof($_REQUEST['ranks']) === 0) {
                ?>
                <div class="borderBox margin0-10">
                    <div class="notification error widthAuto">
                        <div>
                            <?php
                            echo TEAM_FORM_EMPTY;
                            ?>
                        </div>
                    </div>
                </div>
                <?php
                return;
            }
            // Get Team User ID
            $dbsGetTeamUserId = 'SELECT id, teamstatus_id FROM ' . TEAM_USER_TABLE . ' WHERE user_id = "' . mysql_real_escape_string($_REQUEST['user']) . '" ';
            // Execute
            $dbeGetTeamUserId = mysql_query($dbsGetTeamUserId) or die(nk_debug_bt());
            // Get Row
            $dbaGetTeamUserId = mysql_fetch_assoc($dbeGetTeamUserId);

            $TeamUserId = isset($dbaGetTeamUserId['id']) ? $dbaGetTeamUserId['id'] : null;
            $TeamStatusId = isset($dbaGetTeamUserId['teamstatus_id']) ? (int) $dbaGetTeamUserId['teamstatus_id'] : "(SELECT id FROM " . TEAM_STATUS_TABLE . " ORDER BY id ASC LIMIT 1)";

            // User
            $dbiSetUser = 'REPLACE INTO ' . TEAM_USER_TABLE . ' (id, user_id, teamstatus_id) VALUES (' . ($TeamUserId ? (int) $TeamUserId : 'NULL') . ', "' . mysql_real_escape_string($_REQUEST['user']) . '", ' . $TeamStatusId . ') ';
            mysql_query($dbiSetUser) ;

            if (!$TeamUserId) {
                $TeamUserId = mysql_insert_id();
            }

            // Team
            // Get Team UserTeam ID
            $dbsGetTeamId = 'SELECT id FROM ' . TEAM_USER_TEAM_TABLE . ' WHERE team_id = "' . (int) $_REQUEST['team'] . '" AND teamuser_id = "' . (int) $TeamUserId . '" ';
            // Execute
            $dbeGetTeamId = mysql_query($dbsGetTeamId);
            // Get Row
            $dbaGetTeamId = mysql_fetch_assoc($dbeGetTeamId);

            $TeamId = $dbaGetTeamId['id'];

            // Insert
            $dbiSetTeamUserTeam = 'REPLACE INTO ' . TEAM_USER_TEAM_TABLE . ' (id, teamuser_id, team_id, description) VALUES (' . (int) $TeamId .', ' . (int) $TeamUserId . ', ' . (int) $_REQUEST['team'] . ', "' . mysql_real_escape_string($_REQUEST['description']) . '") ';
            mysql_query($dbiSetTeamUserTeam);

            if ((int) $TeamId) {
                // Delete old
                $dbdUsers = 'DELETE FROM ' . TEAM_USER_RANK_TABLE . ' WHERE teamuserteam_id = ' . (int) $TeamId . ' ';
                mysql_query($dbdUsers);
            }
            else {
                $TeamId = mysql_insert_id();
            }

            $dbrSetUserRank = 'INSERT INTO ' . TEAM_USER_RANK_TABLE . ' (teamuserteam_id, teamrank_id) VALUES ';
            $i = 0;
            foreach ($_REQUEST['ranks'] as $rank) {
                if ($i > 0) {
                    $dbrSetUserRank .= ', ';
                }
                $dbrSetUserRank .= ' (' . (int) $TeamId . ', ' . (int) $rank . ') ';
                $i++;
            }

            if (mysql_query($dbrSetUserRank)) {
                header('Refresh:0, url=index.php?file=Team&page=admin&op='.$op.'&conf=7');
            }
            // Si la requete n'a pas réussi
            else {
                ?>
                <div class="borderBox margin0-10">
                    <div class="notification error widthAuto">
                        <div>
                            <?php
                            echo nk_debug_bt() . '<br />' . TEAM_QUERY . ' ' . $dbrSetUser ;
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            }

        }
        else if ($action === 'del') {

            $users = getUsers($id);
            if ($users && sizeof($users)) {
                $dbdRanks = 'DELETE FROM ' . TEAM_USER_TABLE . ' WHERE id = ' . (int) $users[0]['teamuser_id'] . ' ';

                // execution de la requete
                if (mysql_query($dbdRanks)) {
                    header('Refresh:0, url=index.php?file=Team&page=admin&op='.$op.'&conf=8');
                }
                else {

                    ?>
                    <div class="borderBox margin0-10">
                        <div class="notification error widthAuto">
                            <div>
                                <?php
                                echo nk_debug_bt() . '<br />' . TEAM_QUERY . ' ' . $dbdRanks ;
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }

        }
        else if (isset($_REQUEST['btnSubmit']) && $action === 'edit_user') {
            // Get Team User ID
            $dbsGetTeamUserId = 'SELECT user_id, teamstatus_id FROM ' . TEAM_USER_TABLE . ' WHERE id = "' . (int) $id . '" ';
            // Execute
            $dbeGetTeamUserId = mysql_query($dbsGetTeamUserId);
            // Get Row
            $dbaGetTeamUserId = mysql_fetch_assoc($dbeGetTeamUserId);

            $TeamUserId = $dbaGetTeamUserId['user_id'];

            // User
            $dbiSetUser = 'REPLACE INTO ' . TEAM_USER_TABLE . ' (id, user_id, teamstatus_id) VALUES (' . ($id ? (int) $id : 'NULL') . ', "' . mysql_real_escape_string($TeamUserId) . '", ' . ($_REQUEST['status'] ? (int) $_REQUEST['status'] : 'NULL') . ') ';


            if (mysql_query($dbiSetUser)) {
                header('Refresh:0, url=index.php?file=Team&page=admin&op='.$op.'&action=list_status&conf=7');
            }
            // Si la requete n'a pas réussi
            else {
                ?>
                <div class="borderBox margin0-10">
                    <div class="notification error widthAuto">
                        <div>
                            <?php
                            echo nk_debug_bt() . '<br />' . TEAM_QUERY . ' ' . $dbrSetUser ;
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            }

        }
    }
    else if ($op === 'settings') {
        if(isset($_REQUEST['btnSubmit'])) {
            $dbuSetConfig = 'UPDATE ' . TEAM_SETTINGS_TABLE . ' SET value = "%s" WHERE name = "%s" ';

            if (
                mysql_query(sprintf($dbuSetConfig, $_REQUEST['team_page'], 'team_page'))
                && mysql_query(sprintf($dbuSetConfig, $_REQUEST['display_type'], 'display_type'))
                && mysql_query(sprintf($dbuSetConfig, (int) isset($_REQUEST['picture']), 'picture'))
            ) {
                header('Refresh:0, url=index.php?file=Team&page=admin&op='.$op.'&conf=9');
            }
            // Si la requete n'a pas réussi
            else {
                ?>
                <div class="borderBox margin0-10">
                    <div class="notification error widthAuto">
                        <div>
                            <?php
                            echo nk_debug_bt() . '<br />' . TEAM_QUERY . ' ' . $dbrSetUser ;
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
    }
}

/**
 * Récupère les values envoyé par le post|get
 * @param  String $key     Clé à retrouver
 * @param  String|boolean $default Valeur par défaut si pas trouvé
 * @return String|boolean Valeur retourné
 */
function getValue ($key, $default = false) {
    if (isset($_REQUEST[$key]) && !empty($_REQUEST[$key])) {
        return $_REQUEST[$key];
    } else {
        return $default;
    }
}

/**
 * Affiche un message de confirmation
 * @param  int $case Clé du message
 */
function displayConf ($case) {
    ?>
    <div class="margin0-10 borderBox">
        <div class="notification success widthAuto">
            <div>
                <?php
                    switch ($case) {
                        case '1':
                            echo TEAM_REGISTERED;
                            break;

                        case '2':
                            echo TEAM_DELETED;
                            break;

                        case '3':
                            echo TEAM_STATUS_REGISTERED;
                            break;

                        case '4':
                            echo TEAM_STATUS_DELETED;
                            break;

                        case '5':
                            echo TEAM_RANK_REGISTERED;
                            break;

                        case '6':
                            echo TEAM_RANK_DELETED;
                            break;

                        case '7':
                            echo TEAM_USER_REGISTERED;
                            break;

                        case '8':
                            echo TEAM_USER_DELETED;
                            break;

                        case '9':
                            echo TEAM_SETTINGS_SAVED;
                            break;

                        default:
                            break;
                    }
                ?>
            </div>
        </div>
    </div>
    <?php
}

function uploadImage($file, $dest_path, $dest_file) {

    if (!isset($file['tmp_name']))
        return true;

    // Si le dossier existe pas on le créé
    if (is_dir($dest_path) === false) {
        @mkdir($dest_path, 0755, true);
    }

    $dest_path = realpath($dest_path).DIRECTORY_SEPARATOR;

    if ($file['error'] !== 0) {
        return false;
    }

    $types = array('.jpeg', '.jpg', '.png', '.gif');

    // Format du fichier uploadé
    $type = strrchr($file['name'], '.');
    if (!in_array($type, $types)) {
        return false;
    }

    // Le fichier n'est pas uploadé
    if (is_uploaded_file($file['tmp_name']) === false) {
        return false;
    }

    // On upload le fichier
    if (move_uploaded_file($file['tmp_name'], $dest_path . $dest_file . $type) === false) {
        return false;
    }

    return $dest_file . $type;
}

// Haut
admintop();

// Affichage de l'admin l'admin
displayAdmin();

// Bas
adminfoot();

?>
