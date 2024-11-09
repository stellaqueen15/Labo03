<?php
class ProductModel
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    public function getAllProducts()
    {
        $query = 'SELECT * FROM produits';
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id)
    {
        $sql = "SELECT * FROM produits WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getFilteredProducts($type = null, $couleur = null, $taille = null, $prix_min = null, $prix_max = null)
    {
        $sql = "SELECT * FROM produits WHERE 1=1";
        $params = [];

        if ($type) {
            $sql .= " AND type = :type";
            $params['type'] = $type;
        }

        if ($couleur) {
            $sql .= " AND couleur = :couleur";
            $params['couleur'] = $couleur;
        }

        if ($taille) {
            $sql .= " AND taille = :taille";
            $params['taille'] = $taille;
        }

        if ($prix_min) {
            $sql .= " AND prix >= :prix_min";
            $params['prix_min'] = $prix_min;
        }

        if ($prix_max) {
            $sql .= " AND prix <= :prix_max";
            $params['prix_max'] = $prix_max;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRandomProducts($limit, $currentProductId = null)
    {
        $sql = "SELECT * FROM produits";

        if ($currentProductId) {
            $sql .= " WHERE id != :id";
        }

        $sql .= " ORDER BY RAND() LIMIT :limit";
        $stmt = $this->db->prepare($sql);

        if ($currentProductId) {
            $stmt->bindParam(':id', $currentProductId, PDO::PARAM_INT);
        }

        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>