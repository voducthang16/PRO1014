<?php
    class searchModels extends database {
        function search_product($search) {
            $qr = "SELECT products.id, products.category_id, products.name, products.slug, products.thumbnail, quantity.maxx , quantity.minn 
            FROM products INNER JOIN (SELECT product_id, MAX(price_sale) as maxx, MIN(price_sale) as minn 
            FROM products_type GROUP BY product_id) quantity ON products.id = quantity.product_id 
            WHERE $search AND products.status = 1 ORDER BY products.id DESC";
            $result = $this->connect->prepare($qr);
            $result->execute();
            return $result->fetchAll();
        }
    }
?>