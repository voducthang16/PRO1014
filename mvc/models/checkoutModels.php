<?php
    class checkoutModels extends database {
        function getMemberId($username) {
            $query = "SELECT id FROM members WHERE username = ?";
            $result = $this->connect->prepare($query);
            $result->execute([$username]);
            return $result->fetch()['id'];
        }

        function countProductsMember($id) {
            $query = "SELECT COUNT(*) as 'count' FROM `cart_temporary` WHERE member_id = ?";
            $result = $this->connect->prepare($query);
            $result->execute([$id]);
            return $result->fetch()['count'];
        }

        function getProductsById($id) {
            $query = "SELECT cart_temporary.member_id, cart_temporary.product_type_id, cart_temporary.quantity, products_type.product_id, products_type.price_sale, products.name, products.slug, products.thumbnail 
            FROM `cart_temporary` INNER JOIN products_type ON cart_temporary.product_type_id = products_type.id 
            INNER JOIN products ON products.id = products_type.product_id WHERE member_id = 1 ORDER BY cart_temporary.id DESC";
            $result = $this->connect->prepare($query);
            $result->execute([$id]);
            return $result->fetchAll();
        }

        function getOrderMethods() {
            $query = "SELECT * FROM `orders_method` WHERE status = 1";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        function getProfile($username) {
            $qr = "SELECT id FROM members WHERE username = ?";
            $result = $this->connect->prepare($qr);
            $result->execute([$username]);
            return $result->fetch()['id'];
        }

        function checkCoupon($name) {
            $query = "SELECT * FROM coupon WHERE coupon.name = ?";
            $result = $this->connect->prepare($query);
            $result->execute([$name]);
            return $result;
        }

        function getCouponValue($id) {
            $query = "SELECT value FROM coupon WHERE coupon.id = ?";
            $result = $this->connect->prepare($query);
            $result->execute([$id]);
            return $result->fetch()['value'];
        }

        function checkCouponInOrder($id, $name) {
            $query = "SELECT * FROM `orders` WHERE orders.member_id = ? AND orders.coupon_id = ?";
            $result = $this->connect->prepare($query);
            $result->execute([$id, $name]);
            return $result->rowCount();
        }
    }
?>