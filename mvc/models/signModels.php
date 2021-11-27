<?php
    class signModels extends database {
        function checkExistAttribute($column, $attribute) {
            $sql = "SELECT * FROM `members` WHERE members.$column = '$attribute'";
            $result = $this->connect->prepare($sql);
            $result->execute();
            return $result->rowCount();
        }

        function checkUsername($username){
            $qr = "SELECT * FROM `members` WHERE members.username = '$username'";
            $result = $this->connect->prepare($qr);
            $result->execute();
            return $result->rowCount();
        }

        function createAccount($username, $email, $name, $password) {
            $sql = "INSERT INTO members(username, email, name, password) VALUES('$username', '$email', '$name', '$password')";
            $result = $this->connect->prepare($sql);
            $result->execute();
        }

        function createFb($username,$name){
            $qr = "INSERT INTO members(username, name) VALUES('$username', '$name')";
            $result = $this->connect->prepare($qr);
            $result->execute();
        }
        function createGoogle($username,$name,$email){
            $qr = "INSERT INTO members(username, name,email) VALUES('$username', '$name','$email')";
            $result = $this->connect->prepare($qr);
            $result->execute();
        }

        function checkLogin($username, $password) {
            $sql = "SELECT * FROM members WHERE username = ? AND password = ?";
            $result = $this->connect->prepare($sql);
            $result->execute([$username, $password]);
            return $result->rowCount();
        }

        function checkEmail($email) {
            $qr = "SELECT members.email FROM members WHERE members.email = '$email'";
            $result = $this->connect->prepare($qr);
            $result->execute();
            return $result->rowCount();
        }
        
        function updateCode($email, $code) {
            $qr = "UPDATE `members` SET `code`= '$code' WHERE `email` = '$email'";
            $result = $this->connect->prepare($qr);
            $result->execute();
        }

        function checkCode($email, $code) {
            $qr = "SELECT * FROM `members` WHERE `email` = '$email' and `code` = '$code'";
            $result = $this->connect->prepare($qr);
            $result->execute();
            return $result->rowCount();
        }

        function updatePassword($password,$email,$code) {
            $qr = "UPDATE `members` SET `password`= '$password' WHERE `email` = '$email' and  `code` = '$code'";
            $result = $this->connect->prepare($qr);
            $result->execute();
        }
    }
?>