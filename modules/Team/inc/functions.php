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

require_once 'modules/Admin/libraries/functions.php';

/**
 * Get users
 * @return boolean
 */
function getUsers ($id = false, $by_team = false) {

    $nkUsers = nkGetUsers();

	$dbsGetUsers = '
		SELECT u.user_id, s.name AS team_status, ut.id, ut.team_id, t.name AS team_name, GROUP_CONCAT(" ", r.name) AS ranks_name, GROUP_CONCAT(" ", r.id) AS ranks, ut.team_status_id, ut.team_user_id, t.prefix, t.suffix, t.description, g.name AS gameName, g.icon AS gameIcon, ut.description AS userDescription, t.image
		FROM ' . TEAM_USER_TEAM_TABLE . ' AS ut
            INNER JOIN ' . TEAM_USER_TABLE . ' AS u
                ON ut.team_user_id = u.id';

    if ($id) {
        $dbsGetUsers .= ' AND ut.id = ' . (int) $id . ' ';
    }

    $dbsGetUsers .= '
            INNER JOIN ' . TEAM_TABLE . ' AS t
                ON ut.team_id = t.id
            INNER JOIN ' . TEAM_USER_RANK_TABLE . ' AS ur
                ON ur.team_user_team_id = ut.id
            INNER JOIN ' . TEAM_RANK_TABLE . ' AS r
                ON ur.team_rank_id = r.id
            LEFT OUTER JOIN ' . TEAM_STATUS_TABLE . ' AS s
                ON ut.team_status_id = s.id
            LEFT OUTER JOIN ' . TEAM_GAMES_TABLE . ' AS tg
                ON tg.team_id = ut.team_id
            LEFT OUTER JOIN ' . GAMES_TABLE . ' AS g
                ON g.id = tg.game_id
        ';
    $dbsGetUsers .= '
		GROUP BY ut.team_id, ut.team_user_id
		ORDER BY t.`order` ASC, r.`order` ASC';

	// Exec query
	$dbeGetUsers = mysql_query($dbsGetUsers) or die(nk_debug_bt());
	$users = array();
	if ($dbeGetUsers !== false) {
		while ($dbaGetUsers = mysql_fetch_assoc($dbeGetUsers))
			$users[] = array_merge($nkUsers[$dbaGetUsers['user_id']], $dbaGetUsers);
	}

    if ($users !== false && sizeof($users)) {
    	// Check results
    	if ($by_team === true) {
    		// initialize un tableau
    		$temp = array();
    		// While results
    		foreach ($users as $value) {
                $temp[$value['team_name']]['team_id'] = $value['team_id'];
                $temp[$value['team_name']]['name'] = $value['team_name'];
                $temp[$value['team_name']]['image'] = $value['image'];
                $temp[$value['team_name']]['prefix'] = $value['prefix'];
                $temp[$value['team_name']]['suffix'] = $value['suffix'];
                $temp[$value['team_name']]['description'] = $value['description'];
                $temp[$value['team_name']]['members'][] = $value;
    			$temp[$value['team_name']]['games'][] = array('gameName' => $value['gameName'], 'gameIcon' => $value['gameIcon']);
    		}

    		$return = $temp;
    	}
        else {
            $return = $users;
        }
    }
	else {
		$return = false;
	}

    return $return;
}

function getUsersStatus ($id = false) {

    $nkUsers = nkGetUsers();

    $dbsGetUsers = '
        SELECT u.id, u.user_id, ut.team_user_id, s.name AS status_name, s.id AS status
        FROM ' . TEAM_USER_TEAM_TABLE . ' AS ut
            INNER JOIN ' . TEAM_USER_TABLE . ' AS u
                ON ut.team_user_id = u.id
            INNER JOIN ' . TEAM_STATUS_TABLE . ' AS s
                ON ut.team_status_id = s.id
        ';

    // Exec query
    $dbeGetUsers = mysql_query($dbsGetUsers) or die(nk_debug_bt());
    $users = array();
    if ($dbeGetUsers !== false) {
        while ($dbaGetUsers = mysql_fetch_assoc($dbeGetUsers)) {
            $users[] = array_merge($nkUsers[$dbaGetUsers['user_id']], $dbaGetUsers);
        }
    }

    if ($users !== false && sizeof($users)) {
        $return = $users;
    }
    else {
        $return = false;
    }

    return $return;
}

function getNkGroups ($id = false) {
    $dbsGetNkGroups = '
        SELECT g.id, g.nameGroup, COUNT(ug.id) AS count
        FROM ' . GROUPS_TABLE . ' AS g
            LEFT OUTER JOIN ' . TEAM_GROUPS_TABLE .' AS ug
                ON g.id = ug.groups_id
        GROUP BY g.id
        ORDER BY nameGroup ASC ';

    $dbeGetNkGroups = mysql_query($dbsGetNkGroups) or die(nk_debug_bt());

    $groups = array();

    if ($dbeGetNkGroups !== false) {
        while ($dbaGetNkGroups = mysql_fetch_assoc($dbeGetNkGroups)) {
            $groups[$dbaGetNkGroups['id']] = $dbaGetNkGroups['nameGroup'];
        }
    }

    // Check results
    if ($groups !== false && sizeof($groups)) {
        if ($id) {
            $return = current($groups);
        }
        else {
            $return = $groups;
        }
    }
    else {
        $return = false;
    }

    return $return;
}

/**
 * Liste des jeux
 * @param  integer $id Identifiant du jeu
 * @return mixed       Données trouvées
 */
function nkGetTeamGames ($id = false) {

    $dbsGetGames = "
            SELECT name, id, icon
            FROM " . TEAM_GAMES_TABLE . "";

    if($id) {
        $dbsGetGames .= " WHERE id = '" . (int) $id . "' ";
    }

    $dbeGetGames = mysql_query($dbsGetGames) or die(nk_debug_bt());

    $games = array();
    if ($dbeGetGames !== false) {
        while ($dbaGetGames = mysql_fetch_assoc($dbeGetGames))
            $games[] = $dbaGetGames;
    }
    // Check results
    if ($games !== false && sizeof($games)) {
        if ($id) {
            $return = current($games);
        }
        else {
            $return = $games;
        }
    }
    else {
        $return = false;
    }

    return $return;
}

?>
