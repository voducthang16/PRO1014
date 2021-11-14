<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <title>Đăng Nhập - THANGVD</title>
    <link rel="apple-touch-icon" sizes="76x76" href="<?=BASE_URL?>public/assets/img/favicon.png">
    <link rel="icon" type="image/png" href="<?=BASE_URL?>public/assets/img/favicon.png">
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="<?=BASE_URL?>public/assets/css/material-dashboard.minf066.css?v=2.1.0" rel="stylesheet"/>
</head>

<body class="off-canvas-sidebar">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top text-white">
        <div class="container">
            <div class="navbar-wrapper">
                <a class="navbar-brand" href="">Trang Đăng Nhập</a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                <span class="sr-only">Toggle navigation</span>
                <span class="navbar-toggler-icon icon-bar"></span>
                <span class="navbar-toggler-icon icon-bar"></span>
                <span class="navbar-toggler-icon icon-bar"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="admin" class="nav-link">
                            <i class="material-icons">dashboard</i> Quản trị
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="#" class="nav-link">
                            <i class="material-icons">person_add</i> Đăng ký
                        </a>
                    </li>
                    <li class="nav-item  active ">
                        <a href="" class="nav-link">
                            <i class="material-icons">fingerprint</i> Đăng nhập
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="wrapper wrapper-full-page">
        <div class="page-header login-page header-filter" filter-color="black" style="background-image: url('<?=BASE_URL?>public/assets/img/login.jpg'); background-size: cover; background-position: top center;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
                        <form class="form" method="POST" action="">
                            <div class="card card-login card-hidden">
                                <div class="card-header card-header-rose text-center">
                                    <h4 class="card-title">THE HEAT</h4>
                                </div>
                                <div class="card-body ">
                                    <span class="bmd-form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="material-icons">perm_identity</i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="username" placeholder="Tên đăng nhập..." required>
                                        </div>
                                        <p style="margin-top: 27px; margin-left: 56px; font-size: 0.9rem;color: #f33a58;line-height: 1.2; user-select: none;">
                                            <?= isset($userAlert) ? $userAlert : '' ?>
                                        </p>
                                    </span>
                                    <span class="bmd-form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="material-icons">lock_outline</i>
                                                </span>
                                            </div>
                                            <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu..." required>
                                        </div>
                                        <p style="margin-top: 27px; margin-left: 56px; font-size: 0.9rem;color: #f33a58;line-height: 1.2; user-select: none;">
                                            <?= isset($passwordAlert) ? $passwordAlert : '' ?>
                                            <?= isset($alert) ? $alert : '' ?>
                                        </p>
                                    </span>
                                </div>
                                <div class="card-footer justify-content-center">
                                    <input type="submit" class="btn btn-rose btn-link btn-lg" value="Đăng Nhập">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--   Core JS Files   -->
    <script src="<?=BASE_URL?>public/assets/js/core/jquery.min.js"></script>
    <script src="<?=BASE_URL?>public/assets/js/core/popper.min.js"></script>
    <script src="<?=BASE_URL?>public/assets/js/core/bootstrap-material-design.min.js"></script>
    <script src="<?=BASE_URL?>public/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="<?=BASE_URL?>public/assets/js/material-dashboard.minf066.js?v=2.1.0" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            md.checkFullPageBackgroundImage();
            setTimeout(function() {
                // after 1000 ms we add the class animated to the login/register card
                $('.card').removeClass('card-hidden');
            }, 1000);
        });
    </script>
</body>
</html>