<?php

/**
 * Team page of Team Mod
 *
 * @version     1.8
 * @link http://www.nuked-klan.org Clan Clan Management System for Gamers
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @copyright 2001-2013 Nuked-Klan (Registred Trademark)
 */
defined('INDEX_CHECK') or die('You can\'t run this file alone.');

define('TEAM_TABLE', $nuked['prefix'].'_team');
define('TEAM_SETTINGS_TABLE', $nuked['prefix'].'_team_settings');
define('TEAM_STATUS_TABLE', $nuked['prefix'].'_team_status');
define('TEAM_RANK_TABLE', $nuked['prefix'].'_team_rank');
define('TEAM_USER_TABLE', $nuked['prefix'].'_team_user');
define('TEAM_USER_TEAM_TABLE', $nuked['prefix'].'_team_user_team');
define('TEAM_USER_RANK_TABLE', $nuked['prefix'].'_team_user_rank');
define('TEAM_GROUPS_TABLE', $nuked['prefix'].'_team_groups');
define('TEAM_GAMES_TABLE', $nuked['prefix'].'_team_games');
define('GROUPS_TABLE', $nuked['prefix'].'_groups');

?>
