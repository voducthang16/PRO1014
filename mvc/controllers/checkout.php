<?php
    class checkout extends controller {
        public $checkout;
        public $member_id;
        function __construct() {
            $this-> checkout = $this->model("checkoutModels");
            if(isset($_SESSION["member-username"])) {
                $username = $_SESSION["member-username"];
                $this->member_id = $this->checkout->getMemberId($username);
                $check = $this->checkout->countProductsMember($this->member_id);
                if ($check <= 0) {
                    header("Location:".BASE_URL."pagenotfound");
                }
            } else {
                header("Location:".BASE_URL."pagenotfound");
            }
        }

        function show() {
            $this -> view("index", [
                "page" => "checkout",
                "order_method" => $this->checkout->getOrderMethods()
            ]);
        }

        function showCheckout() {
            $output ='';
            $data = $this->checkout->getProductsById($this->member_id);
            foreach ($data as $item) {
                $output .= '
                    <div class="order-summary-product">
                        <a href="product/detail/'.$item['slug'].'" class="order-summary-link">
                            <img src="'.BASE_URL.'public/upload/'.$item['product_id'].'/'.$item['thumbnail'].'" alt="Product Image" class="order-summary-img">
                        </a>
                        <div class="order-summary-list">
                            <a href="product/detail/'.$item['slug'].'" class="order-summary-list-name">'.$item['name'].'</a>
                            <p class="order-summary-attribute">
                                <span>Size</span> - Color: <span style="background-color: #ccc; top: 3px; left: 3px" class="order-summary-color"></span>
                            </p>
                            <p class="order-summary-money">
                                <span class="price">'.number_format($item['price_sale']).'đ</span>
                                <span>x</span>
                                <span>'.$item['quantity'].'</span>
                            </p>
                        </div>
                    </div>
                ';
            }
            echo $output;
        }

        function totalCheckout() {
            $subtotal = 0;
            $data = $this->checkout->getProductsById($this->member_id);
            foreach ($data as $item) {
                $subtotal += $item['price_sale'] * $item['quantity'];
            }
            $total = $subtotal;
            echo number_format($total)."đ";
        }

        function discount() {
            if (isset($_POST['type'])) {
                $type = $_POST['type'];
                $value = $_POST['value'];
                $total = $_POST['total'];
                // if ($type == '0') {
                //     $result = $total - $value;
                //     echo number_format($result)."đ";
                //     return;
                // } else {
                //     $result = $total - ($total * ($value / 100));
                //     echo number_format($result)."đ";
                //     return;
                // }
            }
        }

        function checkCoupon() {
            if (isset($_POST['couponName'])) {
                $coupon = $_POST['couponName'];
                $result = $this->checkout->checkCoupon($coupon);
                $row = $result->rowCount();
                $result = $result->fetch();
                $coupon_id = $result['id'];
                $type_coupon = $result['type'];
                $value_coupon = $result['value'];
                $member_id = $this->checkout->getProfile($_SESSION["member-username"]);
                if ($row > 0) {
                    $result_coupon_order  = $this->checkout->checkCouponInOrder($member_id, $coupon_id);
                    if ($result_coupon_order < 1) {
                        echo $type_coupon."-".$value_coupon;
                        return;
                    } else {
                        echo 'coupon not found';
                        return;
                    }
                } else {
                    echo 'coupon not found';
                }
            }
        }
    }
?>