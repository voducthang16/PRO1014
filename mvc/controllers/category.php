<?php
    class category extends controller {
        public $category;
        private $a = "hello";
        function __construct() {
            $this->category = $this->model('categoryModels');
        }

        function show() {
            $this -> view("index", [
                "page" => "category",
            ]);
        }
    }
?>