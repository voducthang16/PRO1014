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
                $check = $this->admin->checkExistName('category', $name, $id);
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
                    $format = array("JPG", "JPEG", "PNG", "GIF", "BMP", "jpg", "jpeg", "png", "gif", "bmp");

                    foreach ($_FILES["product-list-images"]['tmp_name'] as $key => $value) {
                        $filename = $_FILES['product-list-images']['name'][$key];
                        $filename_tmp = $_FILES['product-list-images']['tmp_name'][$key];
                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                        $filename = time().'_'.$filename;
                        if (!in_array($ext, $format)) {
                            echo '<script>alert("File khong dung dinh dang. Anh Con");</script>';
                            header("Refresh: 0");
                            return;
                        }
                    }

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

                    $product_thumbnail = $_FILES["product-thumbnail"]['name'];
                    $product_thumbnail_tmp = $_FILES["product-thumbnail"]['tmp_name'];
                    $exp3 = substr($product_thumbnail, strlen($product_thumbnail) - 3);
                    $exp4 = substr($product_thumbnail, strlen($product_thumbnail) - 4);
                    $product_thumbnail = time()."_".$product_thumbnail;
                    
                    if (in_array($exp3, $format) || in_array($exp4, $format)) {
                        $result = $this->admin->addProduct($product_category, $product_name, $product_slug, $product_thumbnail, $product_description, $product_parameters, $product_status);
                        if ($result == true) {
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
    
                            foreach ($_FILES["product-list-images"]['tmp_name'] as $key => $value) {
                                $filename = $_FILES['product-list-images']['name'][$key];
                                $filename_tmp = $_FILES['product-list-images']['tmp_name'][$key];
                                $ext = pathinfo($filename, PATHINFO_EXTENSION);

                                $filename = time().'_'.$filename;
                                if (in_array($ext, $format)) {
                                    move_uploaded_file($filename_tmp, $storage . $filename);
                                    $this->admin->addProductImages($product_id, $filename);
                                }
                            }
                            echo '<script>alert("Thêm thành công.");</script>';
                        }
                    } else {
                        echo '<script>alert("File khong dung dinh dang. Anh thumbnail");</script>';
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
        
        // product details
        function productDetails() {
            if (isset($_POST['productId'])) {
                $product_id = $_POST['productId'];
                $result = $this->admin->getProductTypeFromProductId($product_id);
                $output = '<h5 class="text-center">Thông tin sản phẩm #'.$product_id.'</h5>';
                $output .= '
                <div class="row>
                    <div class="col l-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" class="text-center">Loại sản phẩm</th>
                                    <th scope="col" class="text-center">Giá gốc</th>
                                    <th scope="col" class="text-center">Giá bán</th>
                                    <th scope="col" class="text-center">Số lượng</th>
                                    <th scope="col" class="text-center">Đã bán</th>
                                </tr>
                            </thead>
                            <tbody>';
                $count = 1;
                foreach ($result as $item) {
                    $output .= '
                    <tr>
                        <th width="5%" scope="row">'.$count++.'</th>
                        <td width="20%" class="text-center">
                            <h4>Size: '.($this->admin->getProductAttributes($item['id'], "size")['value'] != "" ? $this->admin->getProductAttributes($item['id'], "size")['value'] : "Free Size").'</h4>
                            <h4>Color: <span style="background-color: '.$this->admin->getProductAttributes($item['id'], "color")['value'].'" class="product-color-order-detail"></span></h4>
                        </td>
                        <td width="20%" class="text-center">'.number_format($item['price_origin']).'đ</td>
                        <td width="20%" class="text-center">'.number_format($item['price_sale']).'đ</td>
                        <td width="15%" class="text-center">'.$item['quantity'].'</td>
                        <td width="15%" class="text-center">'.$item['purchases'].'</td>
                    </tr>
                    ';
                }
                $output .= '</tbody>
                        </table>
                    </div>
                </div>';
            }
            echo $output;
        }

        function product_update() {
            if (empty($_POST['update-product-by-id'])) {
                // header("Location:".BASE_URL."admin/product");
            }

            if (isset($_POST['u-product-id'])) {
                $product_size = [];
                $product_color = [];

                if (isset($_POST["product_size"])) {
                    $product_size = $_POST["product_size"];
                }

                if (isset($_POST["product-color"])) {
                    $product_color = $_POST["product-color"];
                }
                $product_name = $_POST['u-product-name'];
                $product_slug = to_slug($product_name);
                $product_category = $_POST['product-category'];
                
                $product_description = $_POST["product-description"];
                $product_parameters = $_POST["product-parameters"];
                $product_status = $_POST["product-status"];

                $product_price_origin = $_POST["product-price-origin"];
                $product_price_sale = $_POST["product-price-sale"];
                $product_quantity = $_POST["product-quantity"];

                $product_thumbnail_origin = $this->admin->getProductById($_POST['u-product-id'])['thumbnail'];

                $product_thumbnail = $_FILES["product-thumbnail"]['name'];
                $product_thumbnail_tmp = $_FILES["product-thumbnail"]['tmp_name'];

                $exp3 = substr($product_thumbnail, strlen($product_thumbnail) - 3);
                $exp4 = substr($product_thumbnail, strlen($product_thumbnail) - 4);

                $format = array("JPG", "JPEG", "PNG", "GIF", "BMP", "jpg", "jpeg", "png", "gif", "bmp");
                $storage = 'public/upload/'.$_POST['u-product-id'].'/';

                if (strlen($product_thumbnail) > 0) {
                    if (in_array($exp3, $format) || in_array($exp4, $format)) {
                        $product_thumbnail = time()."_".$product_thumbnail;
                        move_uploaded_file($product_thumbnail_tmp, $storage . $product_thumbnail);
                        unlink($storage.$product_thumbnail_origin);
                    } else {
                        echo '<script>alert("File khong dung dinh dang.");</script>';
                    }
                }

                if (strlen($product_thumbnail) == 0) {
                    $product_thumbnail = $product_thumbnail_origin;
                }
                
                var_dump($product_thumbnail); echo "<br>";
                var_dump($product_size); echo "<br>";
                var_dump($product_color); echo "<br>";
                var_dump($product_price_origin); echo "<br>";
                var_dump($product_price_sale); echo "<br>";
                var_dump($product_quantity); echo "<br>";
                var_dump($storage); echo "<br>";
                var_dump($product_quantity); echo "<br>";
                var_dump($product_name); echo "<br>";
                var_dump($product_slug); echo "<br>";
                var_dump($product_category); echo "<br>";
                var_dump($product_description); echo "<br>";
                var_dump($product_parameters); echo "<br>";
                var_dump($product_status); echo "<br>";
                // $this->admin->updateNameProduct($_POST['u-product-name'], $_POST['u-product-id']);
            }

            $this-> view("admin/index", [
                "page" => "product_update",
                "product" => $this->admin->getProductById($_POST['update-product-by-id']),
                "getCategories" => $this->admin->getCategories(),
                "getLetterSizes" => $this->admin->getAttributes("letter_size"),
                "getNumberSizes" => $this->admin->getAttributes("number_size"),
                "getColors" => $this->admin->getAttributes("color"),
                "getProductTypeIdById" => $this->admin->getProductTypeIdById($_POST['update-product-by-id']),
            ]);
        }

        function checkExistName() {
            if (isset($_POST['productId'])) {
                $product_id = $_POST['productId'];
                $product_name = $_POST['productName'];
                $product_name = trim($product_name);
                $check = $this->admin->checkExistName('products', $product_name, $product_id);
                if ($check == 1) {
                    echo "ten san pham da ton tai";
                } else {
                    return;
                }
            }
        }

        function getProductImages() {
            if (isset($_POST['productId'])) {
                $product_id = $_POST['productId'];
                $result = $this->admin->getProductImages($product_id);
                $output = "";
                foreach ($result as $row) {
                    $output .= '<div class="col-md-4" style="position: relative;">
                        <span id="'.$row['id'].'" style="position: absolute; top: 0; right: 15px;" class="material-icons del-img">close</span>
                        <img class="box-shadow-img" style="width: 100%; vertical-align: middle" 
                        src="'.BASE_URL.'public/upload/'.$product_id.'/'.$row['image'].'" alt="Product Image">
                    </div>';
                };
                $output .= '<div style="margin-top: 20px" class="text-center">
                    <label>Them anh sản phẩm: </label>
                    <input type="file" class="upload-multi" accept="image/*" name="product-list-images[]" multiple="">
                </div>';
            }
            echo $output;
        }

        function getProductThumbnail() {
            if (isset($_POST['productId'])) {
                $product_id = $_POST['productId'];
                $result = $this->admin->getProductById($product_id)['thumbnail'];
                $output = "";
                $output .= '
                    <div class="fileinput-new thumbnail">
                        <img src="'.BASE_URL.'public/upload/'.$product_id.'/'.$result.'" alt="Product Image">
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                    <div>
                    <span class="btn btn-rose btn-round btn-file">
                        <span class="fileinput-new">Chọn ảnh bìa</span>
                        <span class="fileinput-exists">Thay đổi</span>
                        <input style="z-index: 2 !important;" type="file" name="product-thumbnail" id="u-product-thumbnail" accept="image/*" />
                    </span>
                    <a href="#delImg" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Xóa</a>
                    </div>
                ';
                echo $output;
            }
        }

        function updateThumbnail() {
            if (isset($_FILES['product-thumbnail']['name'])) {
                $storage = 'public/upload/21/';
                // $image = $_POST['image'];
                
                echo 'test';
            }
        }

        function deleteImage() {
            if (isset($_POST['id'])) {
                $id = $_POST['id'];
                $product_id = $_POST['productId'];

                $name = $this->admin->getProductImagesById($id)['image'];

                $storage = 'public/upload/'.$product_id.'/';
                unlink($storage.$name);

                $this->admin->deleteImage($id);
                echo "Image deleted successfully";
            }
        }

        // coupon
        function coupon() {
            if (isset($_POST['coupon-name'])) {
                $name = $_POST['coupon-name'];
                $type = $_POST['coupon-type'];
                if ($type == 1) {
                    $value = $_POST['coupon-value-percent'];
                } else {
                    $value = $_POST['coupon-value-money'];
                }
                $quantity = $_POST['coupon-quantity'];
                $note = $_POST['coupon-note'];
                $date_start = $_POST['coupon-date-start'];
                $date_end = $_POST['coupon-date-end'];
                $min_order = 0;
                if (isset($_POST['coupon-value-min-order'])) {
                    $min_order = $_POST['coupon-value-min-order'];
                }
                $this->admin->insertCoupon($name, $type, $value, $min_order, $quantity, $note, $date_start, $date_end);
                echo '<script>alert("Them tc.");</script>';

                header("Refresh: 0");
            }
            if (isset($_POST['u-coupon-id'])) {
                $id = $_POST['u-coupon-id'];
                $name = $_POST['u-coupon-name'];
                $type = $_POST['u-coupon-type'];
                if ($type == 1) {
                    $value = $_POST['u-coupon-value-percent'];
                } else {
                    $value = $_POST['u-coupon-value-money'];
                }
                $quantity = $_POST['u-coupon-quantity'];
                // $note = $_POST['u-coupon-note'];
                $date_start = $_POST['u-coupon-date-start'];
                $date_end = $_POST['u-coupon-date-end'];
                $min_order = $_POST['u-coupon-value-min-order'];
                $this->admin->updateCoupon($id, $name, $type, $value, $min_order, $quantity, $date_start, $date_end);
                echo '<script>alert("cn tc.");</script>';

                header("Refresh: 0");
            }

            if (isset($_POST['delete-coupon-id'])) {
                $id = $_POST['delete-coupon-id'];
                $check = $this->admin->checkExistCoupon($id);
                if ($check > 0) {
                    echo '<script>alert("k xoa dc.");</script>';
                } else {
                    $this->admin->deleteCoupon($id);
                    echo '<script>alert("xoa thanh cong.");</script>';
                }
                header("Refresh: 0");
            }

            $this -> view("admin/index", [
                "page" => "coupon",
                "getCoupon" => $this->admin->getCoupon(),
            ]);
        }

        // order
        function order($param) {
            $status = 0;
            $title = "";
            switch($param) {
                case 'unprocessed': 
                    $title = "Đơn hàng chưa xử lý";
                    $status = 0;
                    break;
                case 'processing':
                    $title = "Đơn hàng đang xử lý";
                    $status = 1;
                    break;
                case 'processed':
                    $title = "Đơn hàng đã xử lý";
                    $status = 2;
                    break;
                case 'cancelled':
                    $title = "Đơn hàng hủy bỏ";
                    $status = 3;
                    break;
            }

            if (isset($_POST['update-order-id'])) {
                $orderId = $_POST['update-order-id'];
                $orderStatus = $_POST['u-order-status'];
                if ($orderStatus == '2') {
                    $this->admin->updatePaymentStatus($orderId, $orderStatus);
                } else {
                    $this->admin->updateOrderStatus($orderId, $orderStatus);
                }
                echo '<script>alert("cap nhat tc.");</script>';
                header("Refresh: 0");
            }

            $this -> view("admin/index", [
                "page" => "order",
                "getOrder" => $this->admin->getOrder($status),
                "title" => $title,
                "status" => $status,
            ]);
        }

        function getOrderInfo() {
            if (isset($_POST['orderId'])) {
                $orderId = $_POST['orderId'];
                $result = $this->admin->getOrderById($orderId);
                $products = $this->admin->getProductsFromOrder($orderId);
                $output = '<h6 class="text-center">Đơn hàng #'.$orderId.'</h6>';
                $output .= '<div class="row">
                <div class="col-6">
                    <h3>Thông tin người đặt hàng</h3>
                    <h5>Họ tên: '.$result['orderName'].'</h5>
                    <h5>Số điện thoại: '.$result['orderPhone'].'</h5>
                    <h5>Email: '.$result['orderEmail'].'</h5>
                    <h5>Địa chỉ: '.$result['orderAddress'].'</h5>
                    <h5>Phương thức thanh toán: '.$result['paymentMethod'].'</h5>
                    <h5>Coupon: '.$result['couponName'].'</h5>
                </div>
                <div class="col-6 text-right">
                    <h3>Thông tin người nhận hàng</h3>
                    <h5>Họ tên: '.$result['receiverName'].'</h5>
                    <h5>Số điện thoại: '.$result['receiverPhone'].'</h5>
                    <h5>Email: '.$result['receiverEmail'].'</h5>
                    <h5>Địa chỉ: '.$result['receiverAddress'].'</h5>
                    <h5>Ghi chú: '.$result['receiverNote'].'</h5>
                </div>
                <div class="col-12">
                    <h3 class="text-center">Các sản phẩm đặt mua</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" class="text-center">Tên sản phẩm</th>
                                    <th scope="col" class="text-center">Loại sản phẩm</th>
                                    <th scope="col" class="text-center">Giá bán</th>
                                    <th scope="col" class="text-center">Số lượng</th>
                                    <th scope="col" class="text-right">Tổng cộng</th>
                                </tr>
                            </thead>
                            <tbody>';
                $count = 1;
                foreach($products as $item) {
                    $output .= '
                        <tr>
                            <th width="5%" scope="row">'.$count++.'</th>
                            <td width="25%" class="text-center">'.$item['name'].'</td>
                            <td width="20%" class="text-center">
                                <h4>Size: '.($this->admin->getProductAttributes($item['product_type_id'], "size")['value'] != "" ? $this->admin->getProductAttributes($item['product_type_id'], "size")['value'] : "Free Size").'</h4>
                                <h4>Color: <span style="background-color: '.$this->admin->getProductAttributes($item['product_type_id'], "color")['value'].'" class="product-color-order-detail"></span></h4>
                            </td>
                            <td width="20%" class="text-center">'.number_format($item['price_sale']).'đ</td>
                            <td width="15%" class="text-center">'.$item['quantity'].'</td>
                            <td width="15%" class="text-right">'.number_format($item['quantity'] * $item['price_sale']).'đ</td>
                        </tr>
                    ';
                }

                $output .= '<tr style="font-weight: 600;">
                                <td colspan="5" class="text-center">Tổng tiền:</td>
                                <td class="text-right">
                                    '.number_format($result['total']).'đ
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>';
                echo $output;
            }
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