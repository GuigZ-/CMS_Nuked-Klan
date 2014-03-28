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

require_once 'modules/Wars/inc/AdminDisplay.php';

// Haut
adminHeader();

// Affiche l'admin
WarsDisplayAdmin();

// Bas
adminFooter();

?>
