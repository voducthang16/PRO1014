<?php
    class productModels extends database {
        function getSlugs() {
            $query = "SELECT slug FROM `products`";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        function getCategoryId($slug) {
            $query = "SELECT category_id FROM `products` WHERE slug = '$slug' and status = 1";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch()['category_id'];
        }

        function getProduct($slug) {
            $query = "SELECT products.id, category_id, name, slug, thumbnail, products_type.price_origin, products_type.price_sale 
            FROM `products` INNER JOIN products_type ON products.id = products_type.product_id 
            WHERE slug = '$slug' and status = 1 GROUP BY products_type.price_origin, products_type.price_sale";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch();
        }

        function getProductId($slug) {
            $query = "SELECT id FROM `products` WHERE slug = '$slug' and status = 1";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch()['id'];
        }

        function getProductImages($id) {
            $query = "SELECT * FROM `products_images` WHERE product_id = '$id'";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        function getCategoryInfo($id) {
            $query = "SELECT * FROM `category` WHERE id = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch();
        }
    }
?>