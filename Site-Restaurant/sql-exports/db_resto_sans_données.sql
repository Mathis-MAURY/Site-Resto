SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET time_zone = "+00:00";

-- Base de données : `db_restoweb`
CREATE DATABASE IF NOT EXISTS `db_restoweb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE `db_restoweb`;

-- --------------------------------------------------------

-- Structure de la table `commande`
CREATE TABLE `commande` (
    `id_commande` INT(11) NOT NULL,
    `id_user` INT(11) NOT NULL,
    `id_etat` INT(11) NOT NULL,
    `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    `total_commande` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    `type_conso` TINYINT(1) NOT NULL,
    PRIMARY KEY (`id_commande`),
    KEY `id_user` (`id_user`),
    KEY `id_etat` (`id_etat`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Structure de la table `ligne`
CREATE TABLE `ligne` (
    `id_ligne` INT(11) NOT NULL,
    `id_commande` INT(11) NOT NULL,
    `id_produit` INT(11) NOT NULL,
    `qte` INT(11) NOT NULL DEFAULT 0,
    `total_ligne_ht` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    PRIMARY KEY (`id_ligne`),
    KEY `id_commande` (`id_commande`),
    KEY `id_produit` (`id_produit`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Structure de la table `produit`
CREATE TABLE `produit` (
    `id_produit` INT(11) NOT NULL,
    `libelle` VARCHAR(255) NOT NULL,
    `prix_ht` DECIMAL(10, 2) NOT NULL,
    `imageUrl` VARCHAR(250) NOT NULL,
    PRIMARY KEY (`id_produit`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Structure de la table `user`
CREATE TABLE `user` (
    `id_user` INT(11) NOT NULL,
    `login` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id_user`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Contraintes pour les tables
ALTER TABLE `commande`
    ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`id_user`)
    REFERENCES `user` (`id_user`);

ALTER TABLE `ligne`
    ADD CONSTRAINT `ligne_ibfk_1` FOREIGN KEY (`id_commande`)
    REFERENCES `commande` (`id_commande`),
    ADD CONSTRAINT `ligne_ibfk_2` FOREIGN KEY (`id_produit`)
    REFERENCES `produit` (`id_produit`);

COMMIT;
