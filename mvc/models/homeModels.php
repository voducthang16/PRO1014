<?php
    class homeModels extends database {
        function getProducts() {
            $query = "SELECT * FROM `products` ORDER BY id DESC LIMIT 8";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }
    }
?>