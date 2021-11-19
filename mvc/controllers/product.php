<?php 
    class product extends controller {
        public $product;
        public $id;
        function __construct() {

            // cut link + check link
            $url = explode("/", filter_var(trim($_GET["url"], "/")));
            if (count($url) > 3) {
                header("Location:".BASE_URL."pagenotfound");
                exit();
            }

            if (!strstr($_GET['url'], 'detail') && !strstr($_GET['url'], 'getProductTypeId')) {
                header("Location:".BASE_URL."pagenotfound");
                exit();
            }

            if(strstr($_GET['url'], 'detail')){
                if (!isset($url[2])) {
                    header("Location:".BASE_URL."pagenotfound");
                    exit();
                }
            }

            $this->product = $this->model('productModels');
            $slugs = $this->product->getSlugs();
            $array_slug = [];
            foreach ($slugs as $slug) {
                array_push($array_slug, $slug['slug']);
            }

            if(strstr($_GET['url'], 'detail')) {
                if (!in_array($url[2], $array_slug)) {
                    header("Location:".BASE_URL."pagenotfound");
                    exit();
                }
            }
        }

        function detail($slug) {
            $category_id = $this->product->getCategoryId($slug);
            $this->id = $this->product->getProductId($slug);
            $this -> view("index", [
                "page" => "product",
                "product" => $this->product->getProduct($slug),
                "category" => $this->product->getCategoryInfo($category_id),
                "productImages" => $this->product->getProductImages($this->id),
                "productSize" => $this->product->getProductAttribute("size", $this->id),
                "productColor" => $this->product->getProductAttribute("color", $this->id),
                "countAllProducts" => $this->product->countAllProducts($this->id)
            ]);
        }

        function getProductTypeId() {
            
            //handle fetch data count qtt product 
            if (isset($_POST['get_quantity'])) {
                $id = $_POST['id_product'];
                $size = $_POST['id_size'];
                $color = $_POST['id_color'];
                if($_POST['id_category']==5){
                    $num = 1;        
                } else {
                    $num = 2;
                }
    
                $result = $this->product->getProductTypeId($id, $color, $size, $num);
                $qtt = $this->product->countProduct($result);
                
                if($qtt == null) {
                    $qtt = $this->product->countAllProducts($id);
                }

                echo $qtt;
            }
        }
    }
?>