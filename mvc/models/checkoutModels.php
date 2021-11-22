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
            INNER JOIN products ON products.id = products_type.product_id WHERE member_id = ? ORDER BY cart_temporary.id DESC";
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

        function getOrderId() {
            $query = "SELECT id FROM orders ORDER BY id DESC LIMIT 1";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch()['id'];
        }

        function getProfile($username) {
            $qr = "SELECT id FROM members WHERE username = ?";
            $result = $this->connect->prepare($qr);
            $result->execute([$username]);
            return $result->fetch()['id'];
        }

        function checkCoupon($name) {
            $query = "SELECT * FROM coupon WHERE coupon.name = ?  and coupon.ended_at > DATE(NOW())";
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

        function insertOrder($member_id, $coupon_id, $order_method_id, $name, $address, $email, $phone, $note) {
            $query = "INSERT INTO `orders`(`member_id`, `coupon_id`, `order_method_id`, `name`, `address`, `email`, `phone`, `note`) 
            VALUES('$member_id', '$coupon_id', '$order_method_id', '$name', '$address', '$email', '$phone', '$note')";
            $result = $this->connect->prepare($query);
            $result->execute();
        }

        function insertOrderWithoutCoupon($member_id, $order_method_id, $name, $address, $email, $phone, $note) {
            $query = "INSERT INTO `orders`(`member_id`, `order_method_id`, `name`, `address`, `email`, `phone`, `note`) 
            VALUES('$member_id', '$order_method_id', '$name', '$address', '$email', '$phone', '$note')";
            $result = $this->connect->prepare($query);
            $result->execute();
        }

        function insertOrderDetails($order, $product_type, $quantity, $price_sale) {
            $query = "INSERT INTO `orders_details` (`order_id`, `product_type_id`, `quantity`, `price_sale`) 
            VALUES ('$order', '$product_type', '$quantity', '$price_sale')";
            $result = $this->connect->prepare($query);
            $result->execute();
        }

        function updateCouponQuantity($id) {
            $query = "UPDATE coupon SET quantity = quantity - 1, used = used + 1 WHERE id = ?";
            $result = $this->connect->prepare($query);
            $result->execute([$id]);
        }

        function deleteProductFromCartTemp($member_id, $product_type_id) {
            $query = "DELETE FROM cart_temporary WHERE member_id = ? AND product_type_id = ?";
            $result = $this->connect->prepare($query);
            $result->execute([$member_id, $product_type_id]);
        }

        function updateTotalMoney($total, $id) {
            $query = "UPDATE `orders` SET `total` = ? WHERE `orders`.`id` = ?";
            $result = $this->connect->prepare($query);
            $result->execute([$total, $id]);
        }
    }
?>