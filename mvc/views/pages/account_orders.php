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
            <div class="account-orders">
                orderpage
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.account-sign-out', function() {
            $.ajax({
                url: "account/signOut",
                type: "POST",
                success: function(data) {
                    window.location.href = "";
                }
            })
        })
    })
</script>