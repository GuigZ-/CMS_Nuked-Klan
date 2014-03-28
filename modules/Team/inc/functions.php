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

/**
 * Get Teams
 * @return boolean|array result of query
 */
function getTeams ($id = false) {

	$dbsGetTeams = '
			SELECT t.name, t.prefix, t.suffix, t.`order`, t.`description`, t.id, GROUP_CONCAT(tg.groups_id) AS groups, GROUP_CONCAT(tga.game_id) AS games
			FROM ' . TEAM_TABLE . ' AS t
                LEFT OUTER JOIN ' . TEAM_GROUPS_TABLE . ' AS tg
                    ON tg.team_id = t.id
                LEFT OUTER JOIN ' . TEAM_GAMES_TABLE . ' AS tga
                    ON tga.team_id = t.id
            ';
    // Si une id est défini
    if($id) {
        $dbsGetTeams .= ' WHERE t.id = "' . (int) $id . '" ';
    }

    $dbsGetTeams .= '
        GROUP BY t.id
        ORDER BY t.`order` ASC ';

	$dbeGetTeams = mysql_query($dbsGetTeams) or die(nk_debug_bt());

	$teams = array();
	if ($dbeGetTeams !== false) {
		while ($dbaGetTeams = mysql_fetch_assoc($dbeGetTeams))
			$teams[] = $dbaGetTeams;
	}
	// Check results
	if ($teams !== false && sizeof($teams)) {
		return $teams;
	}
	else {
		return false;
	}
}

/**
 * Get status
 * @return boolean|array result of query
 */
function getStatus ($id = false) {

    $dbsGetStatus = '
            SELECT name, id
            FROM ' . TEAM_STATUS_TABLE . '';
    // Si une id est défini
    if($id) {
        $dbsGetStatus .= ' WHERE id = "' . (int) $id . '" ';
    }

    $dbeGetStatus = mysql_query($dbsGetStatus) or die(nk_debug_bt());

    $status = array();
    if ($dbeGetStatus !== false) {
        while ($dbaGetStatus = mysql_fetch_assoc($dbeGetStatus))
            $status[] = $dbaGetStatus;
    }
    // Check results
    if ($status !== false && sizeof($status)) {
        return $status;
    }
    else {
        return false;
    }
}

/**
 * Get games
 * @return boolean|array result of query
 */
function getGames ($id = false) {

    $dbsGetGames = '
            SELECT name, id, icon
            FROM ' . TEAM_GAMES_TABLE . '';
    // Si une id est défini
    if($id) {
        $dbsGetGames .= ' WHERE id = "' . (int) $id . '" ';
    }

    $dbeGetGames = mysql_query($dbsGetGames) or die(nk_debug_bt());

    $games = array();
    if ($dbeGetGames !== false) {
        while ($dbaGetGames = mysql_fetch_assoc($dbeGetGames))
            $games[] = $dbaGetGames;
    }
    // Check results
    if ($games !== false && sizeof($games)) {
        return $games;
    }
    else {
        return false;
    }
}

/**
 * Get ranks
 * @return boolean|array result of query
 */
function getRanks ($id = false) {

	$dbsGetRank = '
			SELECT name, `order`, id
			FROM ' . TEAM_RANK_TABLE . '';
    // Si une id est défini
    if($id) {
        $dbsGetRank .= ' WHERE id = "' . (int) $id . '" ';
    }

	$dbeGetRank = mysql_query($dbsGetRank) or die(nk_debug_bt());

	$rank = array();
	if ($dbeGetRank !== false) {
		while ($dbaGetRank = mysql_fetch_assoc($dbeGetRank))
			$rank[] = $dbaGetRank;
	}
	// Check results
	if ($rank !== false && sizeof($rank)) {
		return $rank;
	}
	else {
		return false;
	}
}

/**
 * Get users
 * @return boolean
 */
