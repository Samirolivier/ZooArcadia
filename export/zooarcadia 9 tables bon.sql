-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 03 déc. 2024 à 22:11
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
-- Structure de la table `animals`
--

CREATE TABLE `animals` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `species` varchar(255) NOT NULL,
  `health_status` varchar(255) NOT NULL,
  `views` int(11) DEFAULT 0,
  `habitat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `animals`
--

INSERT INTO `animals` (`id`, `image`, `name`, `species`, `health_status`, `views`, `habitat_id`) VALUES
(1, 'images/images/animals/674df954bb99b_66ec748430919_leo.png', 'Leopards', 'Félins', 'bonne santé', 29, 1),
(2, 'images/images/animals/66ec749230b94_ara bleu.png', 'Ara Bleu', 'Oiseau', 'bonne santé', 21, 1),
(3, 'images/images/animals/66ec74af2347f_Hippopotames.png', 'Hippopotames', 'Mammifères', 'Bonne santé', 8, 2),
(4, 'images/images/animals/66ec74bed87f4_Poisson Clown.png', 'Poisson Clown', 'Poisson', 'Bonne santé', 7, 2),
(5, 'images/images/animals/66ec74caa0e54_Scorpion.png', 'Scorpion', 'Arachnides', 'Malade', 1, 3),
(6, 'images/images/animals/66ec74d2493f2_Dromadaire.png', 'Dromadaire', 'Mammifères', 'Bonne santé', 4, 3),
(7, 'images/images/animals/66ec74e3179fc_Elephant.png', 'Elephant', 'Mammifères', 'Bonne santé', 10, 4),
(8, 'images/images/animals/66ec74f053b02_lionne.png', 'Lionne', 'Félins', 'Enceinte', 14, 4),
(9, 'images/images/animals/66ec750fd3b5e_boa.png', 'Boa Emeraude', 'reptiles', 'bonne', 41, 1),
(10, 'images/images/animals/66edbd3889a87_chimp.png', 'Chimpanzé', 'Singe', 'bonne', 13, 1),
(11, 'images/images/animals/66edbd54e29fb_dendrobate.png', 'Dendrobate', 'Grenouille', '', 3, 1),
(12, 'images/images/animals/66edbd70a595a_gibon.png', 'Gibon', 'Singe', '', 4, 1),
(13, 'images/images/animals/66edbda3c898a_recroqueville.png', 'Recroquevillé', 'Serpent', '', 4, 1),
(14, 'images/images/animals/66edbde21b390_Outres.png', 'Outres', 'Mammifères', '', 7, 2),
(15, 'images/images/animals/66edbe1045830_Perche.png', 'Perche', 'Poisson', '', 4, 2),
(16, 'images/images/animals/66edbe2760e19_Plongeon.png', 'Plongeon', 'Oiseau', '', 2, 2),
(17, 'images/images/animals/66edbe48e4653_Oies de lac.png', 'Oies de lac', 'Oiseau', '', 6, 2),
(18, 'images/images/animals/66edbe65268f9_Crocodile.png', 'Crocodile', 'Alligators', '', 3, 2),
(19, 'images/images/animals/66edbe89bcbc2_Gazelle.png', 'Gazelle', 'Bovidés', '', 1, 3),
(20, 'images/images/animals/66edbea38d279_Cobra.png', 'Cobra', 'Serpent', '', 1, 3),
(21, 'images/images/animals/66edbed3169ab_Diable épineux.png', 'Diable épineux 	', 'reptiles', '', 0, 3),
(22, 'images/images/animals/66edbee7a4951_Vipère cornu.png', 'Vipère cornu', 'reptiles', '', 3, 3),
(24, 'images/images/animals/66edbf2445570_lion.png', 'Lion', 'Félins', '', 3, 4),
(25, 'images/images/animals/66edbf42bd9b2_Lycaon.png', 'Lycaon', 'Canidés', '', 1, 4),
(26, 'images/images/animals/66edbf5b516e4_Chacal.png', 'Chacal', 'Canidés', 'bonne santé', 8, 4),
(27, 'images/images/animals/66edbf6ed41d3_Gnou.png', 'Gnou', 'Mammifères', 'malade', 5, 4),
(28, 'images/images/animals/66edbf83b3597_Buffle.png', 'Buffle', 'Mammifères', '', 0, 4),
(29, 'images/images/animals/66edbf9a33b3e_Girafe.png', 'Girafe', 'Mammifères', '', 1, 4),
(30, 'images/images/animals/66eeb5a8ac754_Lézard à crête.png', 'Lézard à crête', 'reptiles', 'bonne et enceinte', 8, 3),
(31, 'images/images/animals/66eeb5d4254f6_Iguane.png', 'Iguane', 'reptiles', 'très bonne santé', 4, 3);

-- --------------------------------------------------------

--
-- Structure de la table `animal_consultations`
--

CREATE TABLE `animal_consultations` (
  `id` int(11) NOT NULL,
  `animal_id` int(11) NOT NULL,
  `consultation_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`, `is_read`) VALUES
(1, 'Boris Diaw', 'samirolivier@gmail.com', 'faire du benevoltat', '2024-09-16 14:41:45', 1),
(2, 'samir olivier', 'email@entreprise.com', 'je suis intéresser pour bosser avec vous.\r\nmerci de me repondre ', '2024-09-16 16:07:35', 1),
(3, 'rahima', 'rahima@monsite.com', 'je veux un contact', '2024-09-16 16:13:01', 1),
(4, 'rico', 'rico@monsite.com', 'hello', '2024-09-16 16:14:35', 1),
(5, 'nina', 'nina@site.com', 'suis la', '2024-09-16 16:15:36', 1),
(6, 'momy', 'momy@site.com', 'appelez moi', '2024-09-16 16:16:18', 1),
(7, 'mami', 'mami@site.c', 'je suis la', '2024-09-16 16:16:58', 1),
(8, 'ahlem', 'ahlem@gmail.com', 'allo!!!!', '2024-09-16 16:18:10', 1),
(9, 'rakia', 'rakia@gmail.com', 'allo', '2024-09-16 16:21:55', 1),
(10, 'ikram', 'ikram@gmail.com', 'allo', '2024-09-16 16:22:37', 1),
(11, 'bazil', 'bazil@gmail.com', 'allo', '2024-09-16 16:23:29', 1),
(12, 'amir', 'amir@gmailcom', 'youpi', '2024-09-16 19:35:34', 1),
(13, 'fezfge', 'samir@yahoo.fr', 'cool', '2024-09-16 21:48:14', 1),
(14, 'ismael', 'ismael@gmail.com', 'je veux parler au DG', '2024-09-18 20:10:28', 1),
(15, 'samol', 'samol@gmail.com', 'super cool', '2024-09-20 21:23:48', 1),
(16, 'mamichou', 'mamichou@gmail.com', 'je sui ravis', '2024-09-21 12:03:37', 1),
(17, 'Brayan', 'samirolivier@gmail.com', 'super cool', '2024-11-30 09:51:59', 1),
(20, 'lako', 'lako@gmail.com', 'trop cool', '2024-12-01 21:00:34', 0);

-- --------------------------------------------------------

--
-- Structure de la table `feeding_logs`
--

CREATE TABLE `feeding_logs` (
  `id` int(11) NOT NULL,
  `animal_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `food_type` varchar(255) NOT NULL,
  `grammage` decimal(10,2) NOT NULL,
  `feeding_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `feeding_logs`
--

INSERT INTO `feeding_logs` (`id`, `animal_id`, `user_id`, `food_type`, `grammage`, `feeding_time`) VALUES
(1, 1, 3, 'viande de boeuf', '30.00', '2024-09-18 13:59:54'),
(2, 2, 3, 'arrachide', '50.20', '2024-09-18 14:01:00'),
(3, 3, 3, 'pastèque', '30.00', '2024-09-18 14:01:46'),
(4, 4, 3, 'granulés', '25.00', '2024-09-18 14:01:46'),
(5, 5, 3, 'insectes', '5.30', '2024-09-18 14:02:34'),
(6, 6, 3, 'herbes/graines', '300.00', '2024-09-18 14:02:34'),
(7, 7, 3, 'herbes', '1500.00', '2024-09-18 14:03:26'),
(8, 8, 3, 'viande de boeuf', '850.00', '2024-09-18 14:03:26'),
(9, 1, 3, 'poulet', '200.00', '2024-09-18 20:46:00'),
(10, 9, 3, 'souris', '300.00', '2024-09-18 22:09:00'),
(11, 4, 3, 'granulé et vers', '300.00', '2024-09-19 22:41:00'),
(12, 9, 3, 'souris', '250.00', '2024-09-20 23:40:00'),
(13, 10, 3, 'banane', '100.00', '2024-09-21 13:47:00'),
(14, 31, 3, 'insectes', '75.50', '2024-09-21 14:04:00'),
(15, 30, 3, 'insectes', '12.50', '2024-09-21 14:31:00'),
(17, 26, 3, 'poulets', '10.02', '2024-12-01 20:59:00'),
(18, 27, 3, 'herbes', '55.25', '2024-12-01 21:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `habitats`
--

CREATE TABLE `habitats` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `habitats`
--

INSERT INTO `habitats` (`id`, `name`, `description`, `image`, `content`) VALUES
(1, 'Forêts Tropicales', '<br>L\'habitat <b>Forêts Tropicales</b> de notre zoo Arcadia est un environnement dense et humide, abritant une biodiversité exceptionnelle avec des plantes et des animaux uniques. Ce milieu tropical, caractérisé par des températures élevées et des précipitations abondantes, est essentiel à l\'équilibre écologique de notre planète.', 'images/images/habitats/674df6393bc4a_674c59f979037_animal.jpg', '<ul>\r\n<li><b>Description</b> : Un espace ouvert avec des herbes hautes, des arbres épars et des points d\'eau pour recréer les vastes plaines africaines.</li>\r\n<li><b>Animaux</b> : Singes, perroquets, reptiles, amphibiens, diverses espèces d\'insectes etc...</li>\r\n</ul>'),
(2, 'Rivières & Humides', '<br>L\'habitat <b>Rivières & Humides</b> de notre zoo Arcadia représente des zones marécageuses et fluviales, où l\'eau douce abrite une faune et une flore adaptées à un environnement humide et changeant. Ces écosystèmes vitaux sont essentiels pour de nombreuses espèces aquatiques et semi-aquatiques.', 'images/images/habitats/674c9bb401a2e_674c5a0beb00c_sealion.jpg', '<ul>\r\n<li><b>Description</b> : Habitats aquatiques avec des rivières, des marais, des étangs et des plantes aquatiques.</li>\r\n<li><b>Animaux</b> : Hippopotames, crocodiles, loutres, poissons, amphibiens, et oiseaux aquatiqueses etc...</li>\r\n</ul>'),
(3, 'Déserts et Dunes', '<br>L\'habitat <b>Déserts et Dunes</b> de notre zoo Arcadia recrée des environnements arides, caractérisés par des températures extrêmes et une végétation rare, où seules les espèces les plus résistantes peuvent prospérer. Ces écosystèmes fascinants sont le foyer d\'animaux adaptés à la survie dans des conditions de sécheresse et de chaleur intense', 'images/images/habitats/674c5a2287361_lions.jpg', '<ul>\r\n<li><b>Description</b> : Habitats arides avec du sable, des rochers, et des plantes désertiques comme les cactus.</li>\r\n<li><b>Animaux</b> : Chameaux, suricates, lézards, serpents, scorpions etc...</li>\r\n</ul>'),
(4, 'Savane Africaine', '<br>L\'habitat <b>Savane Africaine</b> de notre zoo Arcadia simule les vastes étendues herbeuses et ouvertes d\'Afrique, où des animaux majestueux comme les lions, éléphants et girafes coexistent avec une faune diversifiée, adaptés à un climat chaud et sec. Cet écosystème vibrant reflète la beauté et la complexité des paysages africains.', 'images/images/habitats/674c5a2f51d3f_sav.png', '<ul>\r\n<li><b>Description</b> : Un espace ouvert avec des herbes hautes, des arbres épars et des points d\'eau pour recréer les vastes plaines africaines.</li>\r\n<li><b>Animaux</b> : Lions, éléphants, girafes, zèbres, antilopes,  rhinocéros etc...</li>\r\n</ul>');

-- --------------------------------------------------------

--
-- Structure de la table `habitat_comments`
--

CREATE TABLE `habitat_comments` (
  `id` int(11) NOT NULL,
  `habitat_id` int(11) NOT NULL,
  `veterinarian_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `habitat_comments`
