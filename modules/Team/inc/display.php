<?php

/**
 * Display page of Team Mod
 *
 * @version     1.8
 * @link http://www.nuked-klan.org Clan Clan Management System for Gamers
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @copyright 2001-2013 Nuked-Klan (Registred Trademark)
 */
defined('INDEX_CHECK') or die('You can\'t run this file alone.');

translate('modules/Team/lang/' . $GLOBALS['language'] . '.lang.php');

function index () {

    $teams = getUsers(false, true);

    displayTeam($teams);

}

/**
 * Afficher les équipes
 * @param  array $teams Les équipes
 */
function displayTeam ($teams) {

    if ($teams && sizeof($teams)) {
        // Les configurations
        $config = $GLOBALS['TEAM_CONFIG'];

        // On boucle les équipes
        foreach ($teams as $team) {
            if (!isset($_REQUEST['id_team'])) {
                ?>
                <div class="teamList">
                    <a class="teamBlock" href="index.php?file=Team&id_team=<?php echo $team['team_id']; ?>">
                        <button><?php echo TEAM_VIEW; ?></button>
                        <?php
                        // Si une image exist
                        if (isset($team['image']) && !empty($team['image'])) {
                            ?>
                            <span class="teamBlockImage">
                                <img src="modules/Team/upload/<?php echo printSecuTags($team['image']); ?>" alt="<?php echo printSecuTags($team['name']); ?>">
                            </span>
                            <?php
                        }
                        ?>
                        <h2><?php echo printSecuTags($team['name']); ?></h2>
                        <?php

                        if (isset($i)) {
                            unset($i);
                        }
                        ?>
                    </a>
                </div>
                <?php
            }
            else if (isset($_REQUEST['id_team']) && $team['team_id'] == $_REQUEST['id_team']) {
                displayTeamContent($config, $team);
            }
        }

    }
}

function displayTeamContent ($config, $team) {
    ?>
    <h2><?php echo printSecuTags($team['name']); ?></h2>
    <div class="teamBlock teamDisplay<?php echo ucfirst(strtolower($config['display_type']));  ?>">
        <div class="teamDescription"><?php echo secu_html($team['description']); ?></div>
        <?php

        foreach ($team['games'] as $game) {
            ?>
                <div class="teamGame">
                    <img src="<?php echo $game['gameIcon']; ?>" alt="" />
                    <?php echo $game['gameName']; ?>
                </div>
            <?php
        }

        // Affiche les titres
        if ($config['display_type'] === 'table') {
            displayUserTableTitle();
        }

        // On boucle les membres
        foreach ($team['members'] as $member) {
            // Si on alterne l'affichage
            if ($config['display_type'] === 'alternate') {
                // Si la variable $i n'est pas défini
                if (!isset($i)) {
                    $i = 0;
                }

                displayTeamBlock($member, $team, $config, (boolean) ($i % 2));

                // On incrémente
                $i++;
            }
            else if ($config['display_type'] === 'table') {
                displayUserTable($member, $team);
            }
            else if ($config['display_type'] === 'bloc') {
                displayTeamBlock($member, $team, $config);
            }
        }

        ?>
    </div>
    <?php
}

/**
 * Affichage d'un block
 * @param  array   $member Information du membre
 * @param  array   $team   Information de l'équipe
 * @param  array   $config Préférences du module
 * @param  boolean $right  Aligner à droite
 */
function displayTeamBlock ($member, $team, $config, $right = false) {
    $picture = $config['picture'] ? 'photo' : 'avatar';
    $img = file_exists($member[$picture]) ? $member[$picture] : 'assets/images/nkNoAvatar.png';
    ?>
        <div class="teamMemberBlock<?php echo ($right ? ' rightAlign' : ''); ?>">
            <?php
                if ($right === false) {
                    blockImage($img);
                    blockInfos($member, $team);
                    blockResults($member, array());
                }
                else {
                    blockResults($member, array());
                    blockInfos($member, $team);
                    blockImage($img);
                }
            ?>
        </div>
    <?php
}

/**
 * Block infos d'un membre
 * @param  array $member Information du membre
 * @param  array $team   Information de l'équipe
 */
function blockInfos ($member, $team) {
    ?>
        <div class="teamMemberInfos">
            <div class="teamMemberPseudo">
                <?php
                    echo printSecuTags($member['prenom']);
                ?>
                <b>&#34; <?php echo printSecuTags($member['pseudo']); ?> &#34;</b>
                <?php
                    echo printSecuTags($member['nom']);
                ?>
            </div>
            <i><?php echo $member['ranks_name'] ?></i>
            <ul>
                <li><?php echo TEAM_COUNTRY . ' : <img src="assets/images/flags/'. printSecuTags($member['country']) . '" alt="" /> ' . strstr(printSecuTags($member['country']), '.', true);; ?></li>
                <li><?php echo TEAM_AGE . ' : ' . printSecuTags($member['age']); ?></li>
                <li><?php echo TEAM_SEXE . ' : ' . printSecuTags($member['sexe']); ?></li>
                <li><?php echo TEAM_TOWN . ' : ' . printSecuTags($member['ville']); ?></li>
            </ul>
            <div class="teamMemberDescription">
            <?php
                echo TEAM_DESCRIPTION .' : ' . secu_html($member['userDescription']);
            ?>
            </div>
        </div>
    <?php
}

/**
 * Block de l'image
 * @param  string $img Lien de l'image
 */
function blockImage ($img) {
    ?>
        <div class="teamMemberPicture">
            <div class="teamBorderPicture">
                <img src="<?php echo printSecuTags($img); ?>" alt="" />
            </div>
        </div>
    <?php
}

function blockResults () {
    ?>
        <div class="teamMemberResults">

        </div>
    <?php
}

function displayUserTable ($user, $team) {
    ?>
        <div class="teamRow">
            <div class="teamCols">
                <img src="images/flags/<?php echo $user['country']; ?>" />
                <?php echo $user['prefix'] . $user['pseudo'] . $user['suffix']; ?>
            </div>
            <div class="teamCols">
                <?php echo $user['ranks_name']; ?>
            </div>
        </div>
    <?php
}

function displayUserTableTitle () {
    ?>
        <div class="teamRowTitle">
            <div class="teamCols">
                <?php echo TEAM_NICKAME; ?>
            </div>
            <div class="teamCols">
                <?php echo TEAM_RANKS; ?>
            </div>
        </div>
    <?php
}

/**
 * Charge les configurations du module
 */
function loadConfig() {

    $dbsGetConfig = "SELECT name, value FROM " . TEAM_SETTINGS_TABLE . " ";
    $dbeGetConfig = mysql_query($dbsGetConfig);

    $config = array();

    while ($dbaGetConfig = mysql_fetch_assoc($dbeGetConfig)) {
        $config[$dbaGetConfig['name']] = $dbaGetConfig['value'];
    }

    $GLOBALS['TEAM_CONFIG'] = $config;
}
?>
