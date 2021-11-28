<div class="wishlist-page">
    <div class="page-header">
        <div class="container wide">
            <div class="page-wrapper">
                <h2 class="page-title">My Wishlist</h2>
                <nav class="page-navbar">
                    <ul class="page-list">
                        <li class="page-item">
                            <a href="<?= BASE_URL ?>" class="page-link"><i class="fal fa-home"></i>Trang chủ<i class="fal fa-chevron-right"></i></a>
                        </li>
                        <li class="page-item">
                            <a href="<?= BASE_URL ?>account" class="page-link">Account<i class="fal fa-chevron-right"></i></a>
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
        <div style="padding-bottom: 40px" class="row">
            <div class="col l-4">
                <?php require_once __DIR__ . "/account_sidebar.php"; ?>
            </div>
            <div class="col l-8">
                <div class="account-wishlist">
                    <h2 class="wishlist-title">List of items you added to wishlist:</h2>
                    <div class="wishlist-product-list" id="container-wish-list-prd">
                        <div class="wishlist-product">
                            <!-- <img src="public/upload/'.$row[" product_id"].'/'.$row["thumbnail"].'" alt="">
                            <h2>'.$row['name'].'</h2>
                            <h4>'.number_format($row['minn']).'đ - '.number_format($row['maxx']).'đ</h4>
                            <div class="btn-delete-wish-list btn--delete--wishlist" id="'.$row['product_id'].'">Xoá</div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
            function fetch_wishlist() {
                // show product in wishlist
                $.ajax({
                    url: "account/selectWishList",
                    method: "POST",
                    success: function(data) {
                        let json = JSON.parse(data)
                        $("#container-wish-list-prd").html(json.output);
                        $('#span-quantity-wishlist').html(json.count);
                    },
                });
            }
            fetch_wishlist();
            $(document).on("click", ".btn--delete--wishlist", function(e) {
                e.preventDefault();
                let id_product = $(this).attr("id");
                $.ajax({
                    url: "account/deleteWishList",
                    method: "POST",
                    data: {
                        id_product: id_product
                    },
                    success: function(data) {
                        alert(data);
                        fetch_wishlist();
                    }
                })
            })
        })
    </script>
</div>