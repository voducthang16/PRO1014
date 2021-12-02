<div class="order-page">
    <div class="page-header">
        <div class="container wide">
            <div class="page-wrapper">
                <h2 class="page-title">Đơn hàng của tôi</h2>
                <nav class="page-navbar">
                    <ul class="page-list">
                        <li class="page-item">
                            <a href="<?=BASE_URL?>" class="page-link"><i class="fal fa-home"></i>Trang chủ<i class="fal fa-chevron-right"></i></a>
                        </li>
                        <li class="page-item">
                            <a href="<?=BASE_URL?>account" class="page-link">Tài khoản<i class="fal fa-chevron-right"></i></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link">Lịch sử đặt hàng</a>
                        </li>
                    </ul>
                </nav>
                <button class="btn btn--size-s account-sign-out sm--hide"><i style="margin-right: 8px" class="fal fa-sign-out-alt"></i> Đăng xuất</button>
            </div>
        </div>
    </div>
    <div style="margin-top: -80px" class="container wide">
        <div style="padding-bottom: 40px" class="row">
            <div class="col l-4 c-12">
                <?php require_once __DIR__ . "/account_sidebar.php";?>
            </div>
            <div class="col l-8 c-12">
                <div class="account-orders">
                    <table class="orders-table">
                        <thead class="orders-table-head">
                            <tr>
                                <th>Đơn hàng#</th>
                                <th>Ngày đặt hàng</th>
                                <th>Trạng thái</th>
                                <th>Tổng cộng</th>
                            </tr>
                        </thead>
                        <tbody class="orders-table-body">
                            <?php foreach ($data['order'] as $item): ?>
                                <tr>
                                    <td><span class="orders-table-detail">TH-O<?=$item['id']?></span></td>
                                    <td><?=dateVietnamese($item['orderDate'])?></td>
                                    <td>
                                        <?php
                                            switch ($item['order_status']) {
                                                case '0':
                                                    echo '<span style="background-color: rgb(254, 165, 105)" class="order-status-label">Delayed</span>';
                                                    break;
                                                case '1':
                                                    echo '<span style="background-color: rgb(105, 179, 254)" class="order-status-label">In Progress</span>';
                                                    break;
                                                case '2':
                                                    echo '<span style="background-color: rgb(66, 214, 151)" class="order-status-label">Delivered</span>';
                                                    break;
                                                case '3':
                                                    echo '<span style="background-color: rgb(243, 71, 112)" class="order-status-label">Cancelled</span>';
                                                    break;
                                            }
                                        ?>
                                    </td>
                                    <td><?=number_format($item['total'])?>đ</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(document).on('click', '.account-sign-out', function() {
                $.ajax({
                    url: "account/signOut",
                    type: "POST",
                    success: function(data) {
                        window.location.href = "";
                    }
                })
            })
        })
    </script>
</div>