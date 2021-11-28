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
                !strstr($_GET['url'], 'deleteComment') &&
                !strstr($_GET['url'], 'addWishList')) {
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

        function addWishList() {
            if(isset($_SESSION["member-username"])){
                $account = $this->model('accountModels');
                $username = $_SESSION["member-username"];
                $this->id = $account->getProfile($username);
                if(isset($_POST['action'])){
                    $id_product = $_POST['id_product'];
                    $check = $account->checkPrdWishList($this->id,$id_product);
                    if ($check == 0) {
                        $result = $account->addWishList($this->id,$id_product);
                        if ($result == true) {
                            echo "đã thêm sản phẩm vào wish list";
                            return;
                        }
                        echo "thêm sản phẩm thất bại"; 
                    } else {
                        $account->deleteWishList($this->id, $id_product);
                    }
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
                if ($comment->rowCount() > 0) {
                    if(isset($_SESSION['member-username'])) {
                        $username = $_SESSION["member-username"];
                        $this->id = $this->product->getProfile($username);
                    } else {
                        $this->id = 0;
                    }
                    foreach ($comment->fetchAll() as $row) {
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
                } else {
                    $output .= "<div class='no-comment'>
                                    <span>Sản phẩm chưa có comment</span>
                                </div>";
                }
                $data = array(
                    "data" => $output,
                );
                echo json_encode($data);
            }
        }

        function showCommentData() {
            if(isset($_POST['id'])) {
                $id = $_POST['id'];
                $result = $this->product->showComment($id)->fetchAll();
                $_1star = 0; $_1starPercent = 0;
                $_2star = 0; $_2starPercent = 0;
                $_3star = 0; $_3starPercent = 0;
                $_4star = 0; $_4starPercent = 0;
                $_5star = 0; $_5starPercent = 0;
                $totalStar = 0;
                $average = 0;
                $commentQuantity = count($result);
                if ($commentQuantity > 0) {
                    $starQuantity = $this->product->quantityStar($id);
                    foreach($starQuantity as $star) {
                        if ($star['star'] == 1) {
                            $_1star = $star['count'];
                            $_1starPercent = toFixed(($_1star / $commentQuantity) * 100, 2);
                            $totalStar += $star['star'] * $_1star;
                        }
                        if ($star['star'] == 2) {
                            $_2star = $star['count'];
                            $_2starPercent = toFixed(($_2star / $commentQuantity) * 100, 2);
                            $totalStar += $star['star'] * $_2star;
                        }
                        if ($star['star'] == 3) {
                            $_3star = $star['count'];
                            $_3starPercent = toFixed(($_3star / $commentQuantity) * 100, 2);
                            $totalStar += $star['star'] * $_3star;
                        }
                        if ($star['star'] == 4) {
                            $_4star = $star['count'];
                            $_4starPercent = toFixed(($_4star / $commentQuantity) * 100, 2);
                            $totalStar += $star['star'] * $_4star;
                        }
                        if ($star['star'] == 5) {
                            $_5star = $star['count'];
                            $_5starPercent = toFixed(($_5star / $commentQuantity) * 100, 2);
                            $totalStar += $star['star'] * $_5star;
                        }
                    }
                    $average = $totalStar / $commentQuantity;
                }
                $output = "";
                $output .= '
                    <div class="col l-4">
                        <h3 class="product-comment-quantity">'.$commentQuantity.' Bình luận</h3>
                        <div>';
                for ($i = 0; $i < 5; $i++) {
                    if ($i < round($average)) {
                        $output .= "<span><i class='comment-star-icon average fas fa-star'></i></span>";
                    } else {
                        $output .= "<span><i style='color: #aeb4be; font-size: 1.6rem' class='fal fa-star'></i></span>";
                    }
                };
                $output .='<span style="margin-left: 8px; font-size: 1.6rem">'.toFixed($average, 1).'</span></div>
                    </div>
                    <div class="col l-8">
                        <div class="star-percent">
                            <span>5<i style="margin-left: 4px" class="fas fa-star"></i></span>
                            <div class="star-progress">
                                <div style="width: '.$_5starPercent.'%; background-color: rgb(66, 214, 151)" class="star-progress-bar"></div>
                            </div>
                            <span class="star-quantity">'.$_5star.'</span>
                        </div>
                        <div class="star-percent">
                            <span>4<i style="margin-left: 4px" class="fas fa-star"></i></span>
                            <div class="star-progress">
                                <div style="width: '.$_4starPercent.'%; background-color: #a7e453" class="star-progress-bar"></div>
                            </div>
                            <span class="star-quantity">'.$_4star.'</span>
                        </div>
                        <div class="star-percent">
                            <span>3<i style="margin-left: 4px" class="fas fa-star"></i></span>
                            <div class="star-progress">
                                <div style="width: '.$_3starPercent.'%; background-color: #ffda75" class="star-progress-bar"></div>
                            </div>
                            <span class="star-quantity">'.$_3star.'</span>
                        </div>
                        <div class="star-percent">
                            <span>2<i style="margin-left: 4px" class="fas fa-star"></i></span>
                            <div class="star-progress">
                                <div style="width: '.$_2starPercent.'%; background-color: #fea569" class="star-progress-bar"></div>
                            </div>
                            <span class="star-quantity">'.$_2star.'</span>
                        </div>
                        <div class="star-percent">
                            <span>1<i style="margin-left: 4px" class="fas fa-star"></i></span>
                            <div class="star-progress">
                                <div style="width: '.$_1starPercent.'%; background-color: rgb(243, 71, 112)" class="star-progress-bar"></div>
                            </div>
                            <span class="star-quantity">'.$_1star.'</span>
                        </div>
                    </div>
                ';
                echo $output;
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