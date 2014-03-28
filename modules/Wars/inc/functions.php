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

function getMatchs($id = false)
{
    $dbsGetWars = '
            SELECT *
                FROM ' . MATCH_TABLE . ' AS m
                LEFT OUTER JOIN ' . MATCH_TABLE_MAP . ' AS mm
                    ON mm.`match_id` = m.`id`
                WHERE 1
        ';

    if ($id)
    {
        $dbsGetWars .= ' AND id = "'.(int)$id.'" ';
    }

    $dbeGetWars = mysql_query($dbsGetWars) or die(nk_debug_bt());
    $wars = array();
    if ($dbeGetWars !== false) {
        while ($dbaGetWars = mysql_fetch_assoc($dbeGetWars))
            $wars[] = $dbaGetWars;
    }
    // Check results
    if ($wars !== false && sizeof($wars)) {
        if (!$id)
            return $wars;
        else
            return current($wars);
    }
    else {
        return false;
    }
}

?>
