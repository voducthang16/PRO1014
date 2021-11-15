<div class="product">
    <div class="page-header">
        <div class="container wide">
            <div class="page-wrapper">
                <h2 class="page-title"><?=$data['product']['name']?></h2>
                <nav class="page-navbar">
                    <ul class="page-list">
                        <li class="page-item">
                            <a href="<?=BASE_URL?>" class="page-link"><i class="fal fa-home"></i>Trang chủ<i class="fal fa-chevron-right"></i></a>
                        </li>
                        <li class="page-item">
                            <a href="<?=BASE_URL?>category/detail/<?=$data['category']['slug']?>" class="page-link"><?=$data['category']['name']?><i class="fal fa-chevron-right"></i></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link"><?=$data['product']['name']?></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div class="page-body container wide">
        <div class="product-wrapper row">
            <div class="col l-7">
                <div class="row">
                    <div class="col l-2">
                        <div class="product-slide">
                            <img class="product-slide-image active" src="public/upload/<?=$data['product']['id']?>/<?=$data['product']['thumbnail']?>" alt="Product Image Slide">
                            <?php foreach ($data['productImages'] as $image) :?>
                                <img class="product-slide-image" src="public/upload/<?=$data['product']['id']?>/<?=$image["image"]?>" alt="Product Image Slide">
                            <?php endforeach;?>
                        </div>
                    </div>
                    <div class="col l-10">
                        <div class="product-thumbnail">
                            <img id="product-thumbnail" src="public/upload/<?=$data['product']['id']?>/<?=$data['product']['thumbnail']?>" alt="Product Thumbnail">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col l-5">
                <div class="product-info">
                    
                </div>
            </div>
        </div>
    </div>
</div>