-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 10 oct. 2024 à 08:57
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_restoweb`
--
CREATE DATABASE IF NOT EXISTS `db_restoweb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `db_restoweb`;

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id_commande` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_etat` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `total_commande` decimal(10,2) NOT NULL DEFAULT 0.00,
  `type_conso` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_commande`, `id_user`, `id_etat`, `date`, `total_commande`, `type_conso`) VALUES
(6, 8, 1, '2023-11-30 16:58:27', 35.87, 1),
(7, 8, 1, '2023-11-30 16:59:36', 37.40, 2),
(8, 8, 1, '2023-11-30 17:02:05', 35.87, 1);

-- --------------------------------------------------------

--
-- Structure de la table `ligne`
--

CREATE TABLE `ligne_commande` (
  `id_ligne` int(11) NOT NULL,
  `id_commande` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `qte` int(11) NOT NULL DEFAULT 0,
  `total_ligne_ht` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `ligne`
--

INSERT INTO `ligne` (`id_ligne`, `id_commande`, `id_produit`, `qte`, `total_ligne_ht`) VALUES
(17, 6, 3, 1, 12.50),
(18, 6, 2, 1, 14.00),
(19, 6, 5, 1, 7.50),
(20, 7, 3, 1, 12.50),
(21, 7, 2, 1, 14.00),
(22, 7, 5, 1, 7.50),
(23, 8, 3, 1, 12.50),
(24, 8, 2, 1, 14.00),
(25, 8, 5, 1, 7.50);

DELIMITER |

CREATE TRIGGER `before_ligne_insert` 
BEFORE INSERT ON `ligne_commande`
FOR EACH ROW 
BEGIN
    DECLARE prix_ht DECIMAL(10, 2);
    
    -- Récupérer le prix HT du produit
    SELECT p.prix_ht 
    INTO prix_ht 
    FROM produit p 
    WHERE p.id_produit = NEW.id_produit;

    -- Vérifier si le prix HT a été trouvé
    IF prix_ht IS NULL THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Produit non trouvé ou prix hors taxes non défini.';
    ELSE
        -- Calculer le total ligne HT
        SET NEW.total_ligne_ht = COALESCE(prix_ht, 0) * NEW.qte;
    END IF;

    -- Vérifier si la quantité est positive
    IF NEW.qte <= 0 THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'La quantité doit être supérieure à zéro.';
    END IF;
END |
DELIMITER ;


DELIMITER |
CREATE TRIGGER `before_ligne_update` 
BEFORE UPDATE ON `ligne_commande`
FOR EACH ROW 
BEGIN
    DECLARE prix_ht DECIMAL(10, 2); -- Déclaration d'une variable locale pour le prix HT

    -- Récupérer le prix HT du produit
    SELECT p.prix_ht 
    INTO prix_ht 
    FROM produit p 
    WHERE p.id_produit = NEW.id_produit;

    -- Vérifier si le prix HT a été trouvé
    IF prix_ht IS NULL THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Produit non trouvé ou prix hors taxes non défini.';
    ELSE
        -- Calculer le total ligne HT
        SET NEW.total_ligne_ht = COALESCE(prix_ht, 0) * NEW.qte;
    END IF;

    -- Vérifier si la quantité est positive
    IF NEW.qte <= 0 THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'La quantité doit être supérieure à zéro.';
    END IF;

END |
DELIMITER ;


DELIMITER |
CREATE TRIGGER `after_ligne_insert` 
AFTER INSERT ON `ligne_commande`
FOR EACH ROW 
BEGIN
    DECLARE total_commande DECIMAL(10, 2) DEFAULT 0;
    DECLARE type_conso INT DEFAULT 0;
    DECLARE tva DECIMAL(3, 3) DEFAULT 0;

    -- Récupérer le type de consommation
    SELECT c.type_conso 
    INTO type_conso 
    FROM commande c 
    WHERE c.id_commande = NEW.id_commande;

    -- Déterminer le taux de TVA
    IF type_conso = 1 THEN 
        SET tva = 1.055; 
    ELSEIF type_conso = 2 THEN 
        SET tva = 1.1; 
    END IF;

    -- Calculer le total HT des lignes de la commande
    SELECT COALESCE(SUM(total_ligne_ht), 0) 
    INTO total_commande 
    FROM ligne_commande 
    WHERE id_commande = NEW.id_commande;

    -- Calculer le total TTC
    SET total_commande = total_commande * tva;

    -- Mettre à jour le total de la commande
    UPDATE commande 
    SET total_commande = total_commande 
    WHERE id_commande = NEW.id_commande;
END |
DELIMITER ;


DELIMITER |
CREATE TRIGGER `after_ligne_update` 
AFTER UPDATE ON `ligne_commande` 
FOR EACH ROW 
BEGIN
    DECLARE total_commande DECIMAL(10, 2) DEFAULT 0;
    DECLARE type_conso INT DEFAULT 0;
    DECLARE tva DECIMAL(3, 3) DEFAULT 0;

    -- Récupérer le type de consommation
    SELECT c.type_conso 
    INTO type_conso 
    FROM commande c 
    WHERE c.id_commande = NEW.id_commande;

    -- Déterminer le taux de TVA
    IF type_conso = 1 THEN 
        SET tva = 1.055; 
    ELSEIF type_conso = 2 THEN 
        SET tva = 1.1; 
    END IF;

    -- Calculer le total HT des lignes de la commande
    SELECT COALESCE(SUM(total_ligne_ht), 0) 
    INTO total_commande 
    FROM ligne_commande 
    WHERE id_commande = NEW.id_commande;

    -- Calculer le total TTC
    SET total_commande = total_commande * tva;

    -- Mettre à jour le total de la commande
    UPDATE commande 
    SET total_commande = total_commande 
    WHERE id_commande = NEW.id_commande;
END |
DELIMITER ;

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id_produit` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `prix_ht` decimal(10,2) NOT NULL,
  `imageUrl` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `libelle`, `prix_ht`, `imageUrl`) VALUES
