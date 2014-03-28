<?php
/**
 * Script DND
 *
 * @version 1.8
 * @link http://www.nuked-klan.org Clan Management System for Gamers
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @copyright 2001-2013 Nuked-Klan (Registred Trademark)
 */

if (!defined("INDEX_CHECK")) exit('You can\'t run this file alone.');

if (nkHasAdmin()) {
    if (isset($_POST) && isset($_POST['tableDnD']) && $_POST['tableDnD'] == '1') {
        $old = $_POST['old'];
        $new = $_POST['new'];
        $table = $_POST['table'];

        $sql = "UPDATE ".$table." SET `order` = '-1' WHERE `order` = '".$old."' ";
        mysql_query($sql) or die(nk_debug_bt());

        if ($old < $new) {
            $sql = "UPDATE ".$table." SET `order` = `order` - 1 WHERE `order` > '".$old."' AND `order` <= '".$new."' ";
            mysql_query($sql) or die(nk_debug_bt());
        }
        else if ($old > $new) {
            $sql = "UPDATE ".$table." SET `order` = `order` + 1 WHERE `order` < '".$old."' AND `order` >= '".$new."' ";
            mysql_query($sql) or die(nk_debug_bt());
        }

        $sql = "UPDATE ".$table." SET `order` = '".$new."' WHERE `order` = '-1' ";
        mysql_query($sql) or die(nk_debug_bt());

        echo json_encode('ok');
        die;
    }
}

?>
