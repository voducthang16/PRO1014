<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Vo Duc Thang</title>
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
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/pagenotfound.css">

        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/carousel/owl.carousel.min.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/carousel/owl.theme.default.min.css">
        
        <!-- <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/home.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/home-block.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/menu.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/product.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/cart.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/checkout.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/profile.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/search.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/info.css"> -->
        <!-- <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/carousel/owl.carousel.min.css">
        <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/main/carousel/owl.theme.default.min.css"> -->
    </head>
    <body>
        <div class="app">
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
    </body>
    <script src="<?=BASE_URL?>public/assets/js/jquery.min.js"></script>
    <script src="<?=BASE_URL?>public/assets/js/owl.carousel.min.js"></script>
    <script src="<?=BASE_URL?>public/assets/js/main.js"></script>
</html>