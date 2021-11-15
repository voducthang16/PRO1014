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
            $slugs = $this->category->getSlugs();
            $array_slug = [];
            foreach ($slugs as $slug) {
                array_push($array_slug, $slug['slug']);
            }
            array_push($array_slug, 'all');
            if (!in_array($url[2], $array_slug)) {
                header("Location:".BASE_URL."pagenotfound");
                exit();
            }
        }

        function detail($slug) {
            $this->id = $this -> category-> getCategoryId($slug);

            $this -> view("index", [
                "page" => "category",
                "categories" => $this->category->getCategories(),
                "categoryName" => $slug == "all" ? "Tất cả sản phẩm" : $this->category->getCategoryName($slug),
                "getProducts" => $slug == "all" ? $this->category->getAllProducts() : $this->category->getProducts($this->id),
            ]);
        }
    }
?>