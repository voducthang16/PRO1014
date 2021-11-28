<?php
    class search extends controller {
        public $search;
        public $category;
        function __construct() {
            $this-> search = $this->model("searchModels");
            $this -> category = $this->model("categoryModels");
        }

        function show() {
            $this -> view("index", [
                "page" => "search",
                "categories" => $this->category->getCategories(),
            ]);
        }
    }
?>