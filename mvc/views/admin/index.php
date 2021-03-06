<?php
    if (empty($_SESSION['admin-login'])) {
        header('Location: '.BASE_URL.'admin/login');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <title>ADMIN HOMEPAGE</title>

    <link rel="icon" type="image/png" href="<?=BASE_URL?>public/assets/img/favicon.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?=BASE_URL?>public/assets/img/apple-icon.png">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.3/css/all.css">

    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="<?=BASE_URL?>public/assets/css/material-dashboard.minf066.css?v=2.1.0" rel="stylesheet" />
    <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/home.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/admin.css">
</head>
<body class="">
    <div class="wrapper">
        <!-- Sidebar -->
        <?php require_once __DIR__ . "/pages/sidebar.php";?>
        <div class="main-panel">
            <!-- Navbar -->
            <?php require_once __DIR__ . "/pages/navbar.php";?>
            <!-- End Navbar -->
            <div class="content">
                <div class="content">
                    <div class="container-fluid">
                        <!-- Homepage -->
                        <?php require_once __DIR__ . "/pages/".$data['page'].".php";?>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <?php require_once __DIR__ . "/pages/footer.php";?>
        </div>
        <div id="toast"></div>
    </div>
    
    <base href="<?=BASE_URL?>">
    <!--   Core JS Files   -->
    <script src="<?=BASE_URL?>public/assets/js/core/jquery.min.js"></script>
    <script src="<?=BASE_URL?>public/assets/js/core/popper.min.js"></script>
    <script src="<?=BASE_URL?>public/assets/js/core/bootstrap-material-design.min.js"></script>
    <script src="<?=BASE_URL?>public/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <script src="<?=BASE_URL?>public/assets/js/material-dashboard.minf066.js?v=2.1.0" type="text/javascript"></script>

    <script>
            <?php 
                if(isset($_SESSION['toast_start'])) {
            ?>
            const main = document.getElementById('toast');
                if (main) {
                    const toast = document.createElement('div');
                    const disappear = (<?= $_SESSION['toast_start']['duration'] ?> + 1000).toFixed(2)
                    const autoRemoveId = setTimeout(function() {
                        main.removeChild(toast);
                    }, disappear)

                    toast.onclick = e => {
                        if (e.target.closest('.toast__close')) {
                            main.removeChild(toast);
                            clearTimeout(autoRemoveId);
                        }
                    }

                    const icons = {
                        success: 'fal fa-check',
                        info: 'fal fa-info',
                        warning: 'fal fa-exclamation',
                        error: 'fal fa-exclamation-triangle'
                    };

                    const icon = icons['<?= $_SESSION['toast_start']['type'] ?>'];
                    const delay = (<?= $_SESSION['toast_start']['duration'] ?> / 1000).toFixed(2);
                    toast.classList.add('toast', `toast--<?= $_SESSION['toast_start']['type'] ?>`);
                    toast.style.animation = `animation: slideInLeft ease 0.3s, fadeOut linear 1s ${delay}s forwards;`;
                    toast.innerHTML = `
                        <div class="toast__icon">
                            <i class="${icon}"></i>
                        </div>
                        <div class="toast__body">
                            <h3 class="toast__title"><?= $_SESSION['toast_start']['title'] ?></h3>
                            <p class="toast__msg"><?= $_SESSION['toast_start']['message'] ?></p>
                        </div>
                        <div class="toast__close">
                            <i class="fas fa-times"></i>
                        </div>
                    `;
                    main.appendChild(toast);    
                }
            <?php
                unset($_SESSION['toast_start']);
            }
            ?>
            if ( window.history.replaceState ) {
                    window.history.replaceState( null, null, window.location.href );
                }
        </script>
    
    <script>
        $(document).ready(function() {
            $().ready(function() {
                $sidebar = $(".sidebar");

                $sidebar_img_container = $sidebar.find(".sidebar-background");

                $full_page = $(".full-page");

                $sidebar_responsive = $("body > .navbar-collapse");

                window_width = $(window).width();

                fixed_plugin_open = $(".sidebar .sidebar-wrapper .nav li.active a p").html();

                if (window_width > 767 && fixed_plugin_open == "Dashboard") {
                    if ($(".fixed-plugin .dropdown").hasClass("show-dropdown")) {
                        $(".fixed-plugin .dropdown").addClass("open");
                    }

                }

                $(".fixed-plugin a").click(function(event) {
                    // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
                    if ($(this).hasClass("switch-trigger")) {
                        if (event.stopPropagation) {
                            event.stopPropagation();
                        } else if (window.event) {
                            window.event.cancelBubble = true;
                        }
                    }
                });

                $(".fixed-plugin .active-color span").click(function() {
                    $full_page_background = $(".full-page-background");

                    $(this).siblings().removeClass("active");
                    $(this).addClass("active");

                    var new_color = $(this).data("color");

                    if ($sidebar.length != 0) {
                        $sidebar.attr("data-color", new_color);
                    }

                    if ($full_page.length != 0) {
                        $full_page.attr("filter-color", new_color);
                    }

                    if ($sidebar_responsive.length != 0) {
                        $sidebar_responsive.attr("data-color", new_color);
                    }
                });

                $(".fixed-plugin .background-color .badge").click(function() {
                    $(this).siblings().removeClass("active");
                    $(this).addClass("active");

                    var new_color = $(this).data("background-color");

                    if ($sidebar.length != 0) {
                        $sidebar.attr("data-background-color", new_color);
                    }
                });

                $(".fixed-plugin .img-holder").click(function() {
                    $full_page_background = $(".full-page-background");

                    $(this).parent('li').siblings().removeClass('active');
                    $(this).parent('li').addClass('active');


                    var new_image = $(this).find("img").attr('src');

                    if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                        $sidebar_img_container.fadeOut('fast', function() {
                            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                            $sidebar_img_container.fadeIn('fast');
                        });
                    }

                    if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                        var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                        $full_page_background.fadeOut('fast', function() {
                            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                            $full_page_background.fadeIn('fast');
                        });
                    }

                    if ($('.switch-sidebar-image input:checked').length == 0) {
                        var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
                        var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                        $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                        $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                    }

                    if ($sidebar_responsive.length != 0) {
                        $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
                    }
                });

                $('.switch-sidebar-image input').change(function() {
                    $full_page_background = $('.full-page-background');

                    $input = $(this);

                    if ($input.is(':checked')) {
                        if ($sidebar_img_container.length != 0) {
                            $sidebar_img_container.fadeIn('fast');
                            $sidebar.attr('data-image', '#');
                        }

                        if ($full_page_background.length != 0) {
                            $full_page_background.fadeIn('fast');
                            $full_page.attr('data-image', '#');
                        }

                        background_image = true;
                    } else {
                        if ($sidebar_img_container.length != 0) {
                            $sidebar.removeAttr('data-image');
                            $sidebar_img_container.fadeOut('fast');
                        }

                        if ($full_page_background.length != 0) {
                            $full_page.removeAttr('data-image', '#');
                            $full_page_background.fadeOut('fast');
                        }

                        background_image = false;
                    }
                });

                $('.switch-sidebar-mini input').change(function() {
                    $body = $('body');

                    $input = $(this);

                    if (md.misc.sidebar_mini_active == true) {
                        $('body').removeClass('sidebar-mini');
                        md.misc.sidebar_mini_active = false;

                        $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

                    } else {

                        $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

                        setTimeout(function() {
                            $('body').addClass('sidebar-mini');

                            md.misc.sidebar_mini_active = true;
                        }, 300);
                    }

                    // we simulate the window Resize so the charts will get updated in realtime.
                    var simulateWindowResize = setInterval(function() {
                        window.dispatchEvent(new Event('resize'));
                    }, 180);

                    // we stop the simulation of Window Resize after the animations are completed
                    setTimeout(function() {
                        clearInterval(simulateWindowResize);
                    }, 1000);

                });
            });
        });
    </script>
    <script></script>
    <script src="<?=BASE_URL?>public/assets/js/notification.js"></script>
</body>
</html>