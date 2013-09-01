<?php
/**
 * french.lang.php
 *
 * Admin french language constants
 *
 * @version 1.8
 * @link http://www.nuked-klan.org Clan Management System for Gamers
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @copyright 2001-2013 Nuked-Klan (Registred Trademark)
 */

defined('INDEX_CHECK') or die ('You can\'t run this file alone.');

$arrayAdminLang = array(
    #####################################
    # Admin - Panel
    #####################################
    /**
     * @todo : A DELETE
     */
    '_PREFS'         => 'Pr�f�rences',
    '_POSITION'      => 'Position',
    '_MOVEUP'        => 'D�placer vers le haut',
    '_MOVEDOWN'      => 'D�placer vers le bas',
    '_SEND'          => 'Envoyer',
    '_NAVLINKS'      => 'Liens',
    '_MANAGETEAMMAP' => 'Ajouter une map',
    '_NAVNEWS'       => 'News',
    '_OFF'           => 'D�sactiv�',
    '_NAVRECRUIT'    => 'Recrutement',
    '_SERVERMONITOR' => 'Moniteur de serveur',
    '_BACK'          => 'Retour',
    '_VISITOR'       => 'Visiteur',
    '_LEVEL'         => 'Niveau',
    /**
     * @todo : FIN DELETE
     */
    'HELLO'                => 'Bonjour',
    'ADMIN_WELCOME'        => 'Bienvenue sur l\'administration Nuked-Klan 1.8 !',
    'PANEL'                => 'Panneau',
    'MANAGEMENTS'          => 'Gestions',
    'GENERAL_SETTINGS'     => 'Pr&eacute;f&eacute;rences g&eacute;n&eacute;rales',
    'MYSQL'                => 'MySql',
    'PHPINFO'              => 'PHP Info',
    'ACTIONS'              => 'Actions',
    'SQL_ERRORS'           => 'Erreurs SQL',
    'THEME_MANAGEMENT'     => 'Gestion du th&egrave;me',
    'DISCUSSIONS'          => 'Discussions',
    'NOTIFICATIONS'        => 'Notifications',
    'SQL_ERRORS'           => 'Erreurs SQL detect&eacute;es',
    'STATS'                => 'Statistiques',
    'ACTION'               => 'Action',
    'ACTIONS'              => 'Actions',
    'SEE_ACTIONS'          => 'Voir les actions',
    'SEE_WEBSITE'          => 'Voir le site',
    'ANNOUNCES'            => 'Annonces',
    'CONNECT_IN_PROGRESS'  => 'En cours de connexion avec www.nuked-klan.org',
    'OFFICIAL_FORUM'       => 'Forum officiel Nuked-KLan',
    'ABOUT'                => 'A propos',
    'LICENSE'              => 'Licence',
    'LOGIN_IN_PROGRESS'    => 'Veuillez patienter quelques instants, connexion en cours ...',
    'BAD_LOGIN'            => 'Erreur, mot de passe ou pseudo incorrect !',
    'GOODBYE'              => 'Au revoir, &agrave; bient&ocirc;t',
    'DISCONNECT_SUCCESS'   => 'Op&eacute;ration r&eacute;ussie. Vous avez &eacute;t&eacute; d&eacute;connect&eacute; de l\'administration.',
    'DISCONNECT_FAIL'      => 'Op&eacute;ration &eacute;chou&eacute;e. Vous &ecirc;tes encore connect&eacute; &agrave; l\'administration.',
    'ADMINISTRATION'       => 'Administration',
    'ADMINISTRATION_LOGIN' => 'Connexion &agrave; l\'administration',
    'ADMIN_CHAT'           => 'Discussions Administrateurs',
    'NEW_MESSAGE'          => 'Nouveau message',
    'SELECT_GROUP'         => 'S&eacute;lectionnez les groupes qui y auront acc&egrave;s',
    'TRASH'          => 'Corbeille',
    #####################################
    # Admin - General Settings
    #####################################
    'NOTIFICATION_SUCCESS' => 'Notification de succ�s',
    'NOTIFICATION_INFO'    => 'Notification d\'information',
    'NOTIFICATION_FAIL'    => 'Notification d\'echec',
    'NOTIFICATION_ALERT'   => 'Notification d\'alerte',
    'NOTIFICATIONS_PURGE'  => 'action de plus de 2 semaines a &eacute;t&eacute; supprim&eacute;e.',
    'NOTIFICATIONS_PURGE_P'=> 'actions de plus de 2 semaines ont &eacute;t&eacute; supprim&eacute;es.',
    #####################################
    # Admin - General Settings
    #####################################
    'STATS_ALERT'               => 'Activer les statistiques consomment beaucoup de ressources sur votre base SQL ! <br />Pensez � vider les statistiques de temps en temps depuis l\'administration.',
    'GENERAL'                   => 'G&eacute;n&eacute;ral',
    'WEBSITE_NAME'              => 'Nom du site',
    'SLOGAN'                    => 'Slogan',
    'TAG_PREFIX'                => 'Tag pr&eacute;fix',
    'TAG_SUFFIX'                => 'Tag suffix',
    'WEBSITE_URL'               => 'Url du site',
    'DATE_FORMAT'               => 'Format de la date',
    'DATE_ZONE'                 => 'Fuseau horaire',
    'DATE_ADJUSTEMENT'          => 'En prenant en compte de votre ajustement, nous sommes le :',
    'ADMIN_MAIL'                => 'Mail de l\'administrateur',
    'FOOTER_MESSAGE'            => 'Message en bas de page',
    'WEBSITE_STATUS'            => 'Statut du site',
    'WEBSITE_INDEX'             => 'Index du site',
    'DEFAULT_THEME'             => 'Th&egrave;me par d&eacute;faut',
    'DEFAULT_LANGUAGE'          => 'Langue par d&eacute;faut',
    'PREVIEW'                   => 'Pr&eacute;visualisation',
    'REGISTRATIONS'             => 'Inscriptions',
    'BY_MAIL'                   => 'Par mail',
    'VALIDATION'                => 'Validation',
    'AUTO'                      => 'Automatique',
    'DELETE_THEMSELVES'         => 'Autoriser les membres &agrave; supprimer leur compte',
    'EDITOR'                    => 'Editeur',
    'VIDEOS_EDITOR'             => 'Autoriser l\'ajout de vid&eacute;os dans l\'&eacute;diteur (Youtube, Dailymotion, etc...)',
    'SCAYT_EDITOR'              => 'Activer le correcteur orthographique SCAYT dans l\'&eacute;diteur',
    'WEBSITE_MEMBERS'           => 'Membres du site',
    'MEMBERS_PER_PAGE'          => 'Membres par page',
    'AVATARS'                   => 'Avatars',
    'ALLOW_AVATAR_UPLOAD'       => 'Autoriser l\'upload d\'avatars',
    'ALLOW_EXTERNAL_AVATAR'     => 'Autoriser les avatars externes (liens)',
    'REGISTRATION_MAIL'         => 'Etre averti par email des nouvelles inscriptions',
    'REGISTRATION_DISCLAIMER'   => 'Charte - r&egrave;glement de l\'inscription',
    'REGISTRATION_MAIL_CONTENT' => 'Contenu de l\'email d\'inscription',
    'VISIT_TIME'                => 'Dur&eacute;e en minutes d\'une visite',
    'STATS_ACCESS'              => 'Niveau requis pour voir l\'analyse des visites',
    'DISPLAY_GENERATE_TIME'     => 'Afficher le temps de g&eacute;n&eacute;ration en bas de page',
    'SHARE_STATS'               => 'Partagez vos statistiques',
    'SEE_SHARED_STATS'          => 'Voir les statistiques partag&eacute;es',
    'SHARE_STATS_INFO'          => 'Ce service &agrave; pour but de nous aider &agrave; am&eacute;liorer les services Nuked-Klan tout en gardant votre anonymat.',
    'CONNECTION_OPTIONS'        => 'Options de connexion',
    'COOKIE_NAME'               => 'Nom du cookie',
    'SESSION_TIME'              => 'Dur&eacute;e en minutes d\'une session',
    'COOKIE_TIME'               => 'Dur&eacute;e en jours d\'une session cookie',
    'CONNECTED_TIME'            => 'Dur&eacute;e en seconde du Time-Out du Compteur live',
    'META_TAGS'                 => 'Meta tags',
    'KEYWORDS'                  => 'Mots-cl&eacute;s',
    'WEBSITE_DESCRIPTION'       => 'Description du site',
    'GENERAL_SETTINGS_SAVED'    => 'Pr&eacute;f&eacute;rences g&eacute;n&eacute;rales sauvegard&eacute;es',
    'CHAR_NOT_ALLOW'            => 'Caract&egrave;re non autoris&eacute; !',
    #####################################
    # Admin - Mysql Management
    #####################################
    'MYSQL_MANAGEMENT'          => 'Gestion MySql',
    'DATABASE'                  => 'Base de donn&eacute;e',
    'SAVE_DATABASE'             => 'Sauvegarder la base de donn&eacute;e',
    'OPTIMIZE_DATABASE'         => 'Optimiser la base de donn&eacute;e',
    'TABLE'                     => 'Table',
    'SIZE'                      => 'Taille',
    'SPACE_SAVED'               => 'Espace sauv&eacute;',
    'NO_OPTIMIZED'              => 'Non optimis&eacute;',
    'OPTIMIZED'                 => 'Optimis&eacute;',
    'TOTAL'                     => 'Total',
    #####################################
    # Admin - PHP Info
    #####################################
    'PHPINFO_MANAGEMENT'        => 'Gestion PHP Info',
    'SEE_INFOS'                 => 'Voir les informations',
    'GLOBALES'                  => 'G&eacute;n&eacute;rales',
    'ENVIRONMENT'               => 'Environnement',
    #####################################
    # Admin - Actions
    #####################################
    'ACTIONS_MANAGEMENT'        => 'Gestion des actions',
    'ACTIONS_AUTO_DELETE'       => 'Apr&egrave;s votre lecture, les actions d&eacute;passant 2 semaines seront supprim&eacute;es d&eacute;finitivement.',
    'ACTION_CONNECT'            => 's\'est connect&eacute; &agrave; l\'administration',
    'ACTION_DISCONNECT'         => 's\'est d&eacute;connect&eacute; de l\'administration',
    'ACTION_SAVE_DB'            => 'a sauvegard&eacute; la base de donn&eacute;e',
    'ACTION_OPTIMIZE_DB'        => 'a optimis&eacute; la base de donn&eacute;e',
    'ACTION_PURGE_SQL_ERRORS'   => 'a supprim&eacute; les erreurs SQL',
    'ACTION_GENERAL_SETTINGS'   => 'a modifi&eacute; les pr&eacute;f&eacute;rences g&eacute;n&eacute;rales',
    'ACTION_DEL_NOTIFICATION'   => 'a supprim&eacute; une notification',
    'ACTION_MODIFY_BLOCK'       => 'a modifi&eacute; le bloc',
    'ACTION_ADD_BLOCK'          => 'a ajout&eacute; le bloc',
    'ACTION_DEL_BLOCK'          => 'a supprim&eacute; le bloc',
    'ACTION_EDIT_MODULES'       => 'a modifi&eacute; les modules',
    'ACTION_DELETE_SMILEY'      => 'a supprim&eacute; l\'&eacute;moticone',
    'ACTION_EDIT_SMILEY'        => 'a modifi&eacute; l\'&eacute;moticone',
    'ACTION_ADD_SMILEY'         => 'a ajout&eacute; l\'&eacute;moticone',
    #####################################
    # Admin - SQL Errors
    #####################################
    'SQL_ERRORS_MANAGEMENT'     => 'Gestion des erreurs SQL',
    'PURGE_SQL_ERRORS'          => 'Supprimer les erreurs SQL',
    'SQL_ERRORS_DELETED'        => 'Erreurs SQL supprim&eacute;es avec succ&egrave;s !',
    #####################################
    # Admin - Smilies Management
    #####################################
    'GROUPS_MANAGEMENT' => 'Gestion des groupes',
    'GROUP_ADD' => 'Ajouter un groupe',
    'NB_GROUP_OWNER' => 'Dans le groupe',
    'NO_DESCRIPTION' => 'Aucune description',
    'DESC_ADMINISTRATORS' => 'Groupe des administrateurs supr&ecirc;mes',
    'DESC_MEMBERS' => 'Groupe des utilisateurs enregistr&eacute;s',
    'DESC_VISITORS' => 'Groupes des visiteurs',
    'GROUP_PERMANENT' => 'Groupe permanent',
    'DELETE_GROUP' => 'Supprimer le groupe',
    #####################################
    # Admin - Blocks Management
    #####################################
    'BLOCKS_MANAGEMENT' => 'Gestion des blocs',
    'BLOCK_ADD'         => 'Ajouter un bloc',
    'NO_BLOCKS'         => 'Aucun bloc',
    'BLOCK_OF_MODULE'   => 'Bloc d\'un module',
    'DISPLAY_AVATAR'    => 'Voir l\'avatar',
    'SELECT_PAGE'       => 'S&eacute;lectionnez les pages o&ugrave; vous voulez que le bloc s\'affiche',
    'BLOCK_ADDED'       => 'Bloc ajout&eacute; avec succ&egrave;s',
    'BLOCK_EDITED'      => 'Bloc modifi&eacute; avec succ&egrave;s',
    'BLOCK_DELETED'     => 'Bloc supprim&eacute; avec succ&egrave;s',
    'EDIT_MENU'         => 'Editer le menu',
    'DELETE_BLOCK'      => 'Supprimer le bloc',
    'TEAMS'             => 'Equipes',
    'RSS_TITLE'         => 'Titre du flux',
    'RSS_ICON'          => 'Puce',
    'RSS_COUNT'         => 'Nombre d\'&eacute;l&eacute;ments du flux',
    'HEADER'            => 'Header',
    'FOOTER'            => 'Footer',
    'SURVEY'            => 'Sondage',
    'HTML_CONTENT'      => 'Contenu Html',
    #####################################
    # Admin - Modules Management
    #####################################
    'MODULES_MANAGEMENT' => 'Gestion des modules',
    'MODULE_EDITED'     => 'Module modifi&eacute; avec succ&egrave;s',
    #####################################
    # Admin - Smilies Management
    #####################################
    'SMILIES_MANAGEMENT'   => 'Gestion des &eacute;moticones',
    'SMILEY'               => 'Emoticone',
    'CODE'                 => 'Code',
    'SMILEY_ADD'           => 'Ajouter un &eacute;moticone',
    'UPLOAD_SMILEY'        => 'Envoyer un &eacute;moticone',
    'SMILEY_DELETED'       => 'Smiley supprim&eacute; avec succ&egrave;s',
    'SMILEY_UPLOAD_FAILED' => 'Une erreur est survenue lors de l\'upload du smiley',
    'DELETE_SMILEY'        => 'Supprimer le smiley ',
    'SMILEY_ADDED'         => 'Smiley ajout&eacute; avec succ&egrave;s',
    'SMILEY_EDITED'        => 'Smiley modifi&eacute; avec succ&egrave;s',
    'SMILEY_BAD_CODE'      => 'Le code de l\'&eacute;moticone ne peut contenir de quotes (\' ou ") et ne peut &ecirc;tre &eacute;gale au nom',
    #####################################
    # Admin - Games Management
    #####################################
    'DELETE_GAMES'     => 'Supprimer le jeu',
    'GAMES_MANAGEMENT' => 'Gestion des jeux',
    #####################################
    # Admin - License
    #####################################
    'LICENSE_TYPE'              => 'Licence GNU/GPL',
    'LICENSE_CONTENT'           => '<h3>Les droits garantis</h3>
                                    <p>
                                        Les termes de la GPL autorisent toute personne � recevoir une copie d\'un travail sous GPL. Chaque personne qui adh�re aux termes et aux conditions de la GPL a la permission de modifier le travail, de l\'�tudier et de redistribuer le travail ou un travail d�riv�. Cette personne peut toucher de l\'argent pour ce service ou bien ne rien toucher. Ce dernier point distingue la GPL des autres licences de logiciels qui interdisent la redistribution dans un but commercial. Stallman pense que le logiciel libre ne devrait pas placer de restriction sur l\'utilisation commerciale, et la GPL indique explicitement qu\'un travail sous GPL peut-�tre (re)vendu. En cas de modification, le r�sultat doit �tre plac� sous la m�me licence.
                                    </p>
                                    <h3>Le copyleft</h3>
                                    <p>
                                        La GPL ne donne pas � l\'utilisateur des droits de redistribution sans limite. Le droit de redistribuer est garanti seulement si l\'utilisateur fournit le code source de la version modifi�e. En outre, les copies distribu�es, incluant les modifications, doivent �tre aussi sous les termes de la GPL.
                                        <br/>
                                        Cette condition est connue sous le nom de copyleft, et il obtient son origine l�gale du fait que le programme est � copyright� �. Puisqu\'il est copyright�, l\'utilisateur n\'a aucun droit de le modifier ou de le redistribuer, sauf sous les termes du copyleft. On est oblig� d\'adh�rer � la GPL si on souhaite exercer des droits normalement limit�s (voire interdits) par le copyright, comme la redistribution. Ainsi, si on distribue des copies du travail sans respecter les termes de la GPL (en gardant le code source secret par exemple), on peut �tre poursuivi par l\'auteur original en vertu du copyright.
                                        <br/>
                                        Le copyleft emploie ainsi le copyright pour accomplir l\'oppos� de son but habituel : au lieu des restrictions impos�es, il accorde des droits d\'utilisation. C\'est pour cette raison que la GPL est d�crite comme un d�tournement du copyright. Elle assure �galement qu\'on n\'accorde pas de droits illimit�s de redistribution par l\'interm�diaire de n\'importe quel bogue l�gal trouv� dans les termes du copyleft.
                                    </p>
                                    <p>
                                        Beaucoup de distributeurs de programmes sous GPL fournissent le code source avec l\'ex�cutable. Pour s\'acquitter des obligations du copyleft, une autre possibilit� est de fournir sur demande le code source sur un support physique, par exemple un c�d�rom. Dans la pratique, beaucoup de programmes sous GPL sont distribu�s sur Internet et leur code source est disponible sur FTP, CVS, Cette distribution par Internet �tant compatible avec la licence GPL.
                                    </p>
                                    <p>
                                        Le copyleft s\'applique uniquement quand une personne veut redistribuer le programme. On est autoris� � faire des versions modifi�es priv�es, sans aucune obligation de divulguer les modifications effectu�es sur le programme s\'il n\'est distribu� � personne. Le copyleft s\'applique uniquement au programme et non � ses sorties. Par exemple, un portail Web utilisant une version modifi�e priv�e d\'un CMS sous GPL ne sera pas oblig� de livrer ses sources. Cette situation est corrig�e par l\'Affero General Public License, une version de la GPL 3 qui ajoute un paragraphe pour accorder aux utilisateurs d\'un programme acc�d� par un r�seau les m�mes droits que les utilisateurs d\'un programme install� localement.
                                    </p>
                                    <h3>La licence</h3>
                                    <p>
                                        La GPL a �t� con�ue comme une licence, plut�t que comme un contrat. Dans les juridictions de droit commun (Common Law, notamment les pays anglo-saxons, membres ou issus du Commonwealth), la distinction entre une licence et un contrat est importante : les contrats rel�vent du droit des contrats, tandis que les licences (et donc la GPL) rel�vent du droit d\'auteur (copyright). Cependant, cette distinction n\'est pas utile dans les nombreuses juridictions o� il n\'y a pas de diff�rences entre les contrats et les licences, comme dans les syst�mes de droit civil (Code civil ou Civil Law, notamment nombre de pays latins et de pays continentaux europ�ens ainsi que leurs anciennes colonies). La situation dans les pays de droit islamique ou appliquant un double droit civil et coutumier peut �tre diff�rente en fonction des personnes ou organisations concern�es et de la loi qui s\'applique � eux, la distinction est alors aussi importante pour savoir quel droit s\'applique.
                                    </p>
                                    <h3>La valeur juridique</h3>
                                    <p>
                                        Le tribunal de grande instance de Paris a jug� applicable la licence GPL (version 2) en France le 28 mars 200716.
                                        <br />
                                        Les licences CeCILL ont �t� mises en place afin de permettre � des �tablissements publics de publier leurs travaux logiciels sous licence libre r�dig�e selon le droit fran�ais. La licence CeCILL est compatible, depuis sa version 2, avec la licence publique g�n�rale GNU.
                                        <br />
                                        En Allemagne, on peut noter que le projet Netfilter a obtenu gain de cause suite � une violation de GPL de la part de la soci�t� Sitecom GmbH.
                                        <br />
                                        Harald Welte, fondateur du projet gpl-violations.org, poursuit les soci�t�s et les programmeurs coupables, selon lui, d\'une violation de la GPL. Il a d�j� obtenu, depuis 2004, une trentaine de conciliations, apr�s avoir engag� des poursuites dans certains cas.
                                    </p>',
    #####################################
    # Admin - About
    #####################################
    'ABOUT_INFOS'               => '<h3>Informations g�n�rales :</h3>
                                    <p>
                                        Version 1.8<br />
                                        D�velopp�e par toute <a href="http://www.nuked-klan.org/index.php?file=Equipe">l\'�quipe Nuked-KlaN</a>
                                    </p>
                                    <h3>Contact Nuked-KlaN :</h3>
                                    <p><a href="http://www.nuked-klan.org/index.php?file=Contact">Formulaire de contact</a></p>
                                    <h3>Remerciements :</h3>
                                    <p>A toute l\'�quipe nuked-klan.org, ainsi qu\'� sa communaut� qui nous a permis de corriger rapidement les principaux bugs</p>
                                    <h3>Licence GNU :</h3>
                                    <p>
                                        Merci de ne pas supprimer le <acronym title="Le terme copyleft est un double jeu de mots faisant r�f�rence au copyright traditionnel" style="text-decoration: underline">copyleft</acronym> par respect pour le cms et respecter la licence GNU.
                                    </p>',
);

