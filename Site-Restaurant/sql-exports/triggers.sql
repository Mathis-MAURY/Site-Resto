DELIMITER $$ CREATE TRIGGER `AFTER_INSERT_LIGNE` AFTER
    INSERT ON `LIGNE` FOR EACH ROW
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


                DELIMITER        $$ CREATE TRIGGER `BEFORE_INSERT_LIGNE` BEFORE INSERT ON `LIGNE` FOR EACH ROW BEGIN DECLARE PRIXPRODUITHT DECIMAL(
                    10,
                    2   ) DEFAULT 0; 
                -- Obtenir le prix HT du produit
                SELECT           PRIX_HT INTO PRIXPRODUITHT FROM PRODUIT WHERE PRODUIT.ID_PRODUIT = NEW.ID_PRODUIT;
 
                -- Calculer le total HT de la ligne
                SET              NEW.TOTAL_LIGNE_HT = PRIXPRODUITHT * NEW.QTE;
                END$$            DELIMITER;


                DELIMITER        $$ CREATE TRIGGER `BEFORE_UPDATE_LIGNE` BEFORE UPDATE ON `LIGNE` FOR EACH ROW BEGIN DECLARE PRIXPRODUITHT DECIMAL(10, 2) DEFAULT 0;
 
                -- Obtenir le prix HT du produit
                SELECT           PRIX_HT INTO PRIXPRODUITHT FROM PRODUIT WHERE PRODUIT.ID_PRODUIT = NEW.ID_PRODUIT;
 
                -- Calculer le total HT de la ligne
                SET              NEW.TOTAL_LIGNE_HT = PRIXPRODUITHT * NEW.QTE;
                END$$            DELIMITER;