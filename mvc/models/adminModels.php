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
            $result->execute();
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
    } 
?>