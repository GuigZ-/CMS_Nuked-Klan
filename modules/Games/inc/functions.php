<?php

/**
 * Functions of Games mod
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
function GamesGetValue ($key, $default = false) {
    if (isset($_REQUEST[$key]) && !empty($_REQUEST[$key])) {
        return $_REQUEST[$key];
    } else {
        return $default;
    }
}

function GamesGetGames($id = false)
{
    $dbsGetGames = '
            SELECT id, name
                FROM ' . GAMES_TABLE . ' AS g
                WHERE 1
        ';

    if ($id)
    {
        $dbsGetGames .= " AND id = '" . (int)$id . "' ";
    }

    $dbeGetGames = mysql_query($dbsGetGames) or die(nk_debug_bt());
    $games = array();
    if ($dbeGetGames !== false) {
        while ($dbaGetGames = mysql_fetch_assoc($dbeGetGames))
            $games[] = $dbaGetGames;
    }
    // Check results
    if ($games !== false && sizeof($games)) {
        if ($id)
            return current($games);
        else
            return $games;
    }
    else {
        return false;
    }
}

?>
