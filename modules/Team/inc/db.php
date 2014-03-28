<?php

/**
 * DataBase page of Team Mod
 *
 * @version     1.8
 * @link http://www.nuked-klan.org Clan Clan Management System for Gamers
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @copyright 2001-2013 Nuked-Klan (Registred Trademark)
 */
defined('INDEX_CHECK') or die('You can\'t run this file alone.');

/**
 * Save in back office
 * @param string $table Name of table
 * @param array $datas Datas
 * @return boolean
 */
function save ($table, $datas) {
	// Test
	if (preg_match("#^[A-Za-z_]$#isD", $table) === 0)
		return false;

	// if is an array or is not empty
	if (is_array($datas) && sizeof($datas)) {
		// If current is list
		$current = current($datas);
		if (is_array($current) === false)
			$datas = array($datas);

		$values_stringified = $keys = array();
		$keys_stringified = null;
		foreach ($datas as $row_datas) {
			// Initialize repository
			$values = array();
			// while result
			foreach ($row_datas as $key => $value) {
				// After the first while
				if (is_null($keys_stringified)) {
					// if is not in key, return false because is an error
					if (!in_array($key, $keys)) {
						return false;
					}
				} else {
					$keys[] = $key;
				}
				// keys
				if (isset($keys_stringified) === false) {
					$keys_stringified = implode(',', $keys);
				}

				$values[] = $value;
				$values_stringified[] = '('.implode(', ', $values).')';
			}
		}

		$dbiSaveTeams = "INSERT INTO `".$table."`  (".$keys_stringified.") VALUES ".implode(', ', $values_stringified)."  ";
		return mysql_query($dbiSaveTeams);
	} else {
		return false;
	}
}

?>
