<div class="profile-page">
    <div class="page-header">
        <div class="container wide">
            <div class="page-wrapper">
                <h2 class="page-title">Thông tin khách hàng</h2>
                <nav class="page-navbar">
                    <ul class="page-list">
                        <li class="page-item">
                            <a href="<?= BASE_URL ?>" class="page-link"><i class="fal fa-home"></i>Trang chủ<i class="fal fa-chevron-right"></i></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link">Tài khoản<i class="fal fa-chevron-right"></i></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link">Hồ sơ</a>
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
                    <h2 class="wishlist-title">Cập nhật thông tin chi tiết của bạn bên dưới:</h2>
                    <div class="wishlist-product-list">
                        <form>
                            <div class="row form-update-profile">
                                <div class="col l-6">
                                    <div class="form-group">
                                        <label for="full_name">Họ & Tên</label>
                                        <input type="text" class="form-control" id="full_name" name="full_name" value="<?=$data['profile']['name']?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Số điện thoại</label>
                                        <input type="number" class="form-control" id="phone" name="phone" value="<?=$data['profile']['phone']?>" required>
                                    </div>
                                </div>
                                <div class="col l-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?=$data['profile']['email']?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Địa chỉ</label>
                                        <input type="text" class="form-control" id="address" name="address" value="<?=$data['profile']['address']?>" required>
                                    </div>
                                </div>
                                <div style="text-align: right; width: 100%">
                                    <div style="margin-right: 12px; font-size:13.2px;" type="submit" class="btn btn--size-s btn-submit-update-profile">Cập nhật hồ sơ</div>
                                </div>
                            </div>
                        </form>
                        <form method="POST">
                            <div class="row">
                                <div class="col l-6">
                                    <div class="form-group">
                                        <label for="password">Mật khẩu hiện tại</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                </div>
                                <div class="col l-6">
                                    <div class="form-group">
                                        <label for="password">Mật khẩu mới</label>
                                        <input type="password" class="form-control" id="new-password" name="new-password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_password">Nhập lại mật khẩu mới</label>
                                        <input type="password" class="form-control" id="new-password-re" name="new-password-re" required>
                                    </div>
                                </div>
                                <div style="text-align: right; width: 100%">
                                    <button style="margin-right: 12px" type="submit" class="btn btn--size-s" name="btn-change-password">Cập nhật mật khẩu</button>
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
    $(document).on('click','.btn-submit-update-profile',function() {
        let parent = $(this).parents('.form-update-profile');
        let full_name = parent.find('#full_name').val();
        let email = parent.find('#email').val();
        let address = parent.find('#address').val();
        let phone = parent.find('#phone').val();
        const mailFormat = /^\w+([\.-]?\w+)*@(gmail.com)+$/;

        if (email.match(mailFormat)) {
                email = email;
            } else {
                if (email.length > 0){
                    alert('Bạn cần nhập mail chính xác !!');
                    return;
                }
            }
        if (full_name == "" || email == "" || address == "" || phone == "") {
            alert('Bạn cần cập nhật đầy đủ thông tin');
            return;
        }
        if (phone.length > 12) {
            alert('Bạn cần nhập số điện thoại chính xác !!');
            return;
        }
        $.ajax({
            url: "account/UpdateProfile",
            type: "POST",
            data: {
                email:email,
                phone:phone,
                address:address,
                full_name:full_name
            },  
            success: function(data) {
                alert(data);
                if (data != "update thành công profile") {
                    location.reload();
                }
            }
        })

    })
</script>