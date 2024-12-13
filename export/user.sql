-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 03 déc. 2024 à 22:04
-- Version du serveur : 10.4.25-MariaDB
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `zooarcadia`
--

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','veterinaire','employe') NOT NULL,
  `username` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `role`, `username`, `created_at`) VALUES
(1, 'sam@gmail.com', '$2y$10$FQY93EuQgbfgrdMT8cy4BeMEGw0tKJ5Vte31oPlSpppLXo.fwsVJ2', 'admin', 'sam', '2024-09-18 11:57:29'),
(2, 'olivier@gmail.com', '$2y$10$Asx34/o8Fd33rrpHCTqO8eGAgCytdQJq/iqvU49ZjG6G5zGXAF0lq', 'veterinaire', 'olivier', '2024-09-18 11:57:29'),
(3, 'bocs@gmail.com', '$2y$10$Asx34/o8Fd33rrpHCTqO8eGAgCytdQJq/iqvU49ZjG6G5zGXAF0lq', 'employe', 'bocs', '2024-09-18 11:57:54'),
(8, 'yao0005@yahoo.fr', '$2y$10$643w1sdw9RBbI9kl77gmmeFNJpNx2qgYXogH5jp9QXz9QCuolVl92', 'employe', '', '2024-12-02 11:19:07'),
(9, 'bocshenny@yahoo.fr', '$2y$10$r3obJQqFtHZhx6Rmu3BlWeqkjJH7pBsxeizp1.P7ck.dA1RZB/0Au', 'veterinaire', '', '2024-12-02 11:19:39'),
(10, 'infos@mapluscorporate.com', '$2y$10$Y7F.8f5luNFsxXYYMyp5BuQqN92qksrPyhDjQLOrDaSxHU5RWCrC.', 'employe', '', '2024-12-02 11:33:16');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
