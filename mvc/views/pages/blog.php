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
                        <a>Thực phẩm lành mạnh - Cách sống mới</a>
                    </h2>
                    <a class="blog-entry-meta-link blog-entry-meta-quantity">
                        <i class="fal fa-comment-alt-dots"></i> 356
                    </a>
                </div>
                <div class="blog-entry-author">
                    <a class="blog-entry-meta-link">
                        <div class="blog-entry-author-ava">
                            <img class="core-team__img" src="<?= BASE_URL ?>/public/assets/img/team/01.jpg" alt="bachking">
                        </div>Bach King
                    </a>
                    <span class="blog-entry-meta-divider"></span>
                    <div class="text-muted">trong
                        <a class="blog-entry-meta-link">Cách sống</a>,
                        <a class="blog-entry-meta-link">Dinh dưỡng</a>
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
                        <a>Mẹo bảo mật thanh toán cho khách hàng</a>
                    </h2>
                    <a class="blog-entry-meta-link blog-entry-meta-quantity">
                        <i class="fal fa-comment-alt-dots"></i> 958
                    </a>
                </div>
                <div class="blog-entry-author">
                    <a class="blog-entry-meta-link">
                        <div class="blog-entry-author-ava">
                            <img class="core-team__img" src="<?= BASE_URL ?>/public/assets/img/team/04.jpg" alt="tuankiet">
                        </div>Tuan Kiet
                    </a>
                    <span class="blog-entry-meta-divider"></span>
                    <div class="text-muted">trong
                        <a class="blog-entry-meta-link">Mua sắm trực tuyến</a>
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
                        <a>Khai chương chi nhánh mới tại TP.HCM!</a>
                    </h2>
                    <a class="blog-entry-meta-link blog-entry-meta-quantity">
                        <i class="fal fa-comment-alt-dots"></i> 253
                    </a>
                </div>
                <div class="blog-entry-author">
                    <a class="blog-entry-meta-link">
                        <div class="blog-entry-author-ava">
                            <img class="core-team__img" src="<?= BASE_URL ?>/public/assets/img/team/02.jpg" alt="ducthang">
                        </div>Duc Thang
                    </a>
                    <span class="blog-entry-meta-divider"></span>
                    <div class="text-muted">trong
                        <a class="blog-entry-meta-link">Theheat news</a>
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
                    items: 3,
                    responsiveClass: true,
                });
            });
        </script>
    </div>
    <hr class="container wide" style="margin-top: 48px;">
    <div class="row container wide blog-menu-list">
        <section class="flex-auto-9">
            <article class="blog-list">
                <div class="blog-start-column l-4">
                    <div class="blog-start-column-author">
                        <a class="blog-entry-meta-link">
                            <div class="blog-entry-author-ava">
                                <img class="core-team__img" src="<?= BASE_URL ?>/public/assets/img/team/02.jpg" alt="ducthang">
                            </div>Duc Thang
                        </a>
                        <span class="blog-entry-meta-divider"></span>
                        <a class="blog-entry-meta-link">Fer 17</a>
                    </div>
                    <h2 class="blog-entry-title mb-12">
                        <a href="">Du lịch thế giới trong thời kì Covid</a>
                    </h2>
                </div>
                <div class="blog-end-column l-8">
                    <div class="blog-end-column-title">
                        <div class="blog-end-column-title-1 fs-sm">trong
                            <a class="blog-entry-meta-link">Du lịch</a>, <a class="blog-entry-meta-link">Tài chính</a>
                        </div>
                        <div class="blog-end-column-title-2 fs-sm mb-2">
                            <a class="blog-entry-meta-link" href="">
                                <i class="fal fa-comment-alt-dots"></i> 694</a>
                        </div>
                    </div>
                    <p class="fs-sm">Các doanh nghiệp du lịch trên toàn thế giới mới chỉ tìm được chỗ đứng chỉ hai, ba tháng gần đây sau gần hai năm khủng hoảng bởi đại dịch Covid-19. Thế nhưng giờ đây, họ lại tiếp tục đứng trước lo ngại bị ảnh hưởng bởi các quốc gia dựng lên những rào cản mới để hạn chế di chuyển trong nỗ lực ngăn chặn biến chủng Omicron...<a href="" class="blog-entry-meta-link fw-medium">[Xem thêm]</a></p>
                </div>
            </article>
            <!-- Entry-->
            <article class="blog-list">
                <div class="blog-start-column l-4">
                    <div class="blog-start-column-author">
                        <a class="blog-entry-meta-link">
                            <div class="blog-entry-author-ava">
                                <img class="core-team__img" src="<?= BASE_URL ?>/public/assets/img/team/01.jpg" alt="backing">
                            </div>Bach King
                        </a>
                        <span class="blog-entry-meta-divider"></span>
                        <a class="blog-entry-meta-link">Jan 27</a>
                    </div>
                    <h2 class="blog-entry-title mb-12">
                        <a href="">Các xu hướng mới hàng đầu trong thời trang cao cấp</a>
                    </h2>
                </div>
                <div class="blog-end-column l-8">
                    <a class="blog-entry-thumb gallery-item">
                        <img class="" src="<?= BASE_URL ?>/public/assets/img/blog/04.jpg" alt="open">
                    </a>
                    <div class="blog-end-column-title">
                        <div class="blog-end-column-title-1 fs-sm">trong
                            <a class="blog-entry-meta-link">Du lịch</a>, <a class="blog-entry-meta-link">Tài chính</a>
                        </div>
                        <div class="blog-end-column-title-2 fs-sm mb-2">
                            <a class="blog-entry-meta-link" href="">
                                <i class="fal fa-comment-alt-dots"></i> 199</a>
                        </div>
                    </div>
                    <p class="fs-sm">Thời trang của những năm 1960 nổi bật với một số xu hướng đa dạng. Đó là một thập kỷ đã phá vỡ nhiều truyền thống thời trang, phản chiếu các phong trào xã hội trong thời gian đó... <a href="" class="blog-entry-meta-link fw-medium">[Xem thêm]</a></p>
                </div>
            </article>
            <article class="blog-list">
                <div class="blog-start-column l-4">
                    <div class="blog-start-column-author">
                        <a class="blog-entry-meta-link">
                            <div class="blog-entry-author-ava">
                                <img class="core-team__img" src="<?= BASE_URL ?>/public/assets/img/team/04.jpg" alt="tuankiet">
                            </div>Tuan Kiet
                        </a>
                        <span class="blog-entry-meta-divider"></span>
                        <a class="blog-entry-meta-link">Nov 26</a>
                    </div>
                    <h2 class="blog-entry-title mb-12">
                        <a href="">Mẹo mua sắm sản phẫm giá rẻ.</a>
                    </h2>
                </div>
                <div class="blog-end-column l-8">
                    <a class="blog-entry-thumb gallery-item">
                        <img class="" src="<?= BASE_URL ?>/public/assets/img/blog/05.jpg" alt="open">
                    </a>
                    <div class="blog-end-column-title">
                        <div class="blog-end-column-title-1 fs-sm">trong
                            <a class="blog-entry-meta-link">Du lịch</a>, <a class="blog-entry-meta-link">Tài chính</a>
                        </div>
                        <div class="blog-end-column-title-2 fs-sm mb-2">
                            <a class="blog-entry-meta-link" href="">
                                <i class="fal fa-comment-alt-dots"></i> 458</a>
                        </div>
                    </div>
                    <p class="fs-sm">Đầu tiên, tôi muốn chắc chắn rằng điều này là rõ ràng: mặc dù tôi quan tâm đến thời trang, nhưng tôi không coi những bộ sưu tập mới nhất từ các cửa hàng đắt tiền nhất là có thể mặc được. Tôi tiếp cận việc mua sắm quần áo từ quan điểm rất thực tế...<a href="" class="blog-entry-meta-link fw-medium">[Xem thêm]</a></p>
                </div>
            </article>
            <article class="blog-list">
                <div class="blog-start-column l-4">
                    <div class="blog-start-column-author">
                        <a class="blog-entry-meta-link">
                            <div class="blog-entry-author-ava">
                                <img class="core-team__img" src="<?= BASE_URL ?>/public/assets/img/team/02.jpg" alt="ducthang">
                            </div>Duc Thang
                        </a>
                        <span class="blog-entry-meta-divider"></span>
                        <a class="blog-entry-meta-link">Nov 12</a>
                    </div>
                    <h2 class="blog-entry-title mb-12">
                        <a href="">Google Pay hiện đã có sẵn tại tất cả các cửa hàng</a>
                    </h2>
                </div>
                <div class="blog-end-column l-8">
                    <div class="blog-end-column-title">
                        <div class="blog-end-column-title-1 fs-sm">trong
                            <a class="blog-entry-meta-link">Du lịch</a>, <a class="blog-entry-meta-link">Tài chính</a>
                        </div>
                        <div class="blog-end-column-title-2 fs-sm mb-2">
                            <a class="blog-entry-meta-link" href="">
                                <i class="fal fa-comment-alt-dots"></i> 823</a>
                        </div>
                    </div>
                    <p class="fs-sm">Bạn có thể tìm dữ liệu của mình trong Google Pay trên mạng tại trang pay.google.com, trong ứng dụng Google Pay và tại trang myactivity.google.com.Thông tin giao dịch: Để xem các giao dịch được thực hiện bằng Số tài khoản ảo của bạn tại cửa hàng thực hoặc trên mạng, hãy xem trong ứng dụng Google Pay. Để xem tất cả các giao dịch khác, hãy xem trong ứng dụng Google Pay hoặc trên trang pay.google.com...<a href="" class="blog-entry-meta-link fw-medium">[Xem thêm]</a></p>
                </div>
            </article>
            <article class="blog-list">
                <div class="blog-start-column l-4">
                    <div class="blog-start-column-author">
                        <a class="blog-entry-meta-link">
                            <div class="blog-entry-author-ava">
                                <img class="core-team__img" src="<?= BASE_URL ?>/public/assets/img/team/05.jpg" alt="ducthang">
                            </div>Xuan Nhieu
                        </a>
                        <span class="blog-entry-meta-divider"></span>
                        <a class="blog-entry-meta-link">Sep 19</a>
                    </div>
                    <h2 class="blog-entry-title mb-12">
                        <a href="">Chúng tôi đã ra mắt Dịch vụ giao hàng bằng máy bay không người lái.</a>
                    </h2>
                </div>
                <div class="blog-end-column l-8">
                    <a class="blog-entry-thumb gallery-item">
                        <img class="" src="<?= BASE_URL ?>/public/assets/img/blog/06.jpg" alt="open">
                    </a>
                    <div class="blog-end-column-title">
                        <div class="blog-end-column-title-1 fs-sm">trong
                            <a class="blog-entry-meta-link">Du lich</a>, <a class="blog-entry-meta-link">Tài chính</a>
                        </div>
                        <div class="blog-end-column-title-2 fs-sm mb-2">
                            <a class="blog-entry-meta-link" href="">
                                <i class="fal fa-comment-alt-dots"></i> 293</a>
                        </div>
                    </div>
                    <p class="fs-sm">Ngày 21/10/2019 vừa qua, một ông lớn trong ngành vận chuyển nước Mỹ là UPS tuyên bố hợp tác với CVS (chuỗi cửa hàng dược phẩm lớn nhất nước Mỹ) để khởi động chương trình vận chuyển bằng drone cho các nhà thuốc. Trước đó vào đầu tháng 3/2019, theo chương trình thí điểm tích hợp máy bay không người lái của Bộ giao thông vận tải Mỹ, UPS Flight Forward một công ty con của UPS đã hợp tác với công ty Matternet để vận chuyển các mẫu máu và mẫu của phòng thí nghiệm y tế bằng drone trong khuôn viên chăm sóc sức khỏe của WakeMed ở Raleigh, Bắc Carolina...<a href="" class="blog-entry-meta-link fw-medium">[Xem thêm]</a></p>

                </div>
            </article>
            <!-- Pagination-->
            <div class="pagination-menu c-0">
                <ul class="pagination">
                    <li class="blog-page-item"><a class="blog-page-link"><i class="fal fa-chevron-left"></i>Prev</a></li>
                </ul>
                <ul class="pagination">
                    <li class="blog-page-item pag-active"><a class="blog-page-link">1</a></li>
                    <li class="blog-page-item"><a class="blog-page-link">2</a></li>
                    <li class="blog-page-item"><a class="blog-page-link">3</a></li>
                    <li class="blog-page-item"><a class="blog-page-link">4</a></li>
                    <li class="blog-page-item"><a class="blog-page-link">5</a></li>
                </ul>
                <ul class="pagination">
                    <li class="blog-page-item"><a class="blog-page-link" aria-label="Next">Next<i class="fal fa-chevron-right"></i></a></li>
                </ul>
            </div>
        </section>
    </div>
</div>