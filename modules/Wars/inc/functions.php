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


/**
 * Récupère les values envoyé par le post|get
 * @param  String $key     Clé à retrouver
 * @param  String|boolean $default Valeur par défaut si pas trouvé
 * @return String|boolean Valeur retourné
 */
function WarsGetValue ($key, $default = false) {
    if (isset($_REQUEST[$key]) && !empty($_REQUEST[$key])) {
        return $_REQUEST[$key];
    } else {
        return $default;
    }
}

function getMatchs($id = false)
{
    $dbsGetWars = '
            SELECT *
                FROM ' . MATCH_TABLE . ' AS m
                LEFT OUTER JOIN ' . MATCH_TABLE_MAP . ' AS mm
                    ON mm.`match_id` = m.`id`
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

function WarsGetGames()
{
    $dbsGetGames = '
            SELECT id, name
                FROM ' . GAMES_TABLE . ' AS g
        ';

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

function WarsGetCountries()
{
    $dir = 'assets/images/flags/';
    $types = array('.gif', '.jpg', '.png');
    $flags = array();
    foreach (scandir($dir) as $flag)
    {
        $type = strstr($flag, '.');

        if (in_array($type, $types))
        {
            $flags[] = $flag;
        }
    }

    return $flags;
}

?>
