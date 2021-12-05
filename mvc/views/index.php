<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>project group one</title>
        <!-- Icon -->
        <link rel="icon" href="<?=BASE_URL?>public/assets/img/favicon.png">

        <!-- Reset CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css" integrity="sha512-NmLkDIU1C/C88wi324HBc+S2kLhi08PN5GDeUVVVC/BVt/9Izdsc9SVeVfA1UZbY3sHUlDSyRXhCzHfr6hmPPw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
        <!-- Font Awesome Icon -->
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.3/css/all.css">

        <!-- Google Font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

        <!-- CSS -->
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/base.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/grid.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/header.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/footer.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/home.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/sign.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/pagenotfound.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/category.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/product.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/cart.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/account.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/checkout.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/responsive.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/contacts.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/aboutus.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/forgotpassword.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/blog.css">



        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/carousel/owl.carousel.min.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/carousel/owl.theme.default.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        
        <!-- <link rel="stylesheet" href="public/assets/css/main/home.css">
        <link rel="stylesheet" href="public/assets/css/main/home-block.css">
        <link rel="stylesheet" href="public/assets/css/main/menu.css">
        <link rel="stylesheet" href="public/assets/css/main/product.css">
        <link rel="stylesheet" href="public/assets/css/main/cart.css">
        <link rel="stylesheet" href="public/assets/css/main/checkout.css">
        <link rel="stylesheet" href="public/assets/css/main/profile.css">
        <link rel="stylesheet" href="public/assets/css/main/search.css">
        <link rel="stylesheet" href="public/assets/css/main/info.css"> -->
        <!-- <link rel="stylesheet" href="public/assets/css/main/carousel/owl.carousel.min.css">
        <link rel="stylesheet" href="public/assets/css/main/carousel/owl.theme.default.min.css"> -->
    </head>
    <body>
        <div class="app">
            <base href="<?=BASE_URL?>">
            <button class="scroll-to-top btn">
                <i class="fal fa-arrow-up"></i>
            </button>
            <!-- Start Header -->
            <?php require_once __DIR__ . '/pages/header.php'; ?>
            <!-- End Header -->
            
            <?php require_once __DIR__ . "/pages/".$data['page'].".php";?>

            <!-- Start Footer -->
            <?php require_once __DIR__ . '/pages/footer.php'; ?>
            <!-- End Footer -->
        </div>
        <div id="toast"></div>
    </body>
    <script src="<?=BASE_URL?>public/assets/js/jquery.min.js"></script>
    <script src="<?=BASE_URL?>public/assets/js/owl.carousel.min.js"></script>
    <script src="<?=BASE_URL?>public/assets/js/main.js"></script>
    <script src="<?=BASE_URL?>public/assets/js/product.js"></script>
    <script src="<?=BASE_URL?>public/assets/js/search.js"></script>
    <script src="<?=BASE_URL?>public/assets/js/cart.js"></script>
    <script src="<?=BASE_URL?>public/assets/js/notification.js"></script>
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
        </script>
    
</html>