<?php
/**
 * Admin page of Wars Mod
 *
 * @version     1.8
 * @link http://www.nuked-klan.org Clan Clan Management System for Gamers
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @copyright 2001-2013 Nuked-Klan (Registred Trademark)
 */
defined('INDEX_CHECK') or die('You can\'t run this file alone.');

translate('modules/Wars/lang/' . $GLOBALS['language'] . '.lang.php');

// Inclusion du layout de l'administration
require_once 'modules/Admin/views/layout.php';

// Haut
adminHeader();

if (nkHasAdmin() === true) {
    require_once 'modules/Wars/inc/AdminDisplay.php';
    // Affiche l'admin
    WarsDisplayAdmin();
}
else
{
    printMessage(ADMIN_ACCESS_DENIED, 'Failure');
    ?>
        <div class="backButton center">
            <a class="buttonM bDefault" href="index.php?file=Admin"><?php echo BACK; ?></a>
        </div>
    <?php
}

// Bas
adminFooter();

?>
