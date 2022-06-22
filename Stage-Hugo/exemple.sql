-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 30 mai 2022 à 08:57
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `exemple`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

DROP TABLE IF EXISTS `commentaires`;
CREATE TABLE IF NOT EXISTS `commentaires` (
  `patient_id` int(11) NOT NULL,
  `colonne` varchar(128) NOT NULL,
  `commentaire` varchar(512) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`patient_id`, `colonne`, `commentaire`) VALUES
(12002, 'numero_du_patient', '');

-- --------------------------------------------------------

--
-- Structure de la table `exemple`
--

DROP TABLE IF EXISTS `exemple`;
CREATE TABLE IF NOT EXISTS `exemple` (
  `COL 1` varchar(8) DEFAULT NULL,
  `COL 2` varchar(8) DEFAULT NULL,
  `COL 3` varchar(8) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `exemple`
--

INSERT INTO `exemple` (`COL 1`, `COL 2`, `COL 3`) VALUES
('Titre 1', 'Titre 2', 'Titre 3'),
('x', 'y', 'z'),
('9', '8', '7'),
('0', '1', '0'),
('19/04/22', '20/04/22', '21/04/22');

-- --------------------------------------------------------

--
-- Structure de la table `patientstest`
--

DROP TABLE IF EXISTS `patientstest`;
CREATE TABLE IF NOT EXISTS `patientstest` (
  `patient_id` int(16) NOT NULL,
  `prenom` varchar(64) NOT NULL,
  `nom` varchar(64) NOT NULL,
  `sexe` enum('M','F','NP') NOT NULL,
  `date_naiss` date DEFAULT NULL,
  `grp_sang` enum('A','B','AB','O') NOT NULL,
  `taux_antcrps` int(8) NOT NULL,
  PRIMARY KEY (`patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='taux en g/l';

--
-- Déchargement des données de la table `patientstest`
--

INSERT INTO `patientstest` (`patient_id`, `prenom`, `nom`, `sexe`, `date_naiss`, `grp_sang`, `taux_antcrps`) VALUES
(12002, 'Hugo', 'Lefebvre', 'M', '2003-03-18', 'AB', 18),
(13300, 'Thomas', 'Sansberro', 'M', '1999-12-07', 'O', 19),
(75020, 'Jean', 'Bernard', 'M', '1969-06-06', 'B', 16),
(93030, 'Jeannine', 'Bernardine', 'M', '1966-06-07', 'A', 15);

-- --------------------------------------------------------

--
-- Structure de la table `patienttest`
--

DROP TABLE IF EXISTS `patienttest`;
CREATE TABLE IF NOT EXISTS `patienttest` (
  `COL 1` int(1) DEFAULT NULL,
  `COL 2` varchar(6) DEFAULT NULL,
  `COL 3` varchar(10) DEFAULT NULL,
  `COL 4` varchar(1) DEFAULT NULL,
  `COL 5` varchar(8) DEFAULT NULL,
  `COL 6` varchar(2) DEFAULT NULL,
  `COL 7` int(2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `patienttest`
--

INSERT INTO `patienttest` (`COL 1`, `COL 2`, `COL 3`, `COL 4`, `COL 5`, `COL 6`, `COL 7`) VALUES
(1, 'Hugo', 'Lefebvre', 'M', '18/03/03', 'AB', 20),
(1, 'Thomas', 'Sansberro', 'M', '20/04/00', 'O', 15),
(1, 'Jean', 'Bernard', 'M', '05/05/62', 'B', 18),
(1, 'Jeanne', 'Bernardine', 'F', '07/07/64', 'A', 20),
(1, 'Hugo', 'Lefebvre', 'M', '18/03/03', 'AB', 20),
(1, 'Thomas', 'Sansberro', 'M', '20/04/00', 'O', 15),
(1, 'Jean', 'Bernard', 'M', '05/05/62', 'B', 18),
(1, 'Jeanne', 'Bernardine', 'F', '07/07/64', 'A', 20);

-- --------------------------------------------------------

--
-- Structure de la table `step1`
--

DROP TABLE IF EXISTS `step1`;
CREATE TABLE IF NOT EXISTS `step1` (
  `numero_du_patient` int(5) DEFAULT NULL,
  `nom` varchar(248) DEFAULT NULL,
  `prenom` varchar(248) DEFAULT NULL,
  `sexe` varchar(1) DEFAULT NULL,
  `date_de_naissance` date DEFAULT NULL,
  `groupe_sanguin` varchar(2) DEFAULT NULL,
  `taux_d_anticorps` int(2) DEFAULT NULL,
  `je_suis_positif` varchar(3) DEFAULT NULL,
  `je_suis_malicieux` varchar(3) DEFAULT NULL,
  `je_suis_charlie` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `step1`
--

INSERT INTO `step1` (`numero_du_patient`, `nom`, `prenom`, `sexe`, `date_de_naissance`, `groupe_sanguin`, `taux_d_anticorps`, `je_suis_positif`, `je_suis_malicieux`, `je_suis_charlie`) VALUES
(93030, 'Thomas', 'Sansberro', '', NULL, NULL, NULL, NULL, NULL, NULL),
(75020, 'Jean', 'Bernard', 'M', '1962-05-05', 'B', 18, 'non', 'oui', 3),
(12002, 'Hugo', 'Lefebvre', 'M', '2003-03-18', 'AB', 20, 'oui', 'oui', 1),
(78451, 'Loul', '', '', NULL, '', NULL, 'oui', 'oui', 5);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
