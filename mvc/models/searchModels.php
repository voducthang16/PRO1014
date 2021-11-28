<?php
    class searchModels extends database {
        function search_product($search) {
            $qr = "SELECT * FROM `products` WHERE name LIKE '%$search%'";
            $result = $this->connect->prepare($qr);
            $result->execute();
            return $result;
        }
        function getProductPrice($id){
            $query = "SELECT products.id, quantity.maxx , quantity.minn
            FROM products INNER JOIN (SELECT product_id, MAX(price_sale) as maxx, MIN(price_sale) as minn FROM products_type 
            GROUP BY product_id) quantity 
            ON products.id = quantity.product_id WHERE products.id = $id";
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
    }
?>