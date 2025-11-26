-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 02 déc. 2024 à 22:20
-- Version du serveur : 10.11.6-MariaDB-0+deb12u1
-- Version de PHP : 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `GameShift`
--

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `game_id`, `quantity`) VALUES
(31, 22, 1, 2),
(33, 26, 7, 1);

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `comment_text` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `games`
--

CREATE TABLE `games` (
  `game_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `pegi_rating` int(11) DEFAULT NULL,
  `studio` varchar(100) DEFAULT NULL,
  `platform` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `rating` float DEFAULT 0,
  `release_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `image_1` varchar(255) DEFAULT NULL,
  `image_2` varchar(255) DEFAULT NULL,
  `image_3` varchar(255) DEFAULT NULL,
  `image_4` varchar(255) DEFAULT NULL,
  `image_5` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `added_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `games`
--

INSERT INTO `games` (`game_id`, `title`, `genre`, `pegi_rating`, `studio`, `platform`, `price`, `stock`, `rating`, `release_date`, `description`, `image_url`, `image_1`, `image_2`, `image_3`, `image_4`, `image_5`, `video`, `added_date`) VALUES
(1, 'Cyberpunk 2077', 'RPG', 18, 'CD Projekt Red', 'PC', 50.99, 100, 4.5, '2020-12-10', 'Un jeu de rôle futuriste en monde ouvert.', 'https://cdn.akamai.steamstatic.com/steam/apps/1091500/header.jpg', 'https://gaming-cdn.com/images/products/840/screenshot/cyberpunk-2077-pc-jeu-gog-com-wallpaper-1.jpg?v=1701271565', 'https://gaming-cdn.com/images/products/840/screenshot/cyberpunk-2077-pc-jeu-gog-com-wallpaper-2.jpg?v=1701271565', 'https://gaming-cdn.com/images/products/840/screenshot/cyberpunk-2077-pc-jeu-gog-com-wallpaper-3.jpg?v=1701271565', 'https://gaming-cdn.com/images/products/840/screenshot/cyberpunk-2077-pc-jeu-gog-com-wallpaper-4.jpg?v=1701271565', 'https://gaming-cdn.com/images/products/840/screenshot/cyberpunk-2077-pc-jeu-gog-com-wallpaper-5.jpg?v=1701271565', 'https://video.cloudflare.steamstatic.com/store_trailers/256987126/movie480_vp9.webm?t=1701872758', '2024-12-01 23:46:06'),
(2, 'The Witcher 3: Wild Hunt', 'RPG', 18, 'CD Projekt Red', 'PC', 39.99, 150, 4.9, '2015-05-19', 'Incarnez Geralt de Riv dans une aventure épique.', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/292030/header.jpg?t=1730212926', 'https://cdn.akamai.steamstatic.com/steam/apps/1002/image1.jpg', 'https://cdn.akamai.steamstatic.com/steam/apps/1002/image2.jpg', 'https://cdn.akamai.steamstatic.com/steam/apps/1002/image3.jpg', 'https://cdn.akamai.steamstatic.com/steam/apps/1002/image4.jpg', 'https://cdn.akamai.steamstatic.com/steam/apps/1002/image5.jpg', 'https://cdn.akamai.steamstatic.com/steam/apps/1002/video.mp4', '2024-12-01 23:46:06'),
(3, 'Dota 2', 'MOBA', 12, 'Valve', 'PC', 0.00, 200, 4.8, '2013-07-09', 'Un jeu de stratégie multijoueur en ligne très populaire.', 'https://cdn.akamai.steamstatic.com/steam/apps/570/header.jpg', 'https://cdn.akamai.steamstatic.com/steam/apps/1003/image1.jpg', 'https://cdn.akamai.steamstatic.com/steam/apps/1003/image2.jpg', 'https://cdn.akamai.steamstatic.com/steam/apps/1003/image3.jpg', 'https://cdn.akamai.steamstatic.com/steam/apps/1003/image4.jpg', 'https://cdn.akamai.steamstatic.com/steam/apps/1003/image5.jpg', 'https://cdn.akamai.steamstatic.com/steam/apps/1003/video.mp4', '2024-12-01 23:46:06'),
(4, 'Counter-Strike: Global Offensive', 'FPS', 18, 'Valve', 'PC', 0.00, 300, 4.6, '2012-08-21', 'Un des FPS compétitifs les plus populaires au monde.', 'https://cdn.akamai.steamstatic.com/steam/apps/730/header.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-01 23:46:06'),
(5, 'Apex Legends', 'Battle Royale', 16, 'Respawn Entertainment', 'PC', 0.00, 250, 4.4, '2019-02-04', 'Un jeu de tir battle royale dynamique.', 'https://cdn.akamai.steamstatic.com/steam/apps/1172470/header.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-01 23:46:06'),
(6, 'DOOM Eternal', 'FPS', 18, 'id Software', 'PC', 49.99, 90, 4.7, '2020-03-20', 'Le retour du classique FPS avec des démons et de l\'action.', 'https://cdn.akamai.steamstatic.com/steam/apps/782330/header.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-01 23:46:06'),
(7, 'Among Us', 'Party', 7, 'InnerSloth', 'PC', 3.99, 200, 4.2, '2018-06-15', 'Un jeu multijoueur de déduction sociale.', 'https://cdn.akamai.steamstatic.com/steam/apps/945360/header.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-01 23:46:06'),
(8, 'Red Dead Redemption 2', 'Action', 18, 'Rockstar Games', 'PC', 59.99, 120, 4.9, '2019-11-05', 'Une aventure dans le Far West en monde ouvert.', 'https://cdn.akamai.steamstatic.com/steam/apps/1174180/header.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-01 23:46:06'),
(9, 'PUBG: Battlegrounds', 'Battle Royale', 16, 'PUBG Corporation', 'PC', 29.99, 170, 4.3, '2017-12-20', 'Le jeu de battle royale qui a lancé la tendance.', 'https://cdn.akamai.steamstatic.com/steam/apps/578080/header.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-01 23:46:06'),
(10, 'Hades', 'Roguelike', 12, 'Supergiant Games', 'PC', 24.99, 80, 4.8, '2020-09-17', 'Un jeu de combat roguelike dans le monde des enfers.', 'https://cdn.akamai.steamstatic.com/steam/apps/1145360/header.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-01 23:46:06'),
(11, 'Fall Guys: Ultimate Knockout', 'Party', 3, 'Mediatonic', 'PC', 19.99, 150, 4, '2020-08-04', 'Un jeu de plateforme multijoueur coloré et amusant.', 'https://cdn.akamai.steamstatic.com/steam/apps/1097150/header.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-01 23:46:06'),
(12, 'Grand Theft Auto V', 'Action', 18, 'Rockstar Games', 'PC', 29.99, 250, 4.8, '2015-04-14', 'Un jeu d\'action en monde ouvert avec une histoire captivante.', 'https://cdn.akamai.steamstatic.com/steam/apps/271590/header.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-01 23:46:06'),
(13, 'Hollow Knight', 'Aventure', 7, 'Team Cherry', 'PC', 14.99, 110, 4.7, '2017-02-24', 'Un jeu de plateforme aventure dans un monde souterrain.', 'https://cdn.akamai.steamstatic.com/steam/apps/367520/header.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-01 23:46:06'),
(14, 'Dark Souls III', 'RPG', 16, 'FromSoftware', 'PC', 59.99, 70, 4.6, '2016-04-12', 'Un RPG difficile et gratifiant dans un univers sombre.', 'https://cdn.akamai.steamstatic.com/steam/apps/374320/header.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-01 23:46:06'),
(15, 'Terraria', 'Sandbox', 12, 'Re-Logic', 'PC', 9.99, 300, 4.5, '2011-05-16', 'Un jeu sandbox en 2D avec exploration et construction.', 'https://cdn.akamai.steamstatic.com/steam/apps/105600/header.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-01 23:46:06'),
(16, 'Rust', 'Survie', 16, 'Facepunch Studios', 'PC', 34.99, 80, 4.1, '2018-02-08', 'Un jeu de survie multijoueur en monde ouvert.', 'https://cdn.akamai.steamstatic.com/steam/apps/252490/header.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-01 23:46:06'),
(17, 'Assassin\'s Creed Valhalla', 'Action', 18, 'Ubisoft', 'PC', 59.99, 90, 4.3, '2020-11-10', 'Un jeu d\'action historique dans le monde des Vikings.', 'https://cdn.akamai.steamstatic.com/steam/apps/1222730/header.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-01 23:46:06'),
(18, 'Left 4 Dead 2', 'FPS', 18, 'Valve', 'PC', 9.99, 200, 4.4, '2009-11-17', 'Un FPS coopératif contre des zombies.', 'https://cdn.akamai.steamstatic.com/steam/apps/550/header.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-01 23:46:06'),
(19, 'FIFA 21', 'Sport', 3, 'Electronic Arts', 'PC', 59.99, 150, 3.9, '2020-10-06', 'Le jeu de football populaire avec des mises à jour annuelles.', 'https://cdn.akamai.steamstatic.com/steam/apps/1313860/header.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-01 23:46:06'),
(20, 'The Elder Scrolls V: Skyrim', 'RPG', 18, 'Bethesda', 'PC', 39.99, 100, 4.9, '2011-11-11', 'Un RPG en monde ouvert dans l\'univers de Tamriel.', 'https://cdn.akamai.steamstatic.com/steam/apps/72850/header.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-01 23:46:06'),
(22, 'Bleach', 'Action / Aventure', 12, 'Pierrot', '0', 49.99, 500, 0, NULL, NULL, 'https://www.hindustantimes.com/ht-img/img/2023/04/12/1600x900/Bleach_Tite_Kubo_1681318581666_1681318624861_1681318624861.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-02 00:03:35'),
(24, 'Elden Ring', 'Aventure', 16, 'Bandai Namco ', '0', 39.99, 250, 0, NULL, NULL, 'https://lebetatesteur.ca/wp-content/uploads/2022/03/elden-ring-key-art-1271785.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-02 09:46:15');

-- --------------------------------------------------------

--
-- Structure de la table `game_keys`
--

CREATE TABLE `game_keys` (
  `key_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `game_key` varchar(255) NOT NULL,
  `purchase_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `newsletter_history`
--

CREATE TABLE `newsletter_history` (
  `newsletter_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `send_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `newsletter_history`
--

INSERT INTO `newsletter_history` (`newsletter_id`, `subject`, `content`, `send_date`) VALUES
(1, 'test', 'ceco est un test ', '2024-11-21 14:41:30');

-- --------------------------------------------------------

--
-- Structure de la table `newsletter_subscribers`
--

CREATE TABLE `newsletter_subscribers` (
  `subscriber_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subscription_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `newsletter_subscribers`
--

INSERT INTO `newsletter_subscribers` (`subscriber_id`, `email`, `subscription_date`) VALUES
(1, 'wyll509@gmail.com', '2024-11-21 14:08:23'),
(2, 'test@gmail.com', '2024-11-25 20:18:30');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` timestamp NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL,
  `statut` varchar(20) DEFAULT 'En cours'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `id_verification` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `verification_token` varchar(64) DEFAULT NULL,
  `is_verified_mail` tinyint(1) DEFAULT 0,
  `session_token` varchar(64) DEFAULT NULL,
  `confirm_password` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT 'default_profile.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `first_name`, `last_name`, `age`, `address`, `id_verification`, `is_verified`, `verification_token`, `is_verified_mail`, `session_token`, `confirm_password`, `profile_pic`) VALUES
(19, 'test', 'alt.n1-1315009@yopmail.com', '$2y$10$gODsh/5HDE9PR.PTkq5h3ePXTnDYEL5PBhjd4SAxtO9rjSL3Vv3WW', 'test', 'test', 15, 'test', NULL, 1, NULL, 1, NULL, NULL, 'default_profile.jpg'),
(22, 'FUDJI', 'Wyll509@gmail.com', '$2y$10$Jsst5fsZKu6ojNQ1q/RwyeaiIICnn6x8dF9bIeFbYia4qa025W/ty', 'Wyllem', 'Ethou-Pierre', 20, '78 test avenue test villetest', NULL, 1, NULL, 1, NULL, NULL, 'default_profile.jpg'),
(26, 'LMN', 'laymax93@gmail.com', '$2y$10$ISFeI7/Gi.4hwHlws1Yf4uxbZ30wqVIHHAW/YemWixW/kXf/fCeJ6', 'Lamine', 'Sane', 21, 'Rue Jean Claude Vandame', NULL, 1, NULL, 1, NULL, NULL, 'default_profile.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `game_id` (`game_id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `game_id` (`game_id`);

--
-- Index pour la table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`game_id`);

--
-- Index pour la table `game_keys`
--
ALTER TABLE `game_keys`
  ADD PRIMARY KEY (`key_id`),
  ADD UNIQUE KEY `game_key` (`game_key`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `newsletter_history`
--
ALTER TABLE `newsletter_history`
  ADD PRIMARY KEY (`newsletter_id`);

--
-- Index pour la table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  ADD PRIMARY KEY (`subscriber_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `game_id` (`game_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `games`
--
ALTER TABLE `games`
  MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `game_keys`
--
ALTER TABLE `game_keys`
  MODIFY `key_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `newsletter_history`
--
ALTER TABLE `newsletter_history`
  MODIFY `newsletter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  MODIFY `subscriber_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `games` (`game_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `games` (`game_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `game_keys`
--
ALTER TABLE `game_keys`
  ADD CONSTRAINT `game_keys_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`game_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `game_keys_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `games` (`game_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
