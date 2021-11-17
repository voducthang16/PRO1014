<?php
    class account extends controller {
        public $account;

        function __construct() {
            $this-> account = $this->model("accountModels");
        }

        function show() {
            $this -> view("index", [
                "page" => "account_orders"
            ]);
        }
    }
?>