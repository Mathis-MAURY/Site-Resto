<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
class ConnexionBDD
{
    private $host = 'localhost';
    private $dbname = 'db_restoweb';
    private $root = 'root';
    private $password = '';
    private $dbh;

    public function __construct()
    {
        $this->host = "localhost";
        $this->dbname = "db_restoweb";
        $this->root = "root";
        $this->password = "";
        $this->dbh = $this->connect();
    }

    /*
     * Méthode qui permet de préparer et d'éxcuter une requête
     */
    function prepareAndFetchAll($sql, $params = [])
    {
        try {
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute($params);

            if ($stmt->rowCount() == 0)
                return [];
            else
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            throw $ex;
        }
    }


    /*
     * Méthode qui permet de préparer et d'éxcuter une requête
     */
    function prepareAndFetchOne($sql, $params = [])
    {
        try {
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute($params);

            if ($stmt->rowCount() == 0)
                return [];
            else
                return $stmt->fetch();
        } catch (PDOException $ex) {
            throw $ex;
        }
    }

    public function connect()
    {
        try {
            // Création de la connexion PDO
            $db = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->root, $this->password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            die(
                "<b>Une erreur est survenue lors de la connexion à MYSQL !</b><br><br><u>" .
                $e->getMessage() .
                "</u>"
            );
        }
    }

    public function login($login, $password): bool
    {
        $user = $this->prepareAndFetchOne(
            "SELECT * FROM user WHERE login = :login",
            [
                ':login' => $login
            ]
        );

        if ($user === false || $user === []) {
            return FALSE;
        }

        $passwordHash = $user["password"];
        if ($password == NULL || $passwordHash == NULL) {
            die("One of the passwords is null");
        }
        $verification = password_verify($password, $passwordHash);
        $_SESSION["user"] = $user;
        return $verification;
    }

    /*
     *   Méthode pour récuperer l'utilisateur depuis la session
     *   si la méthode retourne NULL c'est que l'utilisateur
     *               n'est pas connecté.
     */
    function getUserFromSession()
    {
        if (!isset($_SESSION["user"])) {
            return null;
        }

        $user = $_SESSION["user"];

        $res = $this->prepareAndFetchAll(
            "SELECT * FROM user WHERE login = :login AND password = :password",
            [
                ":login" => $user["login"],
                ":password" => $user["password"]
            ]
        );

        if (count($res) == 0)
            return NULL;

        $resultat = $this->login("login", "password");
        if ($resultat) {
            // il est connecté.
        } else {
            // Il n'est pas connecté, les identifiants sont surement incorrects.
        }
        return $res[0];
    }

    public function calculerTotalPanier($panier)
    {
        $total = 0;
    
        // Si le panier est vide, retourner 0 pour le total
        if (empty($panier)) {
            return $total;
        }
    
        $ids = [];
        foreach ($panier as $p) {
            // Vérifiez que l'ID est bien défini et est un entier
            if (isset($p["id_produit"]) && is_numeric($p["id_produit"])) {
                $ids[] = intval($p["id_produit"]); // Convertir en entier
            }
        }
    
        // Vérifiez que nous avons des IDs avant de continuer
        if (empty($ids)) {
            return $total; // Pas d'ID produit
        }
    
        // Construire la requête avec les IDs
        $imploded = implode(",", $ids);
    
        // Créez la requête SQL pour récupérer les produits
        $query = "SELECT produit.prix_ht, produit.id_produit FROM produit WHERE produit.id_produit IN ($imploded);";
    
        // Log de la requête pour le débogage (facultatif)
        error_log($query);
    
        // Exécuter la requête
        $produits = $this->prepareAndFetchAll($query);
    
        foreach ($produits as $prod) {
            $prix = $prod["prix_ht"];
            $id = $prod["id_produit"];
            $qty = $this->rechercheQuantiteDansPanier($panier, $id);
    
            if ($qty != -1) {
                $total += $qty * $prix; // Calculer le total
            }
        }
    
        return $total;
    }
    
    private function rechercheQuantiteDansPanier($panier, $idProduit)
    {
        foreach ($panier as $p) {
            if ($p["id_produit"] == $idProduit)
                return $p["qty"];
        }

        return -1;
    }

    public function insererCommandeEtProduitDepuisPanier($typeConso)
{
    $panier = json_decode($_COOKIE["panier"] ?? "[]", true);

    // Insertion de la commande sans id_etat
    $this->prepareAndFetchOne(
        "INSERT INTO commande(id_user, date, total_commande, type_conso) VALUES (:idUser, SYSDATE(), 0, :typeConso)",
        [
            ":idUser" => $_SESSION["user"]["id_user"],
            ":typeConso" => $typeConso
        ]
    );

    $idCommandeInseree = $this->dbh->lastInsertId();
    $totalCommande = 0;

    foreach ($panier as $produit) {
        $idProduit = $produit["id_produit"];
        $quantite = $produit["qty"];

        // Vérifiez que l'ID du produit et la quantité sont valides
        if (isset($idProduit) && is_numeric($quantite) && $quantite > 0) {
            // Récupérer le prix du produit
            $prixProduit = $this->prepareAndFetchOne(
                "SELECT prix_ht FROM produit WHERE id_produit = :idProduit",
                [":idProduit" => $idProduit]
            );

            if ($prixProduit && isset($prixProduit['prix_ht'])) {
                $prixProduit = $prixProduit['prix_ht'];
                $totalLigne = $prixProduit * $quantite;
                $totalCommande += $totalLigne;

                // Insertion dans la table ligne
                $this->prepareAndFetchOne(
                    "INSERT INTO ligne(id_commande, id_produit, qte, total_ligne_ht) VALUES (:idCommande, :idProduit, :qte, :totalHt)",
                    [
                        ":idCommande" => $idCommandeInseree,
                        ":idProduit" => $idProduit,
                        ":qte" => $quantite,
                        ":totalHt" => $totalLigne
                    ]
                );
            } else {
                error_log("Produit avec ID $idProduit non trouvé ou prix non défini.");
            }
        } else {
            error_log("ID produit ou quantité invalides : ID = $idProduit, Quantité = $quantite.");
        }
    }

    // Mise à jour du total de la commande
    $this->prepareAndFetchOne(
        "UPDATE commande SET total_commande = :totalCommande WHERE id_commande = :idCommande",
        [
            ":totalCommande" => $totalCommande,
            ":idCommande" => $idCommandeInseree
        ]
    );

    $_SESSION["idDeCommandeDernierementInseree"] = $idCommandeInseree;
}
}
?>