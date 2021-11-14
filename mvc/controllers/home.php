<?php
    class home extends controller {
        public $home;

        function __construct() {
            $this->home = $this->model('homeModels');
        }

        function show() {
            $this -> view("index", [
                "page" => "home",
                "getProducts" => $this->home->getProducts(),
                "getHoodiesProducts" => $this->home->getHoodiesProducts(),
            ]);
        }
    }
?>