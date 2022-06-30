-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 29 juin 2022 à 09:50
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
-- Structure de la table `step1`
--

DROP TABLE IF EXISTS `step1`;
CREATE TABLE IF NOT EXISTS `step1` (
  `cliniciens` enum('Vincent','Florence') DEFAULT NULL,
  `upn` int(11) DEFAULT NULL,
  `sexe` enum('F','M') DEFAULT NULL,
  `annee_de_naissance` int(11) DEFAULT NULL,
  `date_de_diagnostic` date DEFAULT NULL,
  `score_de_matutes` enum('4 ou 5','5') DEFAULT NULL,
  `statut_ighv` enum('M','UM') DEFAULT NULL,
  `vh` varchar(8) DEFAULT NULL,
  `homologie___germline` varchar(17) DEFAULT NULL,
  `aberrations_chromosomiques` varchar(21) DEFAULT NULL,
  `mutations_geniques` enum('ND','NOTCH1, POT1','Normal','BIRC3','SF3B1') DEFAULT NULL,
  `traitement__oui_1_vs_non_0` enum('0','1') DEFAULT NULL,
  `date_traitement` date DEFAULT NULL,
  `date_point_pour_l_etude__si_traitement_ecrire_date_du_traitement` date DEFAULT NULL,
  `calcul_du_delai__date_de_point__ou_traitement_moins_date_de_diag` int(11) DEFAULT NULL,
  `colonne15` varchar(0) DEFAULT NULL,
  `date_de_l_echantillon` date DEFAULT NULL,
  `lymphocytose__g_l` varchar(17) DEFAULT NULL,
  `colonne18` varchar(0) DEFAULT NULL,
  `foxp3_protplus__pourcent` varchar(16) DEFAULT NULL,
  `il10_protplus__pourcent` varchar(18) DEFAULT NULL,
  `tgfb1_protplus__pourcent` varchar(17) DEFAULT NULL,
  `colonne22` varchar(0) DEFAULT NULL,
  `pourcent_treg__vs_cd4plus` varchar(17) DEFAULT NULL,
  `mts__pourcent` varchar(32) DEFAULT NULL,
  `od_basal` varchar(4) DEFAULT NULL,
  `od_stimulee` varchar(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `step1`
--

INSERT INTO `step1` (`cliniciens`, `upn`, `sexe`, `annee_de_naissance`, `date_de_diagnostic`, `score_de_matutes`, `statut_ighv`, `vh`, `homologie___germline`, `aberrations_chromosomiques`, `mutations_geniques`, `traitement__oui_1_vs_non_0`, `date_traitement`, `date_point_pour_l_etude__si_traitement_ecrire_date_du_traitement`, `calcul_du_delai__date_de_point__ou_traitement_moins_date_de_diag`, `colonne15`, `date_de_l_echantillon`, `lymphocytose__g_l`, `colonne18`, `foxp3_protplus__pourcent`, `il10_protplus__pourcent`, `tgfb1_protplus__pourcent`, `colonne22`, `pourcent_treg__vs_cd4plus`, `mts__pourcent`, `od_basal`, `od_stimulee`) VALUES
('Vincent', 421, 'M', 1938, '2013-01-25', '5', 'M', 'VH4-34', '91.7', 'Del13', NULL, NULL, NULL, '2020-10-20', 2825, NULL, '2018-05-29', '33', NULL, '2.49', '0.65', '22.4', NULL, '7.3', '21.03', '0.77', '0.94'),
('Vincent', 421, 'M', 1938, '2013-01-25', '5', 'M', 'VH4-34', '91.7', 'Del13', NULL, NULL, NULL, '2020-10-20', 2825, NULL, '2018-05-29', '33', NULL, '2.49', '0.65', '22.4', NULL, '7.3', '21.03', '0.77', '0.94'),
('Florence', 422, 'M', 1961, '2006-06-01', NULL, 'M', 'VH3-33', '93.8', NULL, NULL, NULL, NULL, '2020-12-22', 5318, NULL, '2019-04-16', '17', NULL, NULL, '25.8', '4.89', NULL, '3.34', '-1.15', '0.84', '0.83'),
('Florence', 422, 'M', 1961, '2006-06-01', NULL, 'M', 'VH3-33', '93.8', NULL, NULL, NULL, NULL, '2020-12-22', 5318, NULL, '2019-04-16', '17', NULL, NULL, '25.8', '4.89', NULL, '3.34', '-1.15', '0.84', '0.83'),
('Florence', 422, 'M', 1961, '2006-06-01', NULL, 'M', 'VH3-33', '93.8', NULL, NULL, NULL, NULL, '2020-12-22', 5318, NULL, '2019-04-16', '17', NULL, NULL, '25.8', '4.89', NULL, '3.34', '-1.15', '0.84', '0.83'),
('Vincent', 421, 'M', 1938, '2013-01-25', '5', 'M', 'VH4-34', '91.7', 'Del13', NULL, NULL, NULL, '2020-10-20', 2825, NULL, '2018-05-29', '33', NULL, '2.49', '0.65', '22.4', NULL, '7.3', '21.03', '0.77', '0.94'),
('Vincent', 421, 'M', 1938, '2013-01-25', '5', 'M', 'VH4-34', '91.7', 'Del13', NULL, NULL, NULL, '2020-10-20', 2825, NULL, '2018-05-29', '33', NULL, '2.49', '0.65', '22.4', NULL, '7.3', '21.03', '0.77', '0.94'),
('Florence', 422, 'M', 1961, '2006-06-01', NULL, 'M', 'VH3-33', '93.8', NULL, NULL, NULL, NULL, '2020-12-22', 5318, NULL, '2019-04-16', '17', NULL, NULL, '25.8', '4.89', NULL, '3.34', '-1.15', '0.84', '0.83'),
('Florence', 422, 'M', 1961, '2006-06-01', NULL, 'M', 'VH3-33', '93.8', NULL, NULL, NULL, NULL, '2020-12-22', 5318, NULL, '2019-04-16', '17', NULL, NULL, '25.8', '4.89', NULL, '3.34', '-1.15', '0.84', '0.83'),
('Florence', 422, 'M', 1961, '2006-06-01', NULL, 'M', 'VH3-33', '93.8', NULL, NULL, NULL, NULL, '2020-12-22', 5318, NULL, '2019-04-16', '17', NULL, NULL, '25.8', '4.89', NULL, '3.34', '-1.15', '0.84', '0.83'),
('Florence', 422, 'M', 1961, '2006-06-01', NULL, 'M', 'VH3-33', '93.8', NULL, NULL, NULL, NULL, '2020-12-22', 5318, NULL, '2019-04-16', '17', NULL, NULL, '25.8', '4.89', NULL, '3.34', '-1.15', '0.84', '0.83'),
('Florence', 422, 'M', 1961, '2006-06-01', NULL, 'M', 'VH3-33', '93.8', NULL, NULL, NULL, NULL, '2020-12-22', 5318, NULL, '2019-04-16', '17', NULL, NULL, '25.8', '4.89', NULL, '3.34', '-1.15', '0.84', '0.83'),
('Florence', 422, 'M', 1961, '2006-06-01', NULL, 'M', 'VH3-33', '93.8', NULL, NULL, NULL, NULL, '2020-12-22', 5318, NULL, '2019-04-16', '17', NULL, NULL, '25.8', '4.89', NULL, '3.34', '-1.15', '0.84', '0.83'),
('Florence', 422, 'M', 1961, '2006-06-01', NULL, 'M', 'VH3-33', '93.8', NULL, NULL, NULL, NULL, '2020-12-22', 5318, NULL, '2019-04-16', '17', NULL, NULL, '25.8', '4.89', NULL, '3.34', '-1.15', '0.84', '0.83'),
('Vincent', 421, 'M', 1938, '2013-01-25', '5', 'M', 'VH4-34', '91.7', 'Del13', NULL, NULL, NULL, '2020-10-20', 2825, NULL, '2018-05-29', '33', NULL, '2.49', '0.65', '22.4', NULL, '7.3', '21.03', '0.77', '0.94'),
('Vincent', 421, 'M', 1938, '2013-01-25', '5', 'M', 'VH4-34', '91.7', 'Del13', NULL, NULL, NULL, '2020-10-20', 2825, NULL, '2018-05-29', '33', NULL, '2.49', '0.65', '22.4', NULL, '7.3', '21.03', '0.77', '0.94'),
('Vincent', 421, 'M', 1938, '2013-01-25', '5', 'M', 'VH4-34', '91.7', 'Del13', NULL, NULL, NULL, '2020-10-20', 2825, NULL, '2018-05-29', '33', NULL, '2.49', '0.65', '22.4', NULL, '7.3', '21.03', '0.77', '0.94'),
('Florence', 422, 'M', 1961, '2006-06-01', NULL, 'M', 'VH3-33', '93.8', NULL, NULL, NULL, NULL, '2020-12-22', 5318, NULL, '2019-04-16', '17', NULL, NULL, '25.8', '4.89', NULL, '3.34', '-1.15', '0.84', '0.83'),
('Vincent', 421, 'M', 1938, '2013-01-25', '5', 'M', 'VH4-34', '91.7', 'Del13', NULL, NULL, NULL, '2020-10-20', 2825, NULL, '2018-05-29', '33', NULL, '2.49', '0.65', '22.4', NULL, '7.3', '21.03', '0.77', '0.94'),
(NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Florence', 422, 'M', 1961, '2006-06-01', NULL, 'M', 'VH3-33', '93.8', NULL, NULL, NULL, NULL, '2020-12-22', 5318, NULL, '2019-04-16', '17', NULL, NULL, '25.8', '4.89', NULL, '3.34', '-1.15', '0.84', '0.83'),
('Florence', 422, 'M', 1961, '2006-06-01', NULL, 'M', 'VH3-33', '93.8', NULL, NULL, NULL, NULL, '2020-12-22', 5318, NULL, '2019-04-16', '17', NULL, NULL, '25.8', '4.89', NULL, '3.34', '-1.15', '0.84', '0.83'),
('Florence', 422, 'M', 1961, '2006-06-01', NULL, 'M', 'VH3-33', '93.8', NULL, NULL, NULL, NULL, '2020-12-22', 5318, NULL, '2019-04-16', '17', NULL, NULL, '25.8', '4.89', NULL, '3.34', '-1.15', '0.84', '0.83'),
('Florence', 422, 'M', 1961, '2006-06-01', NULL, 'M', 'VH3-33', '93.8', NULL, NULL, NULL, NULL, '2020-12-22', 5318, NULL, '2019-04-16', '17', NULL, NULL, '25.8', '4.89', NULL, '3.34', '-1.15', '0.84', '0.83'),
('Vincent', 421, 'M', 1938, '2013-01-25', '5', 'M', 'VH4-34', '91.7', 'Del13', NULL, NULL, NULL, '2020-10-20', 2825, NULL, '2018-05-29', '33', NULL, '2.49', '0.65', '22.4', NULL, '7.3', '21.03', '0.77', '0.94');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
