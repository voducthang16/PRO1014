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
        function get_data(){
            if (isset($_POST['value'])) {
                $search = $_POST['value'];
                $output = '';
                $data = $this->search->search_product($search);
                if ($data->rowCount() != 0) {
                    foreach($data->fetchAll() as $row){
                        $price = $this->search-> getProductPrice($row['id']);
                        $product_size = $this->search->getProductAttribute('size', $row["id"]);
                        $product_color = $this->search->getProductAttribute('color', $row["id"]);
                        $output .= '
                                    <div class="col l-4">
                                        <form class="products products-s products-p" id="'.$row['id'].'" method="POST">
                                            <input type="hidden" name="product-id" class="products-id" value="'.$row['id'].'">
                                            <input type="hidden" name="product-category-id" class="products-category-id" value="'.$row["category_id"].'">
                                            <div class="products-heart">
                                                <span>Add to wishlist</span>
                                                <i class="fal fa-heart btn-add-to-wishlist""></i>
                                            </div>
                                            <a href="product/detail/'.$row["slug"].'" class="products-link">
                                                <img src="public/upload/'.$row["id"].'/'.$row["thumbnail"].'" alt="Product Image" class="products-img">
                                            </a>
                                            <div class="products-body">
                                                <a href="product/detail/'.$row["slug"].'" class="products-name">'.$row["name"].'</a>
                                                <h4 class="products-price price-sale-value">'.number_format($price["minn"]).'đ - '.number_format($price["maxx"]).'đ</h4>
                                            </div>
                                            <div class="products-attribute-hidden">
                                                <div class="products-size">';
                                            foreach($product_size as $size) {
                                                $output .= '
                                                    <div class="products-attribute-item">
                                                        <input class="products-attribute-input attributes-size-input radio-box-get-quantity" type="radio" name="size" id="'.$row["id"].'_'.$size['id'].'" value="'.$size['id'].'">
                                                        <label class="products-attribute-option" for="'.$row["id"].'_'.$size['id'].'">'.$size['value'].'</label>
                                                    </div>';
                                            };
                                                    
                                    $output.= ' </div>
                                                <div class="products-color">';
                                            foreach($product_color as $color) {
                                                $output .= '
                                                    <div class="products-attribute-item">
                                                        <input class="products-attribute-input attributes-color-input radio-box-get-quantity" type="radio" name="color" id="'.$row['id'].'_'.$color['id'].'" value="'.$color['id'].'">
                                                        <label class="products-attribute-option color" for="'.$row['id'].'_'.$color['id'].'">
                                                            <span style="background-color: '.$color['value'].'" class="products-attribute-color"></span>
                                                        </label>
                                                    </div>';
                                            };    
                                                    
                                    $output.= ' </div>
                                                <span class="product-quantity-detail" style="display: none;">
                                                    <span id="type_quantity" style="display: block;">
                                                </span> sản phẩm có sẵn</span>
                                                <div class="products-btn">
                                                    <button class="btn btn--size-s btn-add-cart">Add to cart</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>';
                    }
                    $output .= '
                        <script>
                            $(".btn-add-to-wishlist").click(function(e){
                                e.preventDefault();
                                let parent = $(this).parents(".products-s");
                                let id_product = parent.find(".products-id").val();
                                $.ajax({
                                    url: "product/addWishList",
                                        method: "POST",
                                        data: {
                                            "action": "addWishList",
                                            "id_product": id_product
                                        },
                                        success:function(data) {
                                            if (data == "sign") {
                                                document.location.href = "sign";
                                            } else {
                                                alert(data);
                                            }
                                        }
                                });
                            })
                        </script>';
                } else {
                    $output .= "chưa tìm thấy sản phẩm nào";
                }
                echo $output;
            }
        }
    }
?>