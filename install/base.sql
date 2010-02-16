--
-- Structure de la table `enseignant`
--

DROP TABLE IF EXISTS `oc_enseignant`;
CREATE TABLE `oc_enseignant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `identifiant` varchar(50) NOT NULL,
  `mot_de_passe` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `connectfail` varchar(3) NOT NULL DEFAULT 'non',
  `salt` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `log`
--

DROP TABLE IF EXISTS `oc_log`;
CREATE TABLE `oc_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `start` datetime NOT NULL,
  `session_id` varchar(64) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `user_agent` varchar(150) NOT NULL,
  `referer` varchar(64) NOT NULL,
  `termine` varchar(3) NOT NULL,
  `erreur_mdp` varchar(3) NOT NULL,
  `end` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