--

INSERT INTO `habitat_comments` (`id`, `habitat_id`, `veterinarian_id`, `comment`, `created_at`) VALUES
(1, 1, 2, 'ajouter encore des abris', '2024-09-18 20:03:51'),
(2, 2, 2, 'plus arbre', '2024-09-18 20:04:03'),
(3, 4, 2, 'beaucoup plus de fleurs', '2024-09-19 20:40:08'),
(4, 3, 2, 'a revoir', '2024-09-21 12:08:09'),
(5, 3, 2, 'plus plus plus', '2024-12-01 20:06:47');

-- --------------------------------------------------------

--
-- Structure de la table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `veterinarian_id` int(11) NOT NULL,
  `animal_id` int(11) NOT NULL,
  `report_date` date NOT NULL,
  `description` text NOT NULL,
  `health_status` varchar(255) DEFAULT NULL,
  `feeding_comments` text DEFAULT NULL,
  `habitat_comments` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `reports`
--

INSERT INTO `reports` (`id`, `veterinarian_id`, `animal_id`, `report_date`, `description`, `health_status`, `feeding_comments`, `habitat_comments`, `created_at`) VALUES
(1, 2, 1, '2024-09-18', 'il à l\'aire en forme', 'parfaite sante', 'ajouter 10g de plus', 'planter plus d\'arbres', '2024-09-18 19:25:12'),
(2, 2, 2, '2024-09-18', 'grandi bien', 'bien', 'ajouter 2g', '', '2024-09-18 19:51:49'),
(3, 2, 3, '2024-09-18', 'grandi', 'super bine', 'ajouter 200g', 'ça va', '2024-09-18 20:04:31'),
(4, 2, 4, '2024-09-19', 'augmenter encore d\'autres', 'bonne', 'augmenter des vers', 'bien', '2024-09-19 20:40:56'),
(5, 2, 1, '2024-09-19', 'bien', 'bonne', 'ok', '', '2024-09-19 20:43:43'),
(6, 2, 9, '2024-09-20', 'grandit bien', 'enceinte', 'a surveiller de près', '', '2024-09-20 21:42:00'),
(7, 2, 9, '2024-09-20', 'bien', 'bonne santé', 'bonne sante', 'bien', '2024-09-20 21:46:48'),
(8, 2, 1, '2024-09-21', 'ok', 'bonne', '', '', '2024-09-21 11:26:59'),
(9, 2, 1, '2024-09-21', 'ok', 'bonne', '', '', '2024-09-21 11:33:57'),
(10, 2, 10, '2024-09-21', 'en forme', 'bien', '', '', '2024-09-21 11:34:15'),
(11, 2, 10, '2024-09-21', 'en forme', 'bien', '', '', '2024-09-21 11:34:20'),
(12, 2, 9, '2024-09-21', 'ok', 'bonne', '', '', '2024-09-21 11:46:07'),
(13, 2, 10, '2024-09-21', 'ok', 'bonne', '', '', '2024-09-21 11:46:35'),
(14, 2, 31, '2024-09-21', 'en forme', 'très bonne santé', 'bien', 'parfait', '2024-09-21 12:08:00'),
(15, 2, 30, '2024-09-21', 'ok', 'bonne et enceinte', '', '', '2024-09-21 12:20:18'),
(16, 2, 26, '2024-12-01', 'grandit super bien', 'bonne santé', 'ajouter 10g de plus', 'bien', '2024-12-01 20:06:28'),
(17, 2, 27, '2024-12-01', 'diarhee', 'malade', 'des fruits', '', '2024-12-01 20:11:11');

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Index pour la table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `habitat_id` (`habitat_id`);

