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
                "page" => "checkout"
            ]);
        }
    }
?>