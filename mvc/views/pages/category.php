<?php 
    class categoryDetail extends database {
        function getProductAttribute($attribute, $id) {
            $query = "SELECT DISTINCT products_attributes.id, products_attributes.value FROM products_attributes INNER JOIN products_type_attributes 
            ON products_attributes.id = products_type_attributes.attributes_id 
            WHERE products_type_attributes.product_type_id 
            IN (SELECT products_type.id FROM products_type WHERE products_type.product_id = $id) AND products_attributes.name LIKE '%$attribute%'";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }
    }
    $categoryDetail = new categoryDetail();
?>

<div class="category">
    <div class="page-header">
        <div class="container wide">
            <div class="page-wrapper">
                <h2 class="page-title">Danh mục</h2>
                <nav class="page-navbar">
                    <ul class="page-list">
                        <li class="page-item">
                            <a href="<?=BASE_URL?>" class="page-link"><i class="fal fa-home"></i>Trang chủ<i class="fal fa-chevron-right"></i></a>
                        </li>
                        <li class="page-item">
                            <a href="<?=BASE_URL?>" class="page-link">Danh mục<i class="fal fa-chevron-right"></i></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link"><?=$data['categoryName']?></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div class="page-body container wide">
        <div class="row">
            <div class="col l-4">
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
            <div class="col l-8">
                <div class="row mt-80">
                    <?php foreach ($data['getProducts'] as $product): ?>
                        <div class="col l-4">
                            <form class="products" id="<?=$product["id"]?>" method="POST">
                                <input type="hidden" name="product-id" class="products-id" value="<?=$product["id"]?>">
                                <div class="products-heart">
                                    <span>Add to wishlist</span>
                                    <i class="fal fa-heart"></i>
                                </div>
                                <a href="#" class="products-link">
                                    <img src="public/upload/<?=$product["id"]?>/<?=$product["thumbnail"]?>" alt="Product Image" class="products-img">
                                </a>
                                <div class="products-body">
                                    <a href="#" class="products-name"><?=$product["name"]?></a>
                                    <h4 class="products-price">123.000vnd</h4>
                                </div>
                                <div class="products-attribute-hidden">
                                    <div class="products-size">
                                        <?php 
                                            $product_size = $categoryDetail->getProductAttribute('size', $product["id"]);
                                            foreach ($product_size as $size):
                                        ?>
                                            <div class="products-attribute-item">
                                                <input class="products-attribute-input attributes-color-input" type="radio" name="size" id="<?=$product["id"]?>_<?=$size['id']?>" value="<?=$size['id']?>">
                                                <label class="products-attribute-option" for="<?=$product["id"]?>_<?=$size['id']?>"><?=$size['value']?></label>
                                            </div>
                                        <?php endforeach;?>
                                    </div>
                                    <div class="products-color">
                                        <?php 
                                            $product_color = $categoryDetail->getProductAttribute('color', $product["id"]);
                                            foreach ($product_color as $color):
                                        ?>
                                            <div class="products-attribute-item">
                                                <input class="products-attribute-input attributes-size-input" type="radio" name="color" id="<?=$product['id']?>_<?=$color['id']?>" value="<?=$color['id']?>">
                                                <label class="products-attribute-option color" for="<?=$product['id']?>_<?=$color['id']?>">
                                                    <span style="background-color: <?=$color['value']?>" class="products-attribute-color"></span>
                                                </label>
                                            </div>
                                        <?php endforeach;?>
                                    </div>
                                    <div class="products-btn">
                                        <button class="btn btn--size-s btn-add-cart">Add to cart</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
</div>