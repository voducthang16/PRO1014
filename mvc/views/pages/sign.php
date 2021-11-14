<?php
    if (isset($_SESSION["member-login"]) && $_SESSION["member-login"] == "true") {
        header("Location:".BASE_URL);
    }
?>

<div class="account">
    <div class="container wide">
        <div class="row">
            <div class="col l-6">
                <div class="sign-in">
                    <h2 class="account-title">Đăng nhập</h2>
                    <form action="" class="sign-in-form" method="POST">
                        <div class="form-group">
                            <i class="form-icon fal fa-user"></i>
                            <input style="padding-left: 40px!important" type="text" class="form-control" id="si-email" name="si-username" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <i class="form-icon fal fa-lock"></i>
                            <input style="padding-left: 40px!important" type="password" class="form-control" id="si-password" name="si-password" placeholder="Mật khẩu" required>
                        </div>
                        <div style="text-align: right" class="form-group">
                            <button type="submit" class="btn btn-primary">Đăng nhập</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col l-6">
                <div class="sign-up">
                    <h2 class="account-title">Đăng ký</h2>
                    <form action="" class="sign-up-form" method="POST">
                        <div class="form-group">
                            <input type="text" class="form-control" id="su-username" name="su-username" placeholder="Username">
                            <span class="form-icon su-username-notification"></span>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" id="su-email" name="su-email" placeholder="Email">
                            <span class="form-icon su-email-notification"></span>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="su-name" name="su-name" placeholder="Full name">
                            <span class="form-icon su-name-notification"></span>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="su-password" name="su-password" placeholder="Mật khẩu">
                            <span class="form-icon su-password-notification"></span>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="su-re-password" name="su-re-password" placeholder="NL Mật khẩu">
                            <span class="form-icon su-re-password-notification"></span>
                        </div>
                        <div style="text-align: right" class="form-group">
                            <button type="submit" class="btn btn-primary">Đăng ký</button>
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
        $("#su-username").change(function() {
            let username = $(this).val();
            username = username.replace(/ /g,'');
            if (username.length > 0) {
                $.ajax({
                    url: 'sign/checkExistAttribute',
                    type: 'POST',
                    data: {
                        column: "username",
                        attribute: username
                    },
                    success: function(data) {
                        if (data == '1') {
                            $("#su-username").css('border-color', 'var(--danger-color)');
                            $(".su-username-notification").html('<i class="fal fa-times-circle"></i>');
                        } else {
                            $("#su-username").css('border-color', 'var(--success-color)');
                            $(".su-username-notification").html('<i class="fal fa-check-circle"></i>');
                        }
                    }
                });
            } else {
                $("#su-username").css('border-color', '#dae1e7');
                $(".su-username-notification").html('');
            }
        });

        $("#su-email").change(function() {
            let email = $(this).val();
            email = email.replace(/ /g,'');
            if (email.length > 0) {
                $.ajax({
                    url: 'sign/checkExistAttribute',
                    type: 'POST',
                    data: {
                        column: "email",
                        attribute: email
                    },
                    success: function(data) {
                        if (data == '1') {
                            $("#su-email").css('border-color', 'var(--danger-color)');
                            $(".su-email-notification").html('<i class="fal fa-times-circle"></i>');
                        } else {
                            $("#su-email").css('border-color', 'var(--success-color)');
                            $(".su-email-notification").html('<i class="fal fa-check-circle"></i>');
                        }
                    }
                });
            } else {
                $("#su-email").css('border-color', '#dae1e7');
                $(".su-email-notification").html('');
            }
        });
    })
</script>