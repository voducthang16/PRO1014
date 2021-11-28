<div class="profile-page">
    <div class="page-header">
        <div class="container wide">
            <div class="page-wrapper">
                <h2 class="page-title">Profile info</h2>
                <nav class="page-navbar">
                    <ul class="page-list">
                        <li class="page-item">
                            <a href="<?= BASE_URL ?>" class="page-link"><i class="fal fa-home"></i>Trang chủ<i class="fal fa-chevron-right"></i></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link">Account<i class="fal fa-chevron-right"></i></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link">Profile</a>
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
                    <h2 class="wishlist-title">Update you profile details below:</h2>
                    <div class="wishlist-product-list">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col l-6">
                                    <div class="form-group">
                                        <label for="full_name">Full Name</label>
                                        <input type="text" class="form-control" id="full_name" name="full_name" value="<?=$data['profile']['name']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone Number</label>
                                        <input type="number" class="form-control" id="phone" name="phone" value="<?=$data['profile']['phone']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">New Password</label>
                                        <input type="password" class="form-control" id="password" name="password">
                                    </div>
                                </div>
                                <div class="col l-6">
                                    <div style="background-color: #f6f9fc;" class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?=$data['profile']['email']?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" id="address" name="address" value="<?=$data['profile']['address']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="new_password">Confirm Password</label>
                                        <input type="password" class="form-control" id="new_password" name="new_password">
                                    </div>
                                </div>
                                <div style="text-align: right; width: 100%">
                                    <button type="submit" class="btn btn--size-s">Update Profile</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '.account-sign-out', function() {
        $.ajax({
            url: "account/signOut",
            type: "POST",
            success: function(data) {
                window.location.href = "";
            }
        })
    })
</script>