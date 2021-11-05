<?php
    class admin extends controller {
        public $admin;

        function __construct() {
            $this -> admin = $this -> model("adminModels");
        }

        function show() {
            $this -> view("admin/index", []);
        }

        function login() {
            // Call Model
            if (isset($_POST['username'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $check =  $this->admin->checkLogin($username, $password);

                if ($check == 0) {
                    echo '<script>alert("Tên đăng nhập không tồn tại.");</script>';
                } else {
                    $_SESSION['admin-login'] = true;
                    $_SESSION['admin-username'] = $username;
                    header("Location:".BASE_URL."admin");
                }
            }

            // Load View
            $this -> view("admin/pages/login", []);
        }
    }
?>