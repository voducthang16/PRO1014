<?php
    class categoryModels extends database {
        function getCategories() {
            $query = "SELECT * FROM `category` WHERE status = 1";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        function getCategoryName($slug) {
            $query = "SELECT * FROM `category` WHERE slug = '$slug'";
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

        function getProducts($id) {
            $query = "SELECT * FROM `products` WHERE category_id = '$id'";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }
    }
?>