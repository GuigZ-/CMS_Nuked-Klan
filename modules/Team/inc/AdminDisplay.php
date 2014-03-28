<?php
/**
 * Admin display
 *
 * @version     1.8
 * @link http://www.nuked-klan.org Clan Clan Management System for Gamers
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @copyright 2001-2013 Nuked-Klan (Registred Trademark)
 */

/**a
 * Affiche l'admin
 */
function displayAdmin () {

    if (!($op = nkGetValue('op')) || $op === 'index') {
        $op = "teams";
    }

    if (!$action = nkGetValue('action')) {
        $action = "list";
    }

    $id = null;


    if(($action === 'edit' || $action === 'del' || $action === 'edit_user' || $action === 'del_user') && preg_match("#^[0-9]+$#isD", nkGetValue('id'))) {
        $id = nkGetValue('id');
    }
    /**
     * @TODO DELETE NEXT LINE
     */
    ?>
    <div class="content-box">
        <div class="tab-content">
    <?php
            displayMenu($op);
            displaySubMenu($op, $action);
            if ($conf = nkGetValue('conf')) {
                nkDisplayConf($conf);
            }
            postProcess($op, $action, $id);
    ?>
            <div class="widget">
    <?php
                displayContent($op, $action, $id);
    ?>
            </div>
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
        'teams'        => array('name' => TEAM_MANAGEMENT_TEAMS, 'icon' => 'groups'),
        'manage_users' => array('name' => TEAM_MANAGEMENT_USERS, 'icon' => 'users'),
        'status'       => array('name' => TEAM_MANAGEMENT_STATUS, 'icon' => ''),
        'ranks'        => array('name' => TEAM_MANAGEMENT_RANKS, 'icon' => ''),
        'settings'     => array('name' => TEAM_PREFERENCES, 'icon' => 'settings'),
    );

    nkDisplayContentMenu($menus, $op);
}

/**
 * Affiche un sous menu
 * @param  string $op
 */
function displaySubMenu ($op, $action) {

    switch ($op) {
        case 'teams':
            $menus = array(
                'list' => array('name' => TEAM_ADMIN_LIST, 'icon' => ''),
                'add'  => array('name' => TEAM_ADMIN_ADD_TEAM,'icon' => 'add' )
                );
            nkDisplayContentMenu($menus, $action, 'action', $op);
            break;

        case 'manage_users':
            $menus = array(
                'list' => array('name' => TEAM_ADMIN_LIST, 'icon' => ''),
                'add'  => array('name' => TEAM_ADMIN_ADD_COMBINAISON, 'icon' => 'add'),
                'list_status'  => array('name' => TEAM_ADMIN_LIST_STATUS,'icon' => '' )
                );
            nkDisplayContentMenu($menus, $action, 'action', $op);
            break;

        case 'status':
            $menus = array(
                'list' => array('name' => TEAM_ADMIN_LIST, 'icon' => ''),
                'add'  => array('name' => TEAM_ADMIN_ADD_STATUS,'icon' => 'add' )
                );
            nkDisplayContentMenu($menus, $action, 'action', $op);
            break;

        case 'ranks':
            $menus = array(
                'list' => array('name' => TEAM_ADMIN_LIST, 'icon' => ''),
                'add'  => array('name' => TEAM_ADMIN_ADD_RANK,'icon' => 'add' )
                );
            nkDisplayContentMenu($menus, $action, 'action', $op);
            break;

        default:
            break;
    }
}

/**
 * Affiche le contenu
 * @param  string $op
 * @param  string $action
 */
