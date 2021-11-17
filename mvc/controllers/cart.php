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
                "getCart" => isset($_SESSION["member-username"]) ? $this->cart->getCart($this->id_member) : "",
            ]);
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
                        $count += $row['price_sale'] * $row['quantity'];
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

        function insertCart(){
            if(isset($_SESSION['member-username'])){
                if(isset($_POST['insertCart'])){

                    $id_product = $_POST['id_product'];
                    $id_color = $_POST['id_color'];
                    $id_size = $_POST['id_size'];

                    $id_type = $this-> cart->get_type_id($id_product,$id_color,$id_size);

                    $check_id_type = $this-> cart->check_type_id($this->id_member,$id_type);
                    $num = $check_id_type->rowCount();
    
                    if ($num == 0){
                            $insert = $this-> cart->insertCart($this->id_member,$id_type);
                        if ($insert == true){
                            echo 'Thêm Thành Công';
                        } else{
                            echo 'Thêm Thất Bại';
                        }
                    } else {
                        $quantity = $check_id_type->fetch()['quantity'] +1;
                        // echo $quantity;
                        $updateCart = $this-> cart->updateQtt($quantity,$this->id_member,$id_type);
                        if ($updateCart == true){
                            echo 'Đã update +1 trong giỏ hàng';
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