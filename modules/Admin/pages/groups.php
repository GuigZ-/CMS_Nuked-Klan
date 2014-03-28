<?php
/**
 * groups.php
 *
 * Administration of groups management
 *
 * @version 1.8
 * @link http://www.nuked-klan.org Clan Management System for Gamers
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @copyright 2001-2013 Nuked-Klan (Registred Trademark)
 */

 #####################################
    # Admin - Groups Management
    #####################################
/*    'GROUPS_MANAGEMENT'         => 'Gestion des groupes',
    'NB_GROUP_OWNER'            => 'Nb personnes dans le groupe',
    'GROUP_ADD'                 => 'Ajouter un groupe',
    'NO_DESCRIPTION'            => 'Aucune description',
    'DESC_ADMINISTRATORS'       => 'Administrateurs supr&ecirc;mes',
    'DESC_MEMBERS'              => 'Tous les membres du site',
    'DESC_VISITORS'             => 'Tous les visiteurs (personnes non-connect&eacute;es)',
*/
if (!defined("INDEX_CHECK")) exit('You can\'t run this file alone.');

// Inclusion du layout de l'administration
require_once 'modules/Admin/views/layout.php';

adminHeader();

$hasAdminAccess = nkAccessAdmin('Actions');

if ($hasAdminAccess === true){
    function mainGroup() {
?>
        <ul class="middleNavR">
            <li>
                <a class="tipN" href="index.php?file=Admin&amp;page=groups&amp;op=formGroup" original-title="<?php echo GROUP_ADD; ?>">
                    <span class="nkIcons icon-add"></span>
                </a>
            </li>
            <li>
                <a class="tipN" rel="modal" data-title="<?php echo HELP; ?>" data-close="<?php echo CLOSE; ?>" href="help/<?php echo $GLOBALS['language'];?>/groups.php" original-title="<?php echo HELP; ?>">
                    <span class="nkIcons icon-help"></span>
                </a>
            </li>
        </ul>
        <div class="widget fluid">
            <div class="whead">
                <h6><?php echo GROUPS_MANAGEMENT; ?></h6>
                <div class="clear"></div>
            </div>
            <table class="tDefault" class="grid4">
                <thead>
                    <tr>
                        <td class="center">
                            <strong><?php echo NAME; ?></strong>
                        </td>
                        <td class="center">
                            <strong><?php echo DESCRIPTION; ?></strong>
                        </td>
                        <td class="center">
                            <strong><?php echo NB_GROUP_OWNER; ?></strong>
                        </td>
                        <td class="center">
                            <strong><?php echo EDIT; ?></strong>
                        </td>
                    </tr>
                </thead>
                <tbody>
<?php
                    $dbsOwners   = 'SELECT ids_group
                                    FROM '.USERS_TABLE;
                    $dbeOwners   = mysql_query($dbsOwners);

                    $arrayOwners = array();

                    while ($data = mysql_fetch_assoc($dbeOwners)) {
                        $arrayGroupsId = explode('|', $data['ids_group']);

                        foreach ($arrayGroupsId as $groupId) {
                            if (array_key_exists($groupId, $arrayOwners)) {
                                $arrayOwners[$groupId]++;
                            }
                            else {
                                $arrayOwners[$groupId] = 1;
                            }
                        }
                    }

                    $dbsGroups  = 'SELECT id, nameGroup, description
                                   FROM '.GROUPS_TABLE.'
                                   ORDER BY nameGroup';
                    $dbeGroups  = mysql_query($dbsGroups) or die (nk_debug_bt());

                    while ($group = mysql_fetch_assoc($dbeGroups)) {
                        if (empty($group['description'])) {
                            $group['description'] = NO_DESCRIPTION;
                        }

                        if (defined(strtoupper($group['nameGroup']))) {
                            $group['nameGroup'] = constant(strtoupper($group['nameGroup']));
                        }

                        if (defined(strtoupper($group['description']))) {
                            $group['description'] = constant(strtoupper($group['description']));
                        }

                        $group['nbOwners'] = 0;

                        if (array_key_exists($group['id'], $arrayOwners)) {
                            $group['nbOwners'] = $arrayOwners[$group['id']];
                        }

                        $titleOwners = strtolower(USERS);

                        if ($group['nbOwners'] == 1) {
                            $titleOwners = strtolower(USER);
                        }

?>
                        <tr id="group_<?php echo $group['id']; ?>">
                            <td style="width: 20%;">
                                <?php echo $group['nameGroup']; ?>
                            </td>
                            <td style="width: 35%;">
                                <?php echo $group['description']; ?>
                            </td>
                            <td style="width: 20%;text-align:right;">
                                <strong><?php echo $group['nbOwners']; ?></strong>&nbsp;
                                <span class="nkIcons icon-groups" title="<?php echo $group['nbOwners'].' '.$titleOwners; ?>"></span>
                            </td>
                            <td style="width: 20%;text-align:center;">
                                <a class="tablectrl_medium bDefault tipS nkIcons icon-edit" href="index.php?file=Admin&amp;page=groups&amp;op=formGroup&amp;id=<?php echo $group['id']; ?>" original-title="<?php echo EDIT; ?>"></a>
                                <a class="tablectrl_medium bDefault tipS nkIcons icon-delete" href="javascript:delGroup('<?php echo mysql_real_escape_string($group['nameGroup']); ?>', '<?php echo $group['id']; ?>');" original-title="<?php echo DELETE; ?>"></a>
                            </td>
                        </tr>
<?php
                    }
?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="body center">
                            <a class="buttonM bDefault" href="index.php?file=Admin"><?php echo BACK; ?></a>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
<?php
    }

    function formGroup() {
        $dbsModules = ' SELECT id, name, status
                       FROM '.MODULES_TABLE.'
                       ORDER BY name';
        $dbeModules = mysql_query($dbsModules);

        $arrayModules = array();

        while($data = mysql_fetch_assoc($dbeModules)) {
            foreach($data as $field => $value){
                if ($field != 'id') {
                    $arrayModules[$data['id']][$field] = $value;
                }
            }
        }
?>
        <div class="content-box" style="max-width:900px;">
            <div class="content-box-header">
                <h3><?php echo GROUPS_MANAGEMENT; ?></h3>
                <div style="text-align:right">
                    <a class="adminIcon icon-help" href="help/<?php echo $GLOBALS['language'];?>/block.php" rel="modal" title="<?php echo HELP; ?>">
                        <span><?php echo HELP; ?></span>
                    </a>
                </div>
            </div>
            <div id="tab2" class="tab-content">
                    <div class="margin10Center"><strong>
                        <a href="index.php?file=Admin&amp;page=group&amp;op=mainGroup"><?php echo _TITLEGESTGROUP; ?></a> |
                            </strong><?php echo _MENUADDGROUP; ?>
                    </div>
                    <form id="adminGroup" method="post" action="index.php?file=Admin&amp;page=group&amp;op=sendGroupAdd">
                        <div id="userGroup">
                            <div class="three">
                                <span><?php echo _NAMEGROUP; ?></span>
                                <input class="tableWidth50" type="text" name="name" required="required" />
                            </div>
                            <div class="three">
                                <span><?php echo _DESCGROUP; ?></span>
                                <input class="tableWidth50" type="text" name="description" />
                            </div>
                            <div class="three" id="colorPickerJquery">
                                <span><?php echo _COLOR; ?></span>
                                <input class="tableWidth50" type="text" name="color" id="colorPickerGroup" value="#000000" />
                                <div id="picker"></div>
                            </div>
                            <div class="full"><span><?php echo _LISTMODULE; ?></span></div>
<?php
                            foreach($arrayModules as $module){
                                if(!nkIsModEnabled($module['name'])){
                                    $class = 'groupModDisabled';
                                }
                                else{
                                    $class = 'groupModEnabled';
                                }

                                if($module['name'] == 'Users' || $module['name'] == 'Groups'){
                                    $class2 = 'groupFakeMod';
                                }
                                else{
                                    $class2 = '';
                                }
?>
                            <div class="quarter <?php echo $class; ?>">
                                <span><?php echo $module['name']; ?></span>
<?php
                                if($module['name'] != 'Users' && $module['name'] != 'Groups'){
?>
                                    <div class="checkboxSliderWrapper">
                                        <span><?php echo _ACCESMODULE; ?></span>
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="<?php echo $module['name'].'Access'; ?>" class="onoffswitch-checkbox pageCheckbox" id="<?php echo $module['name'].'Access'; ?>">
                                            <label class="onoffswitch-label" for="<?php echo $module['name'].'Access'; ?>">
                                                <div class="onoffswitch-inner"></div>
                                                <div class="onoffswitch-switch"></div>
                                            </label>
                                        </div>
                                    </div>
<?php
                                }
?>
                                    <div class="checkboxSliderWrapper">
                                        <span><?php echo _ACCESADMIN; ?></span>
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="<?php echo $module['name'].'AccessAdmin'; ?>" class="onoffswitch-checkbox pageCheckbox" id="<?php echo $module['name'].'AccessAdmin'; ?>">
                                            <label class="onoffswitch-label" for="<?php echo $module['name'].'AccessAdmin'; ?>">
                                                <div class="onoffswitch-inner"></div>
                                                <div class="onoffswitch-switch"></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
<?php
                            }
?>
                            <div class="full">
                                <p class="textModEnabled"><?php echo _COLOR_MOD_ENABLED; ?></p>&nbsp;|&nbsp;
                                <p class="textModDisabled"><?php echo _COLOR_MOD_DISABLED; ?></p>
                            </div>
                            <div class="full"><span><input type="submit" value="<?php echo _ADD; ?>" /></span></div>
                        </div>
                    </form>
                </div>
                <div class="boldCenter margin10Center"><a href="index.php?file=Admin&amp;page=group"><?php echo _BACK; ?></a></div>
            </div>
<?php
    }

    function sendGroupAdd() {

        $arrayRequest = array('name', 'description', 'color');
        foreach($arrayRequest as $key){
            if(!array_key_exists($key, $_REQUEST)){
                $_REQUEST[$key] = '';
            }
        }

        $dbsTestName = ' SELECT count(id) AS count
                         FROM '.GROUPS_TABLE.'
                         WHERE nameGroup = "' . $_REQUEST['name'] . '"';
        $dbeTestName = mysql_query($dbsTestName);
        $testName = mysql_fetch_assoc($dbeTestName);

        $errors = 0;
        if(empty($_REQUEST['name'])){
            $errorMsg = _ERROR_NO_GROUPNAME;
            $errors++;
        }

        $arrayNameReserved = array('Visiteur', 'Guest', 'Membres', 'Members', 'Administrateur', 'Administrator');

        if(in_array($_REQUEST['name'], $arrayNameReserved)){
            $errorMsg = _GROUP_NAME_RESERVED;
            $errors++;
        }

        if($errors > 0){
            echo '<div class="notification error png_bg">
                    <div>'.$errorMsg.'</div>
                </div>';
            redirect('index.php?file=Admin&page=group&op=addGroup', 3);
            adminfoot();
            exit();
        }

        if($testName['count'] == 0) {

            $dbsModule = ' SELECT id, name, status
                           FROM ' . MODULES_TABLE . '
                           ORDER BY name';
            $dbeModule = mysql_query($dbsModule);

            $arrayModules = array();

            while($data = mysql_fetch_assoc($dbeModule)) {
                $arrayTmp = array('id', 'name', 'status');
                foreach($arrayTmp as $field){
                    $arrayModules[$data['id']][$field] = $data[$field];
                }
            }

            // Ajout des module Fake Users et Groups
            $arrayUsers = array('id' => '', 'name' => 'Users', 'status' => 0);
            $arrayGroups = array('id' => '', 'name' => 'Groups', 'status' => 0);
            $arrayModules[] = $arrayUsers;
            $arrayModules[] = $arrayGroups;

            $groupForUser = array();
            $groupForAdmin = array();

            foreach($arrayModules as $module) {
                $inputAccess = $module['name'].'Access';
                $inputAdmin  = $module['name'].'AccessAdmin';
                if (array_key_exists($inputAccess, $_REQUEST) && !empty($_REQUEST[$inputAccess])) {
                    $groupForUser[] = $module['name'];
                }
                if (array_key_exists($inputAdmin, $_REQUEST) && !empty($_REQUEST[$inputAdmin])) {
                    $groupForAdmin[] = $module['name'];
                }
            }

            if(count($groupForAdmin) > 0){
                if(!in_array('Admin', $groupForUser)){
                    $groupForUser[] = 'Admin';
                }
            }

            $groupForUser = implode('|', $groupForUser);
            $groupForAdmin = implode('|', $groupForAdmin);

            $pattern = '#[A-z0-9\(\) _éèëêâäàîïöôûü°\.\:\',-]{0,30}#';

            $errors = 0;

            if(!empty($_REQUEST['name']) && !preg_match($pattern, $_REQUEST['name'])){
                $errors++;
                $errorMsg = _NAMEINVALID;
            }

            if(!empty($_REQUEST['name']) && !preg_match($pattern, $_REQUEST['description'])){
                $errors++;
                $errorMsg = _DESCINVALID;
            }

            if(!empty($_REQUEST['name']) && !preg_match('#\#[0-9a-f]{6}#', $_REQUEST['color'])){
                $errors++;
                $errorMsg = _COLORINVALID;
            }

            if($errors > 0){
                echo '<div class="notification error png_bg">
                        <div>'.$errorMsg.'</div>
                    </div>';
                redirect('index.php?file=Admin&page=group&op=addGroup', 3);
                adminfoot();
                exit();
            }

            $name = mysql_real_escape_string($_REQUEST['name']);
            $description = mysql_real_escape_string($_REQUEST['description']);
            $color = mysql_real_escape_string($_REQUEST['color']);

            $dbiInsertGroup = 'INSERT INTO '.GROUPS_TABLE.' (`id` , `nameGroup` , `access`, `accessAdmin`, `description`, `color` )
                               VALUES ("", "' . $name . '" , "' . $groupForUser . '", "' . $groupForAdmin . '", "' . $description . '", "' . $color . '")';
            $dbeInsertGroup = mysql_query($dbiInsertGroup);

            $texteaction = _ACTIONGROUPADD . $name;
            $acdate = time();

            $dbiAction = 'INSERT INTO '.ACTION_TABLE.' (`date`, `pseudo`, `action`)
                          VALUES("' . $acdate . '", "' . $GLOBALS['user']['id'] . '", "' . $texteaction . '")';
            $dbeAction = mysql_query($dbiAction);
?>
            <div class="notification success png_bg">
                <div><?php echo _SUCCESGROUPADD; ?></div>
            </div>
<?php
        }
        else {
?>
            <div class="notification error png_bg">
                <div><?php echo _ERRORGROUPEXIST; ?></div>
            </div>
<?php
        }
    redirect("index.php?file=Admin&page=group", 2);
    }

    function editGroup() {
        if(array_key_exists('id', $_REQUEST)){
            $id = intval($_REQUEST['id']);
        }
        else{
            $id = 0;
        }

        $dbsGroup = ' SELECT nameGroup, access, accessAdmin, description, color, count(*) AS count
                      FROM '.GROUPS_TABLE.'
                      WHERE id = "' . $id . '"';
        $dbeGroup = mysql_query($dbsGroup);
        list($nameGroup, $access, $accessAdmin, $description, $color, $count) = mysql_fetch_array($dbeGroup);

        if($count == 0){
            echo '<div class="notification error png_bg">
                    <div>'._BAD_GROUP_ID.'</div>
                </div>';
            redirect('index.php?file=Admin&page=group&op=addGroup', 3);
            adminfoot();
            exit();
        }

        $access = explode('|', $access);
        $accessAdmin = explode('|', $accessAdmin);

        if(empty($description)){
            $description = 'Aucune description';
        }

        if ($nameGroup == "_ADMINISTRATOR") {
            $disabledName = 'readonly="readonly"';
            $disabledAccess = 'disabled="disabled"';
            $disabledAdmin = 'disabled="disabled"';
        } else if ($nameGroup == "_MEMBERS") {
            $disabledName = 'readonly="readonly"';
            $disabledAccess = '';
            $disabledAdmin = '';
        } else if ($nameGroup == "_VISITOR") {
            $disabledName = 'readonly="readonly"';
            $disabledAccess = '';
            $disabledAdmin = 'disabled="disabled"';
        } else {
            $nameGroup = $nameGroup;
            $disabledName = '';
            $disabledAccess = '';
            $disabledAdmin = '';
        }

        $dbsModule = ' SELECT id, name, status
                       FROM ' . MODULES_TABLE . '
                       ORDER BY name ';
        $dbeModule = mysql_query($dbsModule);

        $arrayModules = array();

        while($data = mysql_fetch_assoc($dbeModule)) {
            $arrayTmp = array('id', 'name', 'status');
            foreach($arrayTmp as $field){
                $arrayModules[$data['id']][$field] = $data[$field];
            }
        }

        // Ajout des module Fake Users et Groups
        $arrayUsers = array('id' => '', 'name' => 'Users', 'status' => 'on');
        $arrayGroups = array('id' => '', 'name' => 'Groups', 'status' => 'on');
        $arrayModules[] = $arrayUsers;
        $arrayModules[] = $arrayGroups;
?>
            <div class="content-box">
                <div class="content-box-header"><h3><?php echo _USERADMINGROUP; ?></h3>
                    <div style="text-align:right;">
                        <a href="help" . $language . "/group.php" rel="modal">
                            <img src="help/help.gif" alt="" title="<?php echo HELP; ?>" />
                        </a>
                    </div>
                </div>
                <div class="tab-content" id="tab2">
                    <div class="margin10Center"><strong>
                        <a href="index.php?file=Admin&amp;page=group&amp;op=mainGroup"><?php echo _TITLEGESTGROUP; ?></a> |
                        <a href="index.php?file=Admin&amp;page=group&amp;op=addGroup"><?php echo _MENUADDGROUP; ?></a></strong>
                    </div>
                    <form id="adminGroup" method="post" action="index.php?file=Admin&amp;page=group&amp;op=sendGroupEdit">
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <div id="userGroup">
                            <div class="three">
                                <span><?php echo _NAMEGROUP; ?></span>
                                <input <?php echo $disabledName; ?> class="tableWidth50" type="text" name="name" value="<?php echo translateGroupName($id, $nameGroup); ?>" required="required" />
                            </div>
                            <div class="three">
                                <span><?php echo _DESCGROUP; ?></span>
                                <input <?php echo $disabledName; ?> class="tableWidth50" type="text" name="description" value="<?php echo translateGroupName($id, $description); ?>" />
                            </div>
                            <div class="three" id="colorPickerJquery">
                                <span><?php echo _COLOR; ?></span>
                                <input class="tableWidth50" type="text" name="color" id="colorPickerGroup" value="<?php echo $color; ?>" />
                                <div id="picker"></div>
                            </div>
                            <div class="full"><span><?php echo _LISTMODULE; ?></span></div>
<?php
                            foreach($arrayModules as $module){
                                if(!nkIsModEnabled($module['name'])){
                                    $class = 'groupModDisabled';
                                }
                                else{
                                    $class = 'groupModEnabled';
                                }

                                if (in_array($module['name'], $access, true)) {
                                    $checkedAcces = 'checked="checked"';
                                } else {
                                    $checkedAcces = '';
                                }
                                if (in_array($module['name'], $accessAdmin, true)) {
                                    $checkedAdmin = 'checked="checked"';
                                } else {
                                    $checkedAdmin = '';
                                }

                                if($module['name'] == 'Users' || $module['name'] == 'Groups'){
                                    $class2 = 'groupFakeMod';
                                }
                                else{
                                    $class2 = '';
                                }
?>
                            <div class="quarter <?php echo $class; ?>">
                                <span><?php echo $module['name']; ?></span>
<?php
                                if($module['name'] != 'Users' && $module['name'] != 'Groups'){
?>
                            <div class="tableWidth80 nKcenter">
                                    <label for="<?php echo $module['name'].'Access'; ?>">
                                        <span class="title"><?php echo _ACCESMODULE; ?></span>
                                        <input id="<?php echo $module['name'].'Access'; ?>" <?php echo $disabledAccess . $checkedAcces; ?> name="<?php echo $module['name'].'Access'; ?>" type="checkbox" />
                                        <span class="checkboxSlider"></span>
                                    </label>
                                </div>
<?php
                                }
?>
                                <div class="tableWidth80 nKcenter <?php echo $class2; ?>">
                                    <label for="<?php echo $module['name'].'AccessAdmin'; ?>">
                                        <span class="title"><?php echo _ACCESADMIN; ?></span>
                                        <input id="<?php echo $module['name'].'AccessAdmin'; ?>" <?php echo $disabledAdmin  . $checkedAdmin; ?> name="<?php echo $module['name'].'AccessAdmin'; ?>" type="checkbox" />
                                        <span class="checkboxSlider"></span>
                                    </label>
                                </div>
                            </div>
<?php
                            }
?>
                            <div class="full">
                                <p class="textModEnabled"><?php echo _COLOR_MOD_ENABLED; ?></p>&nbsp;|&nbsp;
                                <p class="textModDisabled"><?php echo _COLOR_MOD_DISABLED; ?></p>
                            </div>
                            <div class="full"><span><input type="submit" value="<?php echo _EDIT; ?>" /></span></div>
                        </div>
                    </form>
                </div>
                <div class="boldCenter margin10Center"><a href="index.php?file=Admin&amp;page=group"><?php echo _BACK; ?></a></div>
            </div>
<?php
    }

    function sendGroupEdit() {
        $arrayRequest = array('id', 'name', 'description', 'color');
        foreach($arrayRequest as $key){
            if(array_key_exists($key, $_REQUEST)){
                $_REQUEST[$key] = $_REQUEST[$key];
            }
            else{
                $_REQUEST[$key] = '';
            }
        }

        $id = intval($_REQUEST['id']);

        $dbsGroupName = ' SELECT id , nameGroup, count(*) AS count
                          FROM '.GROUPS_TABLE.'
                          WHERE id = "'.$id.'"';
        $dbeGroupName = mysql_query($dbsGroupName);
        $group = mysql_fetch_assoc($dbeGroupName);

        if($group['count'] == 0){
            echo '<div class="notification error png_bg">
                    <div>'._BAD_GROUP_ID.'</div>
                </div>';
            redirect('index.php?file=Admin&page=group', 3);
            adminfoot();
            exit();
        }

        $arrayPermGroup = array('1' => '_ADMINISTRATOR', '2' => '_MEMBERS', '3' => '_VISITOR');
        $arrayPermGroupDesc = array('1' => '_DESCADMINISTRATOR', '2' => '_DESCMEMBERS', '3' => '_DESCVISITORPADMIN');

        if($id == 1 || $id == 2 || $id == 3){
            $_REQUEST['name'] = $arrayPermGroup[$id];
            $_REQUEST['description'] = $arrayPermGroupDesc[$id];
        }

        $arrayNameReserved = array('Visiteur', 'Guest', 'Membres', 'Members', 'Administrateur', 'Administrator');

        if(in_array($_REQUEST['name'], $arrayNameReserved)){
            echo '<div class="notification error png_bg">
                    <div>'._GROUP_NAME_RESERVED.'</div>
                </div>';
            redirect('index.php?file=Admin&page=group&op=editGroup&id='.$id, 3);
            adminfoot();
            exit();
        }

        $dbsModule = ' SELECT id, name, status
                       FROM ' . MODULES_TABLE . '
                       ORDER BY name ';
        $dbeModule = mysql_query($dbsModule);

        $arrayModules = array();

        while($data = mysql_fetch_assoc($dbeModule)) {
            $arrayTmp = array('id', 'name', 'status');
            foreach($arrayTmp as $field){
                $arrayModules[$data['id']][$field] = $data[$field];
            }
        }

        // Ajout des module Fake Users et Groups
        $arrayUsers = array('id' => '', 'name' => 'Users', 'status' => 0);
        $arrayGroups = array('id' => '', 'name' => 'Groups', 'status' => 0);
        $arrayModules[] = $arrayUsers;
        $arrayModules[] = $arrayGroups;

        $groupForUser = array();
        $groupForAdmin = array();

        foreach($arrayModules as $module) {
            $inputAccess = $module['name'].'Access';
            $inputAdmin  = $module['name'].'AccessAdmin';
            if (array_key_exists($inputAccess, $_REQUEST) && !empty($_REQUEST[$inputAccess])) {
                $groupForUser[] = $module['name'];
            }
            if (array_key_exists($inputAdmin, $_REQUEST) && !empty($_REQUEST[$inputAdmin])) {
                $groupForAdmin[] = $module['name'];
            }
        }

        if(count($groupForAdmin) > 0){
            if(!in_array('Admin', $groupForUser)){
                $groupForUser[] = 'Admin';
            }
        }

        $groupForUser = implode('|', $groupForUser);
        $groupForAdmin = implode('|', $groupForAdmin);

        $pattern = '#[A-z0-9\(\) _éèëêâäàîïöôûü°\.\:\',-]{0,30}#';

        $errors = 0;

        if(!empty($_REQUEST['name']) && !preg_match($pattern, $_REQUEST['name'])){
            $errors++;
            $errorMsg = _NAMEINVALID;
        }

        if(!empty($_REQUEST['name']) && !preg_match($pattern, $_REQUEST['description'])){
            $errors++;
            $errorMsg = _DESCINVALID;
        }

        if(!empty($_REQUEST['name']) && !preg_match('#\#[0-9a-f]{6}#', $_REQUEST['color'])){
            $errors++;
            $errorMsg = _COLORINVALID;
        }

        if($errors > 0){
            echo '<div class="notification error png_bg">
                    <div>'.$errorMsg.'</div>
                </div>';
            redirect('index.php?file=Admin&page=group&op=editGroup&id='.$id, 3);
            adminfoot();
            exit();
        }

        $name = mysql_real_escape_string($_REQUEST['name']);
        $description = mysql_real_escape_string($_REQUEST['description']);
        $color = mysql_real_escape_string($_REQUEST['color']);

        $fields = '';

        if($id != 1) {
            $fields .= ' access = "'.$groupForUser.'" ';
        }

        if ($id != 1 && $id != 3) {
            $fields .= ' , accessAdmin = "'.$groupForAdmin.'" ';
        }

        if($id != 1 && $id != 2 && $id != 3) {
            $fields .= ', nameGroup = "'.$name.'", description = "'.$description.'" ';
        }

        if(!empty($fields)){
            $fields .= ' , ';
        }
        $fields .= 'color = "'.$color.'" ';

        if(!empty($fields)){
            $dbuGroup = '   UPDATE '.GROUPS_TABLE.'
                            SET  '.$fields.'
                            WHERE id = "' . $id . '"';
            $dbeGroup = mysql_query($dbuGroup);

            $texteaction = _ACTIONGROUPEDIT . $name;
            $acdate = time();

            $dbiAction = 'INSERT INTO '.ACTION_TABLE.' (`date`, `pseudo`, `action`)
                          VALUES("' . $acdate . '", "' . $GLOBALS['user']['id'] . '", "' . $texteaction . '")';
            $dbeAction = mysql_query($dbiAction);
        }
?>
        <div class="notification success png_bg">
            <div><?php echo _SUCCESGROUPEDIT; ?></div>
        </div>
<?php
    redirect("index.php?file=Admin&page=group", 2);
    }

    function delGroup() {
        if(array_key_exists('id', $_REQUEST)){
            $id = intval($_REQUEST['id']);
        }
        else{
            $id = 0;
        }

        if($id == 1 || $id == 2 || $id == 3){
            echo '<div class="notification error png_bg">
                    <div>'._NO_DELETE_GROUP.'</div>
                </div>';
            redirect('index.php?file=Admin&page=group', 3);
            adminfoot();
            exit();
        }

        $dbsGroupName = " SELECT id, nameGroup, count(*) AS count
                          FROM ".GROUPS_TABLE."
                          WHERE id = '".$id."' ";
        $dbeGroupName = mysql_query($dbsGroupName);
        $group = mysql_fetch_assoc($dbeGroupName);

        if($group['count'] == 0){
            echo '<div class="notification error png_bg">
                    <div>'._BAD_GROUP_ID.'</div>
                </div>';
            redirect('index.php?file=Admin&page=group', 3);
            adminfoot();
            exit();
        }


        $del = mysql_query("DELETE FROM " . GROUPS_TABLE . " WHERE id = '" . $id . "'");

        $texteaction = _ACTIONGROUPDEL . $group['nameGroup'];
        $acdate = time();

        $dbiAction = 'INSERT INTO '.ACTION_TABLE.' (`date`, `pseudo`, `action`)
                      VALUES("' . $acdate . '", "' . $GLOBALS['user']['id'] . '", "' . $texteaction . '")';
        $dbeAction = mysql_query($dbiAction);
?>
        <div class="notification success png_bg">
            <div><?php echo _SUCCESGROUPDEL; ?></div>
        </div>
<?php
        redirect("index.php?file=Admin&page=group", 2);
    }

    if(!array_key_exists('op', $_REQUEST)){
        $_REQUEST['op'] = '';
    }

    switch ($_REQUEST['op']){
        case "mainGroup":
            mainGroup();
            break;

        case "formGroup":
            formGroup();
            break;

        case "delGroup":
            delGroup();
            break;

        case "sendGroup":
            sendGroup();
            break;

        default:
            mainGroup();
            break;
    }

}
else{
    // On affiche le message d'erreur
    printMessage(ADMIN_ACCESS_DENIED, 'Failure');
    // On affiche le bouton de retour
    printBackButton('index.php?file=Admin');
}
    // On affiche le footer
    adminFooter();
?>
