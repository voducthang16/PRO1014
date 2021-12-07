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
            $query = "INSERT INTO category(name, slug, status) VALUES (:name, :slug,:status)";
            $result = $this->connect->prepare($query);
            $result->bindValue(':name', $name, PDO::PARAM_STR);
            $result->bindValue(':slug', $slug, PDO::PARAM_STR);
            $result->bindValue(':status', $status, PDO::PARAM_INT);
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
            VALUES ('$category_id', :name, '$slug', '$thumbnail', :description, :parameters, '$status')";
            $result = $this->connect->prepare($query);
            $result->bindValue(':name', $name, PDO::PARAM_STR);
            $result->bindValue(':description', $description, PDO::PARAM_STR);
            $result->bindValue(':parameters', $parameters, PDO::PARAM_STR);
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
            $query = "SELECT products.*,category.name as nameCategory FROM products INNER JOIN category ON products.category_id = category.id WHERE products.id = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch();
        }

        function getProductDetails($id) {
            $query = "SELECT products.id, products.category_id, products_type.* FROM products_type 
            INNER JOIN products on products_type.product_id = products.id WHERE products.id = $id and products_type.status = 1";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        function getAttributesByTypeId($id, $attribute) {
            $query = "SELECT products_attributes.name, products_attributes.value FROM products_attributes 
            INNER JOIN products_type_attributes on products_attributes.id = products_type_attributes.attributes_id 
            WHERE products_type_attributes.product_type_id = $id AND products_attributes.name LIKE '%$attribute%'";
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

        // get product type id from order details
        function getProductTypeIdById($product_id) {
            $query = "SELECT orders_details.product_type_id FROM orders_details 
            INNER JOIN products_type ON products_type.id = orders_details.product_type_id 
            INNER JOIN products ON products.id = products_type.product_id WHERE products.id = ? GROUP BY orders_details.product_type_id";
            $result = $this->connect->prepare($query);
            $result->execute([$product_id]);
            return $result->fetchAll();
        }

        // get product type id from cart temporary
        function getProductTypeIdFromCartTemporary($product_id) {
            $query = "SELECT DISTINCT cart_temporary.product_type_id FROM cart_temporary 
            INNER JOIN products_type ON products_type.id = cart_temporary.product_type_id 
            WHERE products_type.product_id = $product_id";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        // get product type status = 0
        function getProductTypeIdInactive($product_id) {
            $query = "SELECT products_type.id FROM products_type WHERE products_type.product_id = $product_id AND products_type.status = 0";
            $result = $this->connect->prepare($query);
            $result->execute();
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
            $query = "SELECT * FROM products_type WHERE products_type.product_id = $id AND products_type.status = 1";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        function getProductAttributes($id, $attribute) {
            $query = "SELECT products_attributes.value FROM products_attributes 
            INNER JOIN products_type_attributes ON products_attributes.id = products_type_attributes.attributes_id 
            WHERE products_type_attributes.product_type_id = $id AND products_attributes.name LIKE '%$attribute%'";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch();
        }

        function getComments() {
            $query = "SELECT comments.id, comments.member_id, comments.product_id, comments.content, comments.star, comments.star, comments.status, 
            DATE(comments.created_at) as 'date', members.name FROM `comments` INNER JOIN members ON members.id = comments.member_id";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        function updateComment($id,$status) {
            $query = "UPDATE comments SET status = ? WHERE id = ?";
            $result = $this->connect->prepare($query);
            $result->execute([$status, $id]);
        }

        function deleteComment($id) {
            $query = "DELETE FROM comments WHERE id = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
        }
        // update product
        function updateNameProduct($name, $id) {
            $query = "UPDATE products SET name = '$name' WHERE id = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
        }

        function updateProduct($name, $slug, $thumbnail, $description, $parameters, $status, $id) {
            $query = "UPDATE products SET name = :name, slug = '$slug', thumbnail = '$thumbnail', 
            description = :description, parameters = :parameters, status = '$status' WHERE id = '$id'";
            $result = $this->connect->prepare($query);
            $result->bindValue(':name', $name, PDO::PARAM_STR);
            $result->bindValue(':description', $description, PDO::PARAM_STR);
            $result->bindValue(':parameters', $parameters, PDO::PARAM_STR);
            $result->execute();
        }

        function getProductTypeIds($id) {
            $query = "SELECT id FROM products_type WHERE products_type.product_id = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        function get_type_id($id_product,$color,$size,$row) {
            $query = "SELECT product_type_id FROM products_type_attributes 
            INNER JOIN products_type ON product_type_id = products_type.id 
            INNER JOIN products ON products_type.product_id = products.id 
            WHERE products.id = ? AND attributes_id IN (?,?) 
            GROUP BY product_type_id HAVING COUNT(1) = ?";
            $result = $this->connect->prepare($query);
            $result->execute([$id_product,$color, $size,$row]);
            return $result->fetch()['product_type_id'];
        }

        function updateProductType($id, $price_origin, $price_sale, $quantity) {
            $query = "UPDATE products_type SET price_origin = '$price_origin', price_sale = '$price_sale', quantity = '$quantity', status = 1 WHERE id = '$id'";
            $result = $this->connect->prepare($query);
            $result->execute();
        }

        function deleteProductTypeAttribute($id) {
            $query = "DELETE FROM products_type_attributes WHERE products_type_attributes.product_type_id IN ($id)";
            $result = $this->connect->prepare($query);
            $result->execute();
        }

        function deleteProductType($id) {
            $query = "DELETE FROM products_type WHERE id = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
        }

        function getProductAttributeId($value) {
            $query = "SELECT id FROM products_attributes WHERE value = '$value'";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch()['id'];
        }

        function getProductTypeIdByAttributeId($product_id, $attribute_id) {
            $query = "SELECT products_type_attributes.product_type_id FROM products_type_attributes INNER JOIN products_type 
            ON products_type.id = products_type_attributes.product_type_id WHERE products_type.product_id = $product_id 
            AND products_type_attributes.attributes_id = $attribute_id";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        function updateProductTypeStatus($id) {
            $query = "UPDATE `products_type` SET `status` = '0' WHERE `products_type`.`id` = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
        }

        function checkProductTypeInOrder($id) {
            $query = "SELECT orders_details.product_type_id FROM `orders_details` INNER JOIN products_type ON products_type.id = orders_details.product_type_id WHERE products_type.product_id = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->rowCount();
        }

        function checkProductTypeInCartTemporary($id) {
            $query = "SELECT cart_temporary.product_type_id FROM cart_temporary INNER JOIN products_type 
            ON products_type.id = cart_temporary.product_type_id WHERE products_type.product_id = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->rowCount();
        }

        function updateStatusProductWhenDelete($id) {
            $query = "UPDATE `products` SET `status` = '0' WHERE `products`.`id` = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
        }

        function deleteProduct($id) {
            $query = "DELETE FROM products WHERE id = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
        }

        function deleteProductImage($name) {
            $query = "DELETE FROM products_images WHERE image = '$name'";
            $result = $this->connect->prepare($query);
            $result->execute();
        }

        function getProductTypeIdFromOrder($order) {
            $query = "SELECT * FROM `orders_details` WHERE orders_details.order_id = $order";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        function updateProductTypeQuantity($id, $quantity) {
            $query = "UPDATE `products_type` SET `quantity` = `quantity` - $quantity, `purchases` = `purchases` + $quantity WHERE `products_type`.`id` = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
        }


        function getAttributesUpdate($name) {
            $query = "SELECT * FROM `products_attributes` WHERE name = ? AND status = 1";
            $result = $this->connect->prepare($query);
            $result->execute([$name]);
            return $result->fetchAll();
        }

        function addProductAttribute($name, $value) {
            $query = "INSERT INTO `products_attributes` (`name`, `value`, `status`) VALUES ('$name', '$value', '1')";
            $result = $this->connect->prepare($query);
            $result->execute();
        }

        function checkExistAttribute($attribute) {
            $query = "SELECT * FROM products_attributes WHERE value = '$attribute'";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->rowCount();
        }
        function checkExistAttributes($attribute) {
            $query = "SELECT * FROM products_attributes WHERE value = '$attribute'";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result;
        }

        function checkExistAttributeById($id, $attribute, $value) {
            $query = "SELECT DISTINCT products_attributes.id, products_attributes.value FROM products_attributes 
            INNER JOIN products_type_attributes ON products_attributes.id = products_type_attributes.attributes_id 
            WHERE products_type_attributes.product_type_id IN (SELECT products_type.id 
            FROM products_type WHERE products_type.product_id = $id AND products_type.status = 1) 
            AND products_attributes.name LIKE '%$attribute%' AND products_attributes.value = $value";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->rowCount();
        }

        function updateColumn($prd_id,$type_id,$column,$value){
            $query = "UPDATE `products_type` SET $column=$value WHERE product_id = $prd_id and id = $type_id";
            $result = $this->connect->prepare($query);
            $result->execute();
        }

        // function getTypeIdByAttribute($id, $attribute_id){
        //     $query = "SELECT * FROM products_type INNER JOIN products_type_attributes
        //     ON products_type.id = products_type_attributes.product_type_id 
        //     WHERE products_type_attributes.attributes_id = $attribute_id
        //     AND products_type.product_id = $id";
        //     $result = $this->connect->prepare($query);
        //     $result->execute();
        //     return $result->fetchAll();
        // }

        function selectPrdTypeById($id){
            $query = "SELECT * FROM `products_type` WHERE products_type.product_id = $id AND products_type.status = 1";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        function updateColumnAll($prd_id,$type_id,$price_origin,$price_sale,$quantity){
            $query = "UPDATE `products_type` SET price_origin = $price_origin, price_sale = $price_sale, quantity = $quantity WHERE product_id = $prd_id and id = $type_id";
            $result = $this->connect->prepare($query);
            $result->execute();
        }

        function updateAttributeStatus($attribute) {
            $query = "UPDATE `products_attributes` SET `status` = '1' WHERE `products_attributes`.`value` = '$attribute'";
            $result = $this->connect->prepare($query);
            $result->execute();
        }

        function updateAttributeStatusZero($attribute) {
            $query = "UPDATE `products_attributes` SET `status` = '0' WHERE `products_attributes`.`value` = '$attribute'";
            $result = $this->connect->prepare($query);
            $result->execute();
        }

        function getUsers() {
            $query = "SELECT * FROM `members`";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->rowCount();
        }

        function getAllOrder() {
            $query = "SELECT * FROM `orders`";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->rowCount();
        }

        function getAllComments() {
            $query = "SELECT * FROM `comments`";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->rowCount();
        }

        function getTop5ProductsPurchases() {
            $query = "SELECT products_type.product_id, SUM(products_type.purchases) as 'sum', products.name, products.thumbnail FROM products_type INNER JOIN products ON products.id = products_type.product_id GROUP BY products_type.product_id ORDER BY sum DESC LIMIT 5";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        function getMoneyCategory() {
            $query = "SELECT category.name, SUM(orders_details.price_sale * orders_details.quantity) as price FROM category JOIN products ON category.id = products.category_id JOIN products_type ON products_type.product_id IN (products.id) JOIN orders_details ON products_type.id = orders_details.product_type_id JOIN orders ON orders_details.order_id = orders.id WHERE orders.order_status = 2 AND orders.payment_status = 1 GROUP BY category.name";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        function getTotalMoney() {
            $query = "SELECT SUM(orders.total) as 'total' FROM orders WHERE orders.order_status = 2 AND orders.payment_status = 1";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch()['total'];
        }

        function getProductAttributeUpdate($attribute, $id) {
            $query = "SELECT DISTINCT products_attributes.id, products_attributes.value FROM products_attributes INNER JOIN products_type_attributes 
            ON products_attributes.id = products_type_attributes.attributes_id 
            WHERE products_type_attributes.product_type_id 
            IN (SELECT products_type.id FROM products_type WHERE products_type.product_id = $id AND products_type.status = 1) 
            AND products_attributes.name LIKE '%$attribute%'";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }
        
        function getOrderToday() {
            $query = "SELECT * FROM orders WHERE DATE(orders.created_at) = CURDATE()";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->rowCount();
        }

        function getOrderSuccessToday() {
            $query = "SELECT * FROM orders WHERE DATE(orders.created_at) = CURDATE() AND order_status = 2";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->rowCount();
        }

        function getTotalSuccessToday() {
            $query = "SELECT SUM(orders.total) as total FROM orders WHERE DATE(orders.created_at) = CURDATE() AND order_status = 2";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch()['total'];
        }

        function getViewPrd() {
            $query = "SELECT SUM(products.view) as view FROM products";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch()['view'];
        }
    } 
?>