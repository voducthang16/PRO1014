<?php 
    class categoryDetail extends database {
        function getProductAttribute($attribute, $id) {
            $query = "SELECT DISTINCT products_attributes.id, products_attributes.value FROM products_attributes INNER JOIN products_type_attributes 
            ON products_attributes.id = products_type_attributes.attributes_id 
            WHERE products_type_attributes.product_type_id 
            IN (SELECT products_type.id FROM products_type WHERE products_type.product_id = $id) AND products_attributes.name LIKE '%$attribute%'";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }
        function checkWishList($id_member, $id_prd) {
            $query = "SELECT * FROM products_wishlist WHERE member_id = $id_member AND product_id = $id_prd";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->rowCount();
        }
        function getProfile($username) {
            $qr = "SELECT id FROM members WHERE username = ?";
            $result = $this->connect->prepare($qr);
            $result->execute([$username]);
            return $result->fetch()['id'];
        }
    }
    $categoryDetail = new categoryDetail();
?>

<div class="category">
    <div class="page-header cate">
        <div class="container wide">
            <div class="page-wrapper">
                <h2 class="page-title"><?=$data['categoryName']?></h2>
                <nav class="page-navbar">
                    <ul class="page-list">
                        <li class="page-item">
                            <a href="<?=BASE_URL?>" class="page-link"><i class="fal fa-home"></i>Trang chủ<i class="fal fa-chevron-right"></i></a>
                        </li>
                        <li class="page-item">
                            <a href="<?=BASE_URL?>category/detail/all" class="page-link">Danh mục<i class="fal fa-chevron-right"></i></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link"><?=$data['categoryName']?></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div class="page-body container wide">
        <div class="row">
            <div class="col l-3 c-0">
                <div class="page-sidebar">
                    <div class="category-list">
                        <h3>Danh mục</h3>
                        <ul class="category-list-item">
                            <?php foreach ($data['categories'] as $category): ?>
                                <li class="category-item">
                                    <a href="<?=BASE_URL?>category/detail/<?=$category['slug']?>" class="category-link">
                                        <?=$category['name']?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col l-9 c-12">
                <div class="row mt-80">
                    <?php foreach ($data['getProducts'] as $key=>$product): ?>
                        <div class="col l-4 c-12">
                            <form class="products products-s products-p" id="<?=$product["id"]?>" method="POST">
                                <input type="hidden" name="product-id" class="products-id" value="<?=$product["id"]?>">
                                <input type="hidden" name="product-category-id" class="products-category-id" value="<?=$product["category_id"]?>">
                                <div class="products-heart">
                                    <span>Add to wishlist</span>
                                    <?php
                                        if (isset($_SESSION["member-username"])) {
                                        $id_username = $categoryDetail->getProfile($_SESSION["member-username"]);
                                        $check_wishlist = $categoryDetail->checkWishList($id_username,$product["id"]);
                                        if ($check_wishlist == 0) {
                                    ?>
                                        <i class="fal fa-heart btn-add-to-wishlist"></i>
                                    <?php } else { ?>
                                        <i class="fal fa-heart btn-add-to-wishlist wishlist--status"></i>
                                    <?php }} else { ?>
                                        <i class="fal fa-heart btn-add-to-wishlist"></i>
                                    <?php } ?>
                                    <!-- <i class="btn-add-to-wishlist fal fa-heart"></i> -->
                                </div>
                                <a href="product/detail/<?=$product["slug"]?>" class="products-link">
                                    <img src="public/upload/<?=$product["id"]?>/<?=$product["thumbnail"]?>" alt="Product Image" class="products-img">
                                </a>
                                <div class="products-body">
                                    <a href="product/detail/<?=$product["slug"]?>" class="products-name"><?=$product["name"]?></a>
                                    <h4 class="products-price price-sale-value"><?=number_format($product["minn"])?>đ - <?=number_format($product["maxx"])?>đ</h4>
                                </div>
                                <div class="products-attribute-hidden">
                                    <div class="products-size">
                                        <?php 
                                            $product_size = $categoryDetail->getProductAttribute('size', $product["id"]);
                                            foreach ($product_size as $size):
                                        ?>
                                            <div class="products-attribute-item">
                                                <input class="products-attribute-input attributes-size-input radio-box-get-quantity" type="radio" name="size" id="<?=$product["id"]?>_<?=$size['id']?>" value="<?=$size['id']?>">
                                                <label class="products-attribute-option" for="<?=$product["id"]?>_<?=$size['id']?>"><?=$size['value']?></label>
                                            </div>
                                        <?php endforeach;?>
                                    </div>
                                    <div class="products-color">
                                        <?php 
                                            $product_color = $categoryDetail->getProductAttribute('color', $product["id"]);
                                            foreach ($product_color as $color):
                                        ?>
                                            <div class="products-attribute-item">
                                                <input class="products-attribute-input attributes-color-input radio-box-get-quantity" type="radio" name="color" id="<?=$product['id']?>_<?=$color['id']?>" value="<?=$color['id']?>">
                                                <label class="products-attribute-option color" for="<?=$product['id']?>_<?=$color['id']?>">
                                                    <span style="background-color: <?=$color['value']?>" class="products-attribute-color"></span>
                                                </label>
                                            </div>
                                        <?php endforeach;?>
                                    </div>
                                    <span class="product-quantity-detail" style="display: none;">
                                        <span id="type_quantity" style="display: block;">
                                    </span> sản phẩm có sẵn</span>
                                    <div class="products-btn">
                                        <button class="btn btn--size-s btn-add-cart">Add to cart</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php endforeach;?>
                    <?php 
                        $url = explode("/", filter_var(trim($_GET["url"], "/")));
                        $url2 = explode("/", filter_var(trim($_GET["url"], "/")));
                        if (count($url) > 3) {
                            $url = array_diff($url, [$url[3]]);
                        }
                        $urlPagination = "";
                        foreach ($url as $key=>$value) {
                            $urlPagination .= $url[$key] .= "/";
                        };
                    ?>
                    <div class="col l-12 c-12">
                        <div class="pagination">
                            <?php for ($i = 1; $i <= $data['totalPages']; $i++):?>
                                <a class="pagination-item <?=((count($url2) == 3 && $i == 1) || ($url2[3] == $i)) ? 'active' : ''?>" href="<?=$urlPagination?><?=$i?>">
                                    <?=$i?>
                                </a>
                            <?php endfor;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>