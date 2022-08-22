-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : sam. 20 août 2022 à 19:25
-- Version du serveur :  5.7.34
-- Version de PHP : 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `grocery_bdd`
--

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `pid`, `name`, `price`, `quantity`, `image`) VALUES
(1, 8, 58, 'Red Bull blue', 3, 1, 'redbullbleu.jpeg'),
(2, 8, 53, 'Coca-cola cerise', 3, 1, 'canettecocacerise50cl.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `order_status` varchar(20) DEFAULT 'processing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `order_status`) VALUES
(1, 8, 'John Doe', '555654213', 'johndoe@gmail.fr', 'paypal', 'flat no. 21 street McChicken   New-York  USA - 21345', ', Red Bull original ( 1 ), Dao pastèque ( 1 ), Milka biscuit étoile ( 1 ), M&amp;Ms choco ( 1 ),  DOOMINO ( 1 ), Dragibus ( 1 )', 25, '25-Jul-2022', 'processing');

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(20) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` float NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `details`, `price`, `image`) VALUES
(53, 'Coca-cola cerise', 'boisson', 'Coca-cola gout cerise', 2.7, 'canettecocacerise50cl.jpeg'),
(54, 'Coca-cola', 'boisson', 'Coca-cola', 2, 'coca50cl.jpeg'),
(55, 'Dao pastèque', 'boisson', 'Dao saveur pastèque', 3, 'daopasteque290ml.jpeg'),
(56, 'Ice-tea peche', 'boisson', 'Ice-tea peche', 2.5, 'iceteapeache33cl.jpeg'),
(57, 'Red Bull original', 'boisson', 'Red Bull original', 3, 'redbulloriginal.jpeg'),
(58, 'Red Bull blue', 'boisson', 'Red Bull saveur myrtille', 3, 'redbullbleu.jpeg'),
(59, 'Red Bull Red', 'boisson', 'Red Bull pastèque', 3, 'redbullrouge.jpeg'),
(61, 'Haribo schtroumpf', 'bonbon', 'Bonbon Haribo schtroumpf', 3, 'haribo shtroumpf.jpeg'),
(62, 'Dragibus', 'bonbon', 'boite haribo dragibus', 10, 'Haribo boite dragi.jpeg'),
(63, 'Fraise Tagada', 'bonbon', 'Haribo Fraise tagada', 2, 'Haribo fraises.jpeg'),
(64, 'Cola', 'bonbon', 'Haribo cola', 2, 'Haribo coca.jpeg'),
(65, 'Milka biscuit étoile', 'gateaux', 'Milka biscuit étoile au lait', 3, 'etoile milka.jpeg'),
(67, 'Olive', 'aperitif', 'Olive orientale', 3, 'olive.jpeg'),
(68, 'Cookie coeur caramel', 'gateaux', 'Milka Cookie coeur caramel', 4, 'milkacookies.jpeg'),
(69, 'Pringles boeuf', 'aperitif', 'Pringles boeuf', 3, 'chips.jpeg'),
(70, 'Chips vinaigre', 'aperitif', 'Chips vinaigre', 3, 'chips 2.jpeg'),
(72, 'ChupaChups cerise', 'boisson', 'chupa chups cerise', 3, 'chupachupscerise.jpeg'),
(73, '7up mojito', 'boisson', '7up gout mojito', 2, '7upmojito.jpeg'),
(74, 'Reese\'s ', 'gateaux', 'Reese\'s original', 3, 'reeses.jpeg'),
(75, 'M&amp;Ms', 'gateaux', 'M&amp;Ms original', 3, 'm&ms.png'),
(76, 'M&amp;Ms choco', 'gateaux', 'M&amp;Ms tout chocolat', 4, 'm&msmarron.png'),
(77, 'M&amp;Ms brownies', 'gateaux', 'M&amp;Ms gout brownies', 4.5, 'm&msviolet.jpeg'),
(78, 'DESPERADOS', 'alcool', 'BIERE AROMATISEE TEQUILA', 2.49, 'desperados.jpeg'),
(79, ' DESPERADOS RED', 'alcool', 'BIERE AROME TEQUIILA', 3, 'deperados red.jpeg'),
(80, 'DESPERADOS Mojito', 'alcool', 'BIERE AROME MOJITOS ', 4, 'desperados moji.jpeg'),
(81, ' HEINEKEN', 'alcool', 'BIERE BLONDE 65CL', 3, 'HK.jpeg'),
(82, '1664', 'alcool', 'BIERE BLONDE 12X25CL', 10, '1964.jpeg'),
(83, 'Bebeto cable acide', 'bonbon', 'Bebeto cable acidulé fruité', 2, 'Cable acide.jpeg'),
(84, 'Bebeto géant', 'bonbon', 'Bebeto géant', 4, 'Cable geant.jpeg'),
(86, 'Biscuit Nutella ', 'gateaux', 'x12 ', 3, 'nutella.jpeg'),
(87, 'Quadro', 'gateaux', 'BISCUITS GAUFRETTES PRALINE', 4, 'quadro.jpeg'),
(88, ' DOOMINO', 'gateaux', 'BISCUITS DOOMINO CHOCOLAT ', 2, 'doomino.jpeg'),
(89, 'GALETTE AU BEURRE', 'gateaux', 'GALETTE AU BEURRE', 3, 'galette beurre.jpeg'),
(90, 'Gobelet ', 'autres', 'Gobelet carton x12', 2, 'gobelet.jpeg'),
(91, 'Tire bouchon', 'autres', 'Tire bouchon', 10, 'tire bouchon.jpeg'),
(92, 'MINI BATON DE BERGER ', 'aperitif', 'NOISETTES', 3, 'helouf.jpeg'),
(93, 'PISTACHES SALEES', 'aperitif', 'PISTACHES SALEES - BORGES', 4, 'pistache.jpeg'),
(94, ' MINI CRACKERS', 'aperitif', 'BISCUITS APERITIFS', 2, 'crackers.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `image`) VALUES
(7, 'tata', 'tata@outlook.fr', 'tata', 'admin', 'bouteillevinrouge stemilion.jpeg'),
(8, 'test', 'test@gmail.com', 'test', 'user', 'bananas-gebb56ae63_640.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `pid`, `name`, `price`, `image`) VALUES
(1, 8, 54, 'Coca-cola', 2, 'coca50cl.jpeg'),
(2, 8, 55, 'Dao pastèque', 3, 'daopasteque290ml.jpeg'),
(3, 8, 57, 'Red Bull original', 3, 'redbulloriginal.jpeg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
