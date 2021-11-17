<?php
    class admin extends controller {
        public $admin;

        function __construct() {
            $this-> admin = $this->model("adminModels");
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
                $name = mb_convert_case($name, MB_CASE_TITLE, "UTF-8");
                $slug = to_slug($name);
                $status = $_POST['category-status'];
                $check = $this->admin->checkExistName('category', $name);
                if ($check == 1) {
                    echo '<script>alert("Ten danh muc da tồn tại.");</script>';
                } else {
                    $this->admin->addCategory($name, $slug, $status);
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

            // delete category
            if (isset($_POST['delete-category-id'])) {
                $category_id = $_POST['delete-category-id'];
                $count = $this->admin->countProductsByCategory($category_id);
                if ($count > 0) {
                    echo '<script>alert("k xoa duoc.");</script>';
                    $this->admin->updateCategoryStatus($category_id);
                } else {
                    $this->admin->deleteCategory($category_id);
                    echo '<script>alert("da xoa.");</script>';
                }

                header("Refresh: 0");
            }

            // load view
            $this -> view("admin/index", [
                "page" => "category",
                "getCategories" => $this->admin->getCategories(),
            ]);
        }

        // admin product
        function product() {
            // add product
            if (isset($_POST['product-name'])) {
                $product_name = $_POST['product-name'];
                $product_name = mb_convert_case($product_name, MB_CASE_TITLE, "UTF-8");
                $check = $this->admin->checkExistName('products', $product_name);
                if ($check == 1) {
                    echo '<script>alert("Ten san pham da tồn tại.");</script>';
                } else {
                    $product_slug = to_slug($product_name);
                    $product_category = $_POST['product-category'];
                    
                    $product_description = $_POST["product-description"];
                    $product_parameters = $_POST["product-parameters"];
                    $product_status = $_POST["product-status"];

                    $product_size = [];
                    $product_color = [];

                    if (isset($_POST["product_size"])) {
                        $product_size = $_POST["product_size"];
                    }

                    if (isset($_POST["product-color"])) {
                        $product_color = $_POST["product-color"];
                    }

                    $product_price_origin = $_POST["product-price-origin"];
                    $product_price_sale = $_POST["product-price-sale"];
                    $product_quantity = $_POST["product-quantity"];

                    $length = count($product_quantity);

                    $format = array("JPG", "JPEG", "PNG", "GIF", "BMP", "jpg", "jpeg", "png", "gif", "bmp");

                    $product_thumbnail = $_FILES["product-thumbnail"]['name'];
                    $product_thumbnail_tmp = $_FILES["product-thumbnail"]['tmp_name'];
                    $exp3 = substr($product_thumbnail, strlen($product_thumbnail) - 3);
                    $exp4 = substr($product_thumbnail, strlen($product_thumbnail) - 4);
                    $product_thumbnail = time()."_".$product_thumbnail;

                    

                    if (in_array($exp3, $format) || in_array($exp4, $format)) {
                        $this->admin->addProduct($product_category, $product_name, $product_slug, $product_thumbnail, $product_description, $product_parameters, $product_status);

                        $product_id = $this->admin->getProductId();

                        $j = 0;
                        $k = 0;
                        for ($i = 0; $i < $length; $i++) {
                            $this->admin->addProductType($product_id, $product_price_origin[$i], $product_price_sale[$i], $product_quantity[$i]);

                            $product_type_id = $this->admin->getProductTypeId();

                            if ($k == count($product_color)) {
                                $j++;
                                $k = 0;
                            }

                            if (count($product_size) > 0) {
                                $this->admin->addProductTypeAttribute($product_type_id, $product_size[$j]);
                            }

                            $this->admin->addProductTypeAttribute($product_type_id, $product_color[$k]);
                            $k++;
                        }

                        mkdir("public/upload/$product_id", 0777, true);

                        $storage = "public/upload/$product_id/";
                        move_uploaded_file($product_thumbnail_tmp, $storage . $product_thumbnail);

                        if (isset($_FILES["product-list-images"])) {
                            foreach ($_FILES["product-list-images"]['tmp_name'] as $key => $value) {
                                $filename = $_FILES['product-list-images']['name'][$key];
                                $filename_tmp = $_FILES['product-list-images']['tmp_name'][$key];
                                $ext = pathinfo($filename, PATHINFO_EXTENSION);

                                $filename = time().'_'.$filename;
                                if (in_array($ext, $format)) {
                                    move_uploaded_file($filename_tmp, $storage . $filename);
                                    $this->admin->addProductImages($product_id, $filename);
                                } else {
                                    echo '<script>alert("File khong dung dinh dang.");</script>';
                                }
                            }
                        }

                        echo '<script>alert("Thêm thành công.");</script>';
                    }

                }
                header("Refresh: 0");
            }



            // load view
            $this -> view("admin/index", [
                "page" => "product",
                "getProducts" => $this->admin->getProducts(),
                "getCategories" => $this->admin->getCategories(),
                "getLetterSizes" => $this->admin->getAttributes("letter_size"),
                "getNumberSizes" => $this->admin->getAttributes("number_size"),
                "getColors" => $this->admin->getAttributes("color"),
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