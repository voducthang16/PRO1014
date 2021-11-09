<?php
    class adminModels extends database {
        function checkLogin($username, $password) {
            $query = "SELECT * FROM `admin` WHERE username = ? AND password = ? AND status = 1";
            $result = $this->connect->prepare($query);
            $result->execute([$username, $password]);
            return $result->rowCount();
        }

        function getCategories() {
            $query = "SELECT * FROM `category`";
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
            
        }

        function getProducts() {
            $query = "SELECT * FROM `products`";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }

        function getAttributes($name) {
            $query = "SELECT * FROM `attributes` WHERE name = ?";
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

        function addProduct($category_id, $name, $slug, $price_origin, $price_sale, $quantity, $thumbnail, $description, $parameters, $status, $size, $color) {
            $query = "INSERT INTO products(category_id, name, slug, price_origin, price_sale, quantity, thumbnail, description, parameters, status) 
            VALUES ('$category_id', '$name', '$slug', '$price_origin', '$price_sale', '$quantity','$thumbnail', '$description', '$parameters', '$status')";
            $result = $this->connect->prepare($query);
            $result->execute();

            $product_id = $this->getProductId();

            foreach ($size as $value) {
                $query = "INSERT INTO products_attributes(product_id, attributes_id) VALUES ('$product_id', '$value')";
                $result = $this->connect->prepare($query);
                $result->execute();
            }

            foreach ($color as $value) {
                $query = "INSERT INTO products_attributes(product_id, attributes_id) VALUES ('$product_id', '$value')";
                $result = $this->connect->prepare($query);
                $result->execute();
            }
        }

        function addProductImages($product_id, $image) {
            $query = "INSERT INTO products_images(product_id, image) VALUES ('$product_id', '$image')";
            $result = $this->connect->prepare($query);
            $result->execute();
        }
    }
?>