/*
define(\"_SPECCNOTALLOW\",\"Caract�res sp�ciaux interdits pour le nom des cookies !\");
define(\"_WAIT\", \"non catalogu�\");
define(\"_FAILLE\", \"faille d�t�ct�e\");
define(\"_PIRATE\", \"tentative de piratage\");
define(\"_VALID\", \"Sans danger\");
define(\"_UPDATE\", \"Mettre � jour\");
define(\"_PAGEACCESS\",\"Vous ne pouvez pas acc�der � cette page directement\");
define(\"_NOENTRANCE\",\"D�sol� mais vous n"avez pas les droits pour acc�der � cette page");
define("_ZONEADMIN","Cette zone est r�serv�e � l'Admin, d�sol�...");
define("_BLOCKADMIN","Gestion des Blocs");
define("HELP","Aides");
define("_BLOCKTITLE","Titre du Bloc");
define("_BLOCK","Blocs");
define("_TITLE","Titre");
define("_TYPE","Type");
define("_LEVEL","Niveau");
define("_LEVELACCES","Niveau d'acc�s");
define("_LEVELADMIN","Niveau d'admin");
define("_SELECTPAGE","S�lectionnez les pages o� vous voulez que le bloc s'affiche");
define('_SELECTGROUP', 'S&eacute;lectionnez les groupes qui auront acc&egrave;s &agrave; ce bloc');
define("_CREATEBLOCK","Cr�er un bloc");
define("_BACK","Retour");
define("_BLOCKSUCCES","Bloc ajout� avec succ�s.");
define("_BLOCKCLEAR","Bloc effac� avec succ�s.");
define("_BLOCKMODIF","Bloc modifi� avec succ�s.");
define("_TEAM","Team");
define("_USER","User");
define("_ADMIN","Admin");
define("_ALL","Tous");
define("_DELBLOCK","Vous �tes sur le point de supprimer le bloc");
define("_CONFIRM","Continuer ?");
define("_POSITION","Position");
define("_RIGHT","Droite");
define("_LEFT","Gauche");
define("_CENTERBLOCK","Centre");
define("_EDIT","Editer");
define("_MODIF","Modifier");
define("_DELETE","Supprimer");
define("_BLOCKDOWN","Descendre ce Bloc");
define("_BLOCKUP","Monter ce Bloc");
define("_BLOCKEDIT","Editer ce Bloc");
define("_BLOCKDEL","Supprimer ce Bloc");
define("_BLOCKADD","Ajouter un Bloc");
define("_BLOCKCOUNTER","Compteur");
define("_BLOCKLANG","Langue");
define("_BLOCKTHEME","Th�mes");
define("_BLOCKHTML","HTML");
define("_NOBLOCK","Aucun bloc");

define("_ADMINISTRATION","Administration");
define("_ADMINLOG","Vous n'�tes pas logu� en tant qu'Admin");
define("_MODULEADMIN","Gestion des Modules");
define("_USERADMIN","Gestion des Membres");
define("_GAMESADMIN","Gestion des Jeux");
define("_SMILIEADMIN","Gestion des Smileys");
define("_ADMINMODULE","Administration des modules");
define("_PREFGEN","Pr�f�rences G�n�rales");
define("_CLICTOHELP","Cliquez sur l'ic�ne ? pour obtenir de l'aide");
define("_CHECKUPDATE","Mises � jour de Nk");
define("_NAMENEWS","News");
define("_NAMEFORUM","Forum");
define("_NAMEDOWNLOAD","T�l�chargements");
define("_NAMEDEFY","D�fie");
define("_NAMERECRUIT","Recrutement");
define("_NAMESECTIONS","Articles");
define("_NAMESERVER","Serveurs");
define("_NAMELINKS","Liens Web");
define("_NAMECALANDAR","Calendrier");
define("_NAMEGALLERY","Galerie");
define("_NAMEMATCHES","Matches");
define("_NAMEIRC","IrC");
define("_NAMEGUESTBOOK","Livre d'or");
define("_NAMESURVEY","Sondage");
define("_NAMESUGGEST","Suggestion");
define("_NAMECOMMENT","Commentaires");
define("_NAMEMEMBERS","Membres");
define("_NAMETEAM","Team");
define("_NAMESHOUTBOX","Tribune libre");
define("_NAMEVOTE","Vote");

define("_MODULE","Module");
define("_NAME","Nom");
define("_MEMBERS","Membre");
define("_LEVEL1","niveau 1");
define("_LEVEL2","niveau 2");
define("_LEVEL9","niveau 9");
define("_ADMINFIRST","Premier Palier d'Admin");
define("_ADMINSUP","Admin Supr�me");
define("_EDITMODULE","Modifier");
define("_OFFMODULE","D�sactiver");
define("_ONMODULE","Activer");
define("_MODULEENABLED","Module activ� avec succ�s.");
define("_MODULEDISABLED","Module d�sactiv� avec succ�s.");
define("_MODULEMODIF","Module modifi� avec succ�s.");
define("_MODULEEDIT","Editer ce Module");
define("_STATUS","Statut");
define("_ENABLED","Activ�");
define("_DISABLED","D�sactiv�");

define("_GENERAL","G�n�ral");
define("_SITENAME","Titre du site");
define("_SLOGAN","Slogan");
define("_TAGPRE","Tag Pr�fixe");
define("_TAGSUF","Tag Suffixe");
define("_SITEURL","URL du Site");
define("_DATEFORMAT","Format de la date");
define("_DATEZONE","Fuseau horaire");
define("_DATEADJUST","En prenant en compte de votre ajustement, nous sommes le :");
define("_ADMINMAIL","Email de l'admin");
define("_FOOTMESS","Message de bas de page");
define("_SITEINDEX","Index du site");
define("_THEMEDEF","Th�me par d�faut");
define("_LANGDEF","Langue par d�faut");
define("_GAMEDEF","Jeu par d�faut");
define("_OPEN","Ouverte");
define("_CLOSE","Ferm�e");
define("_BYMAIL","Par email");
define("_SITEMEMBERS","Membres du site");
define("_NUMBERMEMBER","Nombre de membres par page");
define("_REGISTRATION","Inscription");
define("_REGISTERMAIL","Etre averti par email des nouvelles inscriptions");
define("_SUGGESTMAIL","Etre averti par email des nouvelles suggestions");
define("_REGISTERTXT","Texte de l'email d'inscription");
define("_REGISTERDISC","Charte - r�glement de l'inscription");
define("_OPTIONCONNEX","Option Connexion");
define("_CONNEXMIN","Dur�e en minutes d'une session IP");
define("_CONNEXDAY","Dur�e en jours d'une session cookie");
define("_COOKIENAME","Nom du cookie");
define("_CONNEXSEC","Dur�e en seconde du Time-Out du Compteur live");
define("_METATAG","Meta Tags");
define("_METAWORDS","Mots Clefs");
define("_METADESC","Description du site");
define("_VALIDATION","Validation");
define("_AUTO","Automatique");
define("_ADMINISTRATOR","Administrateur");
define("_STATS","Statistiques");
define("_VISITTIME","Dur�e en minutes d'une visite");
define("_LEVELANALYS","Niveau requis pour voir l'analyse des visites");
define('_DISPLYGNRATETME' => 'Afficher le temps de g�n�ration en bas de page');
define("_AVATARS","Avatars");
define("_AVATARUPLOAD","Autoriser l'upload d'avatars");
define("_AVATARURL","Autoriser les avatars externes (liens)");
define("_USERDELETE","Autoriser les membres � supprimer leur compte");
define("_VIDEOEDITEUR","Autoriser l'ajout de vid�os dans l'�diteur (Youtube, Dailymotion, etc...)");
define("_SCAYTEDITEUR","Activer le correcteur orthographique SCAYT dans l'�diteur");
define("_SITESTATUS","Statut du site");
define("_OPENED","Ouvert");
define("_CLOSED","Ferm�");

define("_PREFUSER","Pr�f�rence de");
define("_NICK","Pseudo");
define("_MAIL","Email");
define("_PUBLIC","publique");
define("_URL","URL");
define("_COUNTRY","Pays");
define("_ICQ","ICQ");
define("_MSN","MSN");
define("_AIM","AIM");
define("_YIM","Yim");
define("_GAME","Jeu");
define("_AVATAR","Avatar");
define("_SIGN","Signature");
define("_RANKTEAM","Rang Team");
define("_PASSWORD","Mot de passe");
define("_TEAMNONE","Aucune");
define("_NORANK","Aucun");
define("_NONE","Aucun");
define("_CONFIRMPASS","confirmez");
define("_MODIFUSER","Modifier ce membre");
define("_ADDUSER","Ajouter un membre");
define("_USERADD","Membre ajout� avec succ�s.");
define("_EMPTYFIELD","Vous avez oubli� de remplir un champ obligatoire !");
define("_2PASSFAIL","Les deux mots de passe saisis ne sont pas identiques");
define("_INFOSMODIF","Informations modifi�es");
define("_USERDEL","Membre effac� avec succ�s.");
define("_DATEUSER","Date d'arriv�e");
define("_EDITUSER","Editer ce membre");
define("_DELETEUSER","Supprimer ce membre");
define("_TEAMMANAGEMENT","Gestion des Teams");
define("_EDITTHISTEAM","Editer cette Team");
define("_DELTHISTEAM","Supprimer cette Team");
define("_ADDTEAM","Ajouter une Team");
define("_NAME","Nom");
define("_TAG","Tag");
define("_ORDER","Ordre");
define("_CREATETEAM","Cr�er une Team");
define("_TEAMADD","Team ajout�e avec succ�s.");
define("_MODIFTHISTEAM","Modifier cette Team");
define("_TEAMMODIF","Team modifi�e avec succ�s.");
define("_TEAMDEL","Team supprim�e avec succ�s.");
define("_NOTEAMINDB","Aucune team dans la base de donn�es");
define("_BAN","Bannissement");
define("_TOBAN","Bannir");
define("_IP","Adresse IP");
define("_ADDIP","Bannir un utilisateur");
define("_IPADD","Utilisateur banni avec succ�s.");
define("_DELTHISIP","D�bannir cet utilisateur");
define("_EDITTHISIP","Editer cet utilisateur");
define("_MODIFTHISIP","Modifier cet utilisateur");
define("_IPDEL","Utilisateur d�banni avec succ�s.");
define("_IPMODIF","Utilisateur modifi� avec succ�s.");
define("_RANKMANAGEMENT","Gestion des Rangs");
define("_EDITTHISRANK","Editer ce rang");
define("_DELTHISRANK","Supprimer ce Rang");
define("_ADDRANK","Ajouter un Rang");
define("_CREATERANK","Cr�er un Rang");
define("_RANKADD","Rang ajout� avec succ�s.");
define("_MODIFTHISRANK","Modifier ce Rang");
define("_RANKMODIF","Rang modifi� avec succ�s.");
define("_RANKDEL","Rang supprim� avec succ�s.");
define("_SEARCH","Recherche");
define("_NORESULTFOR","Aucun membre trouv� pour");
define("_NOUSERINDB","Aucun membre dans la base de donn�es");
define("_ORDERBY","Classer par");
define("_NORANKINDB","Aucun rang dans la base de donn�es");
define("_NOIPINDB","Aucun bannissement dans la base de donn�es");
define("_VISIT","visite");

define("_SMILEYADD","Ajouter un smiley");
define("_SMILEY","Smileys");
define("_CODE","Code");
define("_UPSMILEY","Uploader un smiley");
define("_SMILEYEDIT","Editer ce smiley");
define("_SMILEYDEL","Supprimer ce smiley");
define("_SMILEYSUCCES","Smiley ajout� avec succ�s.");
define("_SMILEYMODIF","Smiley modifi� avec succ�s.");
define("_SMILEYDELETE","Smiley supprim� avec succ�s.");
define("_SEND","Envoyer");

define("_PREFNAME","Pr�f�rence");
define("_ICON","Ic�ne");
define("_GAMEADD","Ajouter un jeu");
define("_GAMEEDIT","Editer ce jeu");
define("_GAMEDEL","Supprimer ce jeu");
define("_GAMESUCCES","Jeu ajout� avec succ�s.");
define("_GAMEMODIF","Jeu modifi� avec succ�s.");
define("_GAMEDELETE","Jeu supprim� avec succ�s.");
define("_SEEICON","Voir les ic�nes");
define("_ICONLIST","Liste des ic�nes");
define("_CLICICON","Cliquez sur une ic�ne pour la s�lectionner");
define("_CLOSEWINDOWS","Fermer la fen�tre");
define("_ERRORCHAMPS","Vous n\'avez pas rempli tous les champs du formulaire !");

define("_USERVALIDATION","Membres non valid�s");
define("_VALIDUSER","valider");
define("_VALIDTHISUSER","Valider ce membre");
define("_NOUSERVALIDATION","Aucun membre en attente");
define("_USERVALIDATE","Membre valid� avec succ�s.");
define("_REGISTRATION","Inscription");
define("_VALIDREGISTRATION","votre compte vient d'�tre valid�, vous pouvez d�s � pr�sent vous identifier sur notre site web :");

define("_MENUADMIN","Gestion des menus");
define("_DEL","Supprimer");
define("_ADD","Ajouter");
define("_DOWN","Descendre");
define("_UP","Monter");
define("_LAST","Derni�re");
define("_PUCE","Puce");
define("_LINK","Lien Web");
define("_SURDELLINE","Etes-vous certain de vouloir supprimer les lignes s�lectionn�es ?");
define("_LINEDELETED","Ligne(s) supprim�e(s)");
define("_LINEMODIFIED","Ligne modifi�e");
define("_EDITLINE","Edition de ligne");
define("_EDITMENU","Edition du menu");
define("_VIEWCOLOR","Voir les codes couleur HTML");
define("_COLORCODE","Codes Couleur HTML");
define("_OK","Ok");
define("_NOCOMLINK","Aucun");
define("_CHECKALL","Tout Cocher");
define("_UNCHECKALL","Tout D�cocher");
define("_DELBOX","Sup");

define("_ADMINMYSQL","Administration MySQL");
define("_EXECUTESQL","Ex�cuter une requ�te SQL :");
define("_MYSQLFILE","Ou un fichier SQL :");
define("_SEND","Envoyer");
define("_DATABASE","Base de donn�es");
define("_ACTION","- ACTION -");
define("_SAVEDB","Sauvegarder");
define("_OPTIMIZEDB","Optimiser");
define("_BACK","Retour");
define("_SQLSEND","Requ�te SQL ex�cut�e avec succ�s.");
define("_OPTIMIZEDATABASE","Optimisation de la base de donn�es");
define("_TABLE","Table");
define("_STATUT","Statut");
define("_SIZE","Taille");
define("_SPACESAVED","Espace sauv�");
define("_NOOPTIMIZE","D�j� optimis�");
define("_OPTIMIZE","Optimis�");
define("_TOTAL","Espace total sauv� :");

define("_ADMINPHPINFO","PHP Info");
define("_VIEWINFO","Voir les informations");
define("_INFOALL","Toutes");
define("_INFOGENERALES","G�n�rales");
define("_INFOCONFIGURATION","Configuration");
define("_INFOMODULES","Modules");
define("_INFOENVIRONMENT","Environnement");
define("_INFOVARIABLES","Variables");

define("_ADMINPROGRESS","Merci de patienter quelques secondes<br />V�rification en cours...");
define("_BADLOGADMIN","Erreur, mot de passe ou pseudo incorrect !");
define("_ADMINSESSION","Session Administration");
define("_LOSTPASS","Perdu votre Password ?");
define("_TOLOG","S'identifier");
define("_TOBACK","Retour");

define("_BONJOUR","Bonjour");
define("_MESSAGEDEBIENVENUE", "Bienvenue sur l'administration Nuked-Klan 1.7.9 !");
define("_AIDE","Aides");
define("_STATS","Statistiques");
define("_SQL","Erreurs SQL d�tect�es");
define("_NOTIFICATION","Ajouter une notification");
define("_DISCUSSION","Discussion");
define("_MESSAGE","Message");
define("_TYPE","Type");
define("_INFO","Information");
define("_ECHEC","Echec");
define("_REUSSITE","R�ussite");
define("_ALERTE","Alerte");
define("_ANNONCES","L'annonce de Nuked-Klan.org");
define("_CONNECTNK","En cours de connexion avec NK.org");
define("_ACTIONS","Actions effectu�es");
define("_VIEWACTIONS","Voir toutes les actions");
define("_ALERTENOT","Notification d'alerte");
define("_INFONOT","Notification d'information");
define("_REUSSITENOT","Notification de r�ussite");
define("_ECHOUENOT","Notification d'�chec");
define("_MAJ","Syst�me de mise � jour");
define("_JAVA","Votre navigateur ne supporte pas le javascript, ou il n'est pas activ�.");
define("_BIENTOT","A bient�t");
define("_OPEREUS","Op�ration effectu�e avec succ�s. Vous avez �t� d�connect� de l'administration.");
define("_OPEECHE","Op�ration �chou�e. Vous �tes encore connect� � l'administration.");
define("_VOIR","voir les");
define("_MESSAGES","messages");
define("_VOIRSITE","Voir le Site");
define("_DECONNEXION","D�connexion");
define("_PANNEAU","Panneau");
define("_PARAMETRE","Param�tres");
define("_GMYSQL","Gestion MySQL");
define("_GESTIONS","Gestions");
define("_UTILISATEURS","Utilisateurs");
define("_THEMIS","Th�me");
define("_MENU","Menu");
define("_JEUX","Jeux");
define("_CONTENU","Contenu");
define("_DIVERS","Divers");
define("_OFFICIEL","Forum officiel NK");
define("_LICENCE","Licence GNU/GPL");
define("_PROPOS","A propos");
define("_DISCUADMIN","Discussions administration");
define("_BY","par");
define("_NEWMSG","Nouveau message");
define("_MAJEXPLI","Le syst�me de mise � jour est enti�rement automatique, cependant si une mise � jour n'est pas effectu�e automatiquement, il y a une possiblit� de l'effectuer depuis la gestion des modules");
define("_MAJMAIN","Mises � jour manuelles");
define("_GESTEMPLATE","Gestion du th�me");
define("_NOADMININTERNE","Le th�me ne poss�de pas d'administration interne.");
define("_A","�");
define("_ADMINSQLERROR","Gestion des erreurs SQL");
define("_VIDERSQL","Supprimer la liste");
define("_DATE","Date");
define("_URL","URL");
define("_INFORMATION","Information");
define("_DELETEFILE","Vous �tes sur le point de supprimer");
define("_ERRORBDD","Erreurs SQL");
define("_SQLERRORDELETED","La liste des erreurs SQL rep�r�es a �t� d�truite.");

define("_ACTIONCONNECT","s\'est connect� � l\'administration");
define("_ACTIONDECONNECT","s\'est d�connect� de l\'administration");
define("_ACTIONVIDERSQL","a vid� les erreurs SQL");
define("_ACTIONADDGAME","a ajout� le jeu");
define("_ACTIONMODIFGAME","a modifi� le jeu");
define("_ACTIONDELGAME","a supprim� le jeu");
define("_ACTIONADDBLOCK","a ajout� le block");
define("_ACTIONMODIFBLOCK","a modifi� le block");
define("_ACTIONDELBLOCK","a supprim� le block");
define("_ACTIONPOSBLOCK","a modifi� la position du block");
define("_ACTIONADDUSER","a ajout� le membre");
define("_ACTIONMODIFUSER","a modifi� le membre");
define("_ACTIONDELUSER","a supprim� le membre");
define("_ACTIONADDCATUSER","a ajout� la team");
define("_ACTIONEDITCATUSER","a modifi� la team");
define("_ACTIONDELCATUSER","a supprim� la team");
define("_ACTIONADDBAN","a banni le membre");
define("_ACTIONMODIFBAN","a modifi� le ban du membre");
define("_ACTIONSUPBAN","a supprim� le ban du membre");
define("_ACTIONADDRANK","a ajout� le rang");
define("_ACTIONMODIFRANK","a modifi� le rang");
define("_ACTIONDELRANK","a supprim� le rang");
define("_DUREE","Dur�e");
define("_1JOUR","1 jour");
define("_7JOUR","1 semaine");
define("_1MOIS","1 mois");
define("_1AN","1 an");
define("_AVIE","A vie");
define("_ACTIONADDSMILEY","a ajout� le smiley");
define("_ACTIONMODIFSMILEY","a modifi� le smiley");
define("_ACTIONDELSMILEY","a supprim� le smiley");
define("_ACTIONSETTING","a modifi� les pr�f�rences g�n�rales.");
define("_ACTIONDELNOT","a supprim� une notification");
define("_ACTIONSAVEDB","a sauvegard� la base de donn�e.");
define("_ACTIONOPTIDB","a optimis� la base de donn�e.");
define("_ACTIONDESMOD","a d�sactiv� le module");
define("_ACTIONACTMOD","a activ� le module");
define("_ACTIONMODIFMOD","a modifi� le level d\'acc�s au module");
define("_ACTIONMODIFMENU","a modifi� le menu");
define("_ADMINACTION","Administration des actions");
define("_INFOACTION","Apr�s votre lecture, les actions d�passant 2 semaines seront supprim�es d�finitivement.");
define("_INFOSETTING","Activer les statistiques consomment beaucoup de ressources sur votre base SQL ! <br />Pensez � vider les statistiques de temps en temps depuis l'administration.");
define("_1NBRNOTACTION","action de plus de 2 semaines a �t� supprim�e.");
define("_NBRNOTACTION","actions de plus de 2 semaines ont �t� supprim�es.");
define("_1USNOTACTION","membre non valid� a �t� supprim�.");
define("_USNOTACTION","membres non valid�s ont �t� supprim�s.");
define("_ACTIONM","Action");
define("_LICENCES","Licence GNU/GPL");
define("_LICENCETXT","<br /><br /><b>Les droits garantis</b><br /><br />
Les termes de la GPL autorisent toute personne � recevoir une copie d'un travail sous GPL. Chaque personne qui adh�re aux termes et aux conditions de la GPL a la permission de modifier le travail, de l'�tudier et de redistribuer le travail ou un travail d�riv�. Cette personne peut toucher de l'argent pour ce service ou bien ne rien toucher. Ce dernier point distingue la GPL des autres licences de logiciels qui interdisent la redistribution dans un but commercial. Stallman pense que le logiciel libre ne devrait pas placer de restriction sur l'utilisation commerciale, et la GPL indique explicitement qu'un travail sous GPL peut-�tre (re)vendu. En cas de modification, le r�sultat doit �tre plac� sous la m�me licence.
<br /><br /><b>Le copyleft</b><br /><br />
La GPL ne donne pas � l'utilisateur des droits de redistribution sans limite. Le droit de redistribuer est garanti seulement si l'utilisateur fournit le code source de la version modifi�e. En outre, les copies distribu�es, incluant les modifications, doivent �tre aussi sous les termes de la GPL.
Cette condition est connue sous le nom de copyleft, et il obtient son origine l�gale du fait que le programme est � copyright� �. Puisqu'il est copyright�, l'utilisateur n'a aucun droit de le modifier ou de le redistribuer, sauf sous les termes du copyleft. On est oblig� d'adh�rer � la GPL si on souhaite exercer des droits normalement limit�s (voire interdits) par le copyright, comme la redistribution. Ainsi, si on distribue des copies du travail sans respecter les termes de la GPL (en gardant le code source secret par exemple), on peut �tre poursuivi par l'auteur original en vertu du copyright.<br />
Le copyleft emploie ainsi le copyright pour accomplir l'oppos� de son but habituel : au lieu des restrictions impos�es, il accorde des droits d'utilisation. C'est pour cette raison que la GPL est d�crite comme un d�tournement du copyright. Elle assure �galement qu'on n'accorde pas de droits illimit�s de redistribution par l'interm�diaire de n'importe quel bogue l�gal trouv� dans les termes du copyleft.<br /><br />
Beaucoup de distributeurs de programmes sous GPL fournissent le code source avec l'ex�cutable. Pour s'acquitter des obligations du copyleft, une autre possibilit� est de fournir sur demande le code source sur un support physique, par exemple un c�d�rom. Dans la pratique, beaucoup de programmes sous GPL sont distribu�s sur Internet et leur code source est disponible sur FTP, CVS,� Cette distribution par Internet �tant compatible avec la licence GPL.<br />
Le copyleft s'applique uniquement quand une personne veut redistribuer le programme. On est autoris� � faire des versions modifi�es priv�es, sans aucune obligation de divulguer les modifications effectu�es sur le programme s'il n'est distribu� � personne. Le copyleft s'applique uniquement au programme et non � ses sorties. Par exemple, un portail Web utilisant une version modifi�e priv�e d'un CMS sous GPL ne sera pas oblig� de livrer ses sources. Cette situation est corrig�e par l�Affero General Public License, une version de la GPL 3 qui ajoute un paragraphe pour accorder aux utilisateurs d�un programme acc�d� par un r�seau les m�mes droits que les utilisateurs d�un programme install� localement.<br />
<br /><br /><b>La licence</b><br /><br />
La GPL a �t� con�ue comme une licence, plut�t que comme un contrat. Dans les juridictions de droit commun (Common Law, notamment les pays anglo-saxons, membres ou issus du Commonwealth), la distinction entre une licence et un contrat est importante : les contrats rel�vent du droit des contrats, tandis que les licences (et donc la GPL) rel�vent du droit d�auteur (copyright). Cependant, cette distinction n�est pas utile dans les nombreuses juridictions o� il n�y a pas de diff�rences entre les contrats et les licences, comme dans les syst�mes de droit civil (Code civil ou Civil Law, notamment nombre de pays latins et de pays continentaux europ�ens ainsi que leurs anciennes colonies). La situation dans les pays de droit islamique ou appliquant un double droit civil et coutumier peut �tre diff�rente en fonction des personnes ou organisations concern�es et de la loi qui s'applique � eux, la distinction est alors aussi importante pour savoir quel droit s'applique.

<br /><br /><b>La valeur juridique</b><br /><br />

Le tribunal de grande instance de Paris a jug� applicable la licence GPL (version 2) en France le 28 mars 200716.<br />
Les licences CeCILL ont �t� mises en place afin de permettre � des �tablissements publics de publier leurs travaux logiciels sous licence libre r�dig�e selon le droit fran�ais. La licence CeCILL est compatible, depuis sa version 2, avec la licence publique g�n�rale GNU.<br />
En Allemagne, on peut noter que le projet Netfilter a obtenu gain de cause suite � une violation de GPL de la part de la soci�t� Sitecom GmbH.<br />
Harald Welte, fondateur du projet gpl-violations.org, poursuit les soci�t�s et les programmeurs coupables, selon lui, d'une violation de la GPL. Il a d�j� obtenu, depuis 2004, une trentaine de conciliations, apr�s avoir engag� des poursuites dans certains cas.");
define("_RETOURNER","Retourner sur le site");
define("_CHOOSEADMIN","Choisir l'affichage du module en 75% ou en 100%, si un module n'est ni 75% (1 colonne de blocks) ni 100% (aucune colonne), il sera alors affich� en 50% soit deux colonnes de blocks.<br /> Attention! Ne pas mettre un module en 75% et en 100%, choisissez toujours l'un ou l'autre.");
define("_ADMINEDITEUR","Gestion de l'�diteur");
define("_EDITEUR","Editeur");
define("_COULEUR","Couleur de la barre de l'�diteur sur le site");
define("_BARREBOUTON","Emplacement de la barre de bouton");
define("_BARRESTATUS","Emplacement de la barre de statut");
define("_BOUTON","Ensemble des boutons activ�s ou d�sactiv�s de l'�diteur");
define("_LIGNE1","Ligne 1");
define("_LIGNE2","Ligne 2:");
define("_LIGNE3","Ligne 3:");
define("_LIGNE4","Ligne 4:");
define("_STYLE", "Liste des styles pr�d�finis de l'�diteur");
define("_Taille","Taille");
define("_Couleur","Couleur");
define("_Gras","Gras");
define("_Italique","Italique");
define("_Souligner","Souligner");
define("_APERCU","Aper�u des styles:");
define("_TOP","Haut");
define("_BOTTOM","Bas");
define("_SCREENHOT","Affichage du popup preview");
define("_LISTERASED","Liste des liens morts effac�e avec succ�s.");
define("_CHANGEEDIT", "Modification effectu�e avec succ�s.");
define("_DELSTYLE","Suppression effectu�e avec succ�s.");
define("_DELSTYLE","Suppression effectu�e avec succ�s.");
define("_ACTIONADDSTYLE","a ajout� un style � l'�diteur.");
define("_ACTIONDELSTYLE","a supprim� un style � l'�diteur.");
define("_ACTIONCHANGEDIT","a modifi� l'�diteur.");
define("_MAP","Gestions des maps");
define("_DELALLMAP","Supprimer les maps");
define("_ADDMAP","Ajouter une map");
define("_MANAGETEAMMAP","Gestions des jeux et des maps.");
define("_THEMEPANEL","Gestion du th�me");
define("_BADUSERNAME","Pseudo incorrect, Certains caract�res sont interdits.");
define("_NICKTOLONG","Votre pseudo est trop long.");
define("_NICKINUSE","Ce pseudo est d�j� r�serv�");
define("_NICKBANNED","Ce pseudo est banni");
define("_SHARESTATS","Partager vos statistiques");
define("_SHAREREASON","Ce service � pour but de nous aider � am�liorer les services Nuked-Klan tout en gardant votre anonymat.");
define("_SEESHARE","voir les statistiques envoy�es");
define("_SMILEYNOTAUTHORIZE","Le code du smiley n'est pas autoris�, merci de le changer");
define("_THANKSPARTICIPATION","Merci pour votre participation.");
define("_NOTIFICATIONNOTRECEIVED","La notification n'a pas �t� re�ue.");
# Page : A propos
define('_INFOSPROPOS', '<h3>Informations g�n�rales :</h3>
Version ' . $nuked['version'] . '<br />
D�velopp�e par toute <a href="http://www.nuked-klan.org/index.php?file=Equipe">l\'�quipe Nuked-KlaN</a><br /><br />

<h3>Contact Nuked-KlaN :</h3>
<a href="http://www.nuked-klan.org/index.php?file=Contact">Formulaire de contact</a><br /><br />

<h3>Remerciements :</h3>
A toute l\'�quipe nuked-klan.org, ainsi qu\'� sa communaut� qui nous a permis de corriger rapidement les principaux bugs<br /><br /><br />

<h3>Licence GNU :</h3>
Merci de ne pas supprimer le <acronym title="Le terme copyleft est un double jeu de mots faisant r�f�rence au copyright traditionnel" style="text-decoration: underline">copyleft</acronym> par respect pour le cms et respecter la licence GNU.<br />');

# Page user group
define("_FUNCDELGROUP","Supprimer ce groupe :");
define("_MENUADDGROUP","Ajouter un Groupe");
define("_EDITTHISGROUP","Editer ce groupe");
define("_DELTHISGROUP","Supprimer ce groupe");

define("_TITLEWORDING","Libell�");
define("_TITLEDESCGROUP","Description");
define("_TITLEGESTGROUP","Gestion des Groupe");
define("_NBUTILISATEURS","Nombre Utilisateurs");

define("_DESCGROUP","Description du groupe");
define("_LISTMODULE","Liste des modules");
define("_NAMEGROUP","Nom du groupe");
define("_COLOR_MOD_ENABLED", "Les modules activ�s sont en bleu");
define("_COLOR_MOD_DISABLED", "Les modules d�sactiv�s sont en rouge");

define("_ACTIONGROUPADD","a ajout� le groupe : ");
define("_ACTIONGROUPEDIT","a modifi� le groupe : ");
define("_ACTIONGROUPDEL","a supprim� le groupe : ");
define("_ERRORGROUPEXIST","Le groupe existe d�j�");

define("_SUCCESGROUPADD","Groupe ajout� avec succ�s.");
define("_SUCCESGROUPEDIT","Groupe modifi� avec succ�s.");
define("_SUCCESGROUPDEL","Groupe effac� avec succ�s.");
define("_ERRORGROUPDEL","Impossible de supprimer ce groupe.");
define("_ERRORGROUPEDIT","Impossible d'avoir le m�me nom.");

define("_DESCADMINISTRATOR","Supr�me Administrateur");
define("_DESCMEMBERS","Membres Inscrit");

define("_USERADMINGROUP","Gestion des Groupes");
define("_GROUPS","Groupes");
define("_DESCVISITORPADMIN","Visiteur non inscrit");
define("_VISITOR","Visiteur");

define("_GROUPDISPO","Groupe Disponible");
define("_GROUPBELONGS","Appartient au groupe");
define("_GROUPCURRENT","Groupe actuel");
define("_GROUPACCES","Groupe d'acces");
define("_GROUPUSE","Groupe d'utilisation");
define("_GROUPSURVEY","Groupe Sondage");
define("_GROUPVOTE","Groupe Vote");
define("_VIEW","Voir");

define("_ACCESMODULE","Acc�s Module");
define("_ACCESADMIN","Administration");
define("_GROUPSMAIN","Groupe Principal");
define("_DESCINVALID","Description invalide");
define("_NAMEINVALID","Nom invalide");
define("_COLORINVALID","Couleur invalide");
define("_BAD_GROUP_ID","Aucun groupe ne correspond &agrave; cet ID");
define("_GROUP_NAME_RESERVED", "Ce nom de groupe est r&eacute;serv&eacute;");
define("_NO_DELETE_GROUP", "Ce groupe ne peut pas &ecirc;tre supprim&eacute;");

define("_ERROR_NO_GROUPNAME", "Vous n'avez pas saisi de nom pour le groupe");
*/
?>
