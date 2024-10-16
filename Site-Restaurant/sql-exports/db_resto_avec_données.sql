-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 16 octobre. 2023 à 23:17
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
CREATE DATABASE IF NOT EXISTS `DB_RESTOWEB` DEFAULT CHARACTER SET UTF8 COLLATE UTF8_GENERAL_CI;

USE `DB_RESTOWEB`;

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `COMMANDE` (
    `ID_COMMANDE` INT(11) NOT NULL,
    `ID_USER` INT(11) NOT NULL,
    `ID_ETAT` INT(11) NOT NULL,
    `DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    `TOTAL_COMMANDE` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    `TYPE_CONSO` TINYINT(1) NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=UTF8 COLLATE=UTF8_GENERAL_CI;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `COMMANDE` (
    `ID_COMMANDE`,
    `ID_USER`,
    `ID_ETAT`,
    `DATE`,
    `TOTAL_COMMANDE`,
    `TYPE_CONSO`
) VALUES (
    6,
    8,
    1,
    '2023-11-30 16:58:27',
    35.87,
    1
),
(
    7,
    8,
    1,
    '2023-11-30 16:59:36',
    37.40,
    2
),
(
    8,
    8,
    1,
    '2023-11-30 17:02:05',
    35.87,
    1
);

--
-- Structure de la table `ligne`
--

CREATE TABLE `LIGNE` (
    `ID_LIGNE` INT(11) NOT NULL,
    `ID_COMMANDE` INT(11) NOT NULL,
    `ID_PRODUIT` INT(11) NOT NULL,
    `QTE` INT(11) NOT NULL DEFAULT 0,
    `TOTAL_LIGNE_HT` DECIMAL(10, 2) NOT NULL DEFAULT 0.00
) ENGINE=INNODB DEFAULT CHARSET=UTF8 COLLATE=UTF8_GENERAL_CI;

--
-- Déchargement des données de la table `ligne`
--

INSERT INTO `LIGNE` (
    `ID_LIGNE`,
    `ID_COMMANDE`,
    `ID_PRODUIT`,
    `QTE`,
    `TOTAL_LIGNE_HT`
) VALUES (
    17,
    6,
    3,
    1,
    12.50
),
(
    18,
    6,
    2,
    1,
    14.00
),
(
    19,
    6,
    5,
    1,
    7.50
),
(
    20,
    7,
    3,
    1,
    12.50
),
(
    21,
    7,
    2,
    1,
    14.00
),
(
    22,
    7,
    5,
    1,
    7.50
),
(
    23,
    8,
    3,
    1,
    12.50
),
(
    24,
    8,
    2,
    1,
    14.00
),
(
    25,
    8,
    5,
    1,
    7.50
);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `PRODUIT` (
    `ID_PRODUIT` INT(11) NOT NULL,
    `LIBELLE` VARCHAR(255) NOT NULL,
    `PRIX_HT` DECIMAL(10, 2) NOT NULL,
    `IMAGEURL` VARCHAR(250) NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=UTF8 COLLATE=UTF8_GENERAL_CI;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `PRODUIT` (
    `ID_PRODUIT`,
    `LIBELLE`,
    `PRIX_HT`,
    `IMAGEURL`
) VALUES (
    1,
    'pizza Margherita',
    12.50,
    'https://img.passeportsante.net/1200x675/2022-09-23/shutterstock-2105210927.webp'
),
(
    2,
    'pizza Chorizo',
    14.00,
    'https://www.galbani.fr/wp-content/uploads/2017/07/Image7.jpg'
),
(
    3,
    'assiette de charcuterie',
    12.50,
    'https://www.passionculinaire.fr/wp-content/uploads/2021/09/charcuterie-conseils.jpg'
),
(
    4,
    'assiette de fromages',
    10.50,
    'https://cache.marieclaire.fr/data/photo/w999_c17/cuisine/43/fromages1.jpg'
),
(
    5,
    'hamburger viande',
    7.50,
    'https://www.la-viande.fr/sites/default/files/inline-images/hamburger.jpg'
),
(
    6,
    'hot dog',
    5.00,
    'https://www.tastingtable.com/img/gallery/13-best-hot-dogs-in-america/l-intro-1660217636.jpg'
),
(
    7,
    'empanadas poulet',
    11.00,
    'https://www.enviedebienmanger.fr/sites/default/files/styles/img_orig/public/2020-12/68_1.png?itok=lfzsdW9K'
),
(
    8,
    'empanadas thon',
    9.00,
    'https://www.seb.fr/medias/?context=bWFzdGVyfHJvb3R8NDQ4ODh8aW1hZ2UvanBlZ3xoM2YvaDI0LzE2NDgwMTYzMzk3NjYyLmpwZ3wzYTRjYWI3OTFkYjE5ZGFhODQ4MGZkMThiNDI3Njc3MTQ3MWE3OTkwYTc3MTYwYjc1YTI4ZGU5NjgyZTAzZGU4'
),
(
    9,
    'portion de frites',
    5.00,
    'https://brigade-hocare.com/info/wp-content/uploads/2022/10/portion-de-frites.jpg'
);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `USER` (
    `ID_USER` INT(11) NOT NULL,
    `LOGIN` VARCHAR(255) NOT NULL,
    `PASSWORD` VARCHAR(255) NOT NULL,
    `EMAIL` VARCHAR(255) NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=UTF8 COLLATE=UTF8_GENERAL_CI;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `USER` (
    `ID_USER`,
    `LOGIN`,
    `PASSWORD`,
    `EMAIL`
) VALUES (
    1,
    'jef',
    '$2y$10$OPEElGC0F4PghGraYRFl7OmH57cnVWvApKYF/oWDRmEkj8PVhiwBu',
    'jef@m2l.fr'
),
(
    8,
    'test',
    '$2y$10$wgYsVsexeJHE0Bitxz2OXuzvyGZEhEZdYoR/cxS02SnRkkCmLrxxa',
    'test@test.fr'
),
(
    10,
    '',
    '$2y$10$ZjmEtsUSjb4S4Z.OYC1XhOwDRoGd81LgxG0D/m4nNft5rh.HcAHTS',
    'test2@test.fr'
);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commande`
--
ALTER TABLE `COMMANDE`
    ADD PRIMARY KEY (
        `ID_COMMANDE`
    ), ADD KEY `ID_USER` (
        `ID_USER`
    ), ADD KEY `ID_ETAT` (
        `ID_ETAT`
    );

--
-- Index pour la table `ligne`
--
ALTER TABLE `LIGNE`
    ADD PRIMARY KEY (
        `ID_LIGNE`
    ), ADD KEY `ID_COMMANDE` (
        `ID_COMMANDE`
    ), ADD KEY `ID_PRODUIT` (
        `ID_PRODUIT`
    );

--
-- Index pour la table `produit`
--
ALTER TABLE `PRODUIT`
    ADD PRIMARY KEY (
        `ID_PRODUIT`
    );

--
-- Index pour la table `user`
--
ALTER TABLE `USER`
    ADD PRIMARY KEY (
        `ID_USER`
    );

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `COMMANDE` MODIFY `ID_COMMANDE` INT(
    11
) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `ligne`
--
ALTER TABLE `LIGNE` MODIFY `ID_LIGNE` INT(
    11
) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `PRODUIT` MODIFY `ID_PRODUIT` INT(
    11
) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `USER` MODIFY `ID_USER` INT(
    11
) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `COMMANDE`
    ADD CONSTRAINT `COMMANDE_IBFK_1` FOREIGN KEY (
        `ID_USER`
    )
        REFERENCES `USER` (
            `ID_USER`
        );

--
-- Contraintes pour la table `ligne`
--
ALTER TABLE `LIGNE`
    ADD CONSTRAINT `LIGNE_IBFK_1` FOREIGN KEY (
        `ID_COMMANDE`
    )
        REFERENCES `COMMANDE` (
            `ID_COMMANDE`
        ), ADD CONSTRAINT `LIGNE_IBFK_2` FOREIGN KEY (
            `ID_PRODUIT`
        )
            REFERENCES `PRODUIT` (
                `ID_PRODUIT`
            );

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;