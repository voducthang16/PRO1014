<div class="sidebar" data-color="rose" data-background-color="black" data-image="<?=BASE_URL?>public/assets/img/sidebar-1.jpg">
    <div class="logo" style="text-align: center;">
        <a href="<?=BASE_URL?>admin" style="display: inline-block">
            <img width="80%" src="<?=BASE_URL?>public/assets/img/logo-white.png" alt="Image Logo">
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
                <a class="nav-link" href="?option=menu">
                    <i class="material-icons">restaurant_menu</i>
                    <p>Menu</p>
                </a>
            </li>
            <li class="nav-item products">
                <a class="nav-link" href="?option=products">
                    <i class="material-icons">fastfood</i>
                    <p>Sản Phẩm</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link orders" data-toggle="collapse" href="#formsExamples">
                    <i class="material-icons">content_paste</i>
                    <p> Đơn hàng
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse dh-show" id="formsExamples">
                    <ul class="nav">
                        <li class="nav-item ux">
                            <a class="nav-link" href="?option=orders&status=0">
                                <!-- Unprocessed Xu Ly -->
                                <span class="sidebar-mini"> UX </span>
                                <span style="position: relative !important;" class="sidebar-normal"> Đơn hàng chưa xử lý
                                    <span style="position: absolute !important; right: 0;"></span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item bx">
                            <a class="nav-link" href="?option=orders&status=1">
                                <span class="sidebar-mini"> BX </span>
                                <span class="sidebar-normal"> Đơn hàng đang xử lý
                                    <span style="position: absolute !important; right: 0;"></span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item dx">
                            <a class="nav-link" href="?option=orders&status=2">
                                <span class="sidebar-mini"> DX </span>
                                <span class="sidebar-normal"> Đơn hàng đã xử lý
                                    <span style="position: absolute !important; right: 0;"></span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item cx">
                            <a class="nav-link" href="?option=orders&status=3">
                                <span class="sidebar-mini"> CX </span>
                                <span class="sidebar-normal"> Đơn hàng bị hủy
                                    <span style="position: absolute !important; right: 0;"></span>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="?option=comments">
                    <i class="material-icons">chat</i>
                    <p> Bình luận
                    </p>
                </a>
            </li>
        </ul>
    </div>
</div>