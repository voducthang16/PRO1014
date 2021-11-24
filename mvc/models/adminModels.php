<?php
    class adminModels extends database {
        function checkLogin($username, $password) {
            $query = "SELECT * FROM `admin` WHERE username = ? AND password = ? AND status = 1";
            $result = $this->connect->prepare($query);
            $result->execute([$username, $password]);
            return $result->rowCount();
        }

        function getCategories() {
            $query = "SELECT * FROM `category` ORDER BY id DESC";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        function checkExistName($table, $name, $id = 0) {
            $query = "SELECT * FROM $table WHERE name = ? and id != ?";
            $result = $this->connect->prepare($query);
            $result->execute([$name, $id]);
            return $result->rowCount();
        }

        function addCategory($name, $slug, $status) {
            $query = "INSERT INTO category(name, slug, status) 
            VALUES ('$name', '$slug','$status')";
            $result = $this->connect->prepare($query);
            $result->execute();
        }

        function updateCategory($id, $name, $status) {
            $query = "UPDATE category SET name = ?,  status = ?, updated_at = current_timestamp() WHERE id = ?";
            $result = $this->connect->prepare($query);
            $result->execute([$name, $status, $id]);
        }

        function deleteCategory($id) {
            $query = "DELETE FROM category WHERE id = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
        }

        function updateCategoryStatus($id) {
            $query = "UPDATE category SET status = '0', updated_at = current_timestamp() WHERE id = ?";
            $result = $this->connect->prepare($query);
            $result->execute([$id]);
        }

        function getProducts() {
            $query = "SELECT * FROM `products` ORDER BY id DESC";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        function getAttributes($name) {
            $query = "SELECT * FROM `products_attributes` WHERE name = ?";
            $result = $this->connect->prepare($query);
            $result->execute([$name]);
            return $result->fetchAll();
        }

        function getProductId() {
            $query = "SELECT * FROM `products` ORDER BY id DESC LIMIT 1";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch()['id'];
        }

        function getProductTypeId() {
            $query = "SELECT * FROM `products_type` ORDER BY id DESC LIMIT 1";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch()['id'];
        }

        function addProduct($category_id, $name, $slug, $thumbnail, $description, $parameters, $status) {
            $query = "INSERT INTO products(category_id, name, slug, thumbnail, description, parameters, status) 
            VALUES ('$category_id', '$name', '$slug', '$thumbnail', '$description', '$parameters', '$status')";
            $result = $this->connect->prepare($query);
            $kq = false;
            if ($result->execute()) {
                $kq = true;
                return json_encode($kq);
            }
            return json_encode($kq);
        }

        function addProductType($product_id, $price_origin, $price_sale, $quantity) {
            $query = "INSERT INTO products_type(product_id, price_origin, price_sale, quantity) 
            VALUES ('$product_id', '$price_origin', '$price_sale', '$quantity')";
            $result = $this->connect->prepare($query);
            $result->execute();
        }

        function addProductTypeAttribute($product_type_id, $attributes_id) {
            $query = "INSERT INTO products_type_attributes(product_type_id, attributes_id) 
            VALUES ('$product_type_id', '$attributes_id')";
            $result = $this->connect->prepare($query);
            $result->execute();
        }

        function addProductImages($product_id, $image) {
            $query = "INSERT INTO products_images(product_id, image) VALUES ('$product_id', '$image')";
            $result = $this->connect->prepare($query);
            $result->execute();
        }

        function countProductsByCategory($category_id) {
            $query = "SELECT COUNT(*) as 'count' FROM products WHERE category_id = $category_id";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch()['count'];
        }

        function getProductById($id) {
            $query = "SELECT * FROM products WHERE id = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch();
        }

        function getCoupon() {
            $query = "SELECT * FROM `coupon`";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        function insertCoupon($name, $type, $value, $min_order, $quantity, $note, $date_start, $date_end) {
            $query = "INSERT INTO coupon(name, type, coupon.value, min_order, quantity, note, created_at, ended_at) 
            VALUES('$name', '$type', '$value', '$min_order','$quantity', '$note', '$date_start', '$date_end')";
            $result = $this->connect->prepare($query);
            $result->execute();
        }

        function updateCoupon($id, $name, $type, $value, $min_order, $quantity, $date_start, $date_end) {
            $query = "UPDATE coupon SET name = ?, type = ?, value = ?, min_order = ?, quantity = ?, created_at = ?, ended_at = ? WHERE id = ?";
            $result = $this->connect->prepare($query);
            $result->execute([$name, $type, $value, $min_order, $quantity, $date_start, $date_end, $id]);
        }

        function checkExistCoupon($id) {
            $query = "SELECT * FROM orders WHERE orders.coupon_id = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->rowCount();
        }

        function deleteCoupon($id) {
            $query = "DELETE FROM coupon WHERE id = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
        }

        function getProductTypeIdById($product_id) {
            $query = "SELECT orders_details.product_type_id FROM orders_details 
            INNER JOIN products_type ON products_type.id = orders_details.product_type_id 
            INNER JOIN products ON products.id = products_type.product_id WHERE products.id = ? GROUP BY orders_details.product_type_id";
            $result = $this->connect->prepare($query);
            $result->execute([$product_id]);
            return $result->fetchAll();
        }

        function getProductImages($id) {
            $query = "SELECT * FROM `products_images` WHERE product_id = '$id'";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        function getProductImagesById($id) {
            $query = "SELECT * FROM `products_images` WHERE id = '$id'";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch();
        }

        function deleteImage($id) {
            $query = "DELETE FROM products_images WHERE id = '$id'";
            $result = $this->connect->prepare($query);
            $result->execute();
        }

        // test
        function updateNameProduct($name, $id) {
            $query = "UPDATE products SET name = '$name' WHERE id = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
        }
        // test

        function getOrder($id) {
            $query = "SELECT orders.id, orders.member_id, orders.order_status, 
            DATE(`orders`.`created_at`) as 'orderDate', members.name FROM orders INNER JOIN members ON orders.member_id = members.id  WHERE order_status = '$id'";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        function updateOrderStatus($id, $order) {
            $query = "UPDATE orders SET order_status = $order WHERE id = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
        }

        function updatePaymentStatus($id, $order) {
            $query = "UPDATE orders SET order_status = $order, payment_status = '1' WHERE id = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
        }

        function getOrderById($id) {
            $query = "SELECT members.name as 'orderName', members.email as 'orderEmail', members.phone as 'orderPhone', 
            members.address as 'orderAddress', orders.name as 'receiverName', orders.address as 'receiverAddress', 
            orders.phone as 'receiverPhone', orders.email as 'receiverEmail', orders.note as 'receiverNote', 
            orders_method.name as 'paymentMethod', coupon.name as 'couponName', orders.total FROM members INNER JOIN orders ON members.id = orders.member_id 
            JOIN orders_method ON orders.order_method_id = orders_method.id INNER JOIN coupon ON coupon.id = orders.coupon_id WHERE orders.id = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch();
        }

        function getProductsFromOrder($id) {
            $query = "SELECT orders.id, orders_details.product_type_id, orders_details.quantity, orders_details.price_sale, 
            products_type.product_id, products.name FROM orders_details INNER JOIN products_type 
            ON products_type.id = orders_details.product_type_id INNER JOIN products ON products.id = products_type.product_id 
            INNER JOIN orders ON orders.id = orders_details.order_id WHERE orders.id = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        function getProductTypeFromProductId($id) {
            $query = "SELECT * FROM products_type WHERE products_type.product_id = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        function getProductAttributes($id, $attribute) {
            $query = "SELECT products_attributes.value FROM products_attributes INNER JOIN products_type_attributes ON products_attributes.id = products_type_attributes.attributes_id WHERE products_type_attributes.product_type_id = $id AND products_attributes.name LIKE '%$attribute%'";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch();
        }
    } 
?>