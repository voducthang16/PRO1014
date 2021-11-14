<?php
    class category extends controller {
        public $category;
        public $id;
        function __construct() {
            $url = explode("/", filter_var(trim($_GET["url"], "/")));
            if (!strstr($_GET['url'], 'detail')) {
                header("Location:".BASE_URL."pagenotfound");
                exit();
            }
            if (!isset($url[2])) {
                header("Location:".BASE_URL."pagenotfound");
                exit();
            }
            $this->category = $this->model('categoryModels');
        }

        function detail($slug) {
            $this->id = $this -> category-> getCategoryId($slug);

            $this -> view("index", [
                "page" => "category",
                "categories" => $this->category->getCategories(),
                "categoryName" => $this->category->getCategoryName($slug),
                "getProducts" => $this->category->getProducts($this->id),
            ]);
        }
    }
?>