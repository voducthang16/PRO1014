<?php
    class search extends controller {
        public $search;
        public $category;
        function __construct() {
            $this-> search = $this->model("searchModels");
            $this -> category = $this->model("categoryModels");
        }

        function show() {
            $conditions = "";
            if (isset($_GET['keyword'])) {
                $keyword = explode(" ", $_GET["keyword"]);
                foreach ($keyword as $word) {
                    $conditions .= "products.name LIKE '%".$word."%' OR ";
                }
                $conditions = substr($conditions, 0, -4);
            }
            $this -> view("index", [
                "page" => "search",
                "categories" => $this->category->getCategories(),
                "getProducts" => $this->search->search_product($conditions),
            ]);
        }
    }
?>