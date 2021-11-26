<?php
    class productModels extends database {
        function getProfile($username) {
            $qr = "SELECT id FROM members WHERE username = ?";
            $result = $this->connect->prepare($qr);
            $result->execute([$username]);
            return $result->fetch()['id'];
        }

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

        function getProductTypeId($id, $color, $size, $row) {
            $query = "SELECT product_type_id FROM products_type_attributes 
            INNER JOIN products_type ON product_type_id = products_type.id 
            INNER JOIN products ON products_type.product_id = products.id 
            WHERE products.id = ? AND attributes_id IN (?,?) 
            GROUP BY product_type_id HAVING COUNT(1) = ?";
            $result = $this->connect->prepare($query);
            $result->execute([$id,$color, $size, $row]);
            return $result->fetch()['product_type_id'];
        }

        function countAllProducts($id) {
            $query = "SELECT SUM(quantity) as 'quantity' FROM products_type INNER JOIN products ON products_type.product_id = products.id WHERE products.id = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch()['quantity'];
        }

        function countProduct($id){
            $query = "SELECT products_type.quantity,products_type.price_sale,products_type.price_origin FROM products_type WHERE products_type.id = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result;
        }

        function getProductPrice($id){
            $query = "SELECT products.id, quantity.maxx , quantity.minn, quantity.min2, quantity.max2
            FROM products INNER JOIN (SELECT product_id, MAX(price_sale) as maxx, MIN(price_sale) as minn, 
            MIN(price_origin) as min2, MAX(price_origin) as max2 FROM products_type 
            GROUP BY product_id) quantity 
            ON products.id = quantity.product_id WHERE products.id = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch();
        }

        function updateProductView($id) {
            $query = "UPDATE products SET view = view + 1 WHERE products.id = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
        }

        function insertComment($id_prd, $id_member, $star, $content) {
            $qr = "INSERT INTO `comments`( `member_id`, `product_id`, `content`, `star`) VALUES ('$id_member','$id_prd','$content','$star')";
            $result = $this->connect->prepare($qr);
            $result->execute();
        }
        function showComment($product){
            $qr = "SELECT * FROM `comments` WHERE product_id = '$product' and status = 1 ORDER BY id DESC";
            $result = $this->connect->prepare($qr);
            $result->execute();
            return $result;
        }
        function getProfileById($id){
            $qr = "SELECT members.name FROM `members` WHERE id=$id";
            $result = $this->connect->prepare($qr);
            $result->execute();
            return $result->fetch()['name'];
        }
        function deleteComment($id_comment,$id_member){
            $qr = "DELETE FROM `comments` WHERE id = '$id_comment' and member_id = '$id_member'";
            $result = $this->connect->prepare($qr);
            $result->execute();
        }
    }
?>