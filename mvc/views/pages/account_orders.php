<div class="page-header">
    <div class="container wide">
        <div class="page-wrapper">
            <h2 class="page-title">My order</h2>
            <nav class="page-navbar">
                <ul class="page-list">
                    <li class="page-item">
                        <a href="<?=BASE_URL?>" class="page-link"><i class="fal fa-home"></i>Trang chủ<i class="fal fa-chevron-right"></i></a>
                    </li>
                    <li class="page-item">
                        <a href="<?=BASE_URL?>account" class="page-link">Account<i class="fal fa-chevron-right"></i></a>
                    </li>
                    <li class="page-item">
                        <a class="page-link">Order history</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<div style="margin-top: -80px" class="container wide">
    <div class="row">
        <div class="col l-4">
            <?php require_once __DIR__ . "/account_sidebar.php";?>
        </div>
        <div class="col l-8">
            <div class="account-orders">
                orderpage
            </div>
        </div>
    </div>
</div>