function displayContent ($op, $action, $id = null) {
    switch ($op) {
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
            <div class="nNote nFailure nNoteHideable">
                <p>
                    <?php
                    echo TEAM_404;
                    ?>
                </p>
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
    <div class="whead">
        <h6>&nbsp;</h6>
        <div class="clear both"></div>
    </div>
    <table class="tDefault tableDnD" data-table="<?php echo TEAM_TABLE; ?>">
        <thead>
            <tr>
                <td>
                    <strong><?php echo TEAM_NAME; ?></strong>
                </td>
                <td>
                    <strong><?php echo TEAM_PREFIX; ?></strong>
                    </td>
                <td>
                    <strong><?php echo TEAM_SUFFIX; ?></strong>
                </td>
                <td>
                    <strong><?php echo TEAM_ORDER; ?></strong>
                </td>
                <td>
                    <strong><?php echo TEAM_ACTIONS; ?></strong>
                </td>
            </tr>
        </thead>
        <tbody>
            <!-- Equipes -->
            <?php
                $teams = nkGetTeams();
                if ($teams !== false && is_array($teams) && sizeof($teams)) {
                    foreach ($teams as $value) {
                        ?>
                        <tr data-id="<?php echo $value['id']; ?>">
                            <!-- Nom -->
                            <td>
                                <?php
                                    echo printSecuTags($value['name']);
                                ?>
                            </td>
                            <!-- Prefix -->
                            <td>
                                <?php
                                    if (isset($value['prefix']) && empty($value['prefix']) === false) {
                                        echo printSecuTags($value['prefix']);
                                    }
                                    else {
                                        echo "-";
                                    }
                                ?>
                            </td>
                            <!-- Suffix -->
                            <td>
                                <?php
                                    if (isset($value['suffix']) && empty($value['suffix']) === false) {
                                        echo printSecuTags($value['suffix']);
                                    }
                                    else {
                                        echo "-";
                                    }
                                ?>
                            </td>
                            <!-- Ordre -->
                            <td class="order">
                                <?php
                                    echo printSecuTags($value['order']);
                                ?>
                            </td>
                            <td class="center">
                                <a class="tablectrl_medium bDefault tipS nkIcons icon-edit" href="<?php echo nkGetLink(false, null, array("action" => "edit", "id" => $value['id'])); ?>"></a>
                                <a class="tablectrl_medium bDefault tipS nkIcons icon-delete"  href="<?php echo nkGetLink(false, null, array("action" => "edit", "id" => $value['id'])); ?>"></a>
                            </td>
                        </tr>
                        <?php
                    }
                }
                else {
                    ?>
                    <tr>
                        <td colspan="5">
                            <?php echo TEAM_NO_TEAM_REGISTERED; ?>
                        </td>
                    </tr>
                    <?php
                }
            ?>
            <!-- /Equipes -->
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="body center">
                    <a class="buttonM bDefault" href="index.php?file=Admin"><?php echo BACK; ?></a>
                </td>
            </tr>
        </tfoot>
    </table>
    <?php
}

/**
 * Formulaire de gestion des équipes
 * @param  boolean $id ID à éditer
 */
function formTeams ($id = false) {
    if ($id) {
        $team        = nkGetTeams((int) $id);
        $name        = nkGetValue('name',        $team['name']);
        $image       = nkGetValue('image',       $team['image']);
        $description = nkGetValue('description', $team['description']);
        $suffix      = nkGetValue('suffix',      $team['suffix']);
        $prefix      = nkGetValue('prefix',      $team['prefix']);
        $teamGroups  = nkGetValue('groups',      $team['groups']);
        $teamGames   = nkGetValue('games',       $team['games']);
    }
    else {
        $name        = nkGetValue('name');
        $image       = nkGetValue('image');
        $description = nkGetValue('description');
        $suffix      = nkGetValue('suffix');
        $prefix      = nkGetValue('prefix');
        $teamGroups  = nkGetValue('groups');
        $teamGames   = nkGetValue('games');
    }

    if ($teamGroups != null && is_array($teamGroups) === false) {
        $teamGroups = explode(',', $teamGroups);
    }

    if ($teamGames != null && is_array($teamGames) === false) {
        $teamGames = explode(',', $teamGames);
    }

    if ($teamGroups && sizeof($teamGroups)) {
        $teamGroups = array_unique($teamGroups);
    }

    if ($teamGames && sizeof($teamGames)) {
        $teamGames = array_unique($teamGames);
    }

    ?>
    <form action="" method="POST" class="form" autocomplete="off" enctype="multipart/form-data">
        <div class="fluid">
            <!-- Name -->
            <div class="formRow">
                <div class="grid3">
                    <label for="name">
                        <?php
                            echo TEAM_NAME . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="grid9">
                    <input type="text" name="name" id="name" value="<?php echo $name; ?>" class="validate[required]">
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Name -->
            <!-- Image -->
            <div class="formRow">
                <div class="grid3 quarter">
                    <label for="name">
                        <?php
                            echo TEAM_IMAGE . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="grid9">
                    <input type="file" name="image" id="image" value="<?php echo $image; ?>" class="validate[required]" />
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Image -->
            <!-- Description -->
            <div class="formRow">
                <div class="grid3 quarter">
                    <label for="name">
                        <?php
                            echo TEAM_DESCRIPTION . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="grid9">
                    <textarea type="text" name="description" id="description" class="editor"><?php echo $description; ?></textarea>
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Description -->
            <!-- Prefix -->
            <div class="formRow">
                <div class="grid3">
                    <label for="prefix">
                        <?php
                            echo TEAM_PREFIX . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="grid9">
                    <input type="text" name="prefix" id="prefix" value="<?php echo $prefix; ?>">
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Prefix -->
            <!-- Suffix -->
            <div class="formRow">
                <div class="grid3">
                    <label for="suffix">
                        <?php
                            echo TEAM_SUFFIX . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="grid9">
                    <input type="text" name="suffix" id="suffix" value="<?php echo $suffix; ?>">
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Suffix -->
            <!-- Groups -->
            <div class="formRow">
                <div class="grid3">
                    <label for="suffix">
                        <?php
                            echo TEAM_GROUPS . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="grid9">
                    <?php
                        $groups = getNkGroups();
                        if ($groups) {
                            foreach ($groups as $id => $name) {
                                echo '<div><input type="checkbox" class="check" name="groups[]" value="'.$id.'" id="group_' . $id . '" ' . ( is_array($teamGroups) && in_array($id, $teamGroups) ? 'checked="checked"' : '') . ' /> <label for="group_' . $id . '" class="inlineBlock">' . ucfirst(strtolower($name)) . '</label><br /></div>';
                            }
                        }
                    ?>
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Groups -->
            <!-- Games -->
            <div class="formRow">
                <div class="grid3">
                    <label for="suffix">
                        <?php
                            echo TEAM_GAMES . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="grid9">
                    <?php
                        $games = nkGetGames();
                        if ($games) {
                            foreach ($games as $id => $game) {
                                echo '<div><input type="checkbox" class="check" name="games[]" value="'.$id.'" id="game_' . $id . '" ' . ( is_array($teamGames) && in_array($id, $teamGames) ? 'checked="checked"' : '') . ' /> <label for="game_' . $id . '" class="inlineBlock">' . ucfirst(strtolower($game['name'])) . '</label><br /></div>';
                            }
                        }
                    ?>
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Games -->
            <div class="body center">
                <input type="submit" name="btnSubmit" class="buttonM bBlue">
                <a class="buttonM bDefault" href="<?php echo nkGetLink(); ?>"><?php echo BACK; ?></a>
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
    <div class="whead">
        <h6>&nbsp;</h6>
        <div class="clear both"></div>
    </div>
    <table class="tDefault">
        <thead>
            <tr>
                <td>
                    <strong><?php echo TEAM_NICKAME; ?></strong>
                </td>
                <td>
                    <strong><?php echo TEAM_TEAM; ?></strong>
                </td>
                <td>
                    <strong><?php echo TEAM_RANKS; ?></strong>
                </td>
                <td>
                    <strong><?php echo TEAM_ACTIONS; ?></strong>
                </td>
            </tr>
        </thead>
        <tbody>
            <!-- Status -->
            <?php
            $users = getUsers();
            if ($users !== false && is_array($users) && sizeof($users)) {
                foreach ($users as $value) {
                    ?>
                        <tr>
                            <td>
                                <?php
                                    if (isset($value['pseudo']) && empty($value['pseudo']) === false) {
                                        echo printSecuTags($value['pseudo']);
                                    }
                                    else {
                                        echo "-";
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    if (isset($value['team_name']) && empty($value['team_name']) === false) {
                                        echo printSecuTags($value['team_name']);
                                    }
                                    else {
                                        echo "-";
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    if (isset($value['ranks_name']) && empty($value['ranks_name']) === false) {
                                        echo printSecuTags($value['ranks_name']);
                                    }
                                    else {
                                        echo "-";
                                    }
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
                        <?php
                            echo TEAM_NO_USERS_REGISTERED;
                        ?>
                    </td>
                </tr>
                <?php
            }
            ?>
            <!-- /Status -->
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="body center">
                    <a class="buttonM bDefault" href="index.php?file=Admin"><?php echo BACK; ?></a>
                </td>
            </tr>
        </tfoot>
    </table>
    <?php
}

/**
 * Affiche la liste des utilisateurs avec leur statut
 */
function listUsersStatus() {
    ?>

    <div class="whead">
        <h6>&nbsp;</h6>
        <div class="clear both"></div>
    </div>
    <table class="tDefault">
        <thead>
            <tr>
                <td>
                    <strong><?php echo LOGIN; ?></strong>
                </td>
                <td>
                    <strong><?php echo TEAM_STATUS; ?></strong>
                </td>
                <td>
                    <strong><?php echo TEAM_ACTIONS; ?></strong>
                </td>
            </tr>
        </thead>
        <tbody>
        <?php
            $users = getUsersStatus();
            if ($users !== false && is_array($users) && sizeof($users)) {
                foreach ($users as $value) {
                    ?>
                    <tr>
                        <td>
                            <?php
                                if (isset($value['pseudo']) && empty($value['pseudo']) === false) {
                                    echo printSecuTags($value['pseudo']);
                                }
                                else {
                                    echo "-";
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if (isset($value['status_name']) && empty($value['status_name']) === false) {
                                    echo printSecuTags($value['status_name']);
                                }
                                else {
                                    echo "-";
                                }
                            ?>
                        </td>
                        <td class="center">
                            <a class="tablectrl_medium bDefault tipS nkIcons icon-edit" href="<?php echo nkGetLink(false, null, array("action" => "edit_user", "id" => $value['id'])); ?>"></a>
                            <a class="tablectrl_medium bDefault tipS nkIcons icon-delete"  href="<?php echo nkGetLink(false, null, array("action" => "del_user", "id" => $value['id'])); ?>"></a>
                        </td>
                    </tr>
                    <?php
                }
            }
            else {
                ?>
                <tr>
                    <td colspan="3">
                        <?php
                            echo TEAM_NO_USERS_REGISTERED;
                        ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="body center">
                    <a class="buttonM bDefault" href="index.php?file=Admin"><?php echo BACK; ?></a>
                </td>
            </tr>
        </tfoot>
    </table>
    <?php
}

/**
 * Formulaire d'utilisateur
 * @param integer $id id à éditer
 */
function formUsers ($id = false) {
    $users = nkGetUsers();
    $teams = nkGetTeams();
    $ranks = nkGetTeamsRanks();
    if ($id) {
        $associations = getUsers($id);
        $association = $associations[0];
        $user_id = nkGetValue('user', $association['user_id']);
        $team_id = nkGetValue('team', $association['team_id']);
        $description = nkGetValue('description', $association['description']);
        $rank_ids = nkGetValue('ranks', explode(',', $association['ranks']));
    }
    else {
        $user_id = nkGetValue('user');
        $team_id = nkGetValue('team');
        $description = nkGetValue('description');
        $rank_ids = nkGetValue('ranks', array());
    }

    if ($teams === false || (int) sizeof($teams) === 0){
        ?>
        <div class="nNote nFailure nNoteHideable">
            <p>
                <?php
                echo TEAM_NO_TEAM_REGISTERED;
                ?>
            </p>
        </div>
            <?php
        return;
    }

    ?>
    <form action="" method="POST" class="form" autocomplete="off">
        <div class="fluid">
            <!-- Membre -->
            <div class="formRow">
                <div class="grid3">
                    <label for="name">
                        <?php
                            echo MEMBER . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="grid9 noSearch">
                    <select name="user" class="select validate[required]">
                        <option value=""><?php echo TEAM_CHOOSE; ?></option>
                        <?php
                            foreach ($users as $user) {
                                ?>
                                    <option value="<?php echo $user['id']; ?>"<?php echo ($user_id == $user['id'] ? ' selected' : ''); ?>><?php echo $user['pseudo']; ?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Membre -->
            <!-- Team -->
            <div class="formRow">
                <div class="grid3">
                    <label for="name">
                        <?php
                            echo TEAM . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="grid9 noSearch">
                    <select class="select" name="team">
                        <option value=""><?php echo TEAM_CHOOSE; ?></option>
                        <?php
                            foreach ($teams as $team) {
                                ?>
                                    <option value="<?php echo $team['id']; ?>"<?php echo ($team_id == $team['id'] ? ' selected' : ''); ?>><?php echo $team['name']; ?></option>
                                <?php
                            }
                        ?>
                    </select class="validate[required]">
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Team -->
            <!-- Description -->
            <div class="formRow">
                <div class="grid3 quarter">
                    <label for="name">
                        <?php
                            echo TEAM_DESCRIPTION . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="grid9">
                    <textarea type="text" name="description" id="description" class="editor"><?php echo $description; ?></textarea>
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Description -->
            <!-- Ranks -->
            <div class="formRow">
                <div class="grid3">
                    <label for="name">
                        <?php
                            echo TEAM_RANK . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="grid9">
                    <div class="table tableWidth100">
                        <?php
                            $i = 0;
                            foreach ($ranks as $rank) {
                                ?>
                                    <div>
                                        <input name="ranks[<?php echo $rank['id']; ?>]" value="<?php echo $rank['id']; ?>" type="checkbox" class="check" id="rank_<?php echo $rank['id']; ?>"<?php  echo (in_array($rank['id'], $rank_ids) ? ' checked' : ''); ?> />
                                        <label for="rank_<?php echo $rank['id']; ?>"><?php echo $rank['name']; ?></label>
                                    </div>
                                <?php
                            }
                        ?>
                    </div>
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Ranks -->
            <div class="body center">
                <input type="submit" name="btnSubmit" class="buttonM bBlue">
                <a class="buttonM bDefault" href="<?php echo nkGetLink(); ?>"><?php echo BACK; ?></a>
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
    $status = nkGetTeamsStatus();
    if ($id) {
        $associations = getUsersStatus($id);
        $association = $associations[0];
        $pseudo = $association['pseudo'];
        $status_id = nkGetValue('status', $association['status']);
    }

    ?>
    <form action="" method="POST" class="form" autocomplete="off">
        <div class="fluid">
            <!-- Membre -->
            <div class="formRow">
                <div class="grid3">
                    <label for="name">
                        <?php
                            echo MEMBER . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="grid9">
                    <?php echo $pseudo; ?>
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Membre -->
            <!-- Team -->
            <div class="formRow">
                <div class="grid3">
                    <label for="name">
                        <?php
                            echo TEAM_STATUS . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="grid9 noSearch">
                    <select name="status" class="select validate[required]">
                        <option value=""><?php echo TEAM_CHOOSE; ?></option>
                        <?php
                            foreach ($status as $state) {
                                ?>
                                    <option value="<?php echo $state['id']; ?>"<?php echo ($status_id == $state['id'] ? ' selected' : ''); ?>><?php echo $state['name']; ?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Team -->
            <div class="body center">
                <input type="submit" name="btnSubmit" class="buttonM bBlue">
                <a class="buttonM bDefault" href="<?php echo nkGetLink(); ?>"><?php echo BACK; ?></a>
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
    <div class="whead">
        <h6>&nbsp;</h6>
        <div class="clear both"></div>
    </div>
    <table class="tDefault">
        <thead>
            <tr>
                <td>
                    <strong><?php echo TEAM_NAME; ?></strong>
                </td>
                <td>
                    <strong><?php echo TEAM_ACTIONS; ?></strong>
                </td>
            </tr>
        </thead>
        <tbody>
        <?php
            $status = nkGetTeamsStatus();
            if ($status !== false && is_array($status) && sizeof($status)) {
                foreach ($status as $value) {
                    ?>
                        <tr>
                            <td>
                                <?php
                                    if (isset($value['name']) && empty($value['name']) === false) {
                                        echo printSecuTags($value['name']);
                                    }
                                    else {
                                        echo "-";
                                    }
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
                    ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="body center">
                    <a class="buttonM bDefault" href="index.php?file=Admin"><?php echo BACK; ?></a>
                </td>
            </tr>
        </tfoot>
    </table>
    <?php
}
/**
 * Formulaire de statut
 * @param integer $id id à éditer
 */
function formStatus ($id = false) {

    if ($id) {
        $status = nkGetTeamsStatus((int) $id);
        $name = nkGetValue('name', $status['name']);
    }
    else {
        $name =  nkGetValue('name');
    }

    ?>
    <form action="" method="POST" class="form" autocomplete="off">
        <div class="fluid">
            <!-- Name -->
            <div class="formRow">
                <div class="grid3">
                    <label for="name">
                        <?php
                            echo TEAM_NAME . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="grid9">
                    <input type="text" name="name" id="name" value="<?php echo $name; ?>" class="validate[required]">
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Name -->
            <div class="body center">
                <input type="submit" name="btnSubmit" class="buttonM bBlue">
                <a class="buttonM bDefault" href="<?php echo nkGetLink(); ?>"><?php echo BACK; ?></a>
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
    <div class="whead">
        <h6>&nbsp;</h6>
        <div class="clear both"></div>
    </div>
    <table class="tDefault tableDnD" data-table="<?php echo TEAM_RANK_TABLE; ?>">
        <thead>
            <tr>
                <td>
                    <strong><?php echo TEAM_NAME; ?></strong>
                </td>
                <td>
                    <strong><?php echo TEAM_ORDER; ?></strong>
                </td>
                <td>
                    <strong><?php echo TEAM_ACTIONS; ?></strong>
                </td>
            </tr>
        </thead>
        <tbody>
        <!-- ranks -->
        <?php
            $ranks = nkGetTeamsRanks();
            if ($ranks !== false && is_array($ranks) && sizeof($ranks)) {
                foreach ($ranks as $value) {
                    ?>
                        <tr data-id="<?php echo $value['id']; ?>">
                            <td>
                                <?php
                                    if (isset($value['name']) && empty($value['name']) === false) {
                                        echo printSecuTags($value['name']);
                                    }
                                    else {
                                        echo "-";
                                    }
                                ?>
                            </td>
                            <td class="order">
                                <?php
                                    echo printSecuTags($value['order']);
                                ?>
                            </td>
                            <td class="center">
                                <a class="tablectrl_medium bDefault tipS nkIcons icon-edit" href="<?php echo nkGetLink(false, null, array("action" => "edit", "id" => $value['id'])); ?>"></a>
                                <a class="tablectrl_medium bDefault tipS nkIcons icon-delete"  href="<?php echo nkGetLink(false, null, array("action" => "edit", "id" => $value['id'])); ?>"></a>
                            </td>
                        </tr>
                    <?php
                }
            }
            else {
                ?>
                <tr>
                    <td colspan="3">
                            <?php
                                echo TEAM_NO_RANK_REGISTERED;
                            ?>
                    </td>
                </tr>
                <?php
            }
                    ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="body center">
                    <a class="buttonM bDefault" href="index.php?file=Admin"><?php echo BACK; ?></a>
                </td>
            </tr>
        </tfoot>
    </table>
    <?php
}

/**
 * Formulaire de rank
 * @param integer $id id à éditer
 */
function formRanks ($id = false) {

    if ($id) {
        $ranks = nkGetTeamsRanks((int) $id);
        $name = nkGetValue('name', $ranks['name']);
    }
    else {
        $name =  nkGetValue('name');
    }

    ?>
    <form action="" method="POST" class="form" autocomplete="off">
        <div class="fluid">
            <!-- Name -->
            <div class="formRow">
                <div class="grid3">
                    <label for="name">
                        <?php
                            echo TEAM_NAME . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="grid9">
                    <input type="text" name="name" id="name" value="<?php echo $name; ?>" class="validate[required]">
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Name -->
            <div class="body center">
                <input type="submit" name="btnSubmit" class="buttonM bBlue">
                <a class="buttonM bDefault" href="<?php echo nkGetLink(); ?>"><?php echo BACK; ?></a>
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
        <div class="fluid">
            <!-- Team par page -->
            <div class="formRow">
                <div class="grid3">
                    <label for="team_page">
                        <?php
                            echo TEAM_SETTINGS_TEAM_PAGE . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="grid9">
                    <input type="text" name="team_page" id="team_page" value="<?php echo (isset($config['team_page']) ? $config['team_page'] : ''); ?>" class="validate[required]">
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Team par page -->
            <!-- Affichage -->
            <div class="formRow">
                <div class="grid3">
                    <label for="display_type">
                        <?php
                            echo TEAM_SETTINGS_DISPLAY_TYPE . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="grid9 noSearch">
                    <select name="display_type" id="display_type" class="select validate[required]">
                        <option value="table"<?php echo (isset($config['display_type']) && $config['display_type']  == 'table' ? ' selected' : ''); ?>><?php echo TEAM_DISPLAY_TYPE_TABLE; ?></option>
                        <option value="alternate"<?php echo (isset($config['display_type']) && $config['display_type']  == 'alternate' ? ' selected' : ''); ?>><?php echo TEAM_DISPLAY_TYPE_ALT; ?></option>
                        <option value="bloc"<?php echo (isset($config['display_type']) && $config['display_type']  == 'bloc' ? ' selected' : ''); ?>><?php echo TEAM_DISPLAY_TYPE_BLOC; ?></option>
                    </select>
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Affichage -->
            <!-- Choose photo -->
            <div class="formRow">
                <div class="grid3">
                    <label for="picture">
                        <?php
                            echo TEAM_SETTINGS_PICTURE . ' :' ;
                        ?>
                    </label>
                </div>
                <div class="grid9">
                    <input type="checkbox" value="1" name="picture" id="picture" <?php echo (isset($config['picture']) && $config['picture']  == 1 ? ' checked ' : ''); ?>class="check validate[required]" />
                </div>
                <div class="clear both"></div>
            </div>
            <!-- /Choose photo -->
            <div class="body center">
                <input type="submit" name="btnSubmit" class="buttonM bBlue">
                <a class="buttonM bDefault" href="index.php?file=Admin"><?php echo BACK; ?></a>
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
        if (nkGetValue('btnSubmit') && ($action === 'add' || $action === 'edit')) {
            // Si tous les champs ne sont pas remplis
            if (!nkGetValue('name') || (!$id && empty($_FILES['image']['tmp_name']))) {
                ?>
                    <div class="nNote nFailure nNoteHideable">
                        <p>
                            <?php
                            echo TEAM_FORM_EMPTY;
                            ?>
                        </p>
                    </div>
                <?php
                return;
            }

            $dbsExists = 'SELECT COUNT(name) AS total, id FROM ' . TEAM_TABLE . ' WHERE name = "' . mysql_real_escape_string(nkGetValue('name')) . '" ';
            $dbeExists = mysql_query($dbsExists);
            $dbaExists = mysql_fetch_assoc($dbeExists);
            if ($dbaExists['total'] == 0 || ($id && $id == $dbaExists['id'] && $dbaExists['total'] == 1)) {

                $dir = dirname(__FILE__) .'/upload/';

                $image = nkUploadImage($_FILES['image'], $dir, nkGetValue('name') );

                // si c'est un update
                if ($id) {
                    $dbrSetTeam = 'UPDATE ' . TEAM_TABLE . ' SET name = "' . mysql_real_escape_string(nkGetValue('name')) . '", description = "' . mysql_real_escape_string(nkGetValue('description')) . '", suffix =  "' . mysql_real_escape_string(nkGetValue('suffix')) . '", prefix = "' . mysql_real_escape_string(nkGetValue('prefix')) . '"'.($image ? ', image = "'.mysql_real_escape_string($image).'" ' : '').' WHERE id = "' . (int) $id . '"';
                }
                // Si c'est une insertion
                else {
                    $dbrSetTeam = 'INSERT INTO ' . TEAM_TABLE . ' (id, name, description, suffix, prefix, `order`, image) SELECT NULL, "' . mysql_real_escape_string(nkGetValue('name')) . '", "' . mysql_real_escape_string(nkGetValue('description')) . '", "' . mysql_real_escape_string(nkGetValue('suffix')) . '", "' . mysql_real_escape_string(nkGetValue('prefix')) . '", (MAX(`order`) + 1), "'.mysql_real_escape_string($image).'" FROM ' . TEAM_TABLE . ' ';
                }

                // execution de la requete
                if (mysql_query($dbrSetTeam)) {
                    if (!$id) {
                        $id = mysql_insert_id();
                    }
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

                    $groups = nkGetValue('groups');

                    if (is_array($groups) && sizeof($groups)) {
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

                    $games = nkGetValue('games');

                    if (is_array($games) && sizeof($games)) {
                        $i = 0;
                        foreach($games as $game) {
                            if ($i > 0) {
                                $dbrTeamGame .= ', ';
                            }
                            $dbrTeamGame .= ' ( '. (int)$id .', ' . (int)$game . ' ) ';
                            $i++;
                        }
                        mysql_query($dbrTeamGame);
                    }

                    header('Refresh:0, url='.nkGetLink(true));
                }
                // Si la requete n'a pas réussi
                else {
                    ?>
                    <div class="nNote nFailure nNoteHideable">
                        <p>
                            <?php
                            echo nk_debug_bt() . '<br />' . TEAM_QUERY . ' ' . $dbrSetTeam ;
                            ?>
                        </p>
                    </div>
                    <?php
                }
            }
            else {
                ?>
                <div class="nNote nFailure nNoteHideable">
                    <p>
                        <?php
                        echo TEAM_EXISTS;
                        ?>
                    </p>
                </div>
                <?php
            }
        }
        else if ($action === 'del') {

            $team = nkGetTeams($id);
            if ($team && sizeof($team)) {
                $dbdTeam = 'DELETE FROM ' . TEAM_TABLE . ' WHERE id = ' . (int) $id . ' ';

                // execution de la requete
                if (mysql_query($dbdTeam)) {
                    header('Refresh:0, url='.nkGetLink(true, 2));
                }
                else {

                    ?>
                        <div class="nNote nFailure nNoteHideable">
                            <p>
                                <?php
                                echo nk_debug_bt() . '<br />' . TEAM_QUERY . ' ' . $dbdTeam ;
                                ?>
                            </p>
                        </div>
                    <?php
                }
            }

        }
    }
    else if ($op === 'status') {
        // Si le formulaire est envoyé
        if (nkGetValue('btnSubmit') && ($action === 'add' || $action === 'edit')) {

            // Si tous les champs ne sont pas remplis
            if (!nkGetValue('name')) {
                ?>
                    <div class="nNote nFailure nNoteHideable">
                        <p>
                            <?php
                            echo TEAM_FORM_EMPTY;
                            ?>
                        </p>
                    </div>
                <?php
                return;
            }

            $dbsExists = 'SELECT COUNT(name) AS total, id FROM ' . TEAM_STATUS_TABLE . ' WHERE name = "' . mysql_real_escape_string(nkGetValue('name')) . '" ';
            $dbeExists = mysql_query($dbsExists);
            $dbaExists = mysql_fetch_assoc($dbeExists);

            if ($dbaExists['total'] == 0 || ($id && $id == $dbaExists['id'] && $dbaExists['total'] == 1)) {
                // si c'est un update
                if ($id) {
                    $dbrSetStatus = 'UPDATE ' . TEAM_STATUS_TABLE . ' SET name = "' . mysql_real_escape_string(nkGetValue('name')) . '" WHERE id = "' . (int) $id . '"';
                }
                // Si c'est une insertion
                else {
                    $dbrSetStatus = 'INSERT INTO ' . TEAM_STATUS_TABLE . ' (id, name) VALUES (NULL, "'. mysql_real_escape_string(nkGetValue('name')).'") ';
                }
                // execution de la requete
                if (mysql_query($dbrSetStatus)) {
                    header('Refresh:0, url='.nkGetLink(true));
                }
                // Si la requete n'a pas réussi
                else {
                    ?>
                        <div class="nNote nFailure nNoteHideable">
                            <p>
                                <?php
                                echo nk_debug_bt() . '<br />' . TEAM_QUERY . ' ' . $dbrSetStatus ;
                                ?>
                            </p>
                        </div>
                    <?php
                }
            }
        }
        else if ($action === 'del') {

            $status = nkGetTeamsStatus($id);
            if ($status && sizeof($status)) {
                $dbdStatus = 'DELETE FROM ' . TEAM_STATUS_TABLE . ' WHERE id = ' . (int) $id . ' ';

                // execution de la requete
                if (mysql_query($dbdStatus)) {
                    header('Refresh:0, url='.nkGetLink(true, 2));
                }
                else {

                    ?>
                        <div class="nNote nFailure nNoteHideable">
                            <p>
                                <?php
                                echo nk_debug_bt() . '<br />' . TEAM_QUERY . ' ' . $dbdStatus ;
                                ?>
                            </p>
                        </div>
                    <?php
                }
            }

        }
    }
    else if ($op === 'ranks') {
        // Si le formulaire est envoyé
        if (nkGetValue('btnSubmit') && ($action === 'add' || $action === 'edit')) {

            // Si tous les champs ne sont pas remplis
            if (!nkGetValue('name')) {
                ?>
                    <div class="nNote nFailure nNoteHideable">
                        <p>
                            <?php
                            echo TEAM_FORM_EMPTY;
                            ?>
                        </p>
                    </div>
                <?php
                return;
            }

            $dbsExists = 'SELECT COUNT(name) AS total, id, ((SELECT MAX(`order`) FROM ' . TEAM_RANK_TABLE . ') + 1) AS max_order FROM ' . TEAM_RANK_TABLE . ' WHERE name = "' . mysql_real_escape_string(nkGetValue('name')) . '" ';
            $dbeExists = mysql_query($dbsExists);
            $dbaExists = mysql_fetch_assoc($dbeExists);


            if ($dbaExists['total'] == 0 || ($id && $id == $dbaExists['id'] && $dbaExists['total'] == 1)) {
                // si c'est un update
                if ($id) {
                    $dbrSetRanks = 'UPDATE ' . TEAM_RANK_TABLE . ' SET name = "' . mysql_real_escape_string(nkGetValue('name')) . '" WHERE id = "' . (int) $id . '"';
                }
                // Si c'est une insertion
                else {
                    $dbrSetRanks = 'INSERT INTO ' . TEAM_RANK_TABLE . ' (id, name, `order`) VALUES (NULL, "'. mysql_real_escape_string(nkGetValue('name')).'", "' . (int) $dbaExists['max_order'] . '") ';
                }
                // execution de la requete
                if (mysql_query($dbrSetRanks)) {
                    header('Refresh:0, url='.nkGetLink(true));
                }
                // Si la requete n'a pas réussi
                else {
                    ?>
                        <div class="nNote nFailure nNoteHideable">
                            <p>
                                <?php
                                echo nk_debug_bt() . '<br />' . TEAM_QUERY . ' ' . $dbrSetRanks ;
                                ?>
                            </p>
                        </div>
                    <?php
                }
            }
        }
        else if ($action === 'del') {

            $ranks = nkGetTeamsRanks($id);
            if ($ranks && sizeof($ranks)) {
                $dbdRanks = 'DELETE FROM ' . TEAM_RANK_TABLE . ' WHERE id = ' . (int) $id . ' ';

                // execution de la requete
                if (mysql_query($dbdRanks)) {
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
    else if ($op === 'manage_users') {

        if (nkGetValue('btnSubmit') && ($action === 'add' || $action === 'edit')) {
            // Si tous les champs ne sont pas remplis
            if (!nkGetValue('user') || !nkGetValue('team') || (!$ranks = nkGetValue('ranks')) || sizeof($ranks) === 0) {
                ?>
                    <div class="nNote nFailure nNoteHideable">
                        <p>
                            <?php
                            echo TEAM_FORM_EMPTY;
                            ?>
                        </p>
                    </div>
                <?php
                return;
            }
            // Get Team User ID
            $dbsGetTeamUserId = 'SELECT id, team_status_id FROM ' . TEAM_USER_TABLE . ' WHERE user_id = "' . mysql_real_escape_string(nkGetValue('user')) . '" ';
            // Execute
            $dbeGetTeamUserId = mysql_query($dbsGetTeamUserId) or die(nk_debug_bt());
            // Get Row
            $dbaGetTeamUserId = mysql_fetch_assoc($dbeGetTeamUserId);

            $TeamUserId = isset($dbaGetTeamUserId['id']) ? $dbaGetTeamUserId['id'] : null;
            $TeamStatusId = isset($dbaGetTeamUserId['team_status_id']) ? (int) $dbaGetTeamUserId['team_status_id'] : "(SELECT id FROM " . TEAM_STATUS_TABLE . " ORDER BY id ASC LIMIT 1)";

            // User
            $dbiSetUser = 'REPLACE INTO ' . TEAM_USER_TABLE . ' (id, user_id, team_status_id) VALUES (' . ($TeamUserId ? (int) $TeamUserId : 'NULL') . ', "' . mysql_real_escape_string(nkGetValue('user')) . '", ' . $TeamStatusId . ') ';
            mysql_query($dbiSetUser) ;

            if (!$TeamUserId) {
                $TeamUserId = mysql_insert_id();
            }

            // Team
            // Get Team UserTeam ID
            $dbsGetTeamId = 'SELECT id FROM ' . TEAM_USER_TEAM_TABLE . ' WHERE team_id = "' . (int) nkGetValue('team') . '" AND team_user_id = "' . (int) $TeamUserId . '" ';
            // Execute
            $dbeGetTeamId = mysql_query($dbsGetTeamId);
            // Get Row
            $dbaGetTeamId = mysql_fetch_assoc($dbeGetTeamId);

            $TeamId = $dbaGetTeamId['id'];

            // Insert
            $dbiSetTeamUserTeam = 'REPLACE INTO ' . TEAM_USER_TEAM_TABLE . ' (id, team_user_id, team_id, description) VALUES (' . (int) $TeamId .', ' . (int) $TeamUserId . ', ' . (int) nkGetValue('team') . ', "' . mysql_real_escape_string(nkGetValue('description')) . '") ';
            mysql_query($dbiSetTeamUserTeam);

            if ((int) $TeamId) {
                // Delete old
                $dbdUsers = 'DELETE FROM ' . TEAM_USER_RANK_TABLE . ' WHERE team_user_team_id = ' . (int) $TeamId . ' ';
                mysql_query($dbdUsers);
            }
            else {
                $TeamId = mysql_insert_id();
            }

            $dbrSetUserRank = 'INSERT INTO ' . TEAM_USER_RANK_TABLE . ' (team_user_team_id, team_rank_id) VALUES ';
            $i = 0;
            foreach ($ranks as $rank) {
                if ($i > 0) {
                    $dbrSetUserRank .= ', ';
                }
                $dbrSetUserRank .= ' (' . (int) $TeamId . ', ' . (int) $rank . ') ';
                $i++;
            }

            if (mysql_query($dbrSetUserRank)) {
                header('Refresh:0, url='.nkGetLink(true));
            }
            // Si la requete n'a pas réussi
            else {
                ?>
                    <div class="nNote nFailure nNoteHideable">
                        <p>
                            <?php
                            echo nk_debug_bt() . '<br />' . TEAM_QUERY . ' ' . $dbrSetUser ;
                            ?>
                        </p>
                    </div>
                <?php
            }

        }
        else if ($action === 'del') {

            $users = getUsers($id);
            if ($users && sizeof($users)) {
                $dbdRanks = 'DELETE FROM ' . TEAM_USER_TABLE . ' WHERE id = ' . (int) $users[0]['team_user_id'] . ' ';

                // execution de la requete
                if (mysql_query($dbdRanks)) {
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
        else if (nkGetValue('btnSubmit') && $action === 'edit_user') {
            // Get Team User ID
            $dbsGetTeamUserId = 'SELECT user_id, team_status_id FROM ' . TEAM_USER_TABLE . ' WHERE id = "' . (int) $id . '" ';
            // Execute
            $dbeGetTeamUserId = mysql_query($dbsGetTeamUserId);
            // Get Row
            $dbaGetTeamUserId = mysql_fetch_assoc($dbeGetTeamUserId);

            $TeamUserId = $dbaGetTeamUserId['user_id'];

            // User
            $dbiSetUser = 'REPLACE INTO ' . TEAM_USER_TABLE . ' (id, user_id, team_status_id) VALUES (' . ($id ? (int) $id : 'NULL') . ', "' . mysql_real_escape_string($TeamUserId) . '", ' . nkGetValue('status', 'NULL') . ') ';


            if (mysql_query($dbiSetUser)) {
                header('Refresh:0, url='.nkGetLink(true, null, array('action' => 'list_status')));
            }
            // Si la requete n'a pas réussi
            else {
                ?>
                    <div class="nNote nFailure nNoteHideable">
                        <p>
                            <?php
                            echo nk_debug_bt() . '<br />' . TEAM_QUERY . ' ' . $dbrSetUser ;
                            ?>
                        </p>
                    </div>
                <?php
            }

        }
    }
    else if ($op === 'settings') {
        if(nkGetValue('btnSubmit')) {
            $dbuSetConfig = 'UPDATE ' . TEAM_SETTINGS_TABLE . ' SET value = "%s" WHERE name = "%s" ';

            if (
                mysql_query(sprintf($dbuSetConfig, nkGetValue('team_page'), 'team_page'))
                && mysql_query(sprintf($dbuSetConfig, nkGetValue('display_type'), 'display_type'))
                && mysql_query(sprintf($dbuSetConfig, (int) nkGetValue('picture'), 'picture'))
            ) {
                header('Refresh:0, url='.nkGetLink(true, 3));
            }
            // Si la requete n'a pas réussi
            else {
                ?>
                    <div class="nNote nFailure nNoteHideable">
                        <p>
                            <?php
                            echo nk_debug_bt() . '<br />' . TEAM_QUERY . ' ' . $dbrSetUser ;
                            ?>
                        </p>
                    </div>
                <?php
            }
        }
    }
}

?>
