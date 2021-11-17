<div class="product">
    <div class="page-header">
        <div class="container wide">
            <div class="page-wrapper">
                <h2 class="page-title"><?=$data['product']['name']?></h2>
                <nav class="page-navbar">
                    <ul class="page-list">
                        <li class="page-item">
                            <a href="<?=BASE_URL?>" class="page-link"><i class="fal fa-home"></i>Trang chủ<i class="fal fa-chevron-right"></i></a>
                        </li>
                        <li class="page-item">
                            <a href="<?=BASE_URL?>category/detail/<?=$data['category']['slug']?>" class="page-link"><?=$data['category']['name']?><i class="fal fa-chevron-right"></i></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link"><?=$data['product']['name']?></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div class="page-body container wide">
        <div class="product-wrapper row">
            <div class="col l-7">
                <div class="row">
                    <div class="col l-2">
                        <div class="product-slide">
                            <img class="product-slide-image active" src="public/upload/<?=$data['product']['id']?>/<?=$data['product']['thumbnail']?>" alt="Product Image Slide">
                            <?php foreach ($data['productImages'] as $image) :?>
                                <img class="product-slide-image" src="public/upload/<?=$data['product']['id']?>/<?=$image["image"]?>" alt="Product Image Slide">
                            <?php endforeach;?>
                        </div>
                    </div>
                    <div class="col l-10">
                        <div class="product-thumbnail">
                            <img id="product-thumbnail" src="public/upload/<?=$data['product']['id']?>/<?=$data['product']['thumbnail']?>" alt="Product Thumbnail">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col l-5">
                <div class="product-info">
                    <div class="product-heart">
                        <div class="product-heart-wrapper">
                            <span>Add to wishlist</span>
                            <i class="fal fa-heart"></i>
                        </div>
                    </div>
                    <div class="product-price">
                        <?php if ($data['product']['price_origin'] > $data['product']['price_sale']):?>
                            <p class="product-price-sale"><?=number_format($data['product']['price_sale'])?>đ</p>
                            <del class="product-price-origin"><?=number_format($data['product']['price_origin'])?>đ</del>
                            <span class="product-sale-label">Sale</span>
                        <?php else:?>
                            <p class="product-price-sale"><?=number_format($data['product']['price_origin'])?>đ</p>
                        <?php endif;?>
                    </div>
                    <form action="" method="POST">
                        <input type="hidden" name="product-id" id="product-id" value="<?=$data['product']['id']?>">
                        <input type="hidden" name="product-category-id" id="product-category-id" value="<?=$data['product']['category_id']?>">
                        <div class="product-attribute">
                            <div class="products-size p">
                                <?php echo count($data['productSize']) > 0 ? "<span>Size:</span>" : "";?>
                                <?php foreach ($data['productSize'] as $size):?>
                                    <div class="products-attribute-item">
                                        <input class="products-attribute-input attributes-size-input" type="radio" name="product-size" id="<?=$size['id']?>" value="<?=$size['id']?>">
                                        <label class="products-attribute-option" for="<?=$size['id']?>"><?=$size['value']?></label>
                                    </div>
                                <?php endforeach;?>
                            </div>
                            <div class="products-color p mt-24">
                                <?php echo count($data['productColor']) > 0 ? "<span class='color-title'>Màu:</span>" : "";?>
                                <?php foreach ($data['productColor'] as $color):?>
                                    <div class="products-attribute-item">
                                        <input class="products-attribute-input attributes-color-input" type="radio" name="product-color" id="<?=$color['id']?>" value="<?=$color['id']?>">
                                        <label class="products-attribute-option color" for="<?=$color['id']?>">
                                            <span style="background-color: <?=$color['value']?>" class="products-attribute-color"></span>
                                        </label>
                                    </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                        <div class="product-quantity">
                            <span class="product-quantity-title">Số lượng: </span>
                            <div class="quantity-minus quantity-btn"><i class="fal fa-minus"></i></div>
                            <input type="number" name="product-quantity" class="product-quantity-value" value="1" min="1">
                            <div class="quantity-plus quantity-btn"><i class="fal fa-plus"></i></div>
                            <span class="product-quantity-detail"><span id="type_quantity"><?=$data['countAllProducts']?></span> sản phẩm có sẵn</span> 
                        </div>
                        <div class="product-cta">
                            <button class="btn"><i style="margin-right: 8px" class="fal fa-cart-plus"></i>Add to cart</button>
                        </div>
                    </form>
                    <div class="product-parameters">
                        <h3><i style="margin-right: 8px; margin-left: 20px" class="fal fa-info-circle"></i>Thông số sản phẩm:</h3>
                        <ul>
                            <?php
                                $parameters = explode("-", trim($data['product']['parameters']));
                                array_shift($parameters);
                                foreach ($parameters as $value):
                            ?>
                                <li><?=$value?></li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-description row">
            <div class="l-o-1"></div>
            <div class="col l-5">
                <div class="product-description-content">
                    <h3 class="product-description-title">High quality materials</h3>
                    <h6 class="product-description-sub-title"><?=$data['product']['description']?></h6>
                    <div class="product-description-footer">
                        <h4>Washing instructions</h4>
                    </div>
                </div>
            </div>
            <div class="col l-5">
                <img class="product-description-img" src="https://cartzilla.createx.studio/img/shop/single/prod-img.jpg" alt="Image">
            </div>
            <div class="l-o-1"></div>
        </div>

        <div class="product-origin row">
            <div class="l-o-1"></div>
            <div class="col l-5">
                <img class="product-origin-img" src="https://cartzilla.createx.studio/img/shop/single/prod-map.png" alt="Image">
            </div>
            <div class="col l-5">
                <div class="product-origin-content">
                    <h3 class="product-description-title">Where is it made?</h3>
                </div>
            </div>
            <div class="l-o-1"></div>
        </div>
    </div>
</div>