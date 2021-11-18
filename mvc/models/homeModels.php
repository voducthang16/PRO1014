<?php
    class homeModels extends database {
        function getProducts() {
            $query = "SELECT * FROM (SELECT products.id, category_id, name, slug, thumbnail, products_type.price_origin, products_type.price_sale, ROW_NUMBER() OVER(PARTITION BY name ORDER BY products_type.price_sale DESC) rn FROM `products` INNER JOIN products_type ON products.id = products_type.product_id WHERE status = 1 and category_id != 2 GROUP BY products_type.price_origin, products_type.price_sale, products.name) a WHERE rn = 1 ORDER BY id DESC LIMIT 8";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        function getHoodiesProducts() {
            $query = "SELECT products.id, category_id, name, slug, thumbnail, products_type.price_origin, products_type.price_sale 
            FROM `products` INNER JOIN products_type ON products.id = products_type.product_id 
            WHERE status = 1 AND category_id = 2 GROUP BY products_type.price_origin, products_type.price_sale ORDER BY id DESC LIMIT 6";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }
    }
?>