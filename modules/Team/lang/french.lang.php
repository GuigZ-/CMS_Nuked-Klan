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

$arrayModLang = array(
    #####################################
    # Team - global (admin.php)
    #####################################
    'TEAM_NAME'                   => 'Nom',
    'TEAM_DESCRIPTION'            => 'Description',
    'TEAM_PREFIX'                 => 'Prefix',
    'TEAM_SUFFIX'                 => 'Suffix',
    'TEAM_GROUPS'                 => 'Groupes',
    'TEAM_GAMES'                  => 'Jeux',
    'TEAM_ORDER'                  => 'Ordre',
    'TEAM_ACTIONS'                => 'Actions',
    'FIELDS_REQUIRE'              => 'Champs requis',
    #####################################
    # Team - displayAdmin() (admin.php)
    #####################################
    'TEAM_ADMIN_TITLE'            => 'Administration des teams',
    #####################################
    # Team - displayMenu() (admin.php)
    #####################################
    'TEAM_MANAGEMENT_TEAMS'       => 'Gestion des &eacute;quipes',
    'TEAM_MANAGEMENT_USERS'       => 'Gestion des utilisateurs',
    'TEAM_MANAGEMENT_STATUS'      => 'Gestion des statuts',
    'TEAM_MANAGEMENT_RANKS'       => 'Gestion des rangs',
    'TEAM_PREFERENCES'            => 'Pr&eacute;f&eacute;rences',
    #####################################
    # Team - displaySubMenu() (admin.php)
    #####################################
    'TEAM_ADMIN_LIST'             => 'Liste',
    'TEAM_ADMIN_ADD_TEAM'         => 'Ajouter une &eacute;quipe',
    'TEAM_ADMIN_ADD_STATUS'       => 'Ajouter un statut',
    'TEAM_ADMIN_ADD_RANK'         => 'Ajouter un rang',
    'TEAM_ADMIN_ADD_COMBINAISON'  => 'Associer un membre &agrave; une &eacute;quipe',
    'TEAM_ADMIN_LIST_STATUS'      => 'Gestion des utilisateurs associ&eacute;s',
    #####################################
    # Team - displayContent() (admin.php)
    #####################################
    'TEAM_404'                    => 'Page not found',
    'TEAM_VIEW'                   => 'Voir l\'&eacute;quipe',
    #####################################
    # Team - listTeams() || formUsers() (admin.php)
    #####################################
    'TEAM_NO_TEAM_REGISTERED'     => 'Aucune &eacute;quipe enregistr&eacute;e',
    'TEAM_IMAGE'                  => 'Image',
    'TEAM_ICON'                   => 'Icon',
    #####################################
    # Team - listUsers() (admin.php)
    #####################################
    'TEAM_NO_USERS_REGISTERED'    => 'Aucun membre enregistr&eacute;',
    'TEAM_RANKS'                  => 'Rangs',
    'TEAM_STATUS'                 => 'Statut',
    'TEAM_NICKAME'                => 'Pseudo',
    'TEAM_TEAM'                   => '&Eacute;quipe',
    #####################################
    # Team - listStatus() (admin.php)
    #####################################
    'TEAM_NO_STATUS_REGISTERED'   => 'Aucun statut enregistr&eacute;',
    #####################################
    # Team - listRanks() (admin.php)
    #####################################
    'TEAM_NO_RANK_REGISTERED'     => 'Aucun rang enregistr&eacute;',
    #####################################
    # Team - formUser() (admin.php)
    #####################################
    'TEAM_RANK'                   => 'Rang',
    #####################################
    # Team - formPreferences() (admin.php)
    #####################################
    'TEAM_SETTINGS_TEAM_PAGE'     => 'Nombre de teams par page',
    'TEAM_SETTINGS_DISPLAY_TYPE'  => 'Type d\'affichage',
    'TEAM_SETTINGS_IMAGE_REPLACE' => 'Remplacer le titre par l\'image',
    'TEAM_DISPLAY_TYPE_TABLE'     => 'Tableau',
    'TEAM_DISPLAY_TYPE_ALT'       => 'En alternance',
    'TEAM_DISPLAY_TYPE_BLOC'      => 'Bloc',
    'TEAM_SETTINGS_PICTURE'       => 'Afficher la photo au lieu de l\'avatar',
    #####################################
    # Team - postProcess() (admin.php)
    #####################################
    'TEAM_FORM_EMPTY'             => 'Merci de remplir correctement votre formulaire',
    'TEAM_QUERY'                  => 'Requ&ecirc;te',
    'TEAM_EXISTS'                 => 'Le nom est d&eacute;j&agrave; utilis&eacute;',
    #####################################
    # Team - displayConf() (admin.php)
    #####################################
    'TEAM_FIRSTNAME'              => 'Pr&eacute;nom',
    'TEAM_COUNTRY'                => 'Pays',
    'TEAM_AGE'                    => 'Age',
    'TEAM_SEXE'                   => 'Sexe',
    'TEAM_TOWN'                   => 'Ville'
);

foreach ($arrayModLang as $constant => $translate) {
    if (!defined(constant($constant))) {
        define($constant, $translate);
    }
}

?>
