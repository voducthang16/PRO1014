<?php
    class cart extends controller {
        public $cart;

        function __construct() {
            $this->cart = $this->model('cartModels');

            if(isset($_SESSION["member-username"])){
                $username = $_SESSION["member-username"];
                $member = $this-> cart->getProfile($username);
                foreach ($member as $row) {
                $this->id_member = $row['id'];
                }
            }  
        }
        function show() {
            $this -> view("index", [
                "page" => "cart",
            ]);
        }
        function showCart() {

            $output ='';

            if(isset($_SESSION["member-username"])){
                
                $result = $this-> cart->getCart($this->id_member);
                $num = $result->rowCount();
                $data = $result->FetchAll();

                if($num==0){
                    $output .= '
                        <li class="cart-items__product">
                            chưa có sản phẩm
                        </li>
                    ';
                    echo $output;
                }else{
                    foreach ($data as $row) {
                        $output .= '
                            <li class="cart-items__product">
                                <span>
                                    <a href="product" class="cart-product__link">
                                        <img src="public/upload/'.$row["product_id"].'/'.$row["thumbnail"].'" alt="Product Thumbnail" class="cart-product__img">
                                    </a>
                                </span>
                                <div class="cart-product">
                                    <a href="product" class="cart-product__name">'.$row['name'].'</a>
                                    <p class="cart-product__price">'.$row['price_sale'].'</p>
                                    <span class="cart-product__x">x</span>
                                    <p class="cart-product__quantity">'.$row['quantity'].'</p>
                                    <p class="cart-product__delete">Xóa</p>
                                </div>
                            </li>
                        ';
                    }
                    echo $output;
                }
            } else {
                $output .= '
                        <li class="cart-items__product">
                            chưa có sản phẩm
                        </li>
                    ';
                echo $output;
            }
        }
        function insertCart(){
            if(isset($_POST['insertCart'])){
                $id_product = $_POST['id_product'];
                $id_color = $_POST['id_color'];
                $id_size = $_POST['id_size'];

                $type = $this-> cart->get_type_id($id_product,$id_color,$id_size);
                foreach ($type as $row) {
                    $id_type = $row['product_type_id'];
                }

                $insert = $this-> cart->insertCart($this->id_member,$id_type);
                if ($insert == true){
                    echo 'Thêm Thành Công';
                } else{
                    echo 'Thêm Thất Bại';
                }
            }
        }
        
    }
?>