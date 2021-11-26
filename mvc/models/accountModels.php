<?php
    class accountModels extends database {
        function getProfile($username) {
            $qr = "SELECT id FROM members WHERE username = ?";
            $result = $this->connect->prepare($qr);
            $result->execute([$username]);
            return $result->fetch()['id'];
        }
        
        function addWishList($id_member,$id_product){
            $qr = "INSERT INTO `products_wishlist`(`member_id`, `product_id`) VALUES ('$id_member','$id_product')";
            $result = $this->connect->prepare($qr);
            $kq = false;
            if ($result->execute()) {
                $kq = true;
                return json_encode($kq);
            }
            return json_encode($kq);
        }

        function selectWishList($id_member) {
            $qr = "SELECT products_wishlist.member_id, products_wishlist.product_id, products.name, products.slug, products.thumbnail, quantity.maxx , quantity.minn
            FROM products_wishlist INNER JOIN products ON products_wishlist.product_id = products.id 
            INNER JOIN (SELECT product_id, MAX(price_sale) as maxx, MIN(price_sale) as minn
            FROM products_type GROUP BY product_id) quantity 
            ON products.id = quantity.product_id WHERE products_wishlist.member_id = '$id_member'";
            $result = $this->connect->prepare($qr);
            $result->execute();
            return $result;
        }

        function checkPrdWishList($id_member,$id_product) {
            $qr = "SELECT * FROM `products_wishlist` WHERE `member_id` = $id_member AND `product_id` = $id_product";
            $result = $this->connect->prepare($qr);
            $result->execute();
            return $result->rowCount();
        }
        function deleteWishList($id_member,$id_product) {
            $qr = "DELETE FROM `products_wishlist` WHERE `member_id` = $id_member AND `product_id` = $id_product";
            $result = $this->connect->prepare($qr);
            $result->execute();
        }

        function getOrderByMemberId($id) {
            $query = "SELECT orders.id, orders.member_id, orders.order_status, orders.total,
            DATE(`orders`.`created_at`) as 'orderDate', members.name FROM orders INNER JOIN members ON orders.member_id = members.id 
            WHERE orders.member_id = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }
    }
?>