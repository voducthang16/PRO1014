<?php
    class homeModels extends database {
        function getProducts() {
            $query = "SELECT products.id, products.category_id, products.name, products.slug, products.thumbnail, quantity.maxx , quantity.minn 
            FROM products INNER JOIN (SELECT product_id, MAX(price_sale) as maxx, MIN(price_sale) as minn FROM products_type GROUP BY product_id) 
            quantity ON products.id = quantity.product_id WHERE products.category_id != 2 AND products.status = 1 ORDER BY products.id DESC LIMIT 8";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        function getHoodiesProducts() {
            $query = "SELECT products.id, category_id, name, slug, thumbnail, products_type.price_origin, products_type.price_sale 
            FROM `products` INNER JOIN products_type ON products.id = products_type.product_id 
            WHERE products_type.status = 1 AND category_id = 2 AND products.status = 1 GROUP BY products_type.price_origin, products_type.price_sale ORDER BY id DESC LIMIT 6";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }
    }
?>