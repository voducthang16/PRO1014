<div class="forgot-password">
    <div class="container wide">
        <div class="row">
            <div class="col l-o-3 l-6">
                <h2>Forgot your password?</h2>
                <p>Change your password in three easy steps. This helps to keep your new password secure.</p>
                <form action="" method="post" class="form-forgotPassword">
                    <div class="form-group">
                        <label for="email">Enter your email</label>
                        <input class="form-control input-value-email-forgot" type="email" name="email" id="email" placeholder="Email ..." required>
                    </div>
                    <div style="text-align: left" class="form-group">
                        <button type="submit" class="btn btn-primary btn-forgotPw">Get new password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('.btn-forgotPw').click(function(e){
        e.preventDefault();
        const email = $('.input-value-email-forgot').val();
        if (email == "") {
            notification('danger','Bạn chưa nhập email !! Vui lòng thực hiện lại');
            return;
        }
        $.ajax({
            url:'sign/checkEmailForgotPassword',
            method:'POST',
            data: {
                'email': email
            },
            beforeSend: function() {
                // code loading start
            },
            success:function(data) {
                let json = JSON.parse(data);
                if (json.action == true && json.mailer == true) {
                    $('.form-forgotPassword').html(json.output);
                    notification('success','Nhập mã code dc gửi trong mail để lấy lại mật khẩu');
                } else if (json.action == true && json.mailer == false) {
                    notification('danger','Lỗi khi gửi mail bạn vui lòng thực hiện lại để lấy code');
                } else {
                    notification('danger','Tài khoản không tồn tại trên hệ thống');
                }
            },
            complete: function() {
                // code loading close
            },
        })
    })
</script>