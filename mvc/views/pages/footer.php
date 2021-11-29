<footer class="footer">
    <div class="footer__top">
        <div class="container wide">
            <div class="footer__content row">
                <div class="col l-4 sm--hide">
                    <h3 class="footer__heading">Bộ phận cửa hàng</h3>
                    <ul class="footer__list">
                    <?php foreach ($categories as $category) : ?>
                                    <li class="footer__items">
                                        <a href="category/detail/<?= $category['slug'] ?>" class="footer__link">
                                            <?= $category['name'] ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                        <!-- <li class="footer__items"><a href="#!" class="footer__link">Sneakers & Athletic</a></li>
                        <li class="footer__items"><a href="#!" class="footer__link">Athletic Apparel</a></li>
                        <li class="footer__items"><a href="#!" class="footer__link">Sandals</a></li>
                        <li class="footer__items"><a href="#!" class="footer__link">Jeans</a></li>
                        <li class="footer__items"><a href="#!" class="footer__link">Shirts & Tops</a></li>
                        <li class="footer__items"><a href="#!" class="footer__link">Shorts</a></li>
                        <li class="footer__items"><a href="#!" class="footer__link">T-Shirts</a></li>
                        <li class="footer__items"><a href="#!" class="footer__link">Swimwear</a></li>
                        <li class="footer__items"><a href="#!" class="footer__link">Clogs & Mules</a></li>
                        <li class="footer__items"><a href="#!" class="footer__link">Bags & Wallets</a></li>
                        <li class="footer__items"><a href="#!" class="footer__link">Accessories</a></li>
                        <li class="footer__items"><a href="#!" class="footer__link"> Sunglasses & Eyewear</a></li>
                        <li class="footer__items"><a href="#!" class="footer__link">Watches</a></li> -->
                    </ul>
                </div>
                <div class="col l-4 sm--hide">
                    <h3 class="footer__heading">Tài khoản & Giao hàng</h3>
                    <ul class="footer__list">
                        <li class="footer__items"><a href="#!" class="footer__link">Tài khoản của bạn</a></li>
                        <li class="footer__items"><a href="#!" class="footer__link">Chính sách & Giá vận chuyển</a></li>
                        <li class="footer__items"><a href="#!" class="footer__link">Hoàn lại tiền & Đổi trả</a></li>
                        <li class="footer__items"><a href="#!" class="footer__link">Theo dõi đơn hàng</a></li>
                        <li class="footer__items"><a href="#!" class="footer__link">Thông tin giao hàng</a></li>
                        <li class="footer__items"><a href="#!" class="footer__link">Thuế & Phí</a></li>
                    </ul>
                    <h3 class="footer__heading">Về chúng tôi</h3>
                    <ul class="footer__list">
                        <li class="footer__items"><a href="#!" class="footer__link">Về công ty</a></li>
                        <li class="footer__items"><a href="#!" class="footer__link">Đội của chúng tôi</a></li>
                        <li class="footer__items"><a href="#!" class="footer__link">Nghề nghiệp</a></li>
                        <li class="footer__items"><a href="#!" class="footer__link">Tin tức</a></li>
                    </ul>
                </div>
                <div class="col l-4">
                    <div class="footer__box">
                        <div class="footer__box-top">
                            <h3 class="footer__heading">Nhận thông báo mới nhất</h3>
                            <form class="subscription-form" action="" method="post" name="ml-embedded-subscribe-form" target="">
                                <div class="input-group">
                                    <i class="fal fa-envelope input-group__icon"></i>
                                    <input class="form-subscribe rounded-start" type="email" name="EMAIL" placeholder="Your email" required>
                                    <button class="btn btn-primary btn-subscription-form" type="submit" name="subscribe">Đăng ký</button>
                                </div>
                            </form>
                            <p>*Đăng ký bản tin của chúng tôi để nhận được ưu đãi giảm giá sớm, thông tin cập nhật và sản phẩm mới.</p>
                        </div>
                        <div class="footer__box-bot">
                            <h3 class="footer__heading">Tải xuống ứng dụng</h3>
                            <div class="footer__app-download">
                                <a href="#!">
                                    <img src="public/assets/img/gg_play.png" class="gg-play-store" alt="google-play-store">
                                </a>
                                <a href="#!">
                                    <img src="public/assets/img/app_store.png" class="app-store" alt="app-store">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer__bottom">
        <div class="container wide">
            <div class="footer__services row">
                <div class="col footer__services-item l-3">
                    <i class="fal fa-rocket-launch footer__services-icon"></i>
                    <div>
                        <h6 class="footer__services-heading">Giao hàng nhanh chóng và miễn phí</h6>
                        <p class="footer__services-text">Free shiping cho đơn hàng trên $200</p>
                    </div>
                </div>
                <div class="col footer__services-item l-3">
                    <i class="fal fa-hand-holding-usd footer__services-icon"></i>
                    <div>
                        <h6 class="footer__services-heading">Chính sách hoàn tiền</h6>
                        <p class="footer__services-text">Hoàn tiền trong vòng 30 ngày</p>
                    </div>
                </div>
                <div class="col footer__services-item l-3">
                    <i class="fal fa-headset footer__services-icon"></i>
                    <div>
                        <h6 class="footer__services-heading">Hỗ trợ khách hàng 24/7</h6>
                        <p class="footer__services-text">Hỗ trợ khách hàng thân thiện 24/7</p>
                    </div>
                </div>
                <div class="col footer__services-item l-3">
                    <i class="fal fa-credit-card footer__services-icon"></i>
                    <div>
                        <h6 class="footer__services-heading">Thanh toán trực tuyến an toàn</h6>
                        <p class="footer__services-text">Chúng tôi có SSL / Chứng chỉ bảo mật</p>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row footer__services-info">
                <div class="col l-6">
                    <div class="box-1">
                        <div class="navbar-logo footer-logo">
                            <a href="#" class="navbar-logo-link">
                                <img width="100%" src="<?= BASE_URL ?>public/assets/img/test.png" alt="LOGO">
                            </a>
                        </div>
                        <div class="currency-exchange">
                            <img src="<?= BASE_URL ?>public/assets/img/flags/US.png" alt="">
                            <span>Eng / $</span>
                            <i class="fad fa-caret-down"></i>
                        </div>
                    </div>
                    <div class="box-2">
                        <ul class="footer__list-row">
                            <li class="footer__items"><a href="#!" class="footer__link">Cửa hàng</a></li>
                            <li class="footer__items"><a href="#!" class="footer__link">Chi Nhánh</a></li>
                            <li class="footer__items"><a href="#!" class="footer__link">Ủng hộ</a></li>
                            <li class="footer__items"><a href="#!" class="footer__link">Quyền riêng tư</a></li>
                            <li class="footer__items"><a href="#!" class="footer__link">Điều khoản sử dụng</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col l-6">
                    <div class="icon-bar">
                        <div class="icon facebook">
                            <div class="tooltip">Facebook</div>
                            <span><i class="fab fa-facebook-f"></i></span>
                        </div>
                        <div class="icon twitter">
                            <div class="tooltip">Twitter</div>
                            <span><i class="fab fa-twitter"></i></span>
                        </div>
                        <div class="icon instagram">
                            <div class="tooltip">Instagram</div>
                            <span><i class="fab fa-instagram"></i></span>
                        </div>
                        <div class="icon pinterest">
                            <div class="tooltip">Pinterest</div>
                            <span><i class="fab fa-pinterest"></i></span>
                        </div>
                        <div class="icon youtube">
                            <div class="tooltip">Youtube</div>
                            <span><i class="fab fa-youtube"></i></span>
                        </div>
                    </div>
                    <div class="pay-icon-bar">
                        <i class="fab fa-cc-visa"></i>
                        <i class="fab fa-cc-amex"></i>
                        <i class="fab fa-cc-mastercard"></i>
                        <i class="fab fa-cc-discover"></i>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <span>© All rights reserved. Made by Nhom 1-PRO1014</span>
            </div>
        </div>
    </div>
</footer>