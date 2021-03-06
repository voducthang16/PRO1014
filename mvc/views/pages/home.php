<?php 
    class homepage extends database {
        function getProductAttribute($attribute, $id) {
            $query = "SELECT DISTINCT products_attributes.id, products_attributes.value FROM products_attributes INNER JOIN products_type_attributes 
            ON products_attributes.id = products_type_attributes.attributes_id 
            WHERE products_type_attributes.product_type_id 
            IN (SELECT products_type.id FROM products_type WHERE products_type.product_id = $id AND products_type.status = 1) 
            AND products_attributes.name LIKE '%$attribute%'";
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
    $homepage = new homepage();
?>

<!-- Slide -->
<div class="slide">
    <div class="owl-carousel owl-theme owl-banner home-slide">
        <div class="slide-wrapper slide-wrapper-1">
            <div class="container wide">
                <div class="row slider-mobile">
                    <div class="col l-6">
                        <div class="slide-content">
                            <h4 class="slide-sub-title">Vừa ra mắt!</h4>
                            <h3 class="slide-title delay-1">Bộ sưu tập mùa hè khổng lồ</h3>
                            <p class="slide-desc delay-2">Đồ bơi, Áo khoác ngoài, Quần đùi, Kính râm và nhiều hơn thế nữa ...</p>
                            <div>
                                <a href="#" class="btn btn--size-m slide-link delay-3">Mua ngay <i style="margin-left: 8px" class="fal fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col l-6">
                        <div class="slide-img">
                            <img src="public/assets/img/01.jpg" alt="Slide Image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="slide-wrapper slide-wrapper-2">
            <div class="container wide">
                <div class="row slider-mobile">
                    <div class="col l-6">
                        <div class="slide-content">
                            <h4 class="slide-sub-title">Nhanh lên nào! Ưu đãi có hạn.</h4>
                            <h3 class="slide-title delay-1">Giảm giá quần áo thể thao cho nữ</h3>
                            <p class="slide-desc delay-2">Giày thể thao, Keds, Áo khoác nỉ, Áo hoodie và nhiều hơn nữa...</p>
                            <div>
                                <a href="<?=BASE_URL?>category/detail/all" class="btn btn--size-m slide-link delay-3">Mua ngay <i style="margin-left: 8px" class="fal fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col l-6">
                        <div class="slide-img">
                            <img src="public/assets/img/02.jpg" alt="Slide Image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="slide-wrapper slide-wrapper-3">
            <div class="container wide">
                <div class="row slider-mobile">
                    <div class="col l-6">
                        <div class="slide-content">
                            <h4 class="slide-sub-title">Hoàn thiện ngoại hình của bạn với</h4>
                            <h3 class="slide-title delay-1">Phụ kiện nam mới</h3>
                            <p class="slide-desc delay-2">Mũ & Mũ lưỡi trai, Kính râm, Túi xách và nhiều hơn nữa...</p>
                            <div>
                                <a href="#" class="btn btn--size-m slide-link delay-3">Mua ngay <i style="margin-left: 8px" class="fal fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col l-6">
                        <div class="slide-img">
                            <img src="public/assets/img/03.jpg" alt="Slide Image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Block Category-->
<div class="block-category">
    <div class="container wide">
        <div class="row">
            <div class="col l-8">
                <div class="block-category-wrapper row">
                    <div class="col l-4 c-12">
                        <div class="block-wrapper">
                            <a href="#" class="block-category-link">
                                <img src="public/assets/img/cat-sm01.jpg" alt="Men">
                                <h3>Nam</h3>
                            </a>
                        </div>
                    </div>
                    <div class="col l-4 c-12">
                        <div class="block-wrapper">
                            <a href="#" class="block-category-link">
                                <img src="public/assets/img/cat-sm02.jpg" alt="Men">
                                <h3>Nữ</h3>
                            </a>
                        </div>
                    </div>
                    <div class="col l-4 c-12">
                        <div class="block-wrapper">
                            <a href="#" class="block-category-link">
                                <img src="public/assets/img/cat-sm03.jpg" alt="Men">
                                <h3>Trẻ em</h3>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Home Product -->
<div class="home-product">
    <div class="container wide">
        <h3 class="home-product-title">Sản phẩm thịnh hành</h3>
        <div class="row home-product-wrapper">
            <?php 
                foreach ($data["getProducts"] as $item):
            ?>
                <div class="col l-3 c-12">
                    <form class="products products-s products-p" id="<?=$item["id"]?>" method="POST">
                        <input type="hidden" name="product-id" class="products-id" value="<?=$item["id"]?>">
                        <input type="hidden" name="product-category-id" class="products-category-id" value="<?=$item["category_id"]?>">
                        <div class="products-heart">
                            <span>Thêm vào wishlist</span>
                            <?php
                                if (isset($_SESSION["member-username"])) {
                                $id_username = $homepage->getProfile($_SESSION["member-username"]);
                                $check_wishlist = $homepage->checkWishList($id_username,$item['id']);
                                if ($check_wishlist == 0) {
                            ?>
                                <i class="fal fa-heart btn-add-to-wishlist"></i>
                            <?php } else { ?>
                                <i class="fal fa-heart btn-add-to-wishlist wishlist--status"></i>
                            <?php }} else { ?>
                                <i class="fal fa-heart btn-add-to-wishlist"></i>
                            <?php } ?>
                        </div>
                        <a href="product/detail/<?=$item["slug"]?>" class="products-link">
                            <img src="public/upload/<?=$item["id"]?>/<?=$item["thumbnail"]?>" alt="Product Image" class="products-img">
                        </a>
                        <div class="products-body">
                            <a href="product/detail/<?=$item["slug"]?>" class="products-name"><?=$item["name"]?></a>
                            <h4 class="products-price price-sale-value"><?=number_format($item["minn"])?>đ - <?=number_format($item["maxx"])?>đ</h4>
                        </div>
                        <div class="products-attribute-hidden">
                            <div class="products-size">
                                <?php 
                                    $product_size = $homepage->getProductAttribute('size', $item["id"]);
                                    foreach ($product_size as $size):
                                ?>
                                    <div class="products-attribute-item">
                                        <input class="products-attribute-input attributes-size-input radio-box-get-quantity" type="radio" name="size" id="<?=$item["id"]?>_<?=$size['id']?>" value="<?=$size['id']?>">
                                        <label class="products-attribute-option" for="<?=$item["id"]?>_<?=$size['id']?>"><?=$size['value']?></label>
                                    </div>
                                <?php endforeach;?>
                            </div>
                            <div class="products-color">
                                <?php 
                                    $product_color = $homepage->getProductAttribute('color', $item["id"]);
                                    foreach ($product_color as $color):
                                ?>
                                    <div class="products-attribute-item">
                                        <input class="products-attribute-input attributes-color-input radio-box-get-quantity" type="radio" name="color" id="<?=$item['id']?>_<?=$color['id']?>" value="<?=$color['id']?>">
                                        <label class="products-attribute-option color" for="<?=$item['id']?>_<?=$color['id']?>">
                                            <span style="background-color: <?=$color['value']?>" class="products-attribute-color"></span>
                                        </label>
                                    </div>
                                <?php endforeach;?>
                            </div>
                            <span class="product-quantity-detail" style="display: none;">
                                    <span id="type_quantity" style="display: block;">
                            </span> sản phẩm có sẵn</span>
                            <div class="products-btn">
                                <button class="btn btn--size-s btn-add-cart">Thêm vào giỏ</button>
                            </div>
                        </div>
                    </form>
                </div>
            <?php 
                endforeach;
            ?>
        </div>
        <div class="home-product-btn">
            <a href="<?=BASE_URL?>category/detail/all" class="btn home-product-all">Xem thêm<i style="margin-left: 8px" class="fal fa-chevron-right"></i></a>
        </div>
    </div>
</div>

<!-- Home Banner Ads -->
<div class="home-banner-ads">
    <div class="container wide">
        <div class="row">
            <div class="col l-8 c-12">
                <div class="banner-ads-img">
                    <div class="row">
                        <div class="col l-6 c-12">
                            <div class="banner-ads-img__content">
                                <h3>Nhanh lên! Ưu đãi trong thời gian có hạn</h3>
                                <h2>Converse All Star on Sale</h2>
                                <div>
                                    <a href="#" class="btn box-shadow btn--size-s">Mua ngay</a>
                                </div>
                            </div>
                        </div>
                        <div class="col l-6 c-12">
                            <div>
                                <img class="banner-ads-img__thumbnail" src="public/assets/img/banner.jpg" alt="Banner Image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col l-4 c-12">
                <div class="banner-ads-text">
                    <h2>Your Ads Banner Here</h2>
                    <h3>Hurry up to reserve your spot</h3>
                    <div>
                        <a href="#" class="btn box-shadow btn--size-s">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Home Hoodie -->
<div class="home-hoodie">
    <div class="container wide">
        <div class="row">
            <div class="col l-5 c-12">
                <div class="home-hoodie-thumbnail">
                    <div class="hoodie-thumbnail-header">
                        <h2>Hoodie Day</h2>
                        <a href="#">Ao Hoodie <i class="fal fa-chevron-right"></i></a>
                    </div>
                    <a class="hoodie-thumbnail-img sm--hide">
                        <img src="public/assets/img/hoodie.jpg" alt="Hoodie Thumbnail">
                    </a>
                </div>
            </div>
            <div class="col l-7 c-12">
                <div class="row home-hoodie-slide">
                    <?php foreach ($data['getHoodiesProducts'] as $hoodie): ?>
                        <div class="col l-4 c-6">
                            <div class="home-hoodie-item">
                                <div class="products-heart hoodie">
                                    <span>Add to wishlist</span>
                                    <i class="fal fa-heart"></i>
                                </div>
                                <a href="product/detail/<?=$hoodie["slug"]?>" class="home-hoodie-item-link">
                                    <img src="public/upload/<?=$hoodie['id']?>/<?=$hoodie['thumbnail']?>" alt="Hoodie Image">
                                </a>
                                <div class="home-hoodie-item-body">
                                    <a href="product/detail/<?=$hoodie["slug"]?>" class="home-hoodie-item-name"><?=$hoodie['name']?></a>
                                    <h4 class="home-hoodie-item-price"><?=$hoodie["price_sale"]?>đ</h4>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Home Brands -->
<div class="home-brands">
    <div class="container wide">
        <h3 class="home-brands-title">Mua theo nhãn hiệu</h3>
        <div class="row ml-8 mr-8">
            <div class="col l-3 c-6">
                <div class="home-brands-wrapper">
                    <a href="#" class="home-brands-link">
                        <img class="home-brands-img" src="public/assets/img/brands/01.png" alt="Brand Thumbnail">
                    </a>
                </div>
            </div>
            <div class="col l-3 c-6">
                <div class="home-brands-wrapper">
                    <a href="#" class="home-brands-link">
                        <img class="home-brands-img" src="public/assets/img/brands/02.png" alt="Brand Thumbnail">
                    </a>
                </div>
            </div>
            <div class="col l-3 c-6">
                <div class="home-brands-wrapper">
                    <a href="#" class="home-brands-link">
                        <img class="home-brands-img" src="public/assets/img/brands/03.png" alt="Brand Thumbnail">
                    </a>
                </div>
            </div>
            <div class="col l-3 c-6">
                <div class="home-brands-wrapper">
                    <a href="#" class="home-brands-link">
                        <img class="home-brands-img" src="public/assets/img/brands/04.png" alt="Brand Thumbnail">
                    </a>
                </div>
            </div>
            <div class="col l-3 c-6 mt-24">
                <div class="home-brands-wrapper">
                    <a href="#" class="home-brands-link">
                        <img class="home-brands-img" src="public/assets/img/brands/05.png" alt="Brand Thumbnail">
                    </a>
                </div>
            </div>
            <div class="col l-3 c-6 mt-24">
                <div class="home-brands-wrapper">
                    <a href="#" class="home-brands-link">
                        <img class="home-brands-img" src="public/assets/img/brands/06.png" alt="Brand Thumbnail">
                    </a>
                </div>
            </div>
            <div class="col l-3 c-6 mt-24">
                <div class="home-brands-wrapper">
                    <a href="#" class="home-brands-link">
                        <img class="home-brands-img" src="public/assets/img/brands/07.png" alt="Brand Thumbnail">
                    </a>
                </div>
            </div>
            <div class="col l-3 c-6 mt-24">
                <div class="home-brands-wrapper">
                    <a href="#" class="home-brands-link">
                        <img class="home-brands-img" src="public/assets/img/brands/08.png" alt="Brand Thumbnail">
                    </a>
                </div>
            </div>
            <div class="col l-3 c-6 mt-24">
                <div class="home-brands-wrapper">
                    <a href="#" class="home-brands-link">
                        <img class="home-brands-img" src="public/assets/img/brands/09.png" alt="Brand Thumbnail">
                    </a>
                </div>
            </div>
            <div class="col l-3 c-6 mt-24">
                <div class="home-brands-wrapper">
                    <a href="#" class="home-brands-link">
                        <img class="home-brands-img" src="public/assets/img/brands/10.png" alt="Brand Thumbnail">
                    </a>
                </div>
            </div>
            <div class="col l-3 c-6 mt-24">
                <div class="home-brands-wrapper">
                    <a href="#" class="home-brands-link">
                        <img class="home-brands-img" src="public/assets/img/brands/11.png" alt="Brand Thumbnail">
                    </a>
                </div>
            </div>
            <div class="col l-3 c-6 mt-24">
                <div class="home-brands-wrapper">
                    <a href="#" class="home-brands-link">
                        <img class="home-brands-img" src="public/assets/img/brands/12.png" alt="Brand Thumbnail">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>