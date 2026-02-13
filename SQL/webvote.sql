SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `webvote`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(7, 'Autres'),
(5, 'Culture'),
(2, 'Éducation'),
(1, 'Environnement'),
(3, 'Santé'),
(6, 'Technologie'),
(4, 'Transport');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `petition_id` int NOT NULL,
  `user_id` int NOT NULL,
  `content` text NOT NULL,
  `status` enum('VISIBLE','HIDDEN') NOT NULL DEFAULT 'VISIBLE',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `petition_id`, `user_id`, `content`, `status`, `created_at`) VALUES
(1, 1, 1, 'W', 'VISIBLE', '2026-02-13 15:18:14'),
(3, 1, 2, 'w', 'VISIBLE', '2026-02-13 16:22:03'),
(4, 1, 3, 'w', 'VISIBLE', '2026-02-13 16:22:55');

-- --------------------------------------------------------

--
-- Structure de la table `petitions`
--

CREATE TABLE `petitions` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `category_id` int NOT NULL,
  `title` varchar(160) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `goal_signatures` int NOT NULL DEFAULT '100',
  `status` enum('DRAFT','PUBLISHED','HIDDEN','CLOSED') NOT NULL DEFAULT 'PUBLISHED',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `petitions`
--

INSERT INTO `petitions` (`id`, `user_id`, `category_id`, `title`, `description`, `image`, `goal_signatures`, `status`, `created_at`) VALUES
(1, 1, 3, 'Pause café obligatoire toutes les 2 heures', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'public/uploads/petitions/a600b26fefe232b349fc0ffcfe29d75e.jpg', 10, 'PUBLISHED', '2026-02-13 15:17:24'),
(2, 2, 1, 'Moins de plastique inutile', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', 'public/uploads/petitions/d46cd16b7abb8140e942c2474728a12f.jpg', 100, 'PUBLISHED', '2026-02-13 15:56:23'),
(3, 2, 3, 'Un rendez-vous sans attendre des mois', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', 'public/uploads/petitions/5e719bddf792c31153589369747aa241.png', 50, 'PUBLISHED', '2026-02-13 15:59:35'),
(4, 2, 4, 'Des trains vraiment à l’heure', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', 'public/uploads/petitions/14a11146db5e92cba16836803b4a4de1.jpg', 99, 'PUBLISHED', '2026-02-13 16:05:33');

-- --------------------------------------------------------

--
-- Structure de la table `signatures`
--

CREATE TABLE `signatures` (
  `id` int NOT NULL,
  `petition_id` int NOT NULL,
  `user_id` int NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `signatures`
--

INSERT INTO `signatures` (`id`, `petition_id`, `user_id`, `created_at`) VALUES
(2, 1, 1, '2026-02-13 15:22:13'),
(3, 2, 2, '2026-02-13 15:57:34'),
(4, 4, 3, '2026-02-13 16:23:12'),
(5, 1, 3, '2026-02-13 16:23:16'),
(6, 2, 3, '2026-02-13 16:23:25');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` enum('USER','ADMIN') NOT NULL DEFAULT 'USER',
  `status` enum('ACTIVE','BANNED') NOT NULL DEFAULT 'ACTIVE',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `email`, `password`, `avatar`, `role`, `status`, `created_at`) VALUES
(1, 'admin', 'admin@mail.fr', '$2y$10$EZRj00OOH0eQw/JSM8tu9O/3FICBAIud6FBbSmzSrwb9V2pyG2UAm', NULL, 'ADMIN', 'ACTIVE', '2026-02-13 15:05:35'),
(2, 'Max', 'max@mail.fr', '$2y$10$9ExFHagV7ovCNs2OOOFCKeod5xqFJ7Qnukuj6PPXhDNOjtdyj28wW', 'public/uploads/avatars/ad4ad6a9ed800fe3588420a01cd3677f.webp', 'USER', 'ACTIVE', '2026-02-13 15:45:15'),
(3, 'John', 'john@mail.fr', '$2y$10$gcrqlR9v01KxnGW/H/cmg.OegcoqgEFaLUIUryKd5tl571YVUaAY.', NULL, 'USER', 'ACTIVE', '2026-02-13 16:22:50');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comments_petition` (`petition_id`),
  ADD KEY `fk_comments_user` (`user_id`);

--
-- Index pour la table `petitions`
--
ALTER TABLE `petitions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_petitions_user` (`user_id`),
  ADD KEY `fk_petitions_category` (`category_id`);

--
-- Index pour la table `signatures`
--
ALTER TABLE `signatures`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_signature` (`petition_id`,`user_id`),
  ADD KEY `fk_signatures_user` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `petitions`
--
ALTER TABLE `petitions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `signatures`
--
ALTER TABLE `signatures`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_petition` FOREIGN KEY (`petition_id`) REFERENCES `petitions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_comments_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `petitions`
--
ALTER TABLE `petitions`
  ADD CONSTRAINT `fk_petitions_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `fk_petitions_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `signatures`
--
ALTER TABLE `signatures`
  ADD CONSTRAINT `fk_signatures_petition` FOREIGN KEY (`petition_id`) REFERENCES `petitions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_signatures_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
