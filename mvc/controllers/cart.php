<?php
    class cart extends controller {
        public $cart;

        function __construct() {
            $this->cart = $this->model('cartModels');

            if(isset($_SESSION["member-username"])){
                $username = $_SESSION["member-username"];
                $this->id_member = $this-> cart->getProfile($username);
            }  
        }

        function show() {
            $this -> view("index", [
                "page" => "cart",
                // "getCart" => isset($_SESSION["member-username"]) ? $this->cart->getCart($this->id_member) : "",
            ]);
        }
        function showOrder(){
            $output ='';
            if (empty($_SESSION["member-login"])){
                $output .= '<div class="no-cart-wrapper">
                    <img src="'.BASE_URL.'public/assets/img/no_cart.png" alt="No Cart Image">
                    <h3>Giỏ hàng của bạn đang trống</h3>
                    <a href="'.BASE_URL.'" class="btn"><i style="margin-right: 8px" class="fal fa-chevron-left"></i>Tiếp tục mua hàng</a>
                    </div>';
            } else {
                $result = $this-> cart->getCart($this->id_member);
                $total = 0;
                if(isset($_SESSION["member-username"])) {
                    $count = $this-> cart->getCart($this->id_member);
                    $num = $count->rowCount();
                    $data = $count->FetchAll();

                    if($num == 0) {
                        $total = 0;
                    } else {
                        foreach ($data as $row) {
                            $total += $row['price_sale'] * $row['quantity'];
                        }
                    }
                } else {
                    $total = 0;
                }
                if ($result->rowCount() > 0){
                    $output .= '<form class="row" method="POST">
                                    <div class="col l-8">
                                    <div class="cart-page-header">
                                        <h3>Sản phẩm</h3>
                                        <a href="'.BASE_URL.'" class="btn btn--size-s"><i style="margin-right: 8px" class="fal fa-chevron-left"></i>Tiếp tục mua hàng</a>
                                    </div>
                                    <div class="order-product-wrapper">';
                    foreach ($result as $row){
                        $output .= ' <div class="order-products cart-items__product">
                        <div class="order-products-info cart-product__link" name="'.$row['product_type_id'].'">
                                <a href="'.BASE_URL.'product/detail/'.$row['slug'].'">
                                    <img src="public/upload/'.$row['product_id'].'/'.$row['thumbnail'].'" alt="Product Thumbnail">
                                </a>
                                <div class="order-products-body">
                                    <a href="'.BASE_URL.'product/detail/'.$row['slug'].'">'.$row['name'].'</a>
                                    <h4>Size: '.($this->cart->getAttributes($row['product_type_id'], "size")['value'] != "" ? $this->cart->getAttributes($row['product_type_id'], "size")['value'] : "Free Size").'</h4>
                                    <h4>Color: <span style="background-color: '.$this->cart->getAttributes($row['product_type_id'], "color")['value'].'" class="cart-product__color ps"></span></h4>
                                    <h3 class="order-products-price">'.number_format($row['price_sale']).'đ</h3>
                                </div>
                            </div>
                            <div class="order-quantity">
                                <div class="product-quantity op">
                                    <span class="product-quantity-title op">Số lượng: </span>
                                    <div class="quantity-minus quantity-btn btn-change-quantity-minus"><i class="fal fa-minus"></i></div>
                                    <input type="number" name="product-quantity" class="product-quantity-value" value="'.$row['quantity'].'" min="1">
                                    <div class="quantity-plus quantity-btn btn-change-quantity-plus"><i class="fal fa-plus"></i></div>
                                </div>
                                <p class="order-delete btn-delete-prd-cart"><i style="margin-right: 4px" class="fal fa-trash"></i> Xóa</p>
                            </div>
                        </div>';
                    }
                    $output .='</div>
                                </div>
                                <div class="col l-4">
                                    <div class="cart-page-sub-total">
                                        <h4>Subtotal</h4>
                                        <h3 id="sub-total-money">'.number_format($total).' đ</h3>
                                        <div class="order-note">
                                            <label for="note">
                                                <span class="label-button">Note</span>
                                                <span class="label-note">Ghi chú</span>
                                            </label>
                                            <textarea name="note" id="note" rows="10"></textarea>
                                        </div>
                                        <a href="'.BASE_URL.'checkout" class="btn order-cta"><i style="margin-right: 8px" class="fal fa-credit-card"></i>Process to checkout</a>
                                    </div>
                                </div>
                            </form>';
                } else {
                    $output .= ' <div class="no-cart-wrapper">
                                    <img src="'.BASE_URL.'public/assets/img/no_cart.png" alt="No Cart Image">
                                    <h3>Giỏ hàng của bạn đang trống</h3>
                                    <a href="'.BASE_URL.'" class="btn"><i style="margin-right: 8px" class="fal fa-chevron-left"></i>Tiếp tục mua hàng</a>
                                </div>';
                }
                    
            }
            echo $output;
            
        }
        function updateQuantity() {
            if(isset($_POST['updateQtt'])) {
                $id_type = $_POST['id_type'];
                $action = $_POST['updateQtt'];
                $check_id_type = $this-> cart->check_type_id($this->id_member,$id_type);
                if($action == 'plus') {
                    $quantity = $check_id_type->fetch()['quantity'] + 1;
                } else {
                    if ($this->cart->getQuantity($id_type, $this->id_member) > 1) {
                        $quantity = $check_id_type->fetch()['quantity'] - 1;
                    } else {
                        echo "k update duoc";
                        return;
                    }
                }
                $updateCart = $this-> cart->updateQtt($quantity,$this->id_member,$id_type);
                if ($updateCart == true) {
                    if($action == 'plus') {
                        echo 'Đã update +1 trong giỏ hàng';
                    } else{
                        echo 'Đã update -1 trong giỏ hàng';
                    }
                } else {
                    echo 'Vui lòng thực hiện lại !!';
                }
            }
        }

        function showCart() {
            $output ='';
            if(isset($_SESSION["member-username"])) {
                $result = $this-> cart->getCart($this->id_member);
                $num = $result->rowCount();
                $data = $result->FetchAll();

                if ($num == 0) {
                    $output .= '
                        <div class="no-cart">
                            <img src="'.BASE_URL.'public/assets/img/no_cart.png" alt="No Cart">
                            <span>Giỏ hàng trống</span>
                        </div>
                    ';
                    echo $output;
                } else {
                    $count = 0;
                    $output .= "<h3 class='cart-items__title'>Sản phẩm đã thêm</h3><ul class='cart-items__list'>";
                    foreach ($data as $row) {
                        $output .= '
                            <li class="cart-items__product" name="'.$row['product_type_id'].'">
                                <span>
                                    <a href="product/detail/'.$row['slug'].'" class="cart-product__link" name="'.$row['product_type_id'].'">
                                        <img src="public/upload/'.$row["product_id"].'/'.$row["thumbnail"].'" alt="Product Thumbnail" class="cart-product__img">
                                    </a>
                                </span>
                                <div class="cart-product">
                                    <div>
                                        <a href="product/detail/'.$row['slug'].'" class="cart-product__name">'.$row['name'].'</a>
                                        <p class="cart-product__attribute">
                                            <span>Size: '.($this->cart->getAttributes($row['product_type_id'], "size")['value'] != "" ? $this->cart->getAttributes($row['product_type_id'], "size")['value'] : "Free Size").'</span> - 
                                            Color:<span style="background-color: '.$this->cart->getAttributes($row['product_type_id'], "color")['value'].'" class="cart-product__color"></span>
                                        </p>
                                    </div>
                                    <p class="cart-product__price">'.number_format($row['price_sale']).'đ</p>
                                    <span class="cart-product__x">x</span>
                                    <p class="cart-product__quantity">'.number_format($row['quantity']).'</p>
                                    <p class="cart-product__delete btn-delete-prd-cart">Xóa</p>
                                </div>
                            </li>
                        ';
                    }
                    $output .= "</ul>";
                    echo $output;
                }
            }
        }

        function countCart() {
            $count = 0;
            if(isset($_SESSION['member-username'])) {
                $result = $this-> cart->getTotal($this->id_member);
                foreach ($result as $row){
                    $count += $row['quantity'];
                }
            }
            echo $count;
        }

        function totalCart() {
            $total = 0;
            if(isset($_SESSION["member-username"])) {
                $result = $this-> cart->getCart($this->id_member);
                $num = $result->rowCount();
                $data = $result->FetchAll();

                if($num == 0) {
                    echo number_format($total)."đ";
                } else {
                    foreach ($data as $row) {
                        $total += $row['price_sale'] * $row['quantity'];
                    }
                    echo number_format($total)."đ";
                }
            } else {
                echo number_format($total)."đ";
            }
        }

        function insertCart() {
            if(isset($_SESSION['member-username'])) {
                if(isset($_POST['insertCart'])){

                    $id_product = $_POST['id_product'];
                    $id_color = $_POST['id_color'];
                    $id_size = $_POST['id_size'];
                    $id_category = $_POST['id_category'];
                    $qtt = $_POST['quantity'];

                    if ($id_category != 5){
                        $id_type = $this-> cart->get_type_id($id_product,$id_color,$id_size,'2');
                    } else {
                        $id_type = $this-> cart->get_type_id($id_product,$id_color,$id_size,'1');
                    }

                    $check_id_type = $this-> cart->check_type_id($this->id_member,$id_type);
                    $num = $check_id_type->rowCount();
    
                    if ($num == 0){
                            $insert = $this-> cart->insertCart($this->id_member,$id_type,$qtt);
                        if ($insert == true){
                            echo 'Thêm Thành Công';
                        } else{
                            echo 'Thêm Thất Bại';
                        }
                    } else {
                        $quantity = $check_id_type->fetch()['quantity'] + $qtt;
                        // echo $quantity;
                        $updateCart = $this-> cart->updateQtt($quantity,$this->id_member,$id_type);
                        if ($updateCart == true){
                            echo 'Đã update +'.$qtt.' trong giỏ hàng';
                        } else {
                            echo 'Vui lòng thực hiện lại !!';
                        }
                    }
                }
            } else {
                echo 'sign';
            }
        }

        function deleteCart(){
            if(isset($_POST['deleteCart'])){
                $id_type = $_POST['id_type'];
                $kq_delete = $this-> cart->deleteCart($this->id_member,$id_type);
                if ($kq_delete == true){
                    echo 'Delete Thành Công';
                } else{
                    echo 'Delete Thất Bại';
                }
            }
        }
    }
?>