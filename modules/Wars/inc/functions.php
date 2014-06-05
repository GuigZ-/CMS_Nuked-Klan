<?php

/**
 * Functions of Wars mod
 *
 * @version     1.8
 * @link http://www.nuked-klan.org Clan Clan Management System for Gamers
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @copyright 2001-2013 Nuked-Klan (Registred Trademark)
 */
defined('INDEX_CHECK') or die('You can\'t run this file alone.');

function getMatchs ($id = false) {
    $dbsGetWars = '
            SELECT *, m.id
                FROM ' . MATCH_TABLE . ' AS m
                LEFT OUTER JOIN ' . MATCH_MAP_TABLE . ' AS mm
                    ON mm.`match_id` = m.`id`
                WHERE 1
        ';

    if ($id) {
        $dbsGetWars .= ' AND m.id = "'.(int)$id.'" ';
    }

    $dbeGetWars = mysql_query($dbsGetWars) or die(nk_debug_bt());
    $wars = array();
    if ($dbeGetWars !== false) {
        while ($dbaGetWars = mysql_fetch_assoc($dbeGetWars)) {
            $temp = $dbaGetWars;
            if (!array_key_exists($dbaGetWars['id'], $wars)) {
                $wars[$dbaGetWars['id']] = $temp;
                $wars[$dbaGetWars['id']]['map'] = array();
                $wars[$dbaGetWars['id']]['files'] = array();
            }

                $scores = explode('-', $dbaGetWars['score']);
                $wars[$dbaGetWars['id']]['map'][] = array(
                    'map' => $dbaGetWars['map_id'],
                    'players' => explode(',', $dbaGetWars['players']),
                    'substitute' => explode(',', $dbaGetWars['substitute']),
                    'score' => array(
                        'local' => $scores[0],
                        'visitor' => $scores[1]
                    ),
                    'game_mod' => $dbaGetWars['game_mod'],
                    'time' => $dbaGetWars['time'],
                    'opponent' => $dbaGetWars['opponent']
                );
                if ($id) {
                    $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'Matchs' . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR;
                    if (is_dir($dir)) {
                        foreach (scandir($dir) as $file) {
                            if (is_dir($file) === false && $file != "index.php" && !preg_match('#^icon-adv#isD', $file)) {
                                $wars[$dbaGetWars['id']]['files'][] = $file;
                            }
                        }
                    }
                }
        }
    }

    // Check results
    if ($wars !== false && sizeof($wars)) {
        if (!$id) {
            $return = $wars;
        }
        else {
            $return = current($wars);
        }
    }
    else {
        $return = false;
    }

    return $return;
}

function MatchGetJsonTab()
{
    $dbsGetInformations = "
        SELECT gm.game_id, g.name AS gameName, tg.team_id, t.name AS teamName, tu.user_id, u.pseudo, gm.id AS map_id, gm.name AS mapName, mm.score AS mapScore, mm.players AS mapPlayers, mm.substitute AS mapSubstitute, mm.game_mod, mm.time, mm.opponent
        FROM ".GAMES_TABLE." AS g
            INNER JOIN ".GAMES_MAP_TABLE." gm
                ON gm.game_id = g.id
            LEFT OUTER JOIN ".MATCH_MAP_TABLE." mm
                ON mm.map_id = gm.id
            INNER JOIN ".TEAM_GAMES_TABLE." AS tg
                ON tg.game_id = g.id
            INNER JOIN ".TEAM_TABLE." AS t
                ON t.id = tg.team_id
            INNER JOIN ".TEAM_USER_TEAM_TABLE." AS tut
                ON tut.team_id = t.id
            INNER JOIN ".TEAM_USER_TABLE." AS tu
                ON tu.id = tut.team_user_id
            INNER JOIN ".USERS_TABLE." AS u
                ON u.id = tu.user_id
    ";

    $dbeGetInformations = mysql_query($dbsGetInformations) or die(nk_debug_bt());

    $tab = array();
    if ($dbeGetInformations !== false) {
        while ($dbaGetInformations = mysql_fetch_assoc($dbeGetInformations)) {
            if (!array_key_exists($dbaGetInformations['game_id'], $tab)) {
                $tab[$dbaGetInformations['game_id']] = array('name' => $dbaGetInformations['gameName'], 'maps' => array(), 'teams' => array());
            }
            // Associate teams games
            $current = &$tab[$dbaGetInformations['game_id']];
            if (!array_key_exists($dbaGetInformations['team_id'], $current['teams'])) {
                $current['teams'][$dbaGetInformations['team_id']] = array('name' => $dbaGetInformations['teamName'], 'players' => array());
            }
            // Associate user team
            $currentTeam = &$current['teams'][$dbaGetInformations['team_id']];
            if (!array_key_exists($dbaGetInformations['user_id'], $currentTeam['players'])) {
                $currentTeam['players'][$dbaGetInformations['user_id']] = $dbaGetInformations['pseudo'];
            }
            // Associate teams maps
            if (!array_key_exists($dbaGetInformations['map_id'], $current['maps'])) {
                $current['maps'][$dbaGetInformations['map_id']] = array(
                    'name'       => $dbaGetInformations['mapName'],
                    'score'      => ($dbaGetInformations['mapScore'] ? explode('-', $dbaGetInformations['mapScore']) : array('0', '0')),
                    'players'    => ($dbaGetInformations['mapPlayers'] ? explode('|', $dbaGetInformations['mapPlayers']) : array()),
                    'substitute' => ($dbaGetInformations['mapSubstitute'] ? explode('|', $dbaGetInformations['mapSubstitute']) : array()),
                    'game_mod'   => $dbaGetInformations['game_mod'],
                    'time'       => $dbaGetInformations['time'],
                    'opponent'   => $dbaGetInformations['opponent'],
                );
            }
        }
    }

    return json_encode($tab);
}

function getMatchPrefs($id = false) {
    $dbsGetWars = '
            SELECT ms.name, ms.value, ms.id
                FROM ' . MATCH_SETTINGS_TABLE . ' AS ms
                WHERE 1
        ';

    if ($id) {
        $dbsGetWars .= ' AND ms.id = "'.(int)$id.'" ';
    }

    $dbeGetWars = mysql_query($dbsGetWars) or die(nk_debug_bt());
    $settings = array();
    if ($dbeGetWars !== false) {
        while ($dbaGetWars = mysql_fetch_assoc($dbeGetWars)) {
            $settings[$dbaGetWars['name']] = $dbaGetWars['value'];
        }
    }

    return $settings;
}

?>
