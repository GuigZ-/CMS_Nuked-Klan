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


if (!defined('TEAM_TABLE'))
    define('TEAM_TABLE', $nuked['prefix'].'_team');
if (!defined('TEAM_SETTINGS_TABLE'))
    define('TEAM_SETTINGS_TABLE', $nuked['prefix'].'_team_settings');
if (!defined('TEAM_STATUS_TABLE'))
    define('TEAM_STATUS_TABLE', $nuked['prefix'].'_team_status');
if (!defined('TEAM_RANK_TABLE'))
    define('TEAM_RANK_TABLE', $nuked['prefix'].'_team_rank');
if (!defined('TEAM_USER_TABLE'))
    define('TEAM_USER_TABLE', $nuked['prefix'].'_team_user');
if (!defined('TEAM_USER_TEAM_TABLE'))
    define('TEAM_USER_TEAM_TABLE', $nuked['prefix'].'_team_user_team');
if (!defined('TEAM_USER_RANK_TABLE'))
    define('TEAM_USER_RANK_TABLE', $nuked['prefix'].'_team_user_rank');
if (!defined('TEAM_GROUPS_TABLE'))
    define('TEAM_GROUPS_TABLE', $nuked['prefix'].'_team_groups');
if (!defined('TEAM_GAMES_TABLE'))
    define('TEAM_GAMES_TABLE', $nuked['prefix'].'_team_games');
if (!defined('GROUPS_TABLE'))
    define('GROUPS_TABLE', $nuked['prefix'].'_groups');

?>
