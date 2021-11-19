<?php
    ob_start();
    class headerModel extends database {
        function getCategories() {
            $query = "SELECT * FROM `category` WHERE status = 1";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }
    }
    $header = new headerModel();

    $categories = $header->getCategories();
?>

<header class="header">
    <div class="topbar">
        <div class="container wide">
            <div class="topbar-wrapper row">
                <div class="col l-3">
                    <p class="support">
                        <i class="fal fa-headset"></i>Hỗ trợ <a href="tel:0123456789">0123456789</a>
                    </p>
                </div>
                <div class="col l-3">
                    <div class="topbar-text">
                        <p class="animate-text">
                            <span>Free shipping for order over $200</span>
                            <span>Friendly 24/7 customer support</span>
                            <span>We return money within 30 days</span>
                        </p>
                    </div>
                </div>
                <div class="col l-3">
                    <p class="order-tracking">
                        <i class="fal fa-map-marker"></i><a href="#">Order Tracking</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="navbar">
        <div class="container wide">
            <div class="navbar-control row">
                <div class="col l-2">
                    <div class="navbar-logo">
                        <a href="" class="navbar-logo-link">
                            <img width="100%" src="public/assets/img/test.png" alt="LOGO">
                        </a>
                    </div>
                </div>
                <div class="col l-6">
                    <div class="search">
                        <input class="search-control" type="text" name="search" id="search" placeholder="Search...." required>
                        <i class="fal fa-search search-icon"></i>
                    </div>
                </div>
                <div class="col l-4">
                    <div class="toolbar">
                        <div class="expand">
                            <p class="expand-btn">
                                <span style="width: 86px">Expand Menu</span>
                                <i class="fal fa-bars"></i>
                            </p>
                        </div>
                        <div class="wishlist">
                            <a href="wishlist" class="wishlist-link">
                                <span>Wishlist</span>
                                <i class="fal fa-heart"></i>
                            </a>
                        </div>
                        <div class="user">
                            <a href="<?=isset($_SESSION["member-login"]) ? 'account' : 'sign'?>" class="user-link">
                                <i class="fal fa-user"></i>
                                <div class="user-action">
                                    <?php if (!isset($_SESSION["member-login"])):?>
                                        <span>Hello, Đăng nhập</span>
                                    <?php endif;?>
                                    <?php if (isset($_SESSION["member-login"])):?>
                                        <span>My account</span>
                                    <?php endif;?>
                                </div>
                            </a>
                        </div>
                        <div class="cart">
                            <a href="<?=BASE_URL?>cart" class="cart-link">
                                <i class="fal fa-shopping-cart cart-icon">
                                    <span class="cart-quantity" id="cart-quantity-val">0</span>
                                </i>
                                <div class="cart-body">
                                    <span>My cart</span>
                                    <span id='cart-total-val-2'></span>
                                </div>
                            </a>
                            <div class="cart-items">
                                <!--  -->
                                <?php if (empty($_SESSION["member-login"])):?>
                                    <div class="no-cart">
                                        <img src="<?=BASE_URL?>public/assets/img/no_cart.png" alt="No Cart">
                                        <span>Giỏ hàng trống</span>
                                    </div>
                                <?php else:?>
                                    <div class="render-cart">
                                        <!-- container list product -->
                                        
                                    </div>
                                    <div class='cart-footer'>
                                        <div class='cart-total'>
                                            <p>Tổng tiền: <span id='cart-total-val'></span></p>
                                            <a href='<?=BASE_URL?>cart' class='cart-view btn btn--size-s'>Xem giỏ hàng <i class='fal fa-chevron-right'></i></a>
                                        </div>
                                        <a href='checkout' class='btn cart-checkout'><i class='fal fa-credit-card'></i> Thanh toán</a>
                                    </div>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="navbar-menu row">
                <div class="col l-10 l-o-2">
                    <ul class="navbar-menu-list">
                        <?php foreach ($categories as $category):?>
                            <li class="navbar-menu-item">
                                <a href="category/detail/<?=$category['slug']?>" class="navbar-menu-link">
                                    <?=$category['name']?>
                                </a>
                            </li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>