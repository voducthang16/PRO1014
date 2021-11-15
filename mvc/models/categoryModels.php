<?php
    class categoryModels extends database {
        function getCategories() {
            $query = "SELECT * FROM `category` WHERE status = 1";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        function getCategoryName($slug) {
            $query = "SELECT * FROM `category` WHERE slug = '$slug' AND status = 1";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch()["name"];
        }

        function getCategoryId($slug) {
            $query = "SELECT * FROM `category` WHERE slug = '$slug'";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch()["id"];
        }

        function getProducts($id, $from, $ppp) {
            $query = "SELECT * FROM `products` WHERE category_id = '$id' AND status = 1 ORDER BY id DESC LIMIT $from, $ppp";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        function countProductsByCategory($id) {
            $query = "SELECT COUNT(*) as 'count' FROM `products` WHERE category_id = $id AND status = 1 ORDER BY id DESC";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch()['count'];
        }

        function getAllProducts($from, $ppp) {
            $query = "SELECT * FROM `products` WHERE status = 1 ORDER BY id DESC LIMIT $from, $ppp";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        function countAllProducts() {
            $query = "SELECT COUNT(*) as 'count' FROM `products` WHERE status = 1 ORDER BY id DESC";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch()['count'];
        }

        function getSlugs() {
            $query = "SELECT slug FROM `category`";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        
    }
?>