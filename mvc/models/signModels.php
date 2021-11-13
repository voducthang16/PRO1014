<?php
    class signModels extends database {
        function checkExistAttribute($column, $username) {
            $sql = "SELECT * FROM users WHERE $column = ?";
            $result = $this->connect->prepare($sql);
            $result->execute([$username]);
            return $result->rowCount();
        }

        function createAccount($username, $email, $name, $password) {
            $sql = "INSERT INTO members(username, email, name, password) VALUES('$username', '$email', '$name', '$password')";
            $result = $this->connect->prepare($sql);
            $result->execute();
        }

        function checkLogin($username, $password) {
            $sql = "SELECT * FROM members WHERE username = ? AND password = ?";
            $result = $this->connect->prepare($sql);
            $result->execute([$username, $password]);
            return $result->rowCount();
        }
    }
?>