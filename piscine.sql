-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 05 mai 2018 à 21:28
-- Version du serveur :  5.7.21
-- Version de PHP :  5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `piscine`
--

-- --------------------------------------------------------

--
-- Structure de la table `action`
--

DROP TABLE IF EXISTS `action`;
CREATE TABLE IF NOT EXISTS `action` (
  `id_action` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clé primaire de l''action',
  `id_pub` int(11) NOT NULL COMMENT 'Clé secondaire de la publication où l''action a été effectuée',
  `id_user` int(11) NOT NULL COMMENT 'Clé secondaire de l''utilisateur ayant fait l''action',
  `type` varchar(15) NOT NULL COMMENT 'Commentaire, aimer ou partager',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `texte` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_action`),
  KEY `id_pub` (`id_pub`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Informations sur les actions ';

-- --------------------------------------------------------

--
-- Structure de la table `apprenti`
--

DROP TABLE IF EXISTS `apprenti`;
CREATE TABLE IF NOT EXISTS `apprenti` (
  `id_apprenti` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clé primaire de l''apprenti',
  `id_user` int(11) NOT NULL COMMENT 'Clé secondaire de l''utilisateur',
  `entreprise` varchar(30) NOT NULL COMMENT 'Entreprise dans laquelle travaille l''apprenti',
  PRIMARY KEY (`id_apprenti`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Informations des apprentis';

--
-- Déchargement des données de la table `apprenti`
--

INSERT INTO `apprenti` (`id_apprenti`, `id_user`, `entreprise`) VALUES
(2, 5, 'qqpart');

-- --------------------------------------------------------

--
-- Structure de la table `connexion`
--

DROP TABLE IF EXISTS `connexion`;
CREATE TABLE IF NOT EXISTS `connexion` (
  `id_user` int(11) NOT NULL COMMENT 'Clé primaire de l''utilisateur connecté',
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `connexion`
--

INSERT INTO `connexion` (`id_user`) VALUES
(1),
(3);

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id_contact` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clé primaire du contact',
  `id_user` int(11) NOT NULL COMMENT 'Clé secondaire de l''utilisateur',
  `id_user_contact` int(11) NOT NULL COMMENT 'Clé primaire du contact',
  `type` varchar(10) NOT NULL COMMENT 'Type de relation (ami ou collegue)',
  `restreint` varchar(4) NOT NULL DEFAULT 'non' COMMENT 'Le contact fait parti du cercle restreint d''amis (oui) ou non',
  PRIMARY KEY (`id_contact`),
  KEY `id_user` (`id_user`),
  KEY `id_user_contact` (`id_user_contact`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1 COMMENT='Informations sur les contacts des utilisateurs';

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id_contact`, `id_user`, `id_user_contact`, `type`, `restreint`) VALUES
(4, 2, 5, 'collegue', 'oui'),
(6, 2, 6, 'ami', 'non'),
(10, 5, 2, 'collegue', 'oui'),
(12, 6, 2, 'ami', 'non'),
(16, 2, 3, 'ami', 'non'),
(17, 3, 2, 'ami', 'non'),
(18, 1, 2, 'ami', 'non'),
(19, 2, 1, 'ami', 'non'),
(20, 1, 5, 'ami', 'non'),
(21, 5, 1, 'ami', 'non'),
(22, 6, 5, 'collegue', 'non'),
(23, 5, 6, 'collegue', 'non'),
(24, 6, 3, 'collegue', 'non'),
(25, 3, 6, 'collegue', 'non'),
(26, 1, 3, 'ami', 'non'),
(27, 3, 1, 'ami', 'non'),
(28, 5, 3, 'ami', 'non'),
(29, 3, 5, 'ami', 'non');

-- --------------------------------------------------------

--
-- Structure de la table `conversation`
--

DROP TABLE IF EXISTS `conversation`;
CREATE TABLE IF NOT EXISTS `conversation` (
  `id_convo` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clé primaire de la conversation',
  `titre` varchar(20) DEFAULT NULL COMMENT 'Titre de la conversation',
  PRIMARY KEY (`id_convo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Informations sur les conversation';

-- --------------------------------------------------------

--
-- Structure de la table `convo_user`
--

DROP TABLE IF EXISTS `convo_user`;
CREATE TABLE IF NOT EXISTS `convo_user` (
  `id_convo` int(11) NOT NULL COMMENT 'Clé primaire de la conversation',
  `id_user` int(11) NOT NULL COMMENT 'Clé primaire de l''utilisateur',
  PRIMARY KEY (`id_convo`,`id_user`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Décrit quel(s) user(s) appartient à quelle(s) conversation(s';

-- --------------------------------------------------------

--
-- Structure de la table `cv`
--

DROP TABLE IF EXISTS `cv`;
CREATE TABLE IF NOT EXISTS `cv` (
  `id_cv` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clé primaire du CV',
  `nom_fichier` varchar(30) NOT NULL COMMENT 'Nom du fichier contenant le CV',
  PRIMARY KEY (`id_cv`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Informations sur les CV des utilisateurs';

--
-- Déchargement des données de la table `cv`
--

INSERT INTO `cv` (`id_cv`, `nom_fichier`) VALUES
(1, 'CV.pdf'),
(2, 'Cv de rim.docx');

-- --------------------------------------------------------

--
-- Structure de la table `demande_ami`
--

DROP TABLE IF EXISTS `demande_ami`;
CREATE TABLE IF NOT EXISTS `demande_ami` (
  `id_demande` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL COMMENT 'id de celui qui envoie la demande',
  `id_contact` int(11) NOT NULL COMMENT 'id de celui qui recoit la demande',
  `type` text NOT NULL COMMENT 'ami ou collegue',
  PRIMARY KEY (`id_demande`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `emploi`
--

DROP TABLE IF EXISTS `emploi`;
CREATE TABLE IF NOT EXISTS `emploi` (
  `id_emploi` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL COMMENT 'id du posteur',
  `entreprise` text NOT NULL,
  `type` text NOT NULL COMMENT 'stage, interim, cdi...',
  `poste` text NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `texte` text NOT NULL COMMENT 'description de l''emploi',
  `lieu` text NOT NULL,
  PRIMARY KEY (`id_emploi`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

DROP TABLE IF EXISTS `employe`;
CREATE TABLE IF NOT EXISTS `employe` (
  `id_employe` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clé primaire de l''employé',
  `id_user` int(11) NOT NULL COMMENT 'Clé primaire de l''utilisateur',
  `poste` varchar(30) NOT NULL COMMENT 'Enseignant, chercheur, administrateur, etc.',
  PRIMARY KEY (`id_employe`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Informations des employés';

--
-- Déchargement des données de la table `employe`
--

INSERT INTO `employe` (`id_employe`, `id_user`, `poste`) VALUES
(1, 6, 'Enseignant'),
(2, 7, 'Mascotte');

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

DROP TABLE IF EXISTS `etudiant`;
CREATE TABLE IF NOT EXISTS `etudiant` (
  `id_etu` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clé primaire de l''étudiant',
  `id_user` int(11) NOT NULL COMMENT 'Clé secondaire de l''utilisateur',
  `etudes` varchar(20) NOT NULL COMMENT 'Type d''études (licence, master...)',
  `annees` int(11) NOT NULL COMMENT 'Années d''études',
  PRIMARY KEY (`id_etu`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COMMENT='Informations des étudiants';

--
-- Déchargement des données de la table `etudiant`
--

INSERT INTO `etudiant` (`id_etu`, `id_user`, `etudes`, `annees`) VALUES
(1, 1, 'license', 3),
(2, 2, 'license', 3),
(3, 3, 'license', 3),
(5, 5, 'license', 3),
(7, 9, 'license', 1),
(8, 10, 'master', 1);

-- --------------------------------------------------------

--
-- Structure de la table `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `id_media` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clé primaire du media',
  `id_user` int(11) NOT NULL COMMENT 'Clé secondaire de l''utilisateur auquel appartient le média',
  `type` varchar(6) NOT NULL COMMENT 'Video ou photo',
  `nom_fichier` text NOT NULL COMMENT 'Nom du fichier contenant le média',
  `titre` varchar(30) NOT NULL COMMENT 'Titre du média',
  `lieu` varchar(20) DEFAULT NULL COMMENT 'Lieu où a été pris le média',
  `date` date DEFAULT NULL COMMENT 'Date ou a été pris le média',
  PRIMARY KEY (`id_media`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 COMMENT='Informations sur les médias';

--
-- Déchargement des données de la table `media`
--

INSERT INTO `media` (`id_media`, `id_user`, `type`, `nom_fichier`, `titre`, `lieu`, `date`) VALUES
(4, 1, 'photo', 'IMG_3802.JPG', 'Profil', NULL, NULL),
(5, 2, 'photo', 'roman_gouge.jpg', 'Profil', NULL, NULL),
(6, 3, 'photo', 'avatar_femme.png', 'Profil', NULL, NULL),
(7, 1, 'photo', 'carnet.jpg', 'Fond', NULL, NULL),
(8, 2, 'photo', 'montagne.jpg', 'Fond', NULL, NULL),
(9, 3, 'photo', 'montagne.jpg', 'Fond', NULL, NULL),
(10, 5, 'photo', 'carnet.jpg', 'Fond', NULL, NULL),
(11, 5, 'photo', 'rim.jpg', 'Fond', NULL, NULL),
(15, 6, 'photo', '5aedbd07677d64.70619126.png', 'Album', NULL, NULL),
(16, 6, 'photo', '5aedbd370a9db2.20072947.png', 'Album', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id_message` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clé primaire du message',
  `id_convo` int(11) NOT NULL COMMENT 'Clé secondaire de la conversation dans laquelle a été envoyé le message',
  `id_user` int(11) NOT NULL COMMENT 'Clé secondaire de l''utilisateur ayant envoyé le message',
  `text` text NOT NULL COMMENT 'Texte du message',
  PRIMARY KEY (`id_message`),
  KEY `id_convo` (`id_convo`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Informations sur les messages';

-- --------------------------------------------------------

--
-- Structure de la table `notif_action`
--

DROP TABLE IF EXISTS `notif_action`;
CREATE TABLE IF NOT EXISTS `notif_action` (
  `id_notifaction` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clé primaire de la notification d''action',
  `id_user` int(11) NOT NULL COMMENT 'Clé secondaire de l''utilisateur à l''origine de l''action',
  `id_action` int(11) NOT NULL COMMENT 'Clé secondaire de l''action',
  `texte` varchar(255) NOT NULL COMMENT 'Texte de la notification',
  PRIMARY KEY (`id_notifaction`),
  KEY `id_user` (`id_user`),
  KEY `id_action` (`id_action`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Information sur les notifications d''action';

-- --------------------------------------------------------

--
-- Structure de la table `notif_pub`
--

DROP TABLE IF EXISTS `notif_pub`;
CREATE TABLE IF NOT EXISTS `notif_pub` (
  `id_notifpub` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clé primaire de la notification de publication',
  `id_user` int(11) NOT NULL COMMENT 'Clé secondaire de l''utilisateur à l''origine de la publication',
  `id_pub` int(11) NOT NULL COMMENT 'Clé secondaire de la publication',
  `texte` varchar(255) NOT NULL COMMENT 'Texte de la notification',
  PRIMARY KEY (`id_notifpub`),
  KEY `id_user` (`id_user`),
  KEY `id_pub` (`id_pub`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COMMENT='Information sur les notifications de publication';

--
-- Déchargement des données de la table `notif_pub`
--

INSERT INTO `notif_pub` (`id_notifpub`, `id_user`, `id_pub`, `texte`) VALUES
(1, 2, 1, 'Nouvelle publication'),
(2, 6, 2, 'Nouvelle publication'),
(3, 1, 3, 'Nouvelle publication'),
(4, 2, 4, 'Nouvelle publication'),
(5, 3, 5, 'Nouvelle publication'),
(6, 6, 6, 'Nouvelle publication'),
(7, 6, 7, 'Photo'),
(8, 6, 8, 'Photo');

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

DROP TABLE IF EXISTS `profil`;
CREATE TABLE IF NOT EXISTS `profil` (
  `id_profil` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clé primaire du profil',
  `id_user` int(11) NOT NULL COMMENT 'Clé secondaire de l''utilisateur',
  `id_photo` int(11) DEFAULT NULL COMMENT 'Clé secondaire de la photo de profil',
  `id_fond` int(11) DEFAULT NULL COMMENT 'Clé secondaire de l''image de fond du profil',
  `id_cv` int(11) DEFAULT NULL COMMENT 'Clé secondaire du CV de l''utilisateur',
  `experience` text COMMENT 'Description de l''expérience',
  `etude` text COMMENT 'Description des études',
  `acces` varchar(10) NOT NULL DEFAULT 'publique' COMMENT 'Publique, prive ou restreint',
  PRIMARY KEY (`id_profil`),
  KEY `id_photo` (`id_photo`),
  KEY `id_fond` (`id_fond`),
  KEY `id_cv` (`id_cv`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COMMENT='Informations des profils';

--
-- Déchargement des données de la table `profil`
--

INSERT INTO `profil` (`id_profil`, `id_user`, `id_photo`, `id_fond`, `id_cv`, `experience`, `etude`, `acces`) VALUES
(1, 1, 4, 7, 1, 'Regarde Netflix depuis qu\'elle est bébé.', 'Lycée dans un coin perdu puis prepa et enfin ECE.', 'publique'),
(2, 2, 5, 8, NULL, 'Chapi-chapo!', 'Lycée puis ECE.', 'prive'),
(3, 3, 6, 9, NULL, 'A survécu en Picardie.', 'Lycée à Paris puis ECE.', 'restreint'),
(5, 5, 10, 11, 2, 'Secrétaire générale d\'ECE International.', 'Etudes de communication lui permettant de connaître tout l\'ECE.', 'publique'),
(6, 6, NULL, NULL, NULL, 'Enseignant à l\'ECE Paris.', 'Un certain lycée.', 'publique'),
(7, 7, NULL, NULL, NULL, NULL, NULL, 'public'),
(9, 9, NULL, NULL, NULL, NULL, NULL, 'public'),
(10, 10, NULL, NULL, NULL, NULL, NULL, 'public');

-- --------------------------------------------------------

--
-- Structure de la table `publication`
--

DROP TABLE IF EXISTS `publication`;
CREATE TABLE IF NOT EXISTS `publication` (
  `id_pub` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clé primaire de la publication',
  `id_user` int(11) NOT NULL COMMENT 'Clé secondaire de l''utilisateur postant la publication',
  `id_media` int(11) DEFAULT NULL COMMENT 'Clé secondaire du média à ajouter à la publicaiton',
  `type` varchar(6) NOT NULL COMMENT 'Texte ou media',
  `date_post` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date à laquelle la publication est postée',
  `texte` text COMMENT 'Message de la publication',
  `statut` varchar(30) DEFAULT NULL COMMENT 'Statut de l''utilisateur au moment de poster',
  `acces` varchar(10) NOT NULL DEFAULT 'publique' COMMENT 'Publique, prive ou restreint',
  PRIMARY KEY (`id_pub`),
  KEY `id_user` (`id_user`),
  KEY `id_media` (`id_media`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COMMENT='Informations d''une publication';

--
-- Déchargement des données de la table `publication`
--

INSERT INTO `publication` (`id_pub`, `id_user`, `id_media`, `type`, `date_post`, `texte`, `statut`, `acces`) VALUES
(1, 2, NULL, 'texte', '2018-05-05 11:25:16', 'Première publication ', NULL, 'publique'),
(2, 6, NULL, 'texte', '2018-05-05 11:25:38', 'deuxième publication', NULL, 'publique'),
(3, 1, NULL, 'texte', '2018-05-05 11:26:02', 'troisième notification', NULL, 'publique'),
(4, 2, NULL, 'texte', '2018-05-05 11:26:18', 'quatrième notification', NULL, 'publique'),
(5, 3, NULL, 'texte', '2018-05-05 11:28:24', 'Cinquième publication', NULL, 'publique'),
(6, 6, NULL, 'texte', '2018-05-05 14:17:21', 'coucou, le projet est pour ce soir', NULL, 'publique'),
(7, 6, 15, 'photo', '2018-05-05 14:17:43', NULL, NULL, 'publique'),
(8, 6, 16, 'photo', '2018-05-05 14:18:31', 'c\'est un test pour voir si le texte marche', NULL, 'publique');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clé primaire de l''étudiant',
  `pseudo` varchar(30) NOT NULL COMMENT 'Pseudonyme',
  `nom` varchar(30) NOT NULL COMMENT 'Nom de famille',
  `prenom` varchar(30) NOT NULL COMMENT 'Prénom',
  `mail` varchar(30) NOT NULL COMMENT 'E-mail',
  `mdp` varchar(30) NOT NULL COMMENT 'Mot de passe',
  `fonction` varchar(30) NOT NULL COMMENT 'Étudiant ou employé',
  `naissance` date DEFAULT NULL COMMENT 'Date de naissance',
  `genre` varchar(6) DEFAULT NULL COMMENT 'Femme ou homme',
  `droit` varchar(15) NOT NULL DEFAULT 'auteur' COMMENT 'Auteur ou administrateur',
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `mail` (`mail`),
  UNIQUE KEY `pseudo` (`pseudo`),
  UNIQUE KEY `pseudo_2` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COMMENT='Informations des utilisateurs';

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_user`, `pseudo`, `nom`, `prenom`, `mail`, `mdp`, `fonction`, `naissance`, `genre`, `droit`) VALUES
(1, 'laparfaite', 'Navarro', 'Camille', 'camille.navarro@edu.ece.fr', 'camillenavarro', 'Etudiant', '1997-06-02', 'femme', 'administrateur'),
(2, 'romanG', 'Gouge', 'Roman', 'roman.gouge@edu.ece.fr', 'romangouge', 'Etudiant', '1997-01-24', 'homme', 'administrateur'),
(3, 'fionaC', 'Chuet', 'Fiona', 'fiona.chuet@edu.ece.fr', 'Fiona300196', 'Etudiant', '1996-10-30', 'femme', 'administrateur'),
(5, 'rimZ', 'Zaafouri', 'Rim', 'rim.zaafouri@edu.ece.fr', 'rimzaafouri', 'Apprenti', '2018-05-04', 'femme', 'administrateur'),
(6, 'manoloH', 'Hina', 'Manolo', 'manolo.hina@ece.fr', 'manolohina', 'Employe', NULL, 'homme', 'auteur'),
(7, 'moochC', 'Chuet', 'Mooch', 'mooch@edu.ece.fr', 'Mooch0616', 'Employe', '2016-06-14', 'autre', 'auteur'),
(9, 'crotte', 'crotte', 'truc', 'crotte@truc.fr', 'crotte', 'Etudiant', NULL, 'femme', 'auteur'),
(10, 'lul', 'franck', 'ie', 'franck@i.e', 'lolo', 'Etudiant', NULL, 'homme', 'auteur');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `action`
--
ALTER TABLE `action`
  ADD CONSTRAINT `action_ibfk_1` FOREIGN KEY (`id_pub`) REFERENCES `publication` (`id_pub`),
  ADD CONSTRAINT `action_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`);

--
-- Contraintes pour la table `apprenti`
--
ALTER TABLE `apprenti`
  ADD CONSTRAINT `apprenti_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`);

--
-- Contraintes pour la table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `contact_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`),
  ADD CONSTRAINT `contact_ibfk_2` FOREIGN KEY (`id_user_contact`) REFERENCES `utilisateur` (`id_user`);

--
-- Contraintes pour la table `convo_user`
--
ALTER TABLE `convo_user`
  ADD CONSTRAINT `convo_user_ibfk_1` FOREIGN KEY (`id_convo`) REFERENCES `conversation` (`id_convo`),
  ADD CONSTRAINT `convo_user_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`);

--
-- Contraintes pour la table `employe`
--
ALTER TABLE `employe`
  ADD CONSTRAINT `employe_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`);

--
-- Contraintes pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD CONSTRAINT `etudiant_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`);

--
-- Contraintes pour la table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`);

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`id_convo`) REFERENCES `conversation` (`id_convo`),
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`);

--
-- Contraintes pour la table `notif_action`
--
ALTER TABLE `notif_action`
  ADD CONSTRAINT `notif_action_ibfk_1` FOREIGN KEY (`id_action`) REFERENCES `action` (`id_action`),
  ADD CONSTRAINT `notif_action_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `action` (`id_user`);

--
-- Contraintes pour la table `notif_pub`
--
ALTER TABLE `notif_pub`
  ADD CONSTRAINT `notif_pub_ibfk_1` FOREIGN KEY (`id_pub`) REFERENCES `publication` (`id_pub`),
  ADD CONSTRAINT `notif_pub_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `publication` (`id_user`);

--
-- Contraintes pour la table `profil`
--
ALTER TABLE `profil`
  ADD CONSTRAINT `profil_ibfk_2` FOREIGN KEY (`id_photo`) REFERENCES `media` (`id_media`),
  ADD CONSTRAINT `profil_ibfk_3` FOREIGN KEY (`id_fond`) REFERENCES `media` (`id_media`),
  ADD CONSTRAINT `profil_ibfk_4` FOREIGN KEY (`id_cv`) REFERENCES `cv` (`id_cv`),
  ADD CONSTRAINT `profil_ibfk_5` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`);

--
-- Contraintes pour la table `publication`
--
ALTER TABLE `publication`
  ADD CONSTRAINT `publication_ibfk_1` FOREIGN KEY (`id_media`) REFERENCES `media` (`id_media`),
  ADD CONSTRAINT `publication_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