--
-- Index pour la table `animal_consultations`
--
ALTER TABLE `animal_consultations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animal_id` (`animal_id`);

--
-- Index pour la table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `feeding_logs`
--
ALTER TABLE `feeding_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feeding_logs_ibfk_1` (`animal_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `habitats`
--
ALTER TABLE `habitats`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `habitat_comments`
--
ALTER TABLE `habitat_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `habitat_id` (`habitat_id`),
  ADD KEY `veterinarian_id` (`veterinarian_id`);

--
-- Index pour la table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `veterinarian_id` (`veterinarian_id`),
  ADD KEY `animal_id` (`animal_id`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `session_token` (`session_token`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT pour la table `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `animal_consultations`
--
ALTER TABLE `animal_consultations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `feeding_logs`
--
ALTER TABLE `feeding_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `habitats`
--
ALTER TABLE `habitats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `habitat_comments`
--
ALTER TABLE `habitat_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `animals`
--
ALTER TABLE `animals`
  ADD CONSTRAINT `animals_ibfk_1` FOREIGN KEY (`habitat_id`) REFERENCES `habitats` (`id`);

--
-- Contraintes pour la table `animal_consultations`
--
ALTER TABLE `animal_consultations`
  ADD CONSTRAINT `animal_consultations_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`id`);

--
-- Contraintes pour la table `feeding_logs`
--
ALTER TABLE `feeding_logs`
  ADD CONSTRAINT `feeding_logs_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `feeding_logs_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `habitat_comments`
--
ALTER TABLE `habitat_comments`
  ADD CONSTRAINT `habitat_comments_ibfk_1` FOREIGN KEY (`habitat_id`) REFERENCES `habitats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `habitat_comments_ibfk_2` FOREIGN KEY (`veterinarian_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`veterinarian_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