function getUsers ($id = false, $by_team = false) {

    $nkUsers = getNkUsers();

	$dbsGetUsers = '
		SELECT u.user_id, s.name AS status, ut.id, ut.team_id, t.name AS team_name, GROUP_CONCAT(" ", r.name) AS ranks_name, GROUP_CONCAT(" ", r.id) AS ranks, u.teamstatus_id, ut.teamuser_id, t.prefix, t.suffix, t.description, g.name AS gameName, g.icon AS gameIcon, ut.description AS userDescription, t.image
		FROM ' . TEAM_USER_TEAM_TABLE . ' AS ut
            INNER JOIN ' . TEAM_USER_TABLE . ' AS u
                ON ut.teamuser_id = u.id';

    if ($id) {
        $dbsGetUsers .= ' AND ut.id = ' . (int) $id . ' ';
    }

    $dbsGetUsers .= '
            INNER JOIN ' . TEAM_TABLE . ' AS t
                ON ut.team_id = t.id
            INNER JOIN ' . TEAM_USER_RANK_TABLE . ' AS ur
                ON ur.teamuserteam_id = ut.id
            INNER JOIN ' . TEAM_RANK_TABLE . ' AS r
                ON ur.teamrank_id = r.id
            LEFT OUTER JOIN ' . TEAM_STATUS_TABLE . ' AS s
                ON u.teamstatus_id = s.id
            LEFT OUTER JOIN ' . TEAM_GAMES_TABLE . ' AS tg
                ON tg.team_id = ut.team_id
            LEFT OUTER JOIN ' . GAMES_TABLE . ' AS g
                ON g.id = tg.game_id
        ';
    $dbsGetUsers .= '
		GROUP BY ut.team_id, ut.teamuser_id
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

    		return $temp;
    	}
        else {
            return $users;
        }
    }
	else {
		return false;
	}
}

function getUsersStatus($id = false) {

    $nkUsers = getNkUsers();

    $dbsGetUsers = '
        SELECT u.id, u.user_id, s.name AS status_name, s.id AS status
        FROM ' . TEAM_USER_TABLE . ' AS u
            LEFT OUTER JOIN ' . TEAM_STATUS_TABLE . ' AS s
                ON u.teamstatus_id = s.id
        ';

    // Exec query
    $dbeGetUsers = mysql_query($dbsGetUsers) or die(nk_debug_bt());
    $users = array();
    if ($dbeGetUsers !== false) {
        while ($dbaGetUsers = mysql_fetch_assoc($dbeGetUsers))
            $users[] = array_merge($nkUsers[$dbaGetUsers['user_id']], $dbaGetUsers);
    }

    if ($users !== false && sizeof($users)) {
        return $users;
    }
    else {
        return false;
    }
}

function getNkUsers(){
    $dbsGetNkUsers = '
        SELECT u.id, u.pseudo, ud.prenom, ud.age, ud.sexe, ud.ville, u.avatar, ud.photo, u.country
        FROM ' . USER_TABLE . ' AS u
            LEFT OUTER JOIN ' . USER_DETAIL_TABLE . ' AS ud
                ON u.id = ud.user_id
            LEFT OUTER JOIN ' . USERS_PROFILS . ' AS up
                ON up.user_id = u.id
        ORDER BY u.niveau DESC, u.pseudo ASC
    ';

    $dbeGetNkUsers = mysql_query($dbsGetNkUsers) or (die(nk_debug_bt());
    $users = array();

    if ($dbeGetNkUsers !== false) {
        while ($dbaGetNkUsers = mysql_fetch_assoc($dbeGetNkUsers))
            $users[$dbaGetNkUsers['id']] = $dbaGetNkUsers;
    }

    // Check results
    if ($users !== false && sizeof($users)) {
        return $users;
    }
    else {
        return false;
    }
}

function getNkGroups($id = false) {
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
        while ($dbaGetNkGroups = mysql_fetch_assoc($dbeGetNkGroups))
            $groups[$dbaGetNkGroups['id']] = $dbaGetNkGroups['nameGroup'];
    }

    // Check results
    if ($groups !== false && sizeof($groups)) {
        return $groups;
    }
    else {
        return false;
    }
}

/**
 * Get games
 * @return boolean|array result of query
 */
function getNkGames () {

    $dbsGetGames = '
            SELECT name, id
            FROM ' . GAMES_TABLE . '';

    $dbeGetGames = mysql_query($dbsGetGames) or die(nk_debug_bt());

    $games = array();
    if ($dbeGetGames !== false) {
        while ($dbaGetGames = mysql_fetch_assoc($dbeGetGames))
            $games[$dbaGetGames['id']] = $dbaGetGames['name'];
    }
    // Check results
    if ($games !== false && sizeof($games)) {
        return $games;
    }
    else {
        return false;
    }
}

function getNkSocials()
{
    $dbsGetNkSocials = '
        SELECT udt.id, udt.name, udt.status
        FROM ' . USERS_SOCIAL . ' AS udt
    ';

    $dbeGetNkSocials = mysql_query($dbsGetNkSocials);
    $socials = array();

    if ($dbeGetNkSocials !== false) {
        while ($dbaGetNkSocials = mysql_fetch_assoc($dbeGetNkSocials))
            $socials[$dbaGetNkSocials['id']] = $dbaGetNkSocials;
    }

    // Check results
    if ($socials !== false && sizeof($socials)) {
        return $socials;
    }
    else {
        return false;
    }
}

?>
