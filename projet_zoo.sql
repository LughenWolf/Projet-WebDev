-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 08 nov. 2024 à 09:29
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet zoo`
--

-- --------------------------------------------------------

--
-- Structure de la table `animaux`
--

DROP TABLE IF EXISTS `animaux`;
CREATE TABLE IF NOT EXISTS `animaux` (
  `id_animaux` int NOT NULL AUTO_INCREMENT,
  `nom` text NOT NULL,
  `id_enclos` int NOT NULL,
  PRIMARY KEY (`id_animaux`),
  KEY `id_enclos` (`id_enclos`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `id` int NOT NULL AUTO_INCREMENT,
  `note` int NOT NULL,
  `commentaire` text,
  `id_user` int NOT NULL,
  `id_enclos` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_enclos` (`id_enclos`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `billets`
--

DROP TABLE IF EXISTS `billets`;
CREATE TABLE IF NOT EXISTS `billets` (
  `id_billet` int NOT NULL AUTO_INCREMENT,
  `type` enum('enfant','adulte') NOT NULL,
  `id_user` int DEFAULT NULL,
  PRIMARY KEY (`id_billet`),
  KEY `id_user` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `biome`
--

DROP TABLE IF EXISTS `biome`;
CREATE TABLE IF NOT EXISTS `biome` (
  `id_biome` int NOT NULL AUTO_INCREMENT,
  `nom` text NOT NULL,
  `couleur` text NOT NULL,
  PRIMARY KEY (`id_biome`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `enclos`
--

DROP TABLE IF EXISTS `enclos`;
CREATE TABLE IF NOT EXISTS `enclos` (
  `id_enclos` int NOT NULL AUTO_INCREMENT,
  `status` enum('user','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_biome` int NOT NULL,
  PRIMARY KEY (`id_enclos`),
  KEY `id_biome` (`id_biome`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `horaire_repas`
--

DROP TABLE IF EXISTS `horaire_repas`;
CREATE TABLE IF NOT EXISTS `horaire_repas` (
  `id_repas` int NOT NULL AUTO_INCREMENT,
  `heure_repas` text NOT NULL,
  `date_repas` text NOT NULL,
  `id_enclos` int NOT NULL,
  PRIMARY KEY (`id_repas`),
  KEY `id_enclos` (`id_enclos`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id_service` int NOT NULL AUTO_INCREMENT,
  `nom` text NOT NULL,
  `id_biome` int DEFAULT NULL,
  PRIMARY KEY (`id_service`),
  KEY `id_biome` (`id_biome`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `prenom` text NOT NULL,
  `nom` text NOT NULL,
  `email` text NOT NULL,
  `mdp` text NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `prenom`, `nom`, `email`, `mdp`, `role`) VALUES
(1, 'Matteo', 'Revest', 'matteo810541@gmail.com', 'motdepasse', 'user'),
(2, 'Matteo', 'Revest', 'matteo810541@gmail.com', 'motdepasse', 'user'),
(3, 'Matteo', 'Revest', 'adresse@gmail.com', '$2y$10$QdcGQOsAMZfUHcVVIWkBbOu6GDRpkGnnnkePCR40mceJMzD/Pu7sy', 'user'),
(4, 'Matteo', 'Revest', 'adresse1@gmail.com', 'meurt', 'user');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
