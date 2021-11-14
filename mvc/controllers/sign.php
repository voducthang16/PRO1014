<?php
    class sign extends controller {
        public $sign;

        function __construct() {
            $this->sign = $this->model('signModels');
        }

        function show() {
            if (isset($_POST["su-username"])) {
                $username = $_POST["su-username"];
                $email = $_POST["su-email"];
                $name = $_POST["su-name"];
                $password = $_POST["su-password"];
                
                $this->sign->createAccount($username, $email, $name, $password);
                echo '<script>alert("Tao tk thanh cong.");</script>';
                header("Refresh: 0");
            }

            if (isset($_POST["si-username"])) {
                $username = $_POST["si-username"];
                $password = $_POST["si-password"];
                $check = $this->sign->checkLogin($username, $password);
                if ($check == 0) {
                    echo '<script>alert("TK KHONG CHINH XAC.");</script>';
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

        function checkExistAttribute() {
            $attribute = $_POST['attribute'];
            $column = $_POST['column'];
            $result = $this -> sign -> checkExistAttribute($column, $attribute);
            echo $result;
        }
    }
?>