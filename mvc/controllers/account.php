<?php
    class account extends controller {
        public $account;
        public $id;
        function __construct() {
            $this-> account = $this->model("accountModels");
            if(isset($_SESSION["member-username"])){
                $username = $_SESSION["member-username"];
                $this->id = $this->account->getProfile($username)['id'];
            } else {
                header("Location:".BASE_URL);
            }
        }

        function order() {
            $this -> view("index", [
                "page" => "account_orders",
                "order" => $this ->account->getOrderByMemberId($this->id),
            ]);
        }

        function profile() {
            $this -> view("index", [
                "page" => "account_profile",
                "profile" => $this ->account->getProfile($_SESSION["member-username"]),
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
            unset($_SESSION['access_token']);
        }

        function addWishList() {
            if(isset($_SESSION["member-username"])){
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
                    } else {
                        $this -> deleteWishList($this->id, $id_product);
                        echo "Đã xoá sản phẩm khỏi wish list";
                    }
                }
            } else {
                echo "sign";
            }
        }

        function selectWishList() {
            if(isset($_SESSION["member-username"])){
                $username = $_SESSION["member-username"];
                $this->id = $this->account->getProfile($username);
            } else {
                header("Location:".BASE_URL);
            }
            $output = "";
            $check = $this->account->selectWishList($this->id);
            if ($check->rowCount() > 0) {

                $data = $check->fetchAll();
                foreach($data as $row) {
                    $output .= '<div class="wishlist-product">
                            <div class="wishlist-product-info">
                                <a href="'.BASE_URL.'product/detail/'.$row['slug'].'">
                                    <img src="public/upload/'.$row["product_id"].'/'.$row["thumbnail"].'" alt="Product Thumbnail">
                                </a>
                                <div>
                                    <a href="'.BASE_URL.'product/detail/'.$row['slug'].'">
                                        <h2>'.$row['name'].'</h2>
                                    </a>
                                    <h4>'.number_format($row['minn']).'đ - '.number_format($row['maxx']).'đ</h4>
                                </div>
                            </div>
                            <button class="btn btn--size-m btn--delete--wishlist" id="'.$row['product_id'].'"><i style="margin-right: 8px"class="fal fa-trash"></i>Xoá</button>
                        </div>';
                }
            } else {
                $output .= '<h3 class="no-product-wishlist">Bạn chưa có sản phẩm nào trong wishlist.</h3>';
            }
            $data = array(
                'output' => $output,
                'count' => $check->rowCount()
            );
            echo json_encode($data);
        }

        function deleteWishList(){
            if(isset($_SESSION["member-username"])){
                $username = $_SESSION["member-username"];
                $this->id = $this->account->getProfile($username);
            } else {
                header("Location:".BASE_URL);
            }
            if(isset($_POST['id_product'])){
                $id_product = $_POST['id_product'];

                $this->account->deleteWishList($this->id,$id_product);
                echo "đã xoá thành công mã sản phẩm " .$id_product." khỏi wishList";
            }
        }
    }
?>