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
(99999, 'nom', 'Ouilepain\r\n'),
(99999, 'numero_du_patient', 'OuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePain'),
(99999, 'numero_du_patient', 'OuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePain'),
(99999, 'numero_du_patient', 'OuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePainOuiLePain');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

