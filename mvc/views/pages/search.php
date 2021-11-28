<div class="category">
    <div class="page-header">
        <div class="container wide">
            <div class="page-wrapper">
                <h2 class="page-title">Tìm kiếm</h2>
                <nav class="page-navbar">
                    <ul class="page-list">
                        <li class="page-item">
                            <a href="<?=BASE_URL?>" class="page-link"><i class="fal fa-home"></i>Trang chủ<i class="fal fa-chevron-right"></i></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link">Tìm kiếm</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div class="page-body container wide">
        <div class="row">
            <div class="col l-3">
                <div class="page-sidebar">
                    <div class="category-list">
                        <h3>Danh mục</h3>
                        <ul class="category-list-item">
                            <?php foreach ($data['categories'] as $category): ?>
                                <li class="category-item">
                                    <a href="<?=BASE_URL?>category/detail/<?=$category['slug']?>" class="category-link">
                                        <?=$category['name']?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col l-9">
                <div class="row mt-80 container-product-search">
                    
                    <!-- css here -->
                    <div>TÌM SẢN PHẨM</div>
                
                </div>
            </div>
        </div>
    </div>
</div>