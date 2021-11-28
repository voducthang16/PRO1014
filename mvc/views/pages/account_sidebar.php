<?php
    class account_sidebar extends database {
        function getProfile($username) {
            $qr = "SELECT * FROM members WHERE username = ?";
            $result = $this->connect->prepare($qr);
            $result->execute([$username]);
            return $result->fetch();
        }

        function countOrderMember($id) {
            $query = "SELECT COUNT(*) as 'count' FROM `orders` WHERE orders.member_id = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch()['count'];
        }

        function countProductWishlist($id) {
            $query = "SELECT COUNT(*) as 'count' FROM `products_wishlist` WHERE products_wishlist.member_id = $id";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch()['count'];
        }
    }
    $account_sidebar = new account_sidebar();
    $result = $account_sidebar->getProfile($_SESSION["member-username"]);
    $id = $result['id'];
    $wishlist_product_quantity = $account_sidebar->countProductWishlist($id);
    $order_quantity = $account_sidebar->countOrderMember($id);
    // echo $id;
?>
<div class="account_sidebar">
    <div class="account-header">
        <img class="account-avatar" src="<?=BASE_URL?>public/assets/img/default-avatar.png" alt="Avatar Images">
        <div class="account-header-info">
            <h3><?=$result['name']?></h3>
            <h4><?=$result['email']?></h4>
        </div>
    </div>
    <div class="account-body">
        <div class="account-body-title">
            <h2>Dashboard</h2>
        </div>
        <ul class="account-body-list">
            <li>
                <a class="account-body-list-link <?=isset($_GET['url']) && $_GET['url'] == 'account/order' ? 'active' : ''?>" href="account/order">
                    <div class="">
                        <i class="fal fa-shopping-bag"></i>
                        <span>Order</span>
                    </div>
                    <span style="color: var(--text-color) !important"><?=$order_quantity?></span>
                </a>
            </li>
            <li>
                <a class="account-body-list-link <?=isset($_GET['url']) && $_GET['url'] == 'account/wishlist' ? 'active' : ''?>" href="account/wishlist">
                    <div class="">
                        <i class="fal fa-heart"></i>
                        <span>Wishlist</span>
                    </div>
                    <span style="color: var(--text-color) !important" id="span-quantity-wishlist"><?=$wishlist_product_quantity?></span>
                </a>
            </li>
        </ul>
        <div class="account-body-title">
            <h2>Account settings</h2>
        </div>
        <ul class="account-body-list">
            <li>
                <a class="account-body-list-link <?=isset($_GET['url']) && $_GET['url'] == 'account/profile' ? 'active' : ''?>" href="account/profile">
                    <div class="">
                        <i class="fal fa-user"></i>
                        <span>Profile info</span>
                    </div>
                </a>
            </li>
            <li>
                <a class="account-body-list-link" href="">
                    <div class="">
                        <i class="fal fa-map-marker-alt"></i>
                        <span>Address</span>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>