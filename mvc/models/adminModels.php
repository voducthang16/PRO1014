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

        function checkExistCategory($name, $id = 0) {
            $query = "SELECT * FROM `category` WHERE name = ? and id != ?";
            $result = $this->connect->prepare($query);
            $result->execute([$name, $id]);
            return $result->rowCount();
        }

        function addCategory($name, $status) {
            $query = "INSERT INTO category(name, status, created_at, updated_at) 
            VALUES ('$name', '$status', current_timestamp(), current_timestamp())";
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
    }
?>