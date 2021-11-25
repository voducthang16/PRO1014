<?php
    class account extends controller {
        public $account;
        public $id;
        function __construct() {
            $this-> account = $this->model("accountModels");
            if(isset($_SESSION["member-username"])){
                $username = $_SESSION["member-username"];
                $this->id = $this->account->getProfile($username);
            } else {
                header("Location:".BASE_URL);
            }
        }

        function show() {
            $this -> view("index", [
                "page" => "account_orders"
            ]);
        }

        function wishlist() {
            $this -> view("index", [
                "page" => "account_wishlist"
            ]);
        }

        function signOut() {
            unset($_SESSION['member-username']);
            unset($_SESSION['member-login']);
        }
        function addWishList() {
            if (isset($_SESSION['member-username'])) {
                if(isset($_POST['action'])){
                    $id_product = $_POST['id_product'];
                    $check = $this->account->checkPrdWishList($this->id,$id_product);
                    if ($check == 0) {
                        $result = $this-> account->addWishList($this->id,$id_product);
                        if ($result == true) {
                            echo "đã thêm sản phẩm vào wish list";
                            return;
                        }
                        echo "thêm sản phẩm thất bại"; 
                    }
                    echo "thêm sản phẩm thất bại";
                }
            } else {
                echo "sign";
            }
        }
        function selectWishList() {
            $output = "";
            $check = $this->account->selectWishList($this->id);
            if ($check->rowCount() > 0) {

                $data = $check->fetchAll();
                foreach($data as $row) {
                    $output .= '<div class="wishlist-product">
                            <img src="public/upload/'.$row["product_id"].'/'.$row["thumbnail"].'" alt="">
                            <h2>'.$row['name'].'</h2>
                            <h4>'.number_format($row['minn']).'đ - '.number_format($row['maxx']).'đ</h4>
                            <div class="btn-delete-wish-list btn--delete--wishlist" id="'.$row['product_id'].'">Xoá</div>
                        </div>';
                }
            } else {
                $output .= 'bạn chưa có sản phẩm nào trong wish list';
            }
            echo $output;
        }
        function deleteWishList(){
            if(isset($_POST['id_product'])){
                $id_product = $_POST['id_product'];

                $this->account->deleteWishList($this->id,$id_product);
                echo "đã xoá thành công mã sản phẩm " .$id_product." khỏi wishList";
            }
        }
    }
?>