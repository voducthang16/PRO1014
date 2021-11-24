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
    }
?>