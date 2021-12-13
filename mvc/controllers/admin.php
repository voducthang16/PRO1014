<?php
    class admin extends controller {
        public $admin;

        function __construct() {
            $this-> admin = $this->model("adminModels");
        }

        // admin homepage
        function show() {
            $this -> view("admin/index", [
                "page" => "home",
                "totalProducts" => $this->admin->getProducts(),
                "totalUsers" => $this->admin->getUsers(),
                "totalOrders" => $this->admin->getAllOrder(),
                "totalComments" => $this->admin->getAllComments(),
                "top5ProductsSale" => $this->admin->getTop5ProductsPurchases(),
                "moneyCategory" => $this->admin->getMoneyCategory(),
                "totalMoney" => $this->admin->getTotalMoney(),
                "countOrder" => $this->admin->getOrderToday(),
                "countOrderSuccess" => $this->admin->getOrderSuccessToday(),
                "totalMoneyToday" => $this->admin->getTotalSuccessToday(),
                "countView" => $this->admin->getViewPrd(),
            ]);
        }

        // admin category
        function category() {
            // add category
            if (isset($_POST['category-name'])) {
                $name = $_POST['category-name'];
                // $name = mb_convert_case($name, MB_CASE_TITLE, "UTF-8");
                $slug = to_slug($name);
                $status = $_POST['category-status'];
                $check = $this->admin->checkExistName('category', $name);
                if ($check == 1) {
                    $toast = array(
                        'title' => 'Warning',
                        'message' => "Tên danh mục đã tồn tại",
                        'type' => "warning",
                        'duration' => 3000
                    );
                } else {
                    $this->admin->addCategory($name, $slug, $status);
                    $toast = array(
                        'title' => 'Success',
                        'message' => "Thêm danh mục thành công",
                        'type' => "success",
                        'duration' => 3000
                    );
                }
                $_SESSION['toast_start'] = $toast;
            }

            // update category
            if (isset($_POST['u-category-name'])) {
                $id = $_POST['u-category-id'];
                $name = $_POST['u-category-name'];
                $status = $_POST['u-category-status'];
                $check = $this->admin->checkExistName('category', $name, $id);
                if ($check == 1) {
                    $toast = array(
                        'title' => 'Warning',
                        'message' => "Tên danh mục đã tồn tại",
                        'type' => "warning",
                        'duration' => 3000
                    );
                } else {
                    $this->admin->updateCategory($id, $name, $status);
                    $toast = array(
                        'title' => 'Success',
                        'message' => "Cập nhật danh mục thành công",
                        'type' => "success",
                        'duration' => 3000
                    );
                }
                $_SESSION['toast_start'] = $toast;
            }

            // delete category
            if (isset($_POST['delete-category-id'])) {
                $category_id = $_POST['delete-category-id'];
                $count = $this->admin->countProductsByCategory($category_id);
                if ($count > 0) {
                    $toast = array(
                        'title' => 'Warning',
                        'message' => "Không thể xoá được danh mục này",
                        'type' => "warning",
                        'duration' => 3000
                    );
                    $this->admin->updateCategoryStatus($category_id);
                } else {
                    $this->admin->deleteCategory($category_id);
                    $toast = array(
                        'title' => 'Success',
                        'message' => "Đã xoá danh mục thành công",
                        'type' => "success",
                        'duration' => 3000
                    );
                }
                $_SESSION['toast_start'] = $toast;
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
                // $product_name = mb_convert_case($product_name, MB_CASE_TITLE, "UTF-8");
                $check = $this->admin->checkExistName('products', $product_name);
                if ($check == 1) {
                    $toast = array(
                        'title' => 'Warning',
                        'message' => "Tên sản phẩm đã tồn tại",
                        'type' => "warning",
                        'duration' => 3000
                    );
                } else {
                    $format = array("JPG", "JPEG", "PNG", "GIF", "BMP", "jpg", "jpeg", "png", "gif", "bmp");

                    foreach ($_FILES["product-list-images"]['tmp_name'] as $key => $value) {
                        $filename = $_FILES['product-list-images']['name'][$key];
                        $filename_tmp = $_FILES['product-list-images']['tmp_name'][$key];
                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                        $filename = time().'_'.$filename;
                        if (!in_array($ext, $format)) {
                            $toast = array(
                                'title' => 'Warning',
                                'message' => "File không đúng định dạng",
                                'type' => "warning",
                                'duration' => 3000
                            );
                            $_SESSION['toast_start'] = $toast;
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
                            $toast = array(
                                'title' => 'Success',
                                'message' => "Thêm sản phẩm thành công",
                                'type' => "success",
                                'duration' => 3000
                            );
                        }
                    } else {
                        $toast = array(
                            'title' => 'Warning',
                            'message' => "File không đúng định dạng",
                            'type' => "warning",
                            'duration' => 3000
                        );
                    }

                }
                $_SESSION['toast_start'] = $toast;
            }

            // delete product
            if (isset($_POST['delete-product-id'])) {
                $id = $_POST['delete-product-id'];
                $checkOrder = $this->admin->checkProductTypeInOrder($id);
                $checkCart = $this->admin->checkProductTypeInCartTemporary($id);

                if ($checkCart > 0) {
                    $toast = array(
                        'title' => 'Warning',
                        'message' => "Không xoá được vì sản phẩm đã tồn tại trong giỏ hàng",
                        'type' => "warning",
                        'duration' => 3000
                    );
                } else if ($checkOrder > 0) {
                    $toast = array(
                        'title' => 'Warning',
                        'message' => "Không xoá được vì sản phẩm đã tồn tại trong order",
                        'type' => "warning",
                        'duration' => 3000
                    );
                    $this->admin->updateStatusProductWhenDelete($id);
                } else {
                    $product_type_ids = $this->admin->getProductTypeFromProductId($id);
                    foreach ($product_type_ids as $key=>$value) {
                        $this->admin->deleteProductTypeAttribute($value['id']);
                        $this->admin->deleteProductType($value['id']);
                    }
                    $storage = 'public/upload/'.$id.'/';
                    $product_images = $this->admin->getProductImages($id);
                    foreach ($product_images as $key=>$value) {
                        $this->admin->deleteProductImage($value['image']);
                        unlink($storage.$value['image']);
                    }
                    $this->admin->deleteProduct($id);
                    $toast = array(
                        'title' => 'Success',
                        'message' => "Xoá sản phẩm thành công",
                        'type' => "success",
                        'duration' => 3000
                    );
                }
                $_SESSION['toast_start'] = $toast;
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
        
        function getColor() {
            if (isset($_POST['value'])) {
                $value = $_POST['value'];
                $output = "";
                $result = $this->admin->getAttributesUpdate($value);
                foreach ($result as $item) {
                    $output .= '
                    <div class="products-color">
                        <div class="products-attribute-item">
                            <input class="products-attribute-input color" type="checkbox" name="product-color[]" id="'.$item["value"].'" value="'.$item["id"].'" checked>
                            <label class="products-attribute-option color" for="'.$item["value"].'">
                                <span style="background-color: '.$item["value"].'" class="products-attribute-color"></span>
                            </label>
                        </div>
                    </div>
                    ';
                }

                $output .= '
                    <div style="margin-left: 16px" class="products-color">
                        <div class="products-attribute-item">
                            <input type="color" id="add-color" class="add-color-input" name="add_color">
                            <label class="add-color">Thêm Màu</label>
                        </div>
                    </div>
                ';
                echo $output;
            }
        }

        function addColor() {
            if (isset($_POST['value'])) {
                $value = $_POST['value'];
                $check = $this->admin->checkExistAttribute($value);
                if ($check > 0) {
                    $this->admin->updateAttributeStatus($value);
                } else {
                    $this->admin->addProductAttribute("color", $value);
                }
            }
            echo $value;
        }

        function updateColorStatus() {
            if (isset($_POST['value'])) {
                $value = $_POST['value'];
                $output = "";
                $result = $this->admin->getAttributesUpdate($value);
                foreach($result as $item) {
                    $this->admin->updateAttributeStatusZero($item['value']);
                }
                $output .= '
                    <div style="margin-left: 16px" class="products-color">
                        <div class="products-attribute-item">
                            <input type="color" id="add-color" class="add-color-input" name="add_color">
                            <label class="add-color">Thêm Màu</label>
                        </div>
                    </div>
                ';
                echo $output;
            }
        }

        function getLetterSize() {
            if (isset($_POST['value'])) {
                $value = $_POST['value'];
                $output = "";
                $result = $this->admin->getAttributesUpdate($value);
                foreach ($result as $item) {
                    $output .= '
                        <div class="products-size letter">
                            <div class="products-attribute-item">
                                <input class="products-attribute-input letter" type="checkbox" name="product_size[]" id="'.$item["value"].'" value="'.$item["id"].'" checked>
                                <label class="products-attribute-option" for="'.$item["value"].'">'.$item["value"].'</label>
                            </div>
                        </div>
                    ';
                }

                $output .= '
                    <div style="margin-left: 16px" class="products-size letter">
                        <div class="products-attribute-item">
                            <input style="width: 48px;" type="text" id="add-size" class="add-letter-size-input" name="add_size">
                            <label class="add-size-l">Thêm Size</label>
                        </div>
                    </div>
                ';
                echo $output;
            }
        }

        function addLetterSize() {
            if (isset($_POST['value'])) {
                $value = $_POST['value'];
                $check = $this->admin->checkExistAttribute($value);
                if ($check > 0) {
                    $this->admin->updateAttributeStatus($value);
                } else {
                    $this->admin->addProductAttribute("letter_size", $value);
                }
            }
            echo $value;
        }

        function updateLetterSizeStatus() {
            if (isset($_POST['value'])) {
                $value = $_POST['value'];
                $output = "";
                $result = $this->admin->getAttributesUpdate($value);
                foreach($result as $item) {
                    $this->admin->updateAttributeStatusZero($item['value']);
                }
                $output .= '
                    <div style="margin-left: 16px" class="products-size letter">
                        <div class="products-attribute-item">
                            <input style="width: 48px;" type="text" id="add-size" class="add-letter-size-input" name="add_size">
                            <label class="add-size-l">Thêm Size</label>
                        </div>
                    </div>
                ';
                echo $output;
            }
        }

        function updateRemoveAttribute() {
            if (isset($_POST['value'])) {
                $value = $_POST['value'];
                $this->admin->updateAttributeStatusZero($value);
            }
        }

        function getNumberSize() {
            if (isset($_POST['value'])) {
                $value = $_POST['value'];
                $output = "";
                $result = $this->admin->getAttributesUpdate($value);
                foreach ($result as $item) {
                    $output .= '
                        <div class="products-size number">
                            <div class="products-attribute-item">
                                <input class="products-attribute-input number" type="checkbox" name="product_size[]" id="'.$item["value"].'" value="'.$item["id"].'" checked>
                                <label class="products-attribute-option" for="'.$item["value"].'">'.$item["value"].'</label>
                            </div>
                        </div>
                    ';
                }
                $output .= '
                    <div style="margin-left: 16px" class="products-size number">
                        <div class="products-attribute-item">
                            <input style="width: 48px;" type="number" class="add-number-size-input" id="add-size-n" name="add_size" min="1">
                            <label class="add-size-n">Thêm Size</label>
                        </div>
                    </div>
                ';
                echo $output;
            }
        }

        function addNumberSize() {
            if (isset($_POST['value'])) {
                $value = $_POST['value'];
                $check = $this->admin->checkExistAttribute($value);
                if ($check > 0) {
                    $this->admin->updateAttributeStatus($value);
                } else {
                    $this->admin->addProductAttribute("number_size", $value);
                }
            }
            echo $value;
        }

        function addNumberSizeById() {
            if(isset($_POST['attributes'])){
                $check = $this->admin->checkExistAttributeById($_POST['id'], $_POST['attributes'], $_POST['numberSize']);
                if ($check > 0) {
                    echo "lỗi";
                } else {
                    $result = $this->admin->getProductAttributeUpdate("color", $_POST['id']);
                    $checkSize = $this->admin->checkExistAttributes($_POST['numberSize']);
                    if($checkSize->rowCount() == 1) {
                        $id_attribute = $checkSize->fetch()['id'];
                    } else {
                        $this->admin->addProductAttribute($_POST['attributes'],$_POST['numberSize']);
                        $checkSizeN = $this->admin->checkExistAttributes($_POST['numberSize']);
                        $id_attribute = $checkSizeN->fetch()['id'];
                    }
                    foreach($result as $item){
                        $this->admin->addProductType($_POST['id'], 0, 0, 0);
                        $product_type_id = $this->admin->getProductTypeId();
                        $this->admin->addProductTypeAttribute($product_type_id, $id_attribute);
                        $this->admin->addProductTypeAttribute($product_type_id, $item['id']);
                    }
                    echo "thành công";
                }
            }   
        }

        function addColorById() {
            if(isset($_POST['attributes'])){
                $check = $this->admin->checkExistAttributeById($_POST['id'], $_POST['attributes'], $_POST['color']);
                if ($check > 0) {
                    echo "lỗi";
                } else {
                    if($_POST['category'] != 5){
                        $attributes = "size";
                        $result = $this->admin->getProductAttributeUpdate($attributes, $_POST['id']);
                        $checkSize = $this->admin->checkExistAttributes($_POST['color']);
                        if($checkSize->rowCount() == 1) {
                            $id_attribute = $checkSize->fetch()['id'];
                        } else {
                            $this->admin->addProductAttribute($_POST['attributes'],$_POST['color']);
                            $checkSizeN = $this->admin->checkExistAttributes($_POST['color']);
                            $id_attribute = $checkSizeN->fetch()['id'];
                        }
                        foreach($result as $item){
                            $this->admin->addProductType($_POST['id'], 0, 0, 0);
                            $product_type_id = $this->admin->getProductTypeId();
                            $this->admin->addProductTypeAttribute($product_type_id, $id_attribute);
                            $this->admin->addProductTypeAttribute($product_type_id, $item['id']);
                        }
                        echo "thành công";
                    } else {
                        $checkSize = $this->admin->checkExistAttributes($_POST['color']);
                        if($checkSize->rowCount() == 1) {
                            $id_attribute = $checkSize->fetch()['id'];
                        } else {
                            $this->admin->addProductAttribute($_POST['attributes'],$_POST['color']);
                            $checkSizeN = $this->admin->checkExistAttributes($_POST['color']);
                            $id_attribute = $checkSizeN->fetch()['id'];
                        }
                        $this->admin->addProductType($_POST['id'], 0, 0, 0);
                        $product_type_id = $this->admin->getProductTypeId();
                        $this->admin->addProductTypeAttribute($product_type_id, $id_attribute);
                        echo "thành công";
                    }
                }
            }  
        }

        function updateStatusType() {

            if(isset($_POST['value'])){
                $result = $this->admin->getProductTypeIdByAttributeId($_POST['id'], $_POST['value']);
                // var_dump($result);
                foreach($result as $row) {
                    $this->admin->updateProductTypeStatus($row['product_type_id']);
                }
                echo "thành công";
            }

        }

        function updateNumberSizeStatus() {
            if (isset($_POST['value'])) {
                $value = $_POST['value'];
                $output = "";
                $result = $this->admin->getAttributesUpdate($value);
                foreach($result as $item) {
                    $this->admin->updateAttributeStatusZero($item['value']);
                }
                $output .= '
                    <div style="margin-left: 16px" class="products-size number">
                        <div class="products-attribute-item">
                            <input style="width: 48px;" type="number" id="add-size-n" class="add-number-size-input" name="add_size" min="1">
                            <label class="add-size-n">Thêm Size</label>
                        </div>
                    </div>
                ';
                echo $output;
            }
        }

        function getLetterSizeUpdate() {
            if (isset($_POST['value'])) {
                $value = $_POST['value'];
                $id = $_POST['id'];
                $output = "";
                $result = $this->admin->getProductAttributeUpdate($value, $id);
                foreach ($result as $item) {
                    $output .= '
                        <div class="products-size letter">
                            <div class="products-attribute-item">
                                <input class="products-attribute-input letter" type="checkbox" name="product_size[]" id="'.$item["value"].'" value="'.$item["id"].'" checked>
                                <label class="products-attribute-option" data-value="letter_size" for="'.$item["value"].'">'.$item["value"].'</label>
                            </div>
                        </div>
                    ';
                }

                $output .= '
                    <div style="margin-left: 16px" class="products-size letter">
                        <div class="products-attribute-item">
                            <input style="width: 48px;" type="text" id="add-size" class="add-letter-size-input" name="add_size">
                            <label class="add-size-l">Thêm Size</label>
                        </div>
                    </div>
                ';
                echo $output;
            }
        }

        function getNumberSizeUpdate() {
            if (isset($_POST['value'])) {
                $value = $_POST['value'];
                $id = $_POST['id'];
                $output = "";
                $result = $this->admin->getProductAttributeUpdate($value, $id);
                foreach ($result as $item) {
                    $output .= '
                    <div class="products-size number">
                        <div class="products-attribute-item">
                            <input class="products-attribute-input number" type="checkbox" name="product_size[]" id="'.$item["value"].'" value="'.$item["id"].'" checked>
                            <label class="products-attribute-option" data-value="number_size" for="'.$item["value"].'">'.$item["value"].'</label>
                        </div>
                    </div>
                    ';
                }

                $output .= '
                <div style="margin-left: 16px" class="products-size number">
                    <div class="products-attribute-item">
                        <input style="width: 48px;" type="number" class="add-number-size-input" id="add-size-n" name="add_size" min="1">
                        <label class="add-size-n">Thêm Size</label>
                    </div>
                </div>
                ';
                echo $output;
            }
        }

        function getColorUpdate() {
            if (isset($_POST['value'])) {
                $value = $_POST['value'];
                $id = $_POST['id'];
                $output = "";
                $result = $this->admin->getProductAttributeUpdate($value, $id);
                foreach ($result as $item) {
                    $output .= '
                    <div class="products-color">
                        <div class="products-attribute-item">
                            <input class="products-attribute-input color" type="checkbox" name="product-color[]" id="'.$item["value"].'" value="'.$item["id"].'" checked>
                            <label class="products-attribute-option color" data-value="color" for="'.$item["value"].'">
                                <span style="background-color: '.$item["value"].'" class="products-attribute-color"></span>
                            </label>
                        </div>
                    </div>
                    ';
                }

                $output .= '
                <div style="margin-left: 16px" class="products-color">
                    <div class="products-attribute-item">
                        <input type="color" id="add-color" class="add-color-input" name="add_color">
                        <label class="add-color">Thêm Màu</label>
                    </div>
                </div>
                ';
                echo $output;
            }
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

        // update product
        function product_update() {
            if (empty($_POST['update-product-by-id'])) {
                header("Location:".BASE_URL."admin/product");
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
                $product_id = $_POST["u-product-id"];
                $product_name = $_POST['u-product-name'];
                $product_slug = to_slug($product_name);
                
                $product_description = $_POST["u-product-description"];
                $product_parameters = $_POST["u-product-parameters"];
                $product_status = $_POST["product-status"];

                $product_price_origin = $_POST["product-price-origin"];
                $product_price_sale = $_POST["product-price-sale"];
                $product_quantity = $_POST["product-quantity"];
                
                $format = array("JPG", "JPEG", "PNG", "GIF", "BMP", "jpg", "jpeg", "png", "gif", "bmp");
                $storage = 'public/upload/'.$product_id.'/';

                if (!empty($_FILES['u-product-list-images'])) {
                    foreach ($_FILES["u-product-list-images"]['tmp_name'] as $key => $value) {
                        $filename = $_FILES['u-product-list-images']['name'][$key];
                        $filename_tmp = $_FILES['u-product-list-images']['tmp_name'][$key];
                        $ext = pathinfo($filename, PATHINFO_EXTENSION);

                        $filename = time().'_'.$filename;
                        if (in_array($ext, $format)) {
                            move_uploaded_file($filename_tmp, $storage . $filename);
                            $this->admin->addProductImages($product_id, $filename);
                        }
                    }
                }

                $product_thumbnail_origin = $this->admin->getProductById($_POST['u-product-id'])['thumbnail'];
                if (isset($_FILES["product-thumbnail"]) && strlen($_FILES["product-thumbnail"]['name']) > 0) {
                    $product_thumbnail = $_FILES["product-thumbnail"]['name'];
                    $product_thumbnail_tmp = $_FILES["product-thumbnail"]['tmp_name'];
    
                    $exp3 = substr($product_thumbnail, strlen($product_thumbnail) - 3);
                    $exp4 = substr($product_thumbnail, strlen($product_thumbnail) - 4);

                    if (in_array($exp3, $format) || in_array($exp4, $format)) {
                        $product_thumbnail = time()."_".$product_thumbnail;
                        move_uploaded_file($product_thumbnail_tmp, $storage . $product_thumbnail);
                        unlink($storage.$product_thumbnail_origin);
                    }
                } else {
                    $product_thumbnail = $product_thumbnail_origin;
                }
                // update product parent
                $this->admin->updateProduct($product_name, $product_slug, $product_thumbnail, $product_description, $product_parameters, $product_status, $product_id);
                $product_type_ids = $this->admin->getProductTypeIds($product_id);
                
                // product type id
                $product_type_ids_array = array();
                foreach ($product_type_ids as $id) {
                    array_push($product_type_ids_array, $id['id']);
                }

                $row = 0;
                // category_id
                $category_id = $_POST['u-product-category'];
                if ($category_id == 5) {
                    $row = 1;
                } else {
                    $row = 2;
                }

                // length for loop
                $length = count($product_quantity);
                echo "length: ".$length."<br>";
                echo "array: ";var_dump($product_type_ids_array); echo "<br>";
                $j = 0;
                $k = 0;
                for ($i = 0; $i < $length; $i++) {
                    if ($k == count($product_color)) {
                        $j++;
                        $k = 0;
                    }
                    if (count($product_size) > 0) {
                        $check_product_type = $this->admin->get_type_id($product_id, $product_size[$j], $product_color[$k], $row);
                        echo $check_product_type."<br>";
                        if (in_array($check_product_type, $product_type_ids_array)) {
                            $this->admin->updateProductType($check_product_type, $product_price_origin[$i], $product_price_sale[$i], $product_quantity[$i]);
                            $product_type_ids_array = array_diff($product_type_ids_array, [$check_product_type]);
                        } else {
                            $this->admin->addProductType($product_id, $product_price_origin[$i], $product_price_sale[$i], $product_quantity[$i]);
                            $product_type_id = $this->admin->getProductTypeId();
                            $this->admin->addProductTypeAttribute($product_type_id, $product_size[$j]);
                            $this->admin->addProductTypeAttribute($product_type_id, $product_color[$k]);
                        }
                    } else {
                        $check_product_type = $this->admin->get_type_id($product_id, $product_color[$k], $product_color[$k], $row);
                        echo $check_product_type."<br>";
                        if (in_array($check_product_type, $product_type_ids_array)) {
                            $this->admin->updateProductType($check_product_type, $product_price_origin[$i], $product_price_sale[$i], $product_quantity[$i]);
                            $product_type_ids_array = array_diff($product_type_ids_array, [$check_product_type]);
                        } else {
                            $this->admin->addProductType($product_id, $product_price_origin[$i], $product_price_sale[$i], $product_quantity[$i]);
                            $product_type_id = $this->admin->getProductTypeId();
                            $this->admin->addProductTypeAttribute($product_type_id, $product_color[$k]);
                        }
                    }
                    $k++;
                }
                $product_type_ids_inactive = $this->admin->getProductTypeIdInactive($product_id);
                var_dump($product_type_ids_array); echo "<br>";
                echo "length: ".count($product_type_ids_array)."<br>";
                foreach ($product_type_ids_inactive as $key=>$value) {
                    $product_type_ids_array = array_diff($product_type_ids_array, [$value['id']]);
                }
                echo "array: ";var_dump($product_type_ids_array); echo "<br>";
                foreach ($product_type_ids_array as $key=>$value) {
                    $this->admin->deleteProductTypeAttribute($product_type_ids_array[$key]);
                    $this->admin->deleteProductType($product_type_ids_array[$key]);
                }
                echo "array: ";var_dump($product_type_ids_array); echo "<br>";
            }

            $this-> view("admin/index", [
                "page" => "product_update",
                "product" => $this->admin->getProductById($_POST['update-product-by-id']),
                "getCategories" => $this->admin->getCategories(),
                "getLetterSizes" => $this->admin->getAttributes("letter_size"),
                "getNumberSizes" => $this->admin->getAttributes("number_size"),
                "getColors" => $this->admin->getAttributes("color"),
                "getProductTypeIdById" => $this->admin->getProductTypeIdById($_POST['update-product-by-id']),
                "getProductTypeFromCartTemporary" => $this->admin->getProductTypeIdFromCartTemporary($_POST['update-product-by-id']),
            ]);
        }

        function updatePrd($id){
            if (isset($_POST['u-product-id'])) {

                $product_id = $_POST["u-product-id"];
                $product_name = $_POST['u-product-name'];
                $product_slug = to_slug($product_name);
                
                $product_description = $_POST["u-product-description"];
                $product_parameters = $_POST["u-product-parameters"];
                $product_status = $_POST["product-status"];
                $format = array("JPG", "JPEG", "PNG", "GIF", "BMP", "jpg", "jpeg", "png", "gif", "bmp");
                $storage = 'public/upload/'.$product_id.'/';
    
                if (!empty($_FILES['u-product-list-images'])) {
                    foreach ($_FILES["u-product-list-images"]['tmp_name'] as $key => $value) {
                        $filename = $_FILES['u-product-list-images']['name'][$key];
                        $filename_tmp = $_FILES['u-product-list-images']['tmp_name'][$key];
                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
    
                        $filename = time().'_'.$filename;
                        if (in_array($ext, $format)) {
                            move_uploaded_file($filename_tmp, $storage . $filename);
                            $this->admin->addProductImages($product_id, $filename);
                        }
                    }
                }
    
                $product_thumbnail_origin = $this->admin->getProductById($_POST['u-product-id'])['thumbnail'];
                if (isset($_FILES["product-thumbnail"]) && strlen($_FILES["product-thumbnail"]['name']) > 0) {
                    $product_thumbnail = $_FILES["product-thumbnail"]['name'];
                    $product_thumbnail_tmp = $_FILES["product-thumbnail"]['tmp_name'];
    
                    $exp3 = substr($product_thumbnail, strlen($product_thumbnail) - 3);
                    $exp4 = substr($product_thumbnail, strlen($product_thumbnail) - 4);
    
                    if (in_array($exp3, $format) || in_array($exp4, $format)) {
                        $product_thumbnail = time()."_".$product_thumbnail;
                        move_uploaded_file($product_thumbnail_tmp, $storage . $product_thumbnail);
                        unlink($storage.$product_thumbnail_origin);
                    }
                } else {
                    $product_thumbnail = $product_thumbnail_origin;
                }
                // update product parent
                $this->admin->updateProduct($product_name, $product_slug, $product_thumbnail, $product_description, $product_parameters, $product_status, $product_id);
                // $toast = array(
                //     'title' => 'Success',
                //     'message' => "Update sản phẩm thành công",
                //     'type' => "success",
                //     'duration' => 3000
                // );
                // $_SESSION['toast_start'] = $toast;
                header('location: '.BASE_URL.'admin/product');
            }
            $this-> view("admin/index", [
                "page" => "prd_update",
                "product" => $this->admin->getProductById($id),
            ]);
        }

        function getDataPrd($id){
            $output = "";
            $info = $this->admin->getProductDetails($id);
            foreach($info as $row){
                $size = $this->admin->getAttributesByTypeId($row['id'],"size");
                $color = $this->admin->getAttributesByTypeId($row['id'],"color");
                if($row['category_id'] == 5){
                    $size['value'] = "Free Size";
                }
                $output .= '
                    <tr class="text-center">
                        <td class="size-w-size">'.$size['value'].'</td>
                        <td class="size-w-color">
                            <div class="color-value" style="background-color: '.$color['value'].'"></div>
                        </td>
                        <td contenteditable class="size-w-price-origin change-value-attribute" data-typeId="'.$row['id'].'" data-type="price_origin">'.number_format($row['price_origin']).'</td>
                        <td contenteditable class="size-w-price-sale change-value-attribute" data-typeId="'.$row['id'].'" data-type="price_sale">'.number_format($row['price_sale']).'</td>
                        <td contenteditable class="size-w-quantity change-value-attribute" data-typeId="'.$row['id'].'" data-type="quantity">'.number_format($row['quantity']).'</td>
                    </tr>';
            }
            echo $output;
        }
        
        function updateAttribute_type(){
            if(isset($_POST['id'])){
                $this->admin->updateColumn($_POST['id'],$_POST['type_id'],$_POST['column'],$_POST['value']);
            }
        }

        function updateAttribute_typeAll(){
            if(isset($_POST['id'])){
                $result = $this->admin->selectPrdTypeById($_POST['id']);
                foreach($result as $row) {
                    $this->admin->updateColumnAll($_POST['id'],$row['id'],$_POST['price_origin'],$_POST['price_sale'],$_POST['quantity']);
                }
            }
        }

        function updateProductTypeStatus() {
            if (isset($_POST['productId'])) {
                $product_id = $_POST['productId'];
                $value = $_POST['value'];
                $product_attribute_id = $this->admin->getProductAttributeId($value);
                $product_type_id_array = $this->admin->getProductTypeIdByAttributeId($product_id, $product_attribute_id);
                foreach ($product_type_id_array as $item) {
                    $this->admin->updateProductTypeStatus($item['product_type_id']);
                }
                $toast = array(
                    'title' => 'Success',
                    'message' => "Update status thành công",
                    'type' => "success",
                    'duration' => 3000
                );
                $_SESSION['toast_start'] = $toast;
            }
        }

        function checkExistName() {
            if (isset($_POST['productId'])) {
                $product_id = $_POST['productId'];
                $product_name = $_POST['productName'];
                $product_name = trim($product_name);
                $check = $this->admin->checkExistName('products', $product_name, $product_id);
                if ($check == 1) {
                    // $toast = array(
                    //     'title' => 'Warning',
                    //     'message' => "Tên sản phẩm đã tồn tại",
                    //     'type' => "warning",
                    //     'duration' => 3000
                    // );
                    // $_SESSION['toast_start'] = $toast;
                    echo 123;
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
                    <input type="file" class="upload-multi" accept="image/*" name="u-product-list-images[]" multiple="">
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
                $toast = array(
                    'title' => 'Success',
                    'message' => "Thêm coupon thành công",
                    'type' => "success",
                    'duration' => 3000
                );
                $_SESSION['toast_start'] = $toast;
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
                $toast = array(
                    'title' => 'Success',
                    'message' => "Cập nhật coupon thành công",
                    'type' => "success",
                    'duration' => 3000
                );
                $_SESSION['toast_start'] = $toast;
            }

            if (isset($_POST['delete-coupon-id'])) {
                $id = $_POST['delete-coupon-id'];
                $check = $this->admin->checkExistCoupon($id);
                if ($check > 0) {
                    $toast = array(
                        'title' => 'Warning',
                        'message' => "Không thể thực hiện được với coupon đã được dùng",
                        'type' => "warning",
                        'duration' => 3000
                    );
                } else {
                    $this->admin->deleteCoupon($id);
                    $toast = array(
                        'title' => 'Success',
                        'message' => "Xoá coupon thành công",
                        'type' => "success",
                        'duration' => 3000
                    );
                }
                $_SESSION['toast_start'] = $toast;
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
                    $product_type_ids = $this->admin->getProductTypeIdFromOrder($orderId);
                    foreach ($product_type_ids as $value) {
                        $this->admin->updateProductTypeQuantity($value['product_type_id'], $value['quantity']);
                    }
                } else {
                    $this->admin->updateOrderStatus($orderId, $orderStatus);
                }
                $toast = array(
                    'title' => 'Success',
                    'message' => "Cập nhật thành công",
                    'type' => "success",
                    'duration' => 3000
                );
                $_SESSION['toast_start'] = $toast;
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

        function comments() {
            // update status comment
            if (isset($_POST['u-comment-status'])) {
                $id = $_POST['u-comment-id'];
                $status = $_POST['u-comment-status'];
                $this->admin->updateComment($id, $status);
                $toast = array(
                    'title' => 'Success',
                    'message' => "Cập nhật thành công",
                    'type' => "success",
                    'duration' => 3000
                );
                $_SESSION['toast_start'] = $toast;
            }

            if (isset($_POST['delete-comment-id'])) {
                $id = $_POST['delete-comment-id'];
                $this->admin->deleteComment($id);
                $toast = array(
                    'title' => 'Success',
                    'message' => "Đã xoá comment",
                    'type' => "success",
                    'duration' => 3000
                );
                $_SESSION['toast_start'] = $toast;
            }

            $this -> view("admin/index", [
                "page" => "comments",
                "getComments" =>$this->admin->getComments(),
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
                    $toast = array(
                        'title' => 'Error',
                        'message' => "Tên đăng nhập không tồn tại !! vui lòng kiểm tra lại",
                        'type' => "error",
                        'duration' => 3000
                    );
                    $_SESSION['toast_start'] = $toast;
                } else {
                    $_SESSION['admin-login'] = true;
                    $_SESSION['admin-username'] = $username;
                    header("Location:".BASE_URL."admin");
                }
            }

            // load view
            $this -> view("admin/pages/login");
        }
    }
?>