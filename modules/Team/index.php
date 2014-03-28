<?php
/**
 * Main page of Team Mod
 *
 * @version     1.8
 * @link http://www.nuked-klan.org Clan Clan Management System for Gamers
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @copyright 2001-2013 Nuked-Klan (Registred Trademark)
 */
defined('INDEX_CHECK') or die('You can\'t run this file alone.');

require_once dirname(__FILE__).'/inc/constants.php';
require_once dirname(__FILE__).'/inc/db.php';
require_once dirname(__FILE__).'/inc/functions.php';
require_once dirname(__FILE__).'/inc/display.php';

// Action
$team = isset($GLOBALS['_REQUEST']['team_id']);

loadConfig();

opentable();
?>
<div id="nkModuleTeam">
    <?php
    switch ($team) {

        case true:
            displayByTeam(isset($GLOBALS['_GET']['team_id']) && is_numeric($GLOBALS['_GET']['team_id']) ? $GLOBALS['_GET']['team_id'] : null);
            break;

        default:
            index();
            break;
    }
?>
</div>
<?php
closetable();
?>
