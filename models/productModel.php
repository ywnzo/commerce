<?php

class ProductModel {
    public function __construct(protected PDO $db){

    }

    public function getAllProducts() {
        $stmt =  $this->db->query('SELECT * FROM products');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProduct() {
        try {
            $stmt = $this->db->prepare('SELECT * FROM products WHERE ID = :id');
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
            $stmt->bindParam(':id', $id);
            //return $id;
            $result = $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return count($result) === 1 ? $result[0] : $result;
        } catch(PDOException $e) {
            echo 'Error occured: ' . $e->getMessage();
            return false;
        }
    }
}

?>
