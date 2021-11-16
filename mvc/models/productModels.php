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
            $query = "SELECT products.id, category_id, name, slug, thumbnail, description, parameters, products_type.price_origin, products_type.price_sale 
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

        function getProductAttribute($attribute, $id) {
            $query = "SELECT DISTINCT products_attributes.id, products_attributes.value FROM products_attributes INNER JOIN products_type_attributes 
            ON products_attributes.id = products_type_attributes.attributes_id 
            WHERE products_type_attributes.product_type_id 
            IN (SELECT products_type.id FROM products_type WHERE products_type.product_id = $id) AND products_attributes.name LIKE '%$attribute%'";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        // function getProductTypeId($id, $color, $size) {
        //     $query = "SELECT product_type_id FROM products_type_attributes 
        //     INNER JOIN products_type ON product_type_id = products_type.id 
        //     INNER JOIN products ON products_type.product_id = products.id 
        //     WHERE products.id = ? AND attributes_id IN (?,?) 
        //     GROUP BY product_type_id HAVING COUNT(1) = 2";
        //     $result = $this->connect->prepare($query);
        //     $result->execute([$id,$color, $size]);
        //     return $result->fetch()['product_type_id'];
        // }

        function countAllProducts($id) {
            $query = "SELECT SUM(quantity) as 'quantity' FROM products_type INNER JOIN products ON products_type.product_id = products.id WHERE products.id = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch()['quantity'];
        }
    }
?>