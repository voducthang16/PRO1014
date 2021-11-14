<?php
    class homeModels extends database {
        function getProducts() {
            $query = "SELECT * FROM `products` WHERE status = 1 ORDER BY id DESC LIMIT 8";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        function getCategories() {
            $query = "SELECT * FROM `category` WHERE status = 1";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        function getHoodiesProducts() {
            $query = "SELECT * FROM `products` WHERE status = 1 AND category_id = 2 ORDER BY id DESC LIMIT 6";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }
    }
?>