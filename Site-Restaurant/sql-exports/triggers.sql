DELIMITER |
CREATE OR REPLACE TRIGGER `before_ligne_insert` BEFORE INSERT ON `ligne`
 FOR EACH ROW BEGIN
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

DELIMITER |
CREATE OR REPLACE TRIGGER `before_ligne_update` BEFORE UPDATE ON `ligne`
 FOR EACH ROW BEGIN
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

DELIMITER |
CREATE OR REPLACE TRIGGER `after_ligne_insert` AFTER INSERT ON `ligne`
 FOR EACH ROW BEGIN
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
    FROM ligne 
    WHERE id_commande = NEW.id_commande;

    -- Calculer le total TTC
    SET total_commande = total_commande * tva;

    -- Mettre à jour le total de la commande
    UPDATE commande 
    SET total_commande = total_commande 
    WHERE id_commande = NEW.id_commande;
END |

DELIMITER |
CREATE OR REPLACE TRIGGER `after_ligne_update` AFTER UPDATE ON `ligne`
 FOR EACH ROW BEGIN
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
    FROM ligne 
    WHERE id_commande = NEW.id_commande;
CREATE TRIGGER `AFTER_INSERT_LIGNE` 
AFTER INSERT ON `LIGNE` 
FOR EACH ROW
BEGIN
    DECLARE TOTALTTC DECIMAL(10, 2) DEFAULT 0;
    DECLARE
        CONSOMMATIONTYPE INT DEFAULT 0;
        DECLARE          TVARATE DECIMAL(5, 3) DEFAULT 1.000;
 
        -- Obtenir le type de consommation de la commande
        SELECT           TYPE_CONSO INTO CONSOMMATIONTYPE FROM COMMANDE WHERE COMMANDE.ID_COMMANDE = NEW.ID_COMMANDE;
 
        -- Appliquer le taux de TVA en fonction du type de consommation
        IF               CONSOMMATIONTYPE = 1 THEN
            SET TVARATE = 1.055;
            ELSEIF           CONSOMMATIONTYPE = 2 THEN
                SET TVARATE = 1.100;
            END IF;
 
            -- Calculer le total HT des lignes de la commande
            SELECT           SUM(TOTAL_LIGNE_HT) INTO TOTALTTC FROM LIGNE WHERE LIGNE.ID_COMMANDE = NEW.ID_COMMANDE;
 
            -- Calculer le total TTC
            SET              TOTALTTC = TOTALTTC * TVARATE;
 
            -- Mettre à jour le total de la commande
            UPDATE           COMMANDE SET TOTAL_COMMANDE = TOTALTTC WHERE COMMANDE.ID_COMMANDE = NEW.ID_COMMANDE;
            END$$            DELIMITER;

/* Deuxieme TRIGGER ORGANISER */

            DELIMITER        $$ CREATE TRIGGER `AFTER_UPDATE_LIGNE` AFTER UPDATE ON `LIGNE` FOR EACH ROW BEGIN DECLARE TOTALTTC DECIMAL(10, 2) DEFAULT 0;
            DECLARE          CONSOMMATIONTYPE INT DEFAULT 0;
            DECLARE          TVARATE DECIMAL(5, 3) DEFAULT 1.000;
 
            -- Obtenir le type de consommation de la commande
            SELECT           TYPE_CONSO INTO CONSOMMATIONTYPE FROM COMMANDE WHERE COMMANDE.ID_COMMANDE = NEW.ID_COMMANDE;
 
            -- Appliquer le taux de TVA en fonction du type de consommation
            IF               CONSOMMATIONTYPE = 1 THEN
                SET TVARATE = 1.055;
                ELSEIF           CONSOMMATIONTYPE = 2 THEN
                    SET TVARATE = 1.100;
                END IF;
 
                -- Calculer le total HT des lignes de la commande
                SELECT           SUM(TOTAL_LIGNE_HT) INTO TOTALTTC FROM LIGNE WHERE LIGNE.ID_COMMANDE = NEW.ID_COMMANDE;
 
                -- Calculer le total TTC
                SET              TOTALTTC = TOTALTTC * TVARATE;
 
                -- Mettre à jour le total de la commande
                UPDATE           COMMANDE SET TOTAL_COMMANDE = TOTALTTC WHERE COMMANDE.ID_COMMANDE = NEW.ID_COMMANDE;
                END$$            DELIMITER;

/* Troisieme TRIGGER ORGANISER */

    -- Calculer le total TTC
    SET total_commande = total_commande * tva;

    -- Mettre à jour le total de la commande
    UPDATE commande 
    SET total_commande = total_commande 
    WHERE id_commande = NEW.id_commande;
END |

/* Quatrieme TRIGGER ORGANISER */

                DELIMITER        $$ CREATE TRIGGER `BEFORE_UPDATE_LIGNE` BEFORE UPDATE ON `LIGNE` FOR EACH ROW BEGIN DECLARE PRIXPRODUITHT DECIMAL(10, 2) DEFAULT 0;
 
                -- Obtenir le prix HT du produit
                SELECT           PRIX_HT INTO PRIXPRODUITHT FROM PRODUIT WHERE PRODUIT.ID_PRODUIT = NEW.ID_PRODUIT;
 
                -- Calculer le total HT de la ligne
                SET              NEW.TOTAL_LIGNE_HT = PRIXPRODUITHT * NEW.QTE;
                END$$            DELIMITER;
