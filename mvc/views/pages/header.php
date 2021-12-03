<?php
ob_start();
class headerModel extends database
{
    function getCategories()
    {
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
                            <span>Free shiping cho đơn hàng trên $200</span>
                            <span>Hỗ trợ khách hàng thân thiện 24/7</span>
                            <span>Hoàn tiền trong vòng 30 ngày</span>
                        </p>
                    </div>
                </div>
                <div class="col l-3">
                    <p class="order-tracking">
                        <i class="fal fa-map-marker"></i><a href="#">Theo dõi đơn hàng</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="navbar">
        <div class="container wide">
            <div class="navbar-control row">
                <div class="col l-2 sm--hide">
                    <div class="navbar-logo">
                        <a href="" class="navbar-logo-link">
                            <img width="100%" src="public/assets/img/test.png" alt="LOGO">
                        </a>
                    </div>
                </div>
                <div class="col l-6 search-width">
                    <form action="search" class="search" id="search-form">
                        <input class="search-control" type="text" name="keyword" id="search" placeholder="Tìm kiếm..." required>
                        <input type="submit" style="display: none">
                        <i class="search-btn fal fa-search search-icon"></i>
                    </form>
                </div>
                <div class="col l-4 navbar-box">
                    <div class="toolbar">
                        <div class="expand">
                            <p class="expand-btn">
                                <span style="width: 86px">Expand Menu</span>
                                <i class="fal fa-bars"></i>
                            </p>
                        </div>
                        <div class="wishlist">
                            <a href="<?= BASE_URL ?>account/wishlist" class="wishlist-link">
                                <span>Wishlist</span>
                                <i class="fal fa-heart"></i>
                            </a>
                        </div>
                        <div class="user">
                            <a href="<?= isset($_SESSION["member-login"]) ? 'account/order' : 'sign' ?>" class="user-link">
                                <i class="fal fa-user"></i>
                                <div class="user-action sm--hide">
                                    <?php if (!isset($_SESSION["member-login"])) : ?>
                                        <span>Hello, Đăng nhập</span>
                                    <?php endif; ?>
                                    <?php if (isset($_SESSION["member-login"])) : ?>
                                        <span>My account</span>
                                    <?php endif; ?>
                                </div>
                            </a>
                        </div>
                        <div class="cart">
                            <a href="<?= BASE_URL ?>cart" class="cart-link">
                                <i class="fal fa-shopping-cart cart-icon">
                                    <span class="cart-quantity" id="cart-quantity-val">0</span>
                                </i>
                                <div class="cart-body sm--hide">
                                    <span>Giỏ hàng</span>
                                    <span id='cart-total-val-2'></span>
                                </div>
                            </a>
                            <div class="cart-items">
                                <!--  -->
                                <?php if (empty($_SESSION["member-login"])) : ?>
                                    <div class="no-cart">
                                        <img src="<?= BASE_URL ?>public/assets/img/no_cart.png" alt="No Cart">
                                        <span>Giỏ hàng trống</span>
                                    </div>
                                <?php else : ?>
                                    <div class="render-cart">
                                        <!-- container list product -->

                                    </div>
                                    <div class='cart-footer'>
                                        <div class='cart-total'>
                                            <p>Tổng tiền: <span id='cart-total-val'></span></p>
                                            <a href='<?= BASE_URL ?>cart' class='cart-view btn btn--size-s'>Xem giỏ hàng <i class='fal fa-chevron-right'></i></a>
                                        </div>
                                        <a href='checkout' class='btn cart-checkout'><i class='fal fa-credit-card'></i> Thanh toán</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="navbar-menu row">
                <div class="col l-10 l-o-2">
                    <ul class="navbar-menu-list">
                        <li class="navbar-menu-item">
                            <a href="" class="navbar-menu-link">
                                Trang chủ
                            </a>
                        </li>
                        <li class="navbar-menu-item">
                            <a class="navbar-menu-link">
                                Danh mục
                            </a>
                            <ul class="navbar-submenu-list">
                                <?php foreach ($categories as $category) : ?>
                                    <li class="navbar-submenu-item">
                                        <a href="category/detail/<?= $category['slug'] ?>" class="navbar-submenu-link">
                                            <?= $category['name'] ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li class="navbar-menu-item">
                            <a href="" class="navbar-menu-link">
                                Giới thiệu
                            </a>
                        </li>
                        <li class="navbar-menu-item">
                            <a href="" class="navbar-menu-link">
                                Blog
                            </a>
                        </li>
                        <li class="navbar-menu-item">
                            <a href="<?=BASE_URL?>contacts" class="navbar-menu-link">
                                Liên hệ
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</header>