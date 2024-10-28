-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 29 oct. 2024 à 00:49
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `inventaire`
--

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `prix` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `nom`, `description`, `prix`, `stock`) VALUES
(12, 'Tournevis à cliquet', 'Tournevis multi-usage avec fonction de cliquet', 15.76, 412),
(13, 'Pneu de rechange', 'Pneu tout-terrain, parfait pour les routes difficiles', 189.63, 3),
(14, 'Batterie 12V', 'Batterie durable pour véhicules légers', 124.51, 12),
(15, 'Coffre à outils', 'Coffre de rangement en métal pour outils divers', 60.78, 43),
(16, 'Jerrican 20L', 'Jerrican robuste pour carburant', 19.26, 37),
(17, 'Disque de frein', 'Disque de frein pour voitures compactes', 79.66, 23),
(18, 'Compresseur d\'air', 'Compresseur portable pour gonfler les pneus', 77.13, 1),
(19, 'Clé dynamométrique', 'Clé avec mesure précise du couple de serrage', 97.50, 3),
(20, 'Essuie-glace', 'Balai d\'essuie-glace résistant aux intempéries', 15.73, 59),
(21, 'Bidon d\'huile moteur', 'Huile moteur 5W-30 pour moteur performant', 31.01, 21),
(22, 'Filtre à huile', 'Filtre de haute qualité pour moteur', 12.99, 1),
(23, 'Éclairage LED pour garage', 'Lampe LED pour un éclairage puissant dans le garage', 34.61, 14),
(24, 'Boîte de boulons', 'Ensemble de boulons de tailles variées', 31.26, 10),
(25, 'Levier de pneu', 'Levier en acier pour changer les pneus', 6.68, 8),
(26, 'Vérin hydraulique', 'Vérin pour soulever facilement les véhicules', 88.11, 9),
(27, 'Cric de voiture', 'Cric compact pour véhicule', 25.90, 27),
(28, 'Vis', 'vis', 0.05, 2147483647),
(29, 'Extincteur pour voiture', 'Extincteur de sécurité pour véhicules', 40.99, 8),
(30, 'Kit de polissage', 'Kit complet pour polir la carrosserie', 21.20, 4),
(31, 'Nettoyant pour jantes', 'Produit nettoyant pour jantes de voiture', 6.25, 61);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
