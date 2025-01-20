-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 12 jan. 2025 à 15:06
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `revendtbd`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `idadmin` int(11) NOT NULL AUTO_INCREMENT,
  `nomad` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `num` varchar(10) NOT NULL,
  `role` enum('admin','superadmin') NOT NULL,
  PRIMARY KEY (`idadmin`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` varchar(50) DEFAULT 'en cours',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `total`, `status`, `created_at`) VALUES
(1, 'Jean Dupont', '50.99', 'livré', '2025-01-09 14:41:48'),
(2, 'Alice Martin', '30.50', 'en cours', '2025-01-09 14:41:48');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL,
  `titreprod` varchar(255) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `prix_promo` decimal(10,2) NOT NULL,
  `description` varchar(255) NOT NULL,
  `vendeur_id` int(11) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `nom_vendeur` varchar(255) NOT NULL,
  `etat` int(11) NOT NULL,
  `whatsapp` int(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_vendeur` (`vendeur_id`),
  KEY `fk_nom_vendeur` (`nom_vendeur`),
  KEY `fk_etat` (`etat`),
  KEY `fk_whatsapp` (`whatsapp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `num` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--------------------------------------------------------

--
-- Structure de la table `vendeurs`
--

CREATE TABLE `vendeurs` (
  `id` int(11) NOT NULL,
  `nom_vendeur` varchar(255) NOT NULL,
  `experience` int(11) NOT NULL,
  `etat` int(11) NOT NULL,
  `whatsapp` int(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_nom_vendeur` (`nom_vendeur`),
  KEY `idx_etat` (`etat`),
  KEY `idx_whatsapp` (`whatsapp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `fk_etat` FOREIGN KEY (`etat`) REFERENCES `vendeurs` (`etat`),
  ADD CONSTRAINT `fk_nom_vendeur` FOREIGN KEY (`nom_vendeur`) REFERENCES `vendeurs` (`nom_vendeur`),
  ADD CONSTRAINT `fk_vendeur` FOREIGN KEY (`vendeur_id`) REFERENCES `vendeurs` (`id`),
  ADD CONSTRAINT `fk_whatsapp` FOREIGN KEY (`whatsapp`) REFERENCES `vendeurs` (`whatsapp`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