(1, 'pizza Margherita', 12.50, 'https://img.passeportsante.net/1200x675/2022-09-23/shutterstock-2105210927.webp'),
(2, 'pizza Chorizo', 14.00, 'https://www.galbani.fr/wp-content/uploads/2017/07/Image7.jpg'),
(3, 'assiette de charcuterie', 12.50, 'https://www.passionculinaire.fr/wp-content/uploads/2021/09/charcuterie-conseils.jpg'),
(4, 'assiette de fromages', 10.50, 'https://cache.marieclaire.fr/data/photo/w999_c17/cuisine/43/fromages1.jpg'),
(5, 'hamburger viande', 7.50, 'https://www.la-viande.fr/sites/default/files/inline-images/hamburger.jpg'),
(6, 'hamburger vegan', 9.00, 'https://violifefoods.com/wp-content/uploads/2020/12/vegan-spicy-burger-1920x850.jpg'),
(7, 'hot dog', 5.00, 'https://www.lidl-recettes.fr/var/site/storage/images/_aliases/960x540/3/1/6/2/2592613-1-fre-FR/Prospectus-S41_Hot-dog-bacon.jpg'),
(8, 'empanadas poulet', 11.00, 'https://www.enviedebienmanger.fr/sites/default/files/styles/img_orig/public/2020-12/68_1.png?itok=lfzsdW9K'),
(9, 'empanadas thon', 9.00, 'https://www.seb.fr/medias/?context=bWFzdGVyfHJvb3R8NDQ4ODh8aW1hZ2UvanBlZ3xoM2YvaDI0LzE2NDgwMTYzMzk3NjYyLmpwZ3wzYTRjYWI3OTFkYjE5ZGFhODQ4MGZkMThiNDI3Njc3MTQ3MWE3OTkwYTc3MTYwYjc1YTI4ZGU5NjgyZTAzZGU4'),
(10, 'portion de frites', 5.00, 'https://brigade-hocare.com/info/wp-content/uploads/2022/10/portion-de-frites.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `login`, `password`, `email`) VALUES
(1, 'jef', '$2y$10$OPEElGC0F4PghGraYRFl7OmH57cnVWvApKYF/oWDRmEkj8PVhiwBu', 'jef@m2l.fr'),
(8, 'test', '$2y$10$wgYsVsexeJHE0Bitxz2OXuzvyGZEhEZdYoR/cxS02SnRkkCmLrxxa', 'test@test.fr'),
(10, '', '$2y$10$ZjmEtsUSjb4S4Z.OYC1XhOwDRoGd81LgxG0D/m4nNft5rh.HcAHTS', 'test2@test.fr');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_etat` (`id_etat`);

--
-- Index pour la table `ligne`
--
ALTER TABLE `ligne`
  ADD PRIMARY KEY (`id_ligne`),
  ADD KEY `id_commande` (`id_commande`),
  ADD KEY `id_produit` (`id_produit`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id_produit`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `ligne`
--
ALTER TABLE `ligne`
  MODIFY `id_ligne` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id_produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Contraintes pour la table `ligne`
--
ALTER TABLE `ligne`
  ADD CONSTRAINT `ligne_ibfk_1` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id_commande`),
  ADD CONSTRAINT `ligne_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id_produit`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;