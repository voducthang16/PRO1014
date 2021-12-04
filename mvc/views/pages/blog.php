<div class="blog">
    <div class="page-header page-header__blog">
        <div class="container wide">
            <div class="page-wrapper page-wrapper__blog">
                <h2 class="page-title page-title__blog">Blog</h2>
                <nav class="page-navbar">
                    <ul class="page-list">
                        <li class="page-item">
                            <a href="<?= BASE_URL ?>" class="page-link page-link__blog"><i class="fal fa-home"></i>Trang chủ<i class="fal fa-chevron-right"></i></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link page-link__blog">Blog</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div class="blog-slider container wide">
        <div class="owl-carousel owl-theme blog-slider--list">
            <div class="blog-slider--item">
                <a class="blog-entry-thumb">
                    <span class="blog-entry-meta-label">
                        <i class="fal fa-clock"></i> Sep 10
                    </span>
                    <img class="" src="<?= BASE_URL ?>/public/assets/img/blog/01.jpg" alt="open">
                </a>
                <div class="blog-entry-heading">
                    <h2 class="blog-entry-title">
                        <a>Healthy Food - New Way of Living</a>
                    </h2>
                    <a class="blog-entry-meta-link blog-entry-meta-quantity">
                        <i class="fal fa-comment-alt-dots"></i> 356
                    </a>
                </div>
                <div class="blog-entry-author">
                    <a class="blog-entry-meta-link" href="#">
                        <div class="blog-entry-author-ava">
                            <img class="core-team__img" src="<?= BASE_URL ?>/public/assets/img/team/01.jpg" alt="bachking">
                        </div>Bach King
                    </a>
                    <span class="blog-entry-meta-divider"></span>
                    <div class="text-muted">in
                        <a href="#" class="blog-entry-meta-link">Lifestyle</a>,
                        <a href="#" class="blog-entry-meta-link">Nutrition</a>
                    </div>
                </div>
            </div>
            <div class="blog-slider--item">
                <a class="blog-entry-thumb">
                    <span class="blog-entry-meta-label">
                        <i class="fal fa-clock"></i> Aug 27
                    </span>
                    <img class="" src="<?= BASE_URL ?>/public/assets/img/blog/02.jpg" alt="open">
                </a>
                <div class="blog-entry-heading">
                    <h2 class="blog-entry-title">
                        <a>Online Payment Security Tips for Shoppers</a>
                    </h2>
                    <a class="blog-entry-meta-link blog-entry-meta-quantity">
                        <i class="fal fa-comment-alt-dots"></i> 958
                    </a>
                </div>
                <div class="blog-entry-author">
                    <a class="blog-entry-meta-link" href="#">
                        <div class="blog-entry-author-ava">
                            <img class="core-team__img" src="<?= BASE_URL ?>/public/assets/img/team/04.jpg" alt="tuankiet">
                        </div>Tuan Kiet
                    </a>
                    <span class="blog-entry-meta-divider"></span>
                    <div class="text-muted">in
                        <a href="#" class="blog-entry-meta-link">Online shopping</a>
                    </div>
                </div>
            </div>
            <div class="blog-slider--item">
                <a class="blog-entry-thumb">
                    <span class="blog-entry-meta-label">
                        <i class="fal fa-clock"></i> Aug 16
                    </span>
                    <img class="" src="<?= BASE_URL ?>/public/assets/img/blog/03.jpg" alt="open">
                </a>
                <div class="blog-entry-heading">
                    <h2 class="blog-entry-title">
                        <a>We Launched New Store in San Francisco!</a>
                    </h2>
                    <a class="blog-entry-meta-link blog-entry-meta-quantity">
                        <i class="fal fa-comment-alt-dots"></i> 253
                    </a>
                </div>
                <div class="blog-entry-author">
                    <a class="blog-entry-meta-link" href="#">
                        <div class="blog-entry-author-ava">
                            <img class="core-team__img" src="<?= BASE_URL ?>/public/assets/img/team/02.jpg" alt="ducthang">
                        </div>Duc Thang
                    </a>
                    <span class="blog-entry-meta-divider"></span>
                    <div class="text-muted">in
                        <a href="#" class="blog-entry-meta-link">Cartzilla news</a>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $(".blog-slider--list").owlCarousel({
                    margin: 10,
                    loop: true,
                    autoWidth: true,
                    mouseDrag: true,
                    touchDrag: true,
                    nav: false,
                    autoplay: true,
                    autoplaySpeed: 1000,
                    smartSpeed: 500,
                    autoplayHoverPause: true,
                    items: 3
                });
            });
        </script>
    </div>
    <hr class="container wide" style="margin-top: 48px;">


</div>