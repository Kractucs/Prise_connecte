-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Mar 28 Mai 2019 à 10:46
-- Version du serveur :  10.1.38-MariaDB-0+deb9u1
-- Version de PHP :  7.0.33-0+deb9u3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `mqtt`
--
CREATE DATABASE IF NOT EXISTS `mqtt` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `mqtt`;

-- --------------------------------------------------------

--
-- Structure de la table `Prises`
--

CREATE TABLE `Prises` (
  `id` int(10) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `State` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `Prises`
--

INSERT INTO `Prises` (`id`, `Name`, `State`) VALUES
(1, 'Prise1', 'OFF'),
(2, 'Prise2', 'ON'),
(3, 'Prise2', 'DEFAULT');

-- --------------------------------------------------------

--
-- Structure de la table `Progra`
--

CREATE TABLE `Progra` (
  `id` int(3) NOT NULL,
  `Prise_id` int(3) NOT NULL,
  `time` time(6) NOT NULL,
  `state` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `Progra`
--

INSERT INTO `Progra` (`id`, `Prise_id`, `time`, `state`) VALUES
(3, 1, '16:30:00.000000', 'ON'),
(4, 1, '17:00:00.000000', 'OFF'),
(6, 2, '17:00:00.000000', 'ON'),
(8, 1, '09:46:00.000000', 'ON'),
(9, 3, '05:46:00.000000', 'ON');

-- --------------------------------------------------------

--
-- Structure de la table `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `user` varchar(20) CHARACTER SET utf8 NOT NULL,
  `pass` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `Users`
--

INSERT INTO `Users` (`id`, `user`, `pass`) VALUES
(1, 'toto', '$2y$10$Il8vl5ouL57BJO3K7Ew5IeLeODtFu7UYv3YjzglAOMLFNYO0fgtXa'),
(2, 'babs', '$2y$10$r/EUKIEKFndldiUjtG67du.c3x.QHv5XgU3CBVQVTbd9JIDUvzeBC');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Prises`
--
ALTER TABLE `Prises`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Progra`
--
ALTER TABLE `Progra`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Prises`
--
ALTER TABLE `Prises`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `Progra`
--
ALTER TABLE `Progra`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
