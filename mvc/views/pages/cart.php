<?php
    class cartPage extends database {
        function getAttributes($id, $attribute) {
            $query = "SELECT products_attributes.value FROM products_attributes INNER JOIN products_type_attributes ON products_attributes.id = products_type_attributes.attributes_id WHERE products_type_attributes.product_type_id = $id AND products_attributes.name LIKE '%$attribute%'";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch();
        }
    }
    $cartPage = new cartPage();
?>

<div class="cart-page">
    <div class="page-header">
        <div class="container wide">
            <div class="page-wrapper">
                <h2 class="page-title">Your cart</h2>
                <nav class="page-navbar">
                    <ul class="page-list">
                        <li class="page-item">
                            <a href="<?=BASE_URL?>" class="page-link"><i class="fal fa-home"></i>Trang chủ<i class="fal fa-chevron-right"></i></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link">Your cart</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container wide">
            <?php if (empty($_SESSION["member-login"])):?>
                <div class="no-cart-wrapper">
                    <img src="<?=BASE_URL?>public/assets/img/no_cart.png" alt="No Cart Image">
                    <h3>Giỏ hàng của bạn đang trống</h3>
                    <a href="<?=BASE_URL?>" class="btn"><i style="margin-right: 8px" class="fal fa-chevron-left"></i>Tiếp tục mua hàng</a>
                </div>
            <?php else:?>
                <?php if ($data['getCart']->rowCount() > 0):?>
                    <form class="row" method="POST">
                        <div class="col l-8">
                            <div class="cart-page-header">
                                <h3>Sản phẩm</h3>
                                <a href="<?=BASE_URL?>" class="btn btn--size-s"><i style="margin-right: 8px" class="fal fa-chevron-left"></i>Tiếp tục mua hàng</a>
                            </div>
                            <div class="order-product-wrapper">
                                <?php foreach ($data['getCart'] as $item):?>
                                    <div class="order-products">
                                        <div class="order-products-info">
                                            <a href="<?=BASE_URL?>product/detail/<?=$item['slug']?>">
                                                <img src="<?=BASE_URL?>public/upload/<?=$item['product_id']?>/<?=$item['thumbnail']?>" alt="Product Thumbnail">
                                            </a>
                                            <div class="order-products-body">
                                                <a href="<?=BASE_URL?>product/detail/<?=$item['slug']?>"><?=$item['name']?></a>
                                                <h4><?=count($cartPage->getAttributes($item['product_type_id'], "size")) > 0 
                                                ? "Size: ".$cartPage->getAttributes($item['product_type_id'], "size")['value'] : ""?></h4>
                                                <h4>Color: <span style="background-color: <?=$cartPage->getAttributes($item['product_type_id'], "color")['value']?>" class="cart-product__color ps"></span></h4>
                                                <h3 class="order-products-price"><?=number_format($item['price_sale'])?>d</h3>
                                            </div>
                                        </div>
                                        <div class="order-quantity">
                                            <div class="product-quantity op">
                                                <span class="product-quantity-title op">Số lượng: </span>
                                                <div class="quantity-minus quantity-btn"><i class="fal fa-minus"></i></div>
                                                <input type="number" name="product-quantity" class="product-quantity-value" value="<?=$item['quantity']?>" min="1">
                                                <div class="quantity-plus quantity-btn"><i class="fal fa-plus"></i></div>
                                            </div>
                                            <p class="order-delete btn-delete-prd-cart"><i style="margin-right: 4px" class="fal fa-trash"></i> Xóa</p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="col l-4">
                            <div class="cart-page-sub-total">
                                <h4>Subtotal</h4>
                                <h3 id="sub-total-money">2425đ</h3>
                                <div class="order-note">
                                    <label for="note">
                                        <span class="label-button">Note</span>
                                        <span class="label-note">Ghi chú</span>
                                    </label>
                                    <textarea name="note" id="note" rows="10"></textarea>
                                </div>
                                <a href="<?=BASE_URL?>checkout" class="btn order-cta"><i style="margin-right: 8px" class="fal fa-credit-card"></i>Process to checkout</a>
                            </div>
                        </div>
                    </form>
                <?php else:?>
                    <div class="no-cart-wrapper">
                        <img src="<?=BASE_URL?>public/assets/img/no_cart.png" alt="No Cart Image">
                        <h3>Giỏ hàng của bạn đang trống</h3>
                        <a href="<?=BASE_URL?>" class="btn"><i style="margin-right: 8px" class="fal fa-chevron-left"></i>Tiếp tục mua hàng</a>
                    </div>
                <?php endif;?>
            <?php endif;?>
        </div>
    </div>
</div>