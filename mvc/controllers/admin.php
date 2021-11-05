<?php
    class admin extends controller {
        public $admin;

        function __construct() {
            $this -> admin = $this -> model("adminModels");
        }

        // admin homepage
        function show() {
            $this -> view("admin/index", [
                "page" => "home"
            ]);
        }

        // admin category
        function category() {
            // add category
            if (isset($_POST['category-name'])) {
                $name = $_POST['category-name'];
                $status = $_POST['category-status'];
                $check = $this->admin->checkExistCategory($name);
                if ($check == 1) {
                    echo '<script>alert("Ten danh muc da tồn tại.");</script>';
                } else {
                    $this->admin->addCategory($name, $status);
                    echo '<script>alert("Thêm thành công.");</script>';
                }
                header("Refresh: 0");
            }

            // update category
            if (isset($_POST['u-category-name'])) {
                $id = $_POST['u-category-id'];
                $name = $_POST['u-category-name'];
                $status = $_POST['u-category-status'];
                $check = $this->admin->checkExistCategory($name, $id);
                if ($check == 1) {
                    echo '<script>alert("Ten danh muc da tồn tại.");</script>';
                } else {
                    $this->admin->updateCategory($id, $name, $status);
                    echo '<script>alert("cap nhat tc.");</script>';
                }
                header("Refresh: 0");
            }

            // load view
            $this -> view("admin/index", [
                "page" => "category",
                "getCategories" => $this->admin->getCategories(),
            ]);
        }




        // admin login
        function login() {
            // check login
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

            // load view
            $this -> view("admin/pages/login", []);
        }
    }
?>