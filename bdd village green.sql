-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 29 avr. 2020 à 17:26
-- Version du serveur :  5.7.24
-- Version de PHP : 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `villagegreen`
--

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `livraisonEnCours` ()  BEGIN
SELECT * from commandes where com_obs = 'En cours de livraison';
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `accorder_remise`
--

CREATE TABLE `accorder_remise` (
  `id` int(11) NOT NULL,
  `commandes_id` int(11) NOT NULL,
  `personnels_id` int(11) DEFAULT NULL,
  `montant_remise` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `com_date` datetime NOT NULL,
  `com_obs` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `type_paiement` tinyint(1) NOT NULL,
  `com_adresse_livraison` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id`, `client_id`, `com_date`, `com_obs`, `user_id`, `type_paiement`, `com_adresse_livraison`) VALUES
(1, 1, '2020-04-29 18:48:24', 'En cours de traitement', 1, 1, '3 rue du nether 97E2TD minecraft'),
(2, 2, '2020-04-29 19:03:53', 'En cours de livraison', 2, 1, '123 avenue louis blanc 80000 Amiens');

-- --------------------------------------------------------

--
-- Structure de la table `fournir`
--

CREATE TABLE `fournir` (
  `id` int(11) NOT NULL,
  `fournisseurs_id` int(11) NOT NULL,
  `produits_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fournisseurs`
--

CREATE TABLE `fournisseurs` (
  `id` int(11) NOT NULL,
  `four_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `four_phone` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `four_email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `four_adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `gerer`
--

CREATE TABLE `gerer` (
  `id` int(11) NOT NULL,
  `clients_id` int(11) NOT NULL,
  `personnels_id` int(11) NOT NULL,
  `coefficient_commercial` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `gerer_pro_per`
--

CREATE TABLE `gerer_pro_per` (
  `id` int(11) NOT NULL,
  `produits_id` int(11) DEFAULT NULL,
  `personnels_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ligne_commandes`
--

CREATE TABLE `ligne_commandes` (
  `id` int(11) NOT NULL,
  `commandes_id` int(11) NOT NULL,
  `lig_quantite` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ligne_commandes`
--

INSERT INTO `ligne_commandes` (`id`, `commandes_id`, `lig_quantite`, `produit_id`) VALUES
(1, 1, 5, 1);

--
-- Déclencheurs `ligne_commandes`
--
DELIMITER $$
CREATE TRIGGER `update_stock` AFTER INSERT ON `ligne_commandes` FOR EACH ROW begin 
declare	id_pro int;
declare quantite int;
declare quantite_de_base int;
set id_pro =new.produit_id ;
set quantite = new.lig_quantite;
set quantite_de_base = (SELECT pro_stock FROM produits where produits.id = id_pro);
If quantite > quantite_de_base THEN 
SIGNAL SQLSTATE '40000' SET MESSAGE_TEXT = 'Pas assez de stock restant pour le nombre de produits désirés' ;
ELSE 
UPDATE produits SET pro_stock = (quantite_de_base - quantite) WHERE produits.id = id_pro;
END IF ;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `livraison`
--

CREATE TABLE `livraison` (
  `id` int(11) NOT NULL,
  `ligne_commandes_id` int(11) NOT NULL,
  `liv_date` datetime NOT NULL,
  `liv_quantite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personnel`
--

CREATE TABLE `personnel` (
  `id` int(11) NOT NULL,
  `per_matricule` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `per_service` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` int(11) NOT NULL,
  `rubriques_id` int(11) DEFAULT NULL,
  `pro_libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pro_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pro_ref` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pro_prix` int(11) NOT NULL,
  `pro_photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pro_ajout` date NOT NULL,
  `pro_stock` int(11) NOT NULL,
  `pro_stock_alert` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `rubriques_id`, `pro_libelle`, `pro_description`, `pro_ref`, `pro_prix`, `pro_photo`, `pro_ajout`, `pro_stock`, `pro_stock_alert`) VALUES
(1, 1, 'L\'ensorcèlement des armes pour les nuls', 'tout est dans le titre', '063HI9DVY', 39, 'efgilf', '2020-04-29', 10, 5);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `profour`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `profour` (
`four_name` varchar(255)
,`fournisseurs_id` int(11)
,`produits_id` int(11)
,`pro_libelle` varchar(255)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `prorue`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `prorue` (
`pro_libelle` varchar(255)
,`rub_libelle` varchar(255)
);

-- --------------------------------------------------------

--
-- Structure de la table `rubrique`
--

CREATE TABLE `rubrique` (
  `id` int(11) NOT NULL,
  `rub_libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `rubrique`
--

INSERT INTO `rubrique` (`id`, `rub_libelle`) VALUES
(1, 'livre de sortilèges');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_role` smallint(6) NOT NULL,
  `user_firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_phone` int(11) NOT NULL,
  `user_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_ref` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` tinyint(1) NOT NULL,
  `user_adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_date_inscription` date NOT NULL,
  `user_coef` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `user_name`, `user_password`, `user_role`, `user_firstname`, `user_phone`, `user_email`, `user_ref`, `user_type`, `user_adresse`, `user_date_inscription`, `user_coef`) VALUES
(1, 'Dominique', 'coucou', 1, 'Patrick', 605040302, 'patrickdominique@bibliothèque.fr', 'chef du village', 1, '3 rue du nether 13DSWWX minecraft', '2020-04-29', 9),
(2, 'Dominique', 'coucou', 2, 'Patrick', 605040302, 'patrickdominique@bibliothèque.fr', 'chef du village', 1, '3 rue du nether 13DSWWX minecraft', '2020-04-29', 9);

-- --------------------------------------------------------

--
-- Structure de la vue `profour`
--
DROP TABLE IF EXISTS `profour`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `profour`  AS  select `fournisseurs`.`four_name` AS `four_name`,`fournir`.`fournisseurs_id` AS `fournisseurs_id`,`fournir`.`produits_id` AS `produits_id`,`produits`.`pro_libelle` AS `pro_libelle` from ((`fournir` join `fournisseurs` on(`fournir`.`fournisseurs_id`)) join `produits` on(`fournir`.`produits_id`)) ;

-- --------------------------------------------------------

--
-- Structure de la vue `prorue`
--
DROP TABLE IF EXISTS `prorue`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `prorue`  AS  select `produits`.`pro_libelle` AS `pro_libelle`,`rubrique`.`rub_libelle` AS `rub_libelle` from (`produits` join `rubrique` on(`rubrique`.`id`)) ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `accorder_remise`
--
ALTER TABLE `accorder_remise`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C6B3C2F38BF5C2E6` (`commandes_id`),
  ADD KEY `IDX_C6B3C2F3C7022806` (`personnels_id`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_35D4282C19EB6921` (`client_id`);

--
-- Index pour la table `fournir`
--
ALTER TABLE `fournir`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_34D13A5227ACDDFD` (`fournisseurs_id`),
  ADD KEY `IDX_34D13A52CD11A2CF` (`produits_id`);

--
-- Index pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `gerer`
--
ALTER TABLE `gerer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_103C68BDAB014612` (`clients_id`),
  ADD KEY `IDX_103C68BDC7022806` (`personnels_id`);

--
-- Index pour la table `gerer_pro_per`
--
ALTER TABLE `gerer_pro_per`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DF28CB88CD11A2CF` (`produits_id`),
  ADD KEY `IDX_DF28CB88C7022806` (`personnels_id`);

--
-- Index pour la table `ligne_commandes`
--
ALTER TABLE `ligne_commandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FA3127A48BF5C2E6` (`commandes_id`),
  ADD KEY `IDX_FA3127A4F347EFB` (`produit_id`);

--
-- Index pour la table `livraison`
--
ALTER TABLE `livraison`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A60C9F1F332B8229` (`ligne_commandes_id`);

--
-- Index pour la table `personnel`
--
ALTER TABLE `personnel`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_BE2DDF8C589A0FBB` (`rubriques_id`);

--
-- Index pour la table `rubrique`
--
ALTER TABLE `rubrique`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `accorder_remise`
--
ALTER TABLE `accorder_remise`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `fournir`
--
ALTER TABLE `fournir`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `gerer`
--
ALTER TABLE `gerer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `gerer_pro_per`
--
ALTER TABLE `gerer_pro_per`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ligne_commandes`
--
ALTER TABLE `ligne_commandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `livraison`
--
ALTER TABLE `livraison`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `personnel`
--
ALTER TABLE `personnel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `rubrique`
--
ALTER TABLE `rubrique`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `accorder_remise`
--
ALTER TABLE `accorder_remise`
  ADD CONSTRAINT `FK_C6B3C2F38BF5C2E6` FOREIGN KEY (`commandes_id`) REFERENCES `commandes` (`id`),
  ADD CONSTRAINT `FK_C6B3C2F3C7022806` FOREIGN KEY (`personnels_id`) REFERENCES `personnel` (`id`);

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `FK_35D4282C19EB6921` FOREIGN KEY (`client_id`) REFERENCES `utilisateurs` (`id`);

--
-- Contraintes pour la table `fournir`
--
ALTER TABLE `fournir`
  ADD CONSTRAINT `FK_34D13A5227ACDDFD` FOREIGN KEY (`fournisseurs_id`) REFERENCES `fournisseurs` (`id`),
  ADD CONSTRAINT `FK_34D13A52CD11A2CF` FOREIGN KEY (`produits_id`) REFERENCES `produits` (`id`);

--
-- Contraintes pour la table `gerer`
--
ALTER TABLE `gerer`
  ADD CONSTRAINT `FK_103C68BDAB014612` FOREIGN KEY (`clients_id`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `FK_103C68BDC7022806` FOREIGN KEY (`personnels_id`) REFERENCES `personnel` (`id`);

--
-- Contraintes pour la table `gerer_pro_per`
--
ALTER TABLE `gerer_pro_per`
  ADD CONSTRAINT `FK_DF28CB88C7022806` FOREIGN KEY (`personnels_id`) REFERENCES `personnel` (`id`),
  ADD CONSTRAINT `FK_DF28CB88CD11A2CF` FOREIGN KEY (`produits_id`) REFERENCES `produits` (`id`);

--
-- Contraintes pour la table `ligne_commandes`
--
ALTER TABLE `ligne_commandes`
  ADD CONSTRAINT `FK_FA3127A48BF5C2E6` FOREIGN KEY (`commandes_id`) REFERENCES `commandes` (`id`),
  ADD CONSTRAINT `FK_FA3127A4F347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`);

--
-- Contraintes pour la table `livraison`
--
ALTER TABLE `livraison`
  ADD CONSTRAINT `FK_A60C9F1F332B8229` FOREIGN KEY (`ligne_commandes_id`) REFERENCES `ligne_commandes` (`id`);

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `FK_BE2DDF8C589A0FBB` FOREIGN KEY (`rubriques_id`) REFERENCES `rubrique` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
