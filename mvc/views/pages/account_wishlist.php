<div class="page-header">
    <div class="container wide">
        <div class="page-wrapper">
            <h2 class="page-title">My Wishlist</h2>
            <nav class="page-navbar">
                <ul class="page-list">
                    <li class="page-item">
                        <a href="<?=BASE_URL?>" class="page-link"><i class="fal fa-home"></i>Trang chủ<i class="fal fa-chevron-right"></i></a>
                    </li>
                    <li class="page-item">
                        <a href="<?=BASE_URL?>account" class="page-link">Account<i class="fal fa-chevron-right"></i></a>
                    </li>
                    <li class="page-item">
                        <a class="page-link">Wishlist</a>
                    </li>
                </ul>
            </nav>
            <button class="btn btn--size-s account-sign-out"><i style="margin-right: 8px" class="fal fa-sign-out-alt"></i> Đăng xuất</button>
        </div>
    </div>
</div>
<div style="margin-top: -80px" class="container wide">
    <div class="row">
        <div class="col l-4">
            <?php require_once __DIR__ . "/account_sidebar.php";?>
        </div>
        <div class="col l-8">
            <div class="account-wishlist">
                <h2 class="wishlist-title">List of items you added to wishlist:</h2>
                <div class="wishlist-product-list">
                    <div class="wishlist-product">
                        <!-- img -->
                        <!-- h2.title -->
                        <!-- h4.price -->
                        <!-- btn.delete -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>