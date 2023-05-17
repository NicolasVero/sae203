-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 20 mai 2022 à 16:06
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sae203_db-veronic`
--

-- --------------------------------------------------------

--
-- Structure de la table `sae203_billets`
--

CREATE TABLE `sae203_billets` (
  `id` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `id_evenement` int(11) NOT NULL,
  `nom_evenement` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_evenement` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sae203_evenements`
--

CREATE TABLE `sae203_evenements` (
  `id` int(11) NOT NULL,
  `nom_evenement` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_evenement` date NOT NULL,
  `nombre_billet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sae203_utilisateurs`
--

CREATE TABLE `sae203_utilisateurs` (
  `id` int(11) NOT NULL,
  `mail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mdp` text COLLATE utf8_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `civilite` int(11) NOT NULL,
  `est_admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `sae203_billets`
--
ALTER TABLE `sae203_billets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_evenement` (`id_evenement`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `sae203_evenements`
--
ALTER TABLE `sae203_evenements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sae203_utilisateurs`
--
ALTER TABLE `sae203_utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `sae203_billets`
--
ALTER TABLE `sae203_billets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sae203_evenements`
--
ALTER TABLE `sae203_evenements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sae203_utilisateurs`
--
ALTER TABLE `sae203_utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `sae203_billets`
--
ALTER TABLE `sae203_billets`
  ADD CONSTRAINT `sae203_billets_ibfk_1` FOREIGN KEY (`id_evenement`) REFERENCES `sae203_evenements` (`id`),
  ADD CONSTRAINT `sae203_billets_ibfk_2` FOREIGN KEY (`id_utilisateur`) REFERENCES `sae203_utilisateurs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
