<?php
if (isset($_SESSION["member-login"]) && $_SESSION["member-login"] == "true") {
    header("Location:" . BASE_URL);
}
?>
<div class="sign">
    <div class="container wide">
        <div class="row">
            <div class="col l-6">
                <div class="sign-in">
                    <h2 class="sign-title">Đăng nhập</h2>
                    <form action="" class="sign-in-form" method="POST">
                        <div class="form-group">
                            <i class="form-icon fal fa-user"></i>
                            <input style="padding-left: 40px!important" type="text" class="form-control" id="si-email" name="si-username" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <i class="form-icon fal fa-lock"></i>
                            <input style="padding-left: 40px!important" type="password" class="form-control" id="si-password" name="si-password" placeholder="Mật khẩu" required>
                        </div>
                        <div class="form-group" style="text-align: right">
                            <a href="<?=BASE_URL?>sign/forgotpassword" class="forgot-pass">Quên mật khẩu ?</a>
                        </div>
                        <div class="form-group" style="text-align: left">
                            <a href="<?=$data['FACEBOOK']?>" class="forgot-pass">Đăng nhập bằng facebook</a>
                        </div>
                        <div class="form-group" style="text-align: right">
                            <a href="<?=$data['GOOGLE']?>" class="forgot-pass">Đăng nhập google</a>
                        </div>
                        <div style="text-align: right" class="form-group">
                            <button type="submit" class="btn btn-primary">Đăng nhập</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col l-6">
                <div class="sign-up">
                    <h2 class="sign-title">Đăng ký</h2>
                    <form class="sign-up-form">
                        <div class="form-group">
                            <input type="text" class="form-control" id="su-username" name="su-username" placeholder="Username" required>
                            <span class="form-icon su-username-notification"></span>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" id="su-email" name="su-email" placeholder="Email" required>
                            <span class="form-icon su-email-notification"></span>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="su-name" name="su-name" placeholder="Full name" required>
                            <span class="form-icon su-name-notification"></span>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="su-password" name="su-password" placeholder="Mật khẩu" required>
                            <span class="form-icon su-password-notification"></span>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="su-re-password" name="su-re-password" placeholder="NL Mật khẩu" required>
                            <span class="form-icon su-re-password-notification"></span>
                        </div>
                        <div style="text-align: right" class="form-group">
                            <div class="btn btn-primary btn-sign-button" style="font-size:12px"> Đăng ký</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        var i=0, x=0, y=0;
        $("#su-username").keyup(function() {
            let username = $(this).val();
            username = username.replace(/ /g, '');
            if (username.length > 0) {
                $.ajax({
                    url: 'sign/checkExistAttribute',
                    type: 'POST',
                    data: {
                        'column': 'username',
                        'attribute': username
                    },
                    success: function(data) {
                        if (data == 0) {
                            $("#su-username").css('border-color', 'var(--success-color)');
                            $(".su-username-notification").html('<i class="fal fa-check-circle"></i>');
                            i = 1;
                        } else {
                            $("#su-username").css('border-color', 'var(--danger-color)');
                            $(".su-username-notification").html('<i class="fal fa-times-circle"></i>');
                            i = 0;
                        }
                    }
                });
            } else {
                $("#su-username").css('border-color', '#dae1e7');
                $(".su-username-notification").html('');
            }
        });

        $('#su-re-password').keyup(function() {
            let password = $('#su-password').val();
            let rePassword = $(this).val();
            if (rePassword.length >0) {
                if (password != rePassword){
                    $("#su-re-password").css('border-color', 'var(--danger-color)');
                    $(".su-re-password-notification").html('<i class="fal fa-times-circle"></i>');
                    x = 0;
                } else {
                    $("#su-re-password").css('border-color', 'var(--success-color)');
                    $(".su-re-password-notification").html('<i class="fal fa-check-circle"></i>');
                    x = 1;
                }
            } else {
                $("#su-re-password").css('border-color', '#dae1e7');
                $(".su-re-password-notification").html('');
            }
        });

        $("#su-email").keyup(function() {
                let email = $(this).val();
                email = email.replace(/ /g, '');
                
                var mailFormat = /^\w+([\.-]?\w+)*@(gmail.com)+$/;
                // \w+([\.-]?\w+)*(\.\w{2,3})+$/;
                if (email.match(mailFormat)) {
                    email = email;
                } else {
                    if (email.length > 0){
                        $("#su-email").css('border-color', 'var(--danger-color)');
                        $(".su-email-notification").html('<i class="fal fa-times-circle"></i>');
                        y = 0;
                        return;
                    }
                }

            if (email.length > 0) {
                $.ajax({
                    url: 'sign/checkExistAttribute',
                    type: 'POST',
                    data: {
                        'column': 'email',
                        'attribute': email
                    },
                    success: function(data) {
                        if (data == 0) {
                            $("#su-email").css('border-color', 'var(--success-color)');
                            $(".su-email-notification").html('<i class="fal fa-check-circle"></i>');
                            y = 1;
                        } else {
                            $("#su-email").css('border-color', 'var(--danger-color)');
                            $(".su-email-notification").html('<i class="fal fa-times-circle"></i>');
                            y = 0;
                        }
                    }
                });
            } else {
                $("#su-email").css('border-color', '#dae1e7');
                $(".su-email-notification").html('');
            }
        });
        $('.btn-sign-button').click(function(){
            let username = $('#su-username').val();
            let email = $('#su-email').val();
            let fullName = $('#su-name').val();
            let password = $('#su-password').val();
            
            if (fullName == "" || username == "" || email == "" || password == ""){
                alert('vui long nhập đầy đủ');
                return;
            }

            let count = x+i+y;
            if (count == 3) {
                $.ajax({
                    url: 'sign/signUp',
                    type: 'POST',
                    data: {
                        'username': username,
                        'email': email,
                        'name': fullName,
                        'password': password
                    },
                    success: function(data) {
                        alert(data);
                        window.location ="home";
                    }
                })
            } else {
                alert('vui lòng kiểm tra lại thông tin !!');
            }

        });
    })
</script>