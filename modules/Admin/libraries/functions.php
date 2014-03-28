<?php
/**
 * Admin page of Wars Mod
 *
 * @version     1.8
 * @link http://www.nuked-klan.org Clan Clan Management System for Gamers
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @copyright 2001-2013 Nuked-Klan (Registred Trademark)
 */
defined('INDEX_CHECK') or die('You can\'t run this file alone.');

if (nkHasAdmin()) {


    /**
     * Affiche un message de confirmation
     * @param  int $case Clé du message
     */
    function nkDisplayConf ($case) {
        ?>
        <div class="nNote nSuccess nNoteHideable">
            <p>
                <?php
                    switch ($case) {
                        case '1':
                            echo 'Création réussie';
                            break;

                        case '2':
                            echo 'Suppression réussie';
                            break;

                        case '3':
                            echo 'Mise à jour réussie';
                            break;

                        default:
                            break;
                    }
                ?>
            </p>
        </div>
        <?php
    }

    /**
     *  Affiche le contenu d'un menu
     *  @param array $menus Liste des menus
     *  @param string $search Valeur à chercher pour le liens courant
     *  @param string $op Type d'action op|action
     *  @param string $op Si c'est pas le menu principal, c'est la valeur du op
     */
    function nkDisplayContentMenu ($menus, $search, $type = "op", $op = null) {
        if(is_array($menus)) {

            $i = 0;
        ?>
            <ul class="middleNavR">
        <?php
                foreach ($menus as $key => $menu) {

                    $request = array();

                    if($type !== "op") {
                        $request = array('op' => $op);
                    }

                    $request = array_merge(array($type => $key), $request);
        ?>
                    <li>
                        <a class="tipN" href="<?php echo nkGetLink(false, null, $request); ?>" original-title="<?php echo $menu['name']; ?>">
                            <span class="nkIcons icon-<?php echo (isset($menu['icon']) && !empty($menu['icon']) ? $menu['icon'] : 'help' ) ?>"></span>
                        </a>
                    </li>
        <?php

                    $i++;
                }
        ?>
            </ul>
        <?php
        }
    }

    /**
     * Retourne une liste des pays
     * @return array Liste des pays
     */
    function nkGetCountries () {
        $dir = 'assets/images/flags/';
        $types = array('.gif', '.jpg', '.png');
        $flags = array();
        foreach (scandir($dir) as $flag) {
            $type = strstr($flag, '.');

            if (in_array($type, $types)) {
                $flags[] = $flag;
            }
        }

        return $flags;
    }

    /**
     * Liste des jeux
     * @param  integer $id Identifiant du jeu
     * @return mixed       Données trouvées
     */
    function nkGetGames ($id = false) {
        $dbsGetGames = '
                SELECT g.id, g.name, COUNT(DISTINCT gm.id) AS maps, g.icon
                FROM ' . GAMES_TABLE . ' AS g
                    LEFT OUTER JOIN ' . GAMES_MAP_TABLE . ' AS gm
                        ON gm.game_id = g.id
                    WHERE 1
            ';

        if ($id) {
            $dbsGetGames .= " AND g.id = '" . (int)$id . "' ";
        }

        $dbsGetGames .= '
            GROUP BY g.id
        ';

        $dbeGetGames = mysql_query($dbsGetGames) or die(nk_debug_bt());
        $games = array();
        if ($dbeGetGames !== false) {
            while ($dbaGetGames = mysql_fetch_assoc($dbeGetGames)) {
                $games[] = $dbaGetGames;
            }
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

    /**
     * Liste des groupes
     * @param  integer $id Identifiant du groupe
     * @return mixed       Données trouvées
     */
    function nkGetGroups ($id = false) {
        $dbsGetGroups = "
            SELECT g.id, g.nameGroup, COUNT(ug.id) AS count
            FROM " . GROUPS_TABLE . " AS g
                LEFT OUTER JOIN " . TEAM_GROUPS_TABLE ." AS ug
                    ON g.id = ug.groups_id
            WHERE 1 ";

        if ($id) {
            $dbsGetGroups .= " AND g.id = '" . (int)$id . "' ";
        }

        $dbsGetGroups .= "
            GROUP BY g.id
            ORDER BY nameGroup ASC ";

        $dbeGetGroups = mysql_query($dbsGetGroups) or die(nk_debug_bt());

        $groups = array();

        if ($dbeGetGroups !== false) {
            while ($dbaGetGroups = mysql_fetch_assoc($dbeGetGroups)) {
                $groups[$dbaGetGroups['id']] = $dbaGetGroups['nameGroup'];
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
     * Génère un lien pour l'admin
     * @param  boolean $conf    Si on utilise une conf
     * @param  integer $id_conf Identifiant de la conf
     * @param  array   $others  Si d'autres éléments sont à ajoutés
     * @return string           Lien construit
     */
    function nkGetLink ($conf = false, $id_conf = null, $others = array()) {

        $request = array();

        if ($file = nkGetValue('file')) {
            $request['file'] = $file;
        }

        if ($page = nkGetValue('page')) {
            $request['page'] = $page;
        }

        if ($op = nkGetValue('op')) {
            $request['op'] = $op;
        }

        if ($conf) {
            if (!$id_conf) {
                $conf = (nkGetValue('id') ? '3' : '1');
            }
            else {
                $conf = $id_conf;
            }

            $request['conf'] = $conf;
        }

        if (is_array($others)) {
            $request = array_merge($request, $others);
        }

        return 'index.php?' . http_build_query($request);
    }

    /**
     * Liste des champs sociaux
     * @param  integer $id Identifiant du champ social
     * @return mixed       Données trouvées
     */
    function nkGetSocials ($id = false) {
        $dbsGetSocials = '
            SELECT udt.id, udt.name, udt.status
            FROM ' . USERS_SOCIAL . ' AS udt
            WHERE 1
        ';

        if ($id) {
            $dbsGetSocials .= " AND id = '" . (int)$id . "' ";
        }

        $dbeGetSocials = mysql_query($dbsGetSocials);
        $socials = array();

        if ($dbeGetSocials !== false) {
            while ($dbaGetSocials = mysql_fetch_assoc($dbeGetSocials)) {
                $socials[$dbaGetSocials['id']] = $dbaGetSocials;
            }
        }

        // Check results
        if ($socials !== false && sizeof($socials)) {
            if ($id) {
                $return = current($socials);
            }
            else {
                $return = $socials;
            }
        }
        else {
            $return = false;
        }

        return $return;
    }

    /**
     * Liste des équipes
     * @param  integer $id Identifiant de l'équipe
     * @return mixed       Données trouvées
     */
    function nkGetTeams ($id = false) {

        $dbsGetTeams = "
            SELECT t.name, t.prefix, t.suffix, t.`order`, t.`description`, t.id, GROUP_CONCAT(tg.groups_id) AS groups, GROUP_CONCAT(tga.game_id) AS games, image
            FROM " . TEAM_TABLE . " AS t
                LEFT OUTER JOIN " . TEAM_GROUPS_TABLE . " AS tg
                    ON tg.team_id = t.id
                LEFT OUTER JOIN " . TEAM_GAMES_TABLE . " AS tga
                    ON tga.team_id = t.id
            ";
        // Si une id est défini
        if($id) {
            $dbsGetTeams .= " WHERE t.id = '" . (int) $id . "' ";
        }

        $dbsGetTeams .= "
            GROUP BY t.id
            ORDER BY t.`order` ASC ";

        $dbeGetTeams = mysql_query($dbsGetTeams) or die(nk_debug_bt());

        $teams = array();
        if ($dbeGetTeams !== false) {
            while ($dbaGetTeams = mysql_fetch_assoc($dbeGetTeams)) {
                $teams[] = $dbaGetTeams;
            }
        }
        // Check results
        if ($teams !== false && sizeof($teams)) {
            if ($id) {
                $return = current($teams);
            }
            else {
                $return = $teams;
            }
        }
        else {
            $return = false;
        }

        return $return;
    }

    /**
     * Liste des rangs
     * @param  integer $id Identifiant du status
     * @return mixed       Données trouvées
     */
    function nkGetTeamsRanks ($id = false) {
        $dbsGetRank = "
            SELECT name, `order`, id
            FROM " . TEAM_RANK_TABLE . "
            WHERE 1
        ";
        // Si une id est défini
        if($id) {
            $dbsGetRank .= " AND id = '" . (int) $id . "' ";
        }

        $dbsGetRank .= '
            ORDER BY `order` ASC
        ';

        $dbeGetRank = mysql_query($dbsGetRank) or die(nk_debug_bt());

        $ranks = array();
        if ($dbeGetRank !== false) {
            while ($dbaGetRank = mysql_fetch_assoc($dbeGetRank)) {
                $ranks[] = $dbaGetRank;
            }
        }
        // Check results
        if ($ranks !== false && sizeof($ranks)) {
            if ($id) {
                $return = current($ranks);
            }
            else {
                $return = $ranks;
            }
        }
        else {
            $return = false;
        }

        return $return;
    }

    /**
     * Liste des statut d'équipe
     * @param  string $id Identifiant du statut
     * @return mixed      Données trouvées
     */
    function nkGetTeamsStatus ($id = false) {

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
            while ($dbaGetStatus = mysql_fetch_assoc($dbeGetStatus)) {
                $status[] = $dbaGetStatus;
            }
        }
        // Check results
        if ($status !== false && sizeof($status)) {
            if ($id) {
                $return = current($status);
            }
            else {
                $return = $status;
            }
        }
        else {
            $return = false;
        }

        return $return;
    }

    /**
     * Liste des utilisateurs
     * @param  string $id Identifiant de l'utilisateur
     * @return mixed      Données trouvées
     */
    function nkGetUsers ($id = false) {
        $dbsGetUsers = "
            SELECT u.id, u.pseudo, ud.prenom, ud.age, ud.sexe, ud.ville, u.avatar, ud.photo, u.country, ud.nom
            FROM " . USERS_TABLE. " AS u
                LEFT OUTER JOIN " . USERS_DETAIL_TABLE . " AS ud
                    ON u.id = ud.user_id
                LEFT OUTER JOIN " . USERS_PROFILS . " AS up
                    ON up.user_id = u.id
            WHERE 1 ";
        if ($id) {
            $dbsGetUsers = " AND id = '" . $id . "' ";
        }

        $dbsGetUsers .= "
            ORDER BY u.niveau DESC, u.pseudo ASC
        ";

        $dbeGetUsers = mysql_query($dbsGetUsers) or die(nk_debug_bt());
        $users = array();

        if ($dbeGetUsers !== false) {
            while ($dbaGetUsers = mysql_fetch_assoc($dbeGetUsers)) {
                $users[$dbaGetUsers['id']] = $dbaGetUsers;
            }
        }

        // Check results
        if ($users !== false && sizeof($users)) {
            if ($id) {
                $return = current($users);
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

    /**
     * Permet de récupérer les données de requêtes
     * @param  string  $key     Clé de la donnée
     * @param  mixed   $default Donnée de retour, si la clé n'est pas trouvé
     * @return mixed            Valeur trouvé ou de défault
     */
    function nkGetValue ($key, $default = false) {
        if (isset($_REQUEST[$key]) && !empty($_REQUEST[$key])) {
            $return = $_REQUEST[$key];
        }
        else {
            $return = $default;
        }

        if (!is_array($return))
            $return = stripslashes($return);
        else
            $return = array_map('stripslashes', $return);

        return $return;
    }

    /**
     * Upload une image
     * @param  mixed  $file      Tableau ($_FILES) ou clé du tableau $_FILES
     * @param  string $dest_path Chemin relatif pour l'image
     * @param  string $dest_file Nouveau nom du fichier
     * @return string            Nom du fichier
     */
    function nkUploadImage ($file, $dest_path, $dest_file = null) {

        if (!is_array($file) && preg_match('#^[0-9_A-Za-z.\-\s]+$#isD', $file)) {
            if (isset($_FILES[$file])) {
                $file = $_FILES[$file];
            }
            else {
                return false;
            }
        }
        else if (!is_array($file)) {
            return false;
        }

        if (!isset($file['tmp_name']))
            return true;

        // Si le dossier existe pas on le créé
        if (is_dir($dest_path) === false) {
            @mkdir($dest_path, 0755, true);
        }

        $dest_path = realpath($dest_path).DIRECTORY_SEPARATOR;

        if ($file['error'] !== 0) {
            return false;
        }

        $types = array('.jpeg', '.jpg', '.png', '.gif');

        // Format du fichier uploadé
        $type = strrchr($file['name'], '.');
        if (!in_array($type, $types)) {
            return false;
        }

        // Le fichier n'est pas uploadé
        if (is_uploaded_file($file['tmp_name']) === false) {
            return false;
        }

        if (!$dest_file) {
            $dest_file = preg_replace('#'.$type.'$#isD', '', $file['name']);
        }

        // On upload le fichier
        if (move_uploaded_file($file['tmp_name'], $dest_path . $dest_file . $type) === false) {
            return false;
        }

        return $dest_file . $type;
    }

}

?>
