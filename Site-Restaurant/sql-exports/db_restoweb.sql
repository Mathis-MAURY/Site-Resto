-- phpmyadmin sql dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- hôte : 127.0.0.1
-- généré le : dim. 03 nov. 2024 à 17:18
-- version du serveur : 10.4.32-mariadb
-- version de php : 8.2.12

set sql_mode = "no_auto_value_on_zero";

start transaction;

set time_zone = "+00:00";

/*!40101 set @old_character_set_client=@@character_set_client */;

/*!40101 set @old_character_set_results=@@character_set_results */;

/*!40101 set @old_collation_connection=@@collation_connection */;

/*!40101 set names utf8mb4 */;

--
-- base de données : `db_restoweb`
create database if not exists `db_restoweb` default character set utf8 collate utf8_general_ci;

use `db_restoweb`;

-- --------------------------------------------------------

--
-- structure de la table `commande`
--

create table `commande` (
  `id_commande` int(11) not null,
  `id_user` int(11) not null,
  `id_etat` int(11) not null,
  `date` datetime not null default current_timestamp(),
  `total_commande` decimal(10, 2) not null default 0.00,
  `type_conso` tinyint(1) not null
) engine=innodb default charset=utf8 collate=utf8_general_ci;

--
-- déchargement des données de la table `commande`
--

insert into `commande` (
  `id_commande`,
  `id_user`,
  `id_etat`,
  `date`,
  `total_commande`,
  `type_conso`
) values (
  16,
  1,
  0,
  '2024-10-29 14:38:05',
  26.50,
  1
);

-- --------------------------------------------------------

--
-- structure de la table `ligne`
--

create table `ligne` (
  `id_ligne` int(11) not null,
  `id_commande` int(11) not null,
  `id_produit` int(11) not null,
  `qte` int(11) not null default 0,
  `total_ligne_ht` decimal(10, 2) not null default 0.00
) engine=innodb default charset=utf8 collate=utf8_general_ci;

--
-- déchargement des données de la table `ligne`
--

insert into `ligne` (
  `id_ligne`,
  `id_commande`,
  `id_produit`,
  `qte`,
  `total_ligne_ht`
) values (
  26,
  16,
  2,
  1,
  14.00
);

-- --------------------------------------------------------

--
-- structure de la table `produit`
--

create table `produit` (
  `id_produit` int(11) not null,
  `libelle` varchar(255) not null,
  `prix_ht` decimal(10, 2) not null,
  `imageurl` varchar(250) not null
) engine=innodb default charset=utf8 collate=utf8_general_ci;

--
-- déchargement des données de la table `produit`
--

insert into `produit` (
  `id_produit`,
  `libelle`,
  `prix_ht`,
  `imageurl`
) values
(1, 'pizza margherita', 12.50, 'https://img.passeportsante.net/1200x675/2022-09-23/shutterstock-2105210927.webp'),
(2, 'pizza chorizo', 14.00, 'https://www.galbani.fr/wp-content/uploads/2017/07/image7.jpg'),
(3, 'assiette de charcuterie', 12.50, 'https://www.passionculinaire.fr/wp-content/uploads/2021/09/charcuterie-conseils.jpg'),
(4, 'assiette de fromages', 10.50, 'https://cache.marieclaire.fr/data/photo/w999_c17/cuisine/43/fromages1.jpg'),
(5, 'hamburger viande', 7.50, 'https://www.la-viande.fr/sites/default/files/inline-images/hamburger.jpg'),
(6, 'hot dog', 5.00, 'https://www.tastingtable.com/img/gallery/13-best-hot-dogs-in-america/l-intro-1660217636.jpg'),
(7, 'empanadas poulet', 11.00, 'https://www.enviedebienmanger.fr/sites/default/files/styles/img_orig/public/2020-12/68_1.png?itok=lfzsdw9k'),
(8, 'empanadas thon', 9.00, 'https://www.seb.fr/medias/?context=bwfzdgvyrhjvb3q4ndg4ohxpbwfnzs9qcgxobmvn'),
(9, 'portion de frites', 5.00, 'https://brigade-hocare.com/info/wp-content/uploads/2022/10/portion-de-frites.jpg');

-- --------------------------------------------------------

--
-- structure de la table `user`
--

create table `user` (
  `id_user` int(11) not null,
  `login` varchar(255) not null,
  `password` varchar(255) not null,
  `email` varchar(255) not null
) engine=innodb default charset=utf8 collate=utf8_general_ci;

--
-- déchargement des données de la table `user`
--

insert into `user` (
  `id_user`,
  `login`,
  `password`,
  `email`
) values
(1, 'leo', '$2y$10$opeelgc0f4pghgrayrfl7omh57cnvwvapkyf/owdrmekj8pvhiwbu', 'leo@m2l.fr'),
(8, 'test', '$2y$10$wgysvsexejhe0bitxz2oxuzvygzehezdyor/cxs02snrkkcmlrxxa', 'test@test.fr'),
(10, 'franck', '$2y$10$zjmetsusjb4s4z.oyc1xh0wdr0gd81lgxg0d/m4nnft5rh.hcahts', 'test2@test.fr');

-- --------------------------------------------------------

-- index pour les tables déchargées

-- index pour la table `commande`
alter table `commande`
  add primary key (`id_commande`),
  add key `id_user` (`id_user`),
  add key `id_etat` (`id_etat`);

-- index pour la table `ligne`
alter table `ligne`
  add primary key (`id_ligne`),
  add key `id_commande` (`id_commande`),
  add key `id_produit` (`id_produit`);

-- index pour la table `produit`
alter table `produit`
  add primary key (`id_produit`);

-- index pour la table `user`
alter table `user`
  add primary key (`id_user`);

-- auto_increment pour les tables déchargées

-- auto_increment pour la table `commande`
alter table `commande` modify `id_commande` int(11) not null auto_increment, auto_increment=22;

-- auto_increment pour la table `ligne`
alter table `ligne` modify `id_ligne` int(11) not null auto_increment, auto_increment=38;

-- auto_increment pour la table `produit`
alter table `produit` modify `id_produit` int(11) not null auto_increment, auto_increment=10;

-- auto_increment pour la table `user`
alter table `user` modify `id_user` int(11) not null auto_increment, auto_increment=11;

-- contraintes pour les tables déchargées

-- contraintes pour la table `commande`
alter table `commande`
  add constraint `commande_ibfk_1` foreign key (`id_user`) references `user` (`id_user`);

-- contraintes pour la table `ligne`
alter table `ligne`
  add constraint `ligne_ibfk_1` foreign key (`id_commande`) references `commande` (`id_commande`),
  add constraint `ligne_ibfk_2` foreign key (`id_produit`) references `produit` (`id_produit`);

commit;

/*!40101 set character_set_client=@old_character_set_client */;

/*!40101 set character_set_results=@old_character_set_results */;

/*!40101 set collation_connection=@old_collation_connection */;
