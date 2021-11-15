<?php
    class category extends controller {
        public $category;
        public $id;
        function __construct() {
            $url = explode("/", filter_var(trim($_GET["url"], "/")));
            if (count($url) > 4) {
                header("Location:".BASE_URL."pagenotfound");
                exit();
            }
            if (!strstr($_GET['url'], 'detail')) {
                header("Location:".BASE_URL."pagenotfound");
                exit();
            }
            if (!isset($url[2])) {
                header("Location:".BASE_URL."pagenotfound");
                exit();
            }

            if (isset($url[3])) {
                if ($url[3] < 0 || !filter_var($url[3], FILTER_VALIDATE_INT)) {
                    header("Location:".BASE_URL."pagenotfound");
                    exit();
                }
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

        function detail($slug, $page = 1) {
            $this->id = $this -> category-> getCategoryId($slug);
            
            $count = $slug == "all" ? $this -> category-> countAllProducts() : $this -> category-> countProductsByCategory($this -> id);
            $ppp = 3;
            $from = ($page - 1) * $ppp;
            $totalPages = ceil($count / $ppp);

            if ($slug == "all") {
                if (count($this->category->getAllProducts($from, $ppp)) == 0) {
                    header("Location:".BASE_URL."pagenotfound");
                    exit();
                }
            } else {
                if (count($this->category->getProducts($this->id, $from, $ppp)) == 0) {
                    header("Location:".BASE_URL."pagenotfound");
                    exit();
                }
            }

            $this -> view("index", [
                "page" => "category",
                "categories" => $this->category->getCategories(),
                "categoryName" => $slug == "all" ? "Tất cả sản phẩm" : $this->category->getCategoryName($slug),
                "getProducts" => $slug == "all" ? $this->category->getAllProducts($from, $ppp) : $this->category->getProducts($this->id, $from, $ppp),
            ]);
        }
    }
?>