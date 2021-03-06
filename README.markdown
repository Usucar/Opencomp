Lisez-moi Opencomp
================================

Instructions d'installation
---------------------------

Pour installer Opencomp, suivez les indications suivantes :

* Téléchargez la dernière version du script [ici](https://github.com/jtraulle/Opencomp/zipball/master)
* Décompressez le dossier
* Transférez le dossier sur votre serveur web
* Assurez vous que le Module de réécriture d'URL Apache est activé sur votre serveur
* Créer une base de donnée MySQL en important le dump SQL suivant :

<pre>
    -- phpMyAdmin SQL Dump
    -- version 3.2.4
    -- http://www.phpmyadmin.net
    --
    -- Host: localhost
    -- Generation Time: Jan 24, 2011 at 08:04 
    -- Server version: 5.1.41
    -- PHP Version: 5.3.1

    SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

    /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
    /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
    /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
    /*!40101 SET NAMES utf8 */;

    --
    -- Database: `opencomp`
    --

    -- --------------------------------------------------------

    --
    -- Table structure for table `competences`
    --

    CREATE TABLE IF NOT EXISTS `competences` (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `parent_id` int(10) unsigned DEFAULT NULL,
      `type` int(1) NOT NULL,
      `lft` int(10) unsigned NOT NULL,
      `rght` int(10) unsigned NOT NULL,
      `libelle` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
      PRIMARY KEY (`id`),
      KEY `parent_id` (`parent_id`),
      KEY `lft` (`lft`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=89 ;

    --
    -- Dumping data for table `competences`
    --

    INSERT INTO `competences` (`id`, `parent_id`, `type`, `lft`, `rght`, `libelle`) VALUES
    (6, 5, 1, 3, 4, 'Raconter, décrire, exposer'),
    (4, NULL, 1, 1, 48, 'Français'),
    (5, 4, 1, 2, 9, 'Langage oral'),
    (7, 5, 1, 5, 6, 'Échanger, débattre'),
    (8, 5, 1, 7, 8, 'Réciter'),
    (9, 4, 1, 10, 11, 'Lecture'),
    (10, 4, 1, 12, 13, 'Littérature'),
    (11, 4, 1, 14, 15, 'Écriture'),
    (12, 4, 1, 16, 17, 'Rédaction'),
    (13, 4, 1, 18, 27, 'Vocabulaire'),
    (14, 13, 1, 19, 20, 'Acquisition du vocabulaire'),
    (15, 13, 1, 21, 22, 'Maîtrise du sens des mots'),
    (16, 13, 1, 23, 24, 'Les familles de mots'),
    (17, 13, 1, 25, 26, 'Utilisation du dictionnaire'),
    (18, 4, 1, 28, 39, 'Grammaire'),
    (19, 18, 1, 29, 30, 'La phrase'),
    (20, 18, 1, 31, 32, 'Les classes de mots'),
    (21, 18, 1, 33, 34, 'Les fonctions'),
    (22, 18, 1, 35, 36, 'Le verbe'),
    (23, 18, 1, 37, 38, 'Les accords'),
    (24, 4, 1, 40, 47, 'Orthographe'),
    (25, 24, 1, 41, 42, 'Compétences grapho-phonétiques'),
    (26, 24, 1, 43, 44, 'Orthographe grammaticale'),
    (27, 24, 1, 45, 46, 'Orthographe lexicale'),
    (28, NULL, 1, 49, 86, 'Mathématiques'),
    (29, 28, 1, 50, 67, 'Nombres et calcul'),
    (30, 29, 1, 51, 52, 'Les nombres entiers jusqu''au million'),
    (31, 29, 1, 53, 54, 'Les nombres entiers jusqu''au milliard'),
    (32, 29, 1, 55, 56, 'Fractions'),
    (33, 29, 1, 57, 58, 'Nombres décimaux'),
    (34, 29, 1, 59, 66, 'Calcul sur des nombres entiers'),
    (35, 34, 1, 60, 61, 'Calculer mentalement'),
    (36, 34, 1, 62, 63, 'Effectuer un calcul posé'),
    (37, 34, 1, 64, 65, 'Problèmes'),
    (38, 28, 1, 68, 75, 'Géométrie'),
    (39, 38, 1, 69, 70, 'Dans le plan'),
    (40, 38, 1, 71, 72, 'Dans l''espace'),
    (41, 38, 1, 73, 74, 'Problèmes de reproduction, de construction'),
    (42, 28, 1, 76, 83, 'Grandeurs et mesures'),
    (43, 42, 1, 77, 78, 'Aires'),
    (44, 42, 1, 79, 80, 'Angles'),
    (45, 42, 1, 81, 82, 'Problèmes'),
    (46, 28, 1, 84, 85, 'Organisation et gestion de données'),
    (47, NULL, 1, 87, 96, 'Éducation Physique et Sportive'),
    (48, 47, 1, 88, 89, 'Réaliser une performance mesurée (distance, temps)'),
    (49, 47, 1, 90, 91, 'Adapter ses déplacements à différents types d''environnements'),
    (50, 47, 1, 92, 93, 'Coopérer et s''opposer individuellement et collectivement'),
    (51, 47, 1, 94, 95, 'Concevoir et réaliser des actions à visées expressive, artistique, esthétique'),
    (52, NULL, 1, 97, 98, 'Langue vivante'),
    (53, NULL, 1, 99, 116, 'Sciences expérimentales et technologie'),
    (54, 53, 1, 100, 101, 'Le ciel et la terre'),
    (55, 53, 1, 102, 103, 'La matière'),
    (56, 53, 1, 104, 105, 'L''énergie'),
    (57, 53, 1, 106, 107, 'L''unité et la diversité du vivant'),
    (58, 53, 1, 108, 109, 'Le fonctionnement du vivant'),
    (59, 53, 1, 110, 111, 'Le fonctionnement du corps humain et la santé'),
    (60, 53, 1, 112, 113, 'Les êtres vivants dans leur environnement'),
    (61, 53, 1, 114, 115, 'Les objets techniques'),
    (62, NULL, 1, 117, 164, 'Culture humaniste'),
    (63, 62, 1, 118, 131, 'Histoire'),
    (64, 63, 1, 119, 120, 'La Préhistoire'),
    (65, 63, 1, 121, 122, 'L''Antiquité'),
    (66, 63, 1, 123, 124, 'Le Moyen Âge'),
    (67, 63, 1, 125, 126, 'Les temps modernes'),
    (68, 63, 1, 127, 128, 'La Révolution française et le XIXème siècle'),
    (69, 63, 1, 129, 130, 'Le XXème siècle et notre époque'),
    (70, 62, 1, 132, 145, 'Géographie'),
    (72, 70, 1, 133, 134, 'Des réalités géographiques locales à la région où vivent les élèves'),
    (73, 70, 1, 135, 136, 'Le territoire français dans l''Union Européenne'),
    (74, 70, 1, 137, 138, 'Les français dans le contexte européen'),
    (75, 70, 1, 139, 140, 'Se déplacer en France et en Europe'),
    (76, 70, 1, 141, 142, 'Produire en France'),
    (77, 70, 1, 143, 144, 'La France dans le monde'),
    (78, 62, 1, 146, 151, 'Pratiques artistiques'),
    (79, 78, 1, 147, 148, 'Arts visuels'),
    (80, 78, 1, 149, 150, 'Éducation musicale'),
    (81, 62, 1, 152, 163, 'Histoire de l''art'),
    (82, 81, 1, 153, 154, 'La Préhistoire et l''Antiquité Gallo-Romaine'),
    (83, 81, 1, 155, 156, 'Le Moyen Âge'),
    (84, 81, 1, 157, 158, 'Les temps modernes'),
    (85, 81, 1, 159, 160, 'Le XIXème siècle'),
    (86, 81, 1, 161, 162, 'Le XXème siècle et notre époque'),
    (87, NULL, 1, 165, 166, 'Techniques Usuelles de l''Information et de la Communication'),
    (88, NULL, 1, 167, 168, 'Instruction civique et morale');

    -- --------------------------------------------------------

    --
    -- Table structure for table `items`
    --

    CREATE TABLE IF NOT EXISTS `items` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `intitule` text NOT NULL,
      `competence_id` int(11) NOT NULL,
      `place` int(11) NOT NULL,
      `type` tinyint(1) NOT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `competence_id` (`competence_id`,`place`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

    --
    -- Dumping data for table `items`
    --

    INSERT INTO `items` (`id`, `intitule`, `competence_id`, `place`, `type`) VALUES
    (1, 'Faire un récit structuré et compréhensible pour un tiers ignorant des faits rapportés ou de l''histoire racontée', 6, 2, 1),
    (2, 'Décrire une image', 6, 1, 1),
    (3, 'Écouter et prendre en compte ce qui a été dit.', 9, 0, 3);

    -- --------------------------------------------------------

    --
    -- Table structure for table `users`
    --

    CREATE TABLE IF NOT EXISTS `users` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `username` varchar(255) NOT NULL,
      `password` varchar(255) NOT NULL,
      `prenom` varchar(255) NOT NULL,
      `nom` varchar(255) NOT NULL,
      `email` varchar(255) NOT NULL,
      `role` varchar(255) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

    --
    -- Dumping data for table `users`
    --

    INSERT INTO `users` (`id`, `username`, `password`, `prenom`, `nom`, `email`, `role`) VALUES
    (2, 'admin', '70454af0546c3c5390733ee0030c0812fe61f61b', 'Administrateur', 'de test', 'admin@test.me', 'admin');
</pre>

* Vérifiez que les informations de connexion présentes dans le fichier `app\config\database.php` (line 76).
* Les identifiants de connexion par défaut sont **admin** pour l'identifiant et **testons** pour le mot de passe.