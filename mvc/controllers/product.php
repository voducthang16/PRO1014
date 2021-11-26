<?php 
    class product extends controller {
        public $product;
        public $id;
        public $id_member;
        function __construct() {

            // cut link + check link
            $url = explode("/", filter_var(trim($_GET["url"], "/")));
            if (count($url) > 3) {
                header("Location:".BASE_URL."pagenotfound");
                exit();
            }

            if (!strstr($_GET['url'], 'detail') && 
                !strstr($_GET['url'], 'getProductTypeId') && 
                !strstr($_GET['url'], 'addComment') &&
                !strstr($_GET['url'], 'showComment') &&
                !strstr($_GET['url'], 'deleteComment')) {
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
            $this->product->updateProductView($this->id);
            $this -> view("index", [
                "page" => "product",
                "product" => $this->product->getProduct($slug),
                "category" => $this->product->getCategoryInfo($category_id),
                "productImages" => $this->product->getProductImages($this->id),
                "productSize" => $this->product->getProductAttribute("size", $this->id),
                "productColor" => $this->product->getProductAttribute("color", $this->id),
                "countAllProducts" => $this->product->countAllProducts($this->id),
                "priceProduct" => $this->product->getProductPrice($this->id)
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
                $qtt = $this->product->countProduct($result)->fetch()['quantity'];
                $price_sale = $this->product->countProduct($result)->fetch()['price_sale'];
                $price_origin = $this->product->countProduct($result)->fetch()['price_origin'];

                $data = array(
                    "quantity" => $qtt,
                    "price_sale" => number_format($price_sale),
                    "price_origin" => number_format($price_origin)
                );

                echo json_encode($data);
            }
        }

        function addComment() {
            if (isset($_SESSION['member-username'])){
                $username = $_SESSION["member-username"];
                $this->id = $this->product->getProfile($username);
                if(isset($_POST['addComment'])){
                    $id_prd = $_POST['id_product'];
                    $star = $_POST['star'];
                    $content = $_POST['content'];

                    $this->product->insertComment($id_prd, $this->id, $star, $content);
                    echo "đã thêm bình luận";
                }
            } else {
                echo "sign";
            }
        }

        function showComment() {
            if(isset($_POST['id'])) {
                $id = $_POST['id'];
                $comment = $this->product->showComment($id);
                $output = "";
                $star = 0;
                if ($comment->rowCount() > 0) {
                    if(isset($_SESSION['member-username'])) {
                        $username = $_SESSION["member-username"];
                        $this->id = $this->product->getProfile($username);
                    } else {
                        $this->id = 0;
                    }
                    foreach ($comment->fetchAll() as $row) {
                        $star += $row['star'];
                        $name = $this->product->getProfileById($row['member_id']);
                        $output .=
                        "<div class='comment'>
                            <div class='comment-header'>
                                <img src='".BASE_URL."public/assets/img/default-avatar.png' alt='User Avatar' class='comment-user-avatar'>
                                <div>
                                    <h3>".$name."</h3>
                                    <span>".dateVietnamese($row['date'])."</span>
                                </div>
                                <div class='comment-star'>";
                            for ($i = 0; $i < 5; $i++) {
                                if ($i < $row['star']) {
                                    $output .= "
                                    <span><i class='comment-star-icon fas fa-star'></i></span>
                                ";
                                } else {
                                    $output .= "
                                        <span><i style='color: #aeb4be' class='fal fa-star'></i></span>
                                    ";
                                }
                            };
                        $output .="</div>
                            </div>
                            <p class='comment-content'>".$row['content']."</p>
                            ".($row['member_id'] == $this->id ? '<div style="text-align: right"><button class="btn remove-comment-myself" id="'.$row['id'].'"><i style="margin-right: 8px" class="fal fa-trash"></i>Xoá</button></div>' : '')."
                        </div>";
                        
                    }
                    $output .= "
                        <script>
                            function fetch_comment(){
                                let id = $('.value-get-showComment').val();
                                $.ajax({
                                    url: 'product/showComment',
                                    method: 'POST',
                                    data: {
                                        'id' : id
                                    },
                                    success:function(data) {
                                        let json = JSON.parse(data)
                                        $('.product-comment-list').html(json.data);
                                        // json.star
                                    }
                                })
                            }
                            $('.remove-comment-myself').click(function(e){
                                e.preventDefault();
                                let id_comment = $(this).attr('id');
                                $.ajax({
                                    url: 'product/deleteComment',
                                    method: 'POST',
                                    data: {
                                        'idComment': id_comment
                                    },
                                    success:function(data) {
                                        alert(data);
                                        fetch_comment();
                                    }
                                })
                            })
                        </script>";
                    $product_star = $star / $comment->rowCount();
                } else {
                    $output .= "<div class='comment'>
                                    <span>chưa có comment nào của sản phẩm này</span>
                                </div>";
                    $product_star = 5;
                }
                $data = array(
                    "data" => $output,
                    "star" => $product_star
                );
                echo json_encode($data);
            }
        }

        function deleteComment() {
            if(isset($_POST['idComment'])){
                $id_comment = $_POST['idComment'];
                $username = $_SESSION["member-username"];
                $id_member = $this->product->getProfile($username);

                $this->product->deleteComment($id_comment,$id_member);
                echo "đã xoá bình luận";
            }
        }
    }
?>