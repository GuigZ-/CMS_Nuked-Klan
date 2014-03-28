<?php
/**
 * About.php
 *
 * Games display
 *
 * @version 1.8
 * @link http://www.nuked-klan.org Clan Management System for Gamers
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @copyright 2001-2013 Nuked-Klan (Registred Trademark)
 */

if (!defined("INDEX_CHECK")) exit('You can\'t run this file alone.');


// Inclusion du layout de l'administration
require_once 'modules/Admin/views/layout.php';

adminHeader();

if (nkHasAdmin() === true) {
    require_once 'modules/Admin/libraries/Games/inc/AdminDisplay.php';
    GamesDisplayAdmin();
}
else {
    printMessage(ADMIN_ACCESS_DENIED, 'Failure');
    ?>
        <div class="backButton center">
            <a class="buttonM bDefault" href="index.php?file=Admin"><?php echo BACK; ?></a>
        </div>
    <?php
}

adminFooter();
?>
