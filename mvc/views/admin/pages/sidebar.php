<?php
    class sidebar extends database {
        function numberOrder($id) {
            $query = "SELECT COUNT(*) as 'count' FROM orders WHERE order_status = ?";
            $result = $this->connect->prepare($query);
            $result->execute([$id]);
            return $result->fetch()['count'];
        }
    }
    $sidebar = new sidebar();
?>

<div class="sidebar" data-color="rose" data-background-color="black" data-image="<?=BASE_URL?>public/assets/img/sidebar-1.jpg">
    <div class="logo" style="text-align: center;">
        <a href="<?=BASE_URL?>admin" style="display: inline-block">
            <img width="80%" src="<?=BASE_URL?>public/assets/img/logo-admin.png" alt="Image Logo">
        </a>
    </div>
    <div class="sidebar-wrapper">
        <div class="user">
            <div class="photo">
                <img src="<?=BASE_URL?>public/assets/img/faces/avatar.jpg" />
            </div>
            <div class="user-info">
                <a style="user-select: none">
                    <span class="username">
                        <?=$_SESSION['admin-username']?>
                    </span>
                </a>
            </div>
        </div>
        <ul class="nav">
            <li class="nav-item home">
                <a class="nav-link" href="<?=BASE_URL?>admin">
                    <i class="material-icons">dashboard</i>
                    <p> Trang chủ </p>
                </a>
            </li>
            <li class="nav-item menu">
                <a class="nav-link" href="<?=BASE_URL?>admin/category">
                    <i class="material-icons">category</i>
                    <p>Danh mục</p>
                </a>
            </li>
            <li class="nav-item products">
                <a class="nav-link" href="<?=BASE_URL?>admin/product">
                    <i class="material-icons">shopping_bag</i>
                    <p>Sản Phẩm</p>
                </a>
            </li>
            <li class="nav-item products">
                <a class="nav-link" href="<?=BASE_URL?>admin/coupon">
                    <i class="material-icons">local_offer</i>
                    <p>Coupon</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link orders" data-toggle="collapse" href="#order">
                    <i class="material-icons">content_paste</i>
                    <p> Đơn hàng
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse dh-show" id="order">
                    <ul class="nav">
                        <li class="nav-item ux">
                            <a class="nav-link" href="<?=BASE_URL?>admin/order/unprocessed">
                                <!-- Unprocessed Xu Ly -->
                                <span class="sidebar-mini"> UX </span>
                                <span style="position: relative !important;" class="sidebar-normal"> Đơn hàng chưa xử lý
                                    <span style="position: absolute !important; right: 0;">
                                        <?=$sidebar->numberOrder('0');?>
                                    </span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item bx">
                            <a class="nav-link" href="<?=BASE_URL?>admin/order/processing">
                                <span class="sidebar-mini"> BX </span>
                                <span class="sidebar-normal"> Đơn hàng đang xử lý
                                    <span style="position: absolute !important; right: 0;">
                                        <?=$sidebar->numberOrder('1');?>
                                    </span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item dx">
                            <a class="nav-link" href="<?=BASE_URL?>admin/order/processed">
                                <span class="sidebar-mini"> DX </span>
                                <span class="sidebar-normal"> Đơn hàng đã xử lý
                                    <span style="position: absolute !important; right: 0;">
                                        <?=$sidebar->numberOrder('2');?>
                                    </span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item cx">
                            <a class="nav-link" href="<?=BASE_URL?>admin/order/cancelled">
                                <span class="sidebar-mini"> CX </span>
                                <span class="sidebar-normal"> Đơn hàng bị hủy
                                    <span style="position: absolute !important; right: 0;">
                                        <?=$sidebar->numberOrder('3');?>
                                    </span>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="<?=BASE_URL?>admin/comments">
                    <i class="material-icons">chat</i>
                    <p> Bình luận
                    </p>
                </a>
            </li>
        </ul>
    </div>
</div>