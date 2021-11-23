<?php
    class sign extends controller {
        public $sign;

        function __construct() {
            $this->sign = $this->model('signModels');
        }

        function show() {
            if (isset($_POST["si-username"])) {
                $username = $_POST["si-username"];
                $password = $_POST["si-password"];
                $check = $this->sign->checkLogin($username, $password);
                if ($check == 0) {
                    echo '<script>alert("TK KHONG CHINH XAC.");</>';
                } else {
                    $_SESSION["member-login"] = "true";
                    $_SESSION["member-username"] = $username;
                    echo '<script>alert("DANG NHAP THANH CONG");</script>';
                    header("Location:".BASE_URL);
                }
                header("Refresh: 0");
            }

            $this -> view("index", [
                "page" => "sign",
            ]);
        }

        function signUp() {
            if (isset($_POST["username"])) {
                $username = $_POST["username"];
                $email = $_POST["email"];
                $name = $_POST["name"];
                $password = $_POST["password"];

                $this->sign->createAccount($username, $email, $name, $password);
                $_SESSION["member-login"] = "true";
                $_SESSION["member-username"] = $username;
                echo 'Tao tk thanh cong';
            }
        }

        function forgotpassword() {
            $this -> view("index", [
                "page" => "forgotpassword",
            ]);
        }

        function checkExistAttribute() {
            $attribute = $_POST['attribute'];
            $column = $_POST['column'];
            $check = $this ->sign-> checkExistAttribute($column, $attribute);
            echo $check;
        }
    }
?>