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
            if (isset($_POST['first_name'])) {
                $member_id = $this->member_id;
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $city_code = $_POST['city'];
                $city = $_POST['city_selected'];
                $district = $_POST['district_selected'];
                $ward = $_POST['ward_selected'];
                $street = $_POST['street'];
                $note = $_POST['note'];
                $order_method = $_POST['order_method'];
                $fullName = $first_name." ".$last_name;
                $address = $street.", ".$ward.", ".$district.", ".$city;
                $coupon_value = 0;
                if (isset($_POST['coupon_id']) && $_POST['coupon_id']) {
                    $coupon_name = $_POST['coupon'];
                    $coupon_value = $this->checkout->checkCoupon($coupon_name)->fetch()['value'];
                    $coupon = $_POST['coupon_id'];
                    $this->checkout->insertOrder($member_id, $coupon, $order_method, $fullName, $address, $email, $phone, $note);
                    $this->checkout->updateCouponQuantity($coupon);
                } else {
                    $this->checkout->insertOrderWithoutCoupon($member_id, $order_method, $fullName, $address, $email, $phone, $note);
                }

                $ship = 0;
                if ($city_code == 202) {
                    $ship = 20000;
                } else {
                    $ship = 30000;
                }

                $products = $this->checkout->getProductsById($member_id);
                $order_id = $this->checkout->getOrderId();

                foreach ($products as $product) {
                    $this-> checkout->insertOrderDetails($order_id, $product['product_type_id'], $product['quantity'], $product['price_sale']);
                    $total += $product['price_sale'] * $product['quantity'];
                    $this-> checkout->deleteProductFromCartTemp($member_id, $product['product_type_id']);
                }

                if ($coupon_value < 100) {
                    $total = $total - ($total * ($coupon_value / 100)) + $ship;
                } else {
                    $total = $total - $coupon_value + $ship;
                }
                $this->checkout->updateTotalMoney($total, $order_id);
                header("Location:".BASE_URL);
            }

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
            $ship = 0;
            if (isset($_POST['ship'])) {
                $ship = $_POST['ship'];
            }
            $subtotal = 0;
            $data = $this->checkout->getProductsById($this->member_id);
            foreach ($data as $item) {
                $subtotal += $item['price_sale'] * $item['quantity'];
            }
            $total = $subtotal + $ship;
            echo number_format($total)."đ";
        }

        function checkCoupon() {
            if (isset($_POST['couponName'])) {
                $coupon = $_POST['couponName'];
                $total = $_POST['total'];
                $result = $this->checkout->checkCoupon($coupon);
                $row = $result->rowCount();
                $result = $result->fetch();
                $coupon_id = $result['id'];
                $type_coupon = $result['type'];
                $value_coupon = $result['value'];
                $min_order = $result['min_order'];
                $member_id = $this->checkout->getProfile($_SESSION["member-username"]);
                if ($row > 0) {
                    $result_coupon_order  = $this->checkout->checkCouponInOrder($member_id, $coupon_id);
                    if ($result_coupon_order < 1) {
                        if ($total < $min_order) {
                            echo 'coupon not found';
                            return;
                        } else {
                            $data = array(
                                'type_coupon' => $type_coupon,
                                'value_coupon' => $value_coupon,
                                'id_coupon' => $coupon_id,
                            );
                            echo json_encode($data);
                            return;
                        }
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