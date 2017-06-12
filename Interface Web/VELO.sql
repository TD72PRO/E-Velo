-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 19 Avril 2017 à 07:25
-- Version du serveur :  5.5.54-0+deb8u1
-- Version de PHP :  5.6.29-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `VELO`
--

-- --------------------------------------------------------

--
-- Structure de la table `DATA`
--

CREATE TABLE IF NOT EXISTS `DATA` (
  `vitesse_actuelle` float NOT NULL,
  `vitesse_cruise` float NOT NULL,
  `flasher_gauche` tinyint(1) NOT NULL,
  `flasher_droit` tinyint(1) NOT NULL,
  `phares` tinyint(1) NOT NULL,
  `klaxon` tinyint(1) NOT NULL,
  `temperature_exterieure` float NOT NULL,
  `temperature_drive` float NOT NULL,
  `temperature_boite` float NOT NULL,
  `luminosite` int(11) NOT NULL,
  `enregistrement_gps` tinyint(1) NOT NULL,
  `image_front_display` text NOT NULL,
  `front_display` int(1) NOT NULL,
  `tonalite_klaxon` text NOT NULL,
  `acceleration_variable` int(11) NOT NULL,
  `vitesse_clignotants` int(11) NOT NULL,
  `activation_lumieres_auto` tinyint(1) NOT NULL,
  `tension_batterie` float NOT NULL,
  `courant_batterie` float NOT NULL,
  `telephone_connecte` tinyint(1) NOT NULL,
  `shutdown` tinyint(1) NOT NULL,
  `reset_gps_history` tinyint(4) NOT NULL,
  `refresh_images_list` tinyint(1) NOT NULL,
  `antidemarreur` tinyint(1) NOT NULL,
  `treshold_temperature_boite` int(11) NOT NULL,
  `treshold_temperature_exterieure` int(11) NOT NULL,
  `treshold_temperature_drive` int(11) NOT NULL,
  `treshold_vitesse` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `DATA`
--

INSERT INTO `DATA` (`vitesse_actuelle`, `vitesse_cruise`, `flasher_gauche`, `flasher_droit`, `phares`, `klaxon`, `temperature_exterieure`, `temperature_drive`, `temperature_boite`, `luminosite`, `enregistrement_gps`, `image_front_display`, `front_display`, `tonalite_klaxon`, `acceleration_variable`, `vitesse_clignotants`, `activation_lumieres_auto`, `tension_batterie`, `courant_batterie`, `telephone_connecte`, `shutdown`, `reset_gps_history`, `refresh_images_list`, `antidemarreur`, `treshold_temperature_boite`, `treshold_temperature_exterieure`, `treshold_temperature_drive`, `treshold_vitesse`) VALUES
(0, 0, 0, 0, 0, 0, 24.2, 23.8, 25.8, 468, 0, 'hqfb.ppm', 0, 'car_horn.mp3', 0, 5, 1, 0, 0, 0, 0, 0, 0, 0, 30, 30, 30, 50);

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
`ImageID` int(11) NOT NULL,
  `Nom` text,
  `Chemin` text
) ENGINE=InnoDB AUTO_INCREMENT=416 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `images`
--

INSERT INTO `images` (`ImageID`, `Nom`, `Chemin`) VALUES
(411, 'raspberrypi', 'raspberrypi.ppm'),
(412, 'hqfb', 'hqfb.ppm'),
(413, 'runtext16', 'runtext16.ppm'),
(414, 'sinus', 'sinus.ppm'),
(415, 'hydroquebec', 'hydroquebec.ppm');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `images`
--
ALTER TABLE `images`
 ADD PRIMARY KEY (`ImageID`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
MODIFY `ImageID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=416;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
