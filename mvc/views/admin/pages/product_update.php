<?php
    class product_update extends database {
        function checkAttributeId($attribute, $id, $attributes_id) {
            $query = "SELECT DISTINCT products_attributes.value FROM products_attributes 
            INNER JOIN products_type_attributes ON products_attributes.id = products_type_attributes.attributes_id 
            WHERE products_type_attributes.product_type_id IN (SELECT products_type.id FROM products_type WHERE products_type.product_id = $id) 
            AND products_attributes.name LIKE '%$attribute%' AND products_attributes.id = $attributes_id";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch()['value'];
        }

        function getAttributes($product_type_id, $attribute) {
            $query = "SELECT products_attributes.value FROM products_attributes 
            INNER JOIN products_type_attributes ON products_type_attributes.attributes_id = products_attributes.id 
            WHERE products_type_attributes.product_type_id = $product_type_id AND products_attributes.name LIKE '%$attribute%'";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetchAll();
        }
    }

    $product_update = new product_update();
?>

<style>
    .products-color,
    .products-size {
        display: inline-block;
    }

    .products-attribute-hidden {
        position: absolute;
        left: 0;
        top: 100%;

        width: 100%;
        padding: 20px;
        border-radius: 8px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-top: 1px solid #fff;

        background-color: #fff;

        opacity: 0;
        visibility: hidden;
        z-index: 1;
    }
    .products-size {
        text-align: center;
    }

    .products-attribute-item {
        display: inline-block;
    }

    .products-attribute-input {
        border: 0;
        vertical-align: top;
        background: none;
        appearance: none;
    }

    .products-attribute-option {
        position: relative;
        display: inline-block;
        width: 32px;
        height: 32px;
        border: 1px solid #e3e9ef;
        border-radius: 4px;

        line-height: 32px;
        text-align: center;

        background-color: #fff;
        color: #aaa;
        transition: color 0.2s ease-in-out, border-color 0.2s ease-in-out;
    }

    .products-attribute-option.color {
        border-radius: 50%;
    }

    .products-attribute-input:checked ~ .products-attribute-option {
        color: #9c27b0;
        border-color: #9c27b0;
    }

    .products-attribute-color {
        position: absolute;
        top: 10%;
        left: 10%;
        
        display: block;
        width: 24px;
        height: 24px;
        border-radius: 50%;
    }

    .products-attribute-option:hover {
        cursor: pointer;
    }

    .products-attribute-input:checked ~ .products-attribute-option {
        color: #9c27b0;
        border-color: #9c27b0;
    }

    .apply-size {
        position: absolute;
        top: 50%;
        right: 50%;
        transform: translateY(-15%);
    }

    .apply-color {
        position: absolute;
        top: 47%;
        right: 37%;
        transform: translateY(-15%);
    }

    .upload-multi {
        opacity: 1 !important;
        position: unset !important;
        width: unset !important;
    }

    .box-shadow-img {
        box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-rose card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">assignment</i>
                </div>
                <h4 class="card-title">Cập nhật sản phẩm có id là <?=$data['product']['id']?></h4>
                <?php foreach ($data['getProductTypeIdById'] as $type): ?>
                    <?php foreach ($product_update->getAttributes($type['product_type_id'], 'size') as $attr): ?>
                        <span class="size-order d-none"><?=$attr['value']?></span>
                    <?php endforeach;?>
                    <?php foreach ($product_update->getAttributes($type['product_type_id'], 'color') as $attr): ?>
                        <span class="color-order d-none"><?=$attr['value']?></span>
                    <?php endforeach;?>
                <?php endforeach;?>
            </div>
            <div class="card-body">
                <form method="POST" action="" enctype="multipart/form-data" id="form">
                    <input type="hidden" id="u-product-id" name="u-product-id" value="<?=$data['product']['id']?>">
                    <div class="form-group">
                        <label for="u-product-name">Tên sản phẩm</label>
                        <input type="text" class="form-control" id="u-product-name" name="u-product-name" placeholder="Nhập tên sản phẩm" value="<?=$data['product']['name']?>">
                    </div>
                    <div class="form-group">
                        <label for="product-category">Danh mục sản phẩm</label>
                        <select class="custom-select" id="product-category" name="product-category" >
                            <?php foreach ($data['getCategories'] as $item): ?>
                                <option value="<?=$item['id']?>" <?=$data['product']['category_id'] == $item['id'] ? ' selected' : ''?>><?=$item['name']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group size <?=$data['product']['category_id'] == '5' ? 'd-none' : ''?>">
                        <label>Size sản phẩm</label><br>
                        <label class="apply-size">Áp dụng</label>
                        <div class="product-letter-size <?=$data['product']['category_id'] != '4' ? '' : 'd-none'?>">
                            <?php foreach ($data['getLetterSizes'] as $item):?>
                                <div class="products-size letter">
                                    <div class="products-attribute-item">
                                        <input class="products-attribute-input letter" type="checkbox" name="product_size[]" 
                                        id="<?=$item["value"]?>" value="<?=$item["id"]?>" 
                                        <?=$product_update->checkAttributeId('size', $data['product']['id'], $item["id"]) == $item["value"] ? 'checked' : ''?>
                                        >
                                        <label class="products-attribute-option" for="<?=$item["value"]?>"><?=$item["value"]?></label>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                        <div class="product-number-size <?=$data['product']['category_id'] == '4' ? '' : 'd-none'?>">
                            <?php foreach ($data['getNumberSizes'] as $item):?>
                                <div class="products-size number">
                                    <div class="products-attribute-item">
                                        <input class="products-attribute-input number" type="checkbox" name="product_size[]" id="<?=$item["value"]?>" value="<?=$item["id"]?>"
                                        <?=$product_update->checkAttributeId('size', $data['product']['id'], $item["id"]) == $item["value"] ? 'checked' : ''?>
                                        >
                                        <label class="products-attribute-option" for="<?=$item["value"]?>"><?=$item["value"]?></label>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <div class="form-group color">
                        <label>Màu sản phẩm</label><br>
                        <label class="apply-color">Áp dụng</label>
                        <?php foreach ($data['getColors'] as $item): ?>
                            <div class="products-color">
                                <div class="products-attribute-item">
                                    <input class="products-attribute-input color" type="checkbox" name="product-color[]" id="<?=$item["value"]?>" value="<?=$item["id"]?>"
                                    <?=$product_update->checkAttributeId('color', $data['product']['id'], $item["id"]) == $item["value"] ? 'checked' : ''?>
                                    >
                                    <label class="products-attribute-option color" for="<?=$item["value"]?>">
                                        <span style="background-color: <?=$item["value"]?>" class="products-attribute-color"></span>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>
                    <div class="form-group">
                        <label for="">Thiết lập phân loại sản phẩm</label><br>
                        <input type="number" class="form-control-custom price-origin" placeholder="Giá gốc" min="1" >
                        <input type="number" class="form-control-custom price-sale" placeholder="Giá bán" min="1" >
                        <input type="number" class="form-control-custom quantity" placeholder="Số lượng sản phẩm" min="1" >
                        <span class="apply-all">Áp dụng cho tất cả</span>
                    </div>
                    <div class="form-group">
                        <label for="">Phân loại sản phẩm</label><br>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center col-size <?=$data['product']['category_id'] == '5' ? 'd-none' : ''?>">Size</th>
                                    <th class="text-center">Màu</th>
                                    <th class="text-center">Giá gốc</th>
                                    <th class="text-center">Giá bán</th>
                                    <th class="text-center">Số lượng</th>
                                </tr>
                            </thead>
                            <tbody class="table-body">
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <h6><label style="text-transform: none;">Ảnh bìa sản phẩm</label></h6>
                        <div class="fileinput fileinput-new text-center load-thumbnail-product" style="width: 100%" data-provides="fileinput">
                            <!-- <div class="fileinput-new thumbnail">
                                <img src="<?=BASE_URL?>public/upload/<?=$data['product']['id']?>/<?=$data['product']['thumbnail']?>" alt="Product Image">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                            <div>
                            <span class="btn btn-rose btn-round btn-file">
                                <span class="fileinput-new">Chọn ảnh bìa</span>
                                <span class="fileinput-exists">Thay đổi</span>
                                <input style="z-index: 2 !important;" type="file" name="product-thumbnail" accept="image/*" />
                            </span>
                            <a href="#delImg" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Xóa</a>
                            </div> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label style="display: block;">Ảnh sản phẩm</label>
                        <div style="display: flex; flex-wrap: wrap" id="list-images"></div>
                    </div>
                    <div class="form-group">
                        <label for="product-description">Miêu tả sản phẩm</label>
                        <textarea class="form-control" name="product-description" rows="3" placeholder="Nhập miêu tả sản phẩm"><?=$data['product']['description']?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="product-description">Thông sản phẩm</label>
                        <textarea class="form-control" name="product-parameters" rows="3" placeholder="Nhập thông số sản phẩm"><?=$data['product']['parameters']?></textarea>
                    </div>
                    <div class="form-check">
                        <label>Trạng thái sản phẩm</label> <br>
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="product-status" value="1" <?=$data['product']['status'] == 1 ? 'checked' : ''?>> Active
                            <span class="circle"><span class="check"></span></span>
                        </label>
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="product-status" value="0" <?=$data['product']['status'] == 0 ? 'checked' : ''?>> Inactive
                            <span class="circle"><span class="check"></span></span>
                        </label>
                    </div>
                    <div class="form-group">
                        <button id="btn-submit" type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<base href="<?=BASE_URL?>">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="<?=BASE_URL?>public/assets/js/plugins/jasny-bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        
        $("#u-product-name").change(function() {
            let productId = $("#u-product-id").val();
            let productName = $(this).val();
            $.ajax({
                url: 'admin/checkExistName',
                type: 'POST',
                data: {
                    productName: productName,
                    productId: productId
                },
                success: function(data) {
                    if (data != '') {
                        alert(data);
                    }
                }
            })
        })
        
        function loadImages() {
            $.ajax({
                url: 'admin/getProductThumbnail',
                type: 'POST',
                data: {
                    productId: $("#u-product-id").val(),
                },
                success: function(data) {
                    $(".load-thumbnail-product").html(data);
                }
            })
            $.ajax({
                url: 'admin/getProductImages',
                type: 'POST',
                data: {
                    productId: $("#u-product-id").val(),
                },
                success: function(data) {
                    $("#list-images").html(data);
                }
            })
            // if (window.history.replaceState ) {
            //     window.history.replaceState(null, null, window.location.href );
            // }
        }

        loadImages();

        $(document).on('click', '.upload-multi', function(event) {
            $(this).change(function() {
                let preview = $(this).prev();
                let file = $(this).prop('files')[0]
                let reader = new FileReader();
                reader.onloadend = function () {
                    preview.attr('src', reader.result);
                }
                if (file) {
                    reader.readAsDataURL(file);
                } else {
                    preview.attr('src', 'http://localhost/PRO1014/public/assets/img/image_placeholder.jpg')
                }
            })
        })

        $(document).on('click', '#u-product-thumbnail', function(e) {
            // e.preventDefault();
            $(this).change(function() {
                let file = $(this).prop('files')[0];
                let fileType = file.type;
                let fileSize = file.size;
                let match = ['image/jpeg', 'image/png', 'image/jpg'];

                if (!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]))) {
                    alert('Please select a file to upload');
                    $("#u-product-thumbnail").val('');
                    return false;
                }

                if (fileSize > 5000000) {
                    alert('Sorry! File size exceeds');
                    return false;
                }
            })
        })

        $(document).on('submit', function(e) {
            // e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: 'admin/updateThumbnail',
                type: 'POST',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {
                    console.log(data);
                }
            })
        })

        $(document).on('click', '.del-img', function(e) {
            let id = $(this).attr('id');
            $.ajax({
                url: 'admin/deleteImage',
                type: 'POST',
                data: {
                    id: id,
                    productId : $("#u-product-id").val(),
                },
                success: function(data) {
                    alert(data);
                    loadImages();
                }
            })
        })

        // Code here













        // =============================================
        let letterSizesArray = [];
        let numberSizesArray = [];
        let colorArray = [];
        let sizeFromOrder = [];
        let colorFromOrder = [];

        let sizeOrder = document.querySelectorAll(".size-order");
        sizeOrder.forEach(e => {
            if (!sizeFromOrder.includes(e.textContent)) {
                sizeFromOrder.push(e.textContent);
            }
        })

        let colorOrder = document.querySelectorAll(".color-order");
        colorOrder.forEach(e => {
            if (!colorFromOrder.includes(e.textContent)) {
                colorFromOrder.push(e.textContent);
            }
        })

        // console.log(sizeFromOrder);
        // console.log(colorFromOrder);

        let numberSizesArray2 = document.querySelectorAll(".products-attribute-input.number");
        numberSizesArray2.forEach(e => {
            if (e.checked) {
                numberSizesArray.push(e.id);
            }
        })

        let letterSizesArray2 = document.querySelectorAll(".products-attribute-input.letter");
        letterSizesArray2.forEach(e => {
            if (e.checked) {
                letterSizesArray.push(e.id);
            }
        })

        let colorArray2 = document.querySelectorAll(".products-attribute-input.color");
        colorArray2.forEach(e => {
            if (e.checked) {
                colorArray.push(e.id);
            }
        })

        let tableBody = document.querySelector('.table-body');

        function letterSizes() {
            let letterSizes = document.querySelectorAll(".products-attribute-input.letter");
            letterSizes.forEach(e => {
                e.onclick = () => {
                    if (e.checked) {
                        if (!letterSizesArray.includes(e.id)) {
                            letterSizesArray.push(e.id);
                        }
                    } else {
                        if (letterSizesArray.includes(e.id)) {
                            letterSizesArray.splice(letterSizesArray.indexOf(e.id), 1);
                        }
                    }
                    let difference = sizeFromOrder.filter(x => !letterSizesArray.includes(x));
                    if (difference.length > 0) {
                        e.checked = true
                        alert('khong duoc bo chon: ' + difference[0])
                        letterSizesArray.push(difference[0])
                        difference = [];
                        letterSizesArray.sort();
                    }
                }
            })
        }

        function numberSizes() {
            let numberSizes = document.querySelectorAll(".products-attribute-input.number");
            numberSizes.forEach(e => {
                e.onclick = () => {
                    if (e.checked) {
                        if (!numberSizesArray.includes(e.id)) {
                            numberSizesArray.push(e.id);
                        }
                    } else {
                        if (numberSizesArray.includes(e.id)) {
                            numberSizesArray.splice(numberSizesArray.indexOf(e.id), 1);
                        }
                    }
                    let difference = sizeFromOrder.filter(x => !numberSizesArray.includes(x));
                    if (difference.length > 0) {
                        e.checked = true
                        alert('khong duoc bo chon: ' + difference[0])
                        numberSizesArray.push(difference[0])
                        difference = [];
                        numberSizesArray.sort();
                    }
                }
            })
        }

        let colors = document.querySelectorAll(".products-attribute-input.color");
        colors.forEach(e => {
            e.onclick = () => {
                if (e.checked) {
                    if (!colorArray.includes(e.id)) {
                        colorArray.push(e.id);
                    }
                } else {
                    if (colorArray.includes(e.id)) {
                        colorArray.splice(colorArray.indexOf(e.id), 1);
                    }
                }
                let difference = colorFromOrder.filter(x => !colorArray.includes(x));
                if (difference.length > 0) {
                    e.checked = true
                    alert('khong duoc bo chon: ' + difference[0])
                    colorArray.push(difference[0])
                    difference = [];
                    colorArray.sort();
                }
            }
        })

        let applySizeElement = document.querySelector(".apply-size");
        let applyColorElement = document.querySelector(".apply-color");

        function applyColor(e) {
            if (e == 1 || e == 2 || e == 3 || e == 4) { 
                applyColorElement.onclick = function() {
                    let sizeWColor = document.querySelectorAll(".size-w-color");
                    let sizeWPriceOrigin = document.querySelectorAll(".size-w-price-origin");
                    let sizeWPriceSale = document.querySelectorAll(".size-w-price-sale");
                    let sizeWQuantity = document.querySelectorAll(".size-w-quantity");
                    let color = "";
                    let priceOrigin = "";
                    let priceSale = "";
                    let quantity = "";
                    sizeWColor.forEach(e => {
                        for (let i = 0; i < colorArray.length; i++) {
                            color += `<div>
                                ${colorArray[i]}
                            </div>`;
                        }
                        e.innerHTML = color;
                        color = "";
                    });
                    sizeWPriceOrigin.forEach(e => {
                        for (let i = 0; i < colorArray.length; i++) {
                            priceOrigin += `<div>
                                <input type="number" name="product-price-origin[]" class="form-control-custom">
                            </div>`;
                        }
                        e.innerHTML = priceOrigin;
                        priceOrigin = "";
                    });
                    sizeWPriceSale.forEach(e => {
                        for (let i = 0; i < colorArray.length; i++) {
                            priceSale += `<div>
                                <input type="number" name="product-price-sale[]" class="form-control-custom">
                            </div>`;
                        }
                        e.innerHTML = priceSale;
                        priceSale = "";
                    });
                    sizeWQuantity.forEach(e => {
                        for (let i = 0; i < colorArray.length; i++) {
                            quantity += `<div>
                                <input type="number" name="product-quantity[]" class="form-control-custom">
                            </div>`;
                        }
                        e.innerHTML = quantity;
                        quantity = "";
                    });
                }
            } else {
                applyColorElement.onclick = function() {
                    let color = "";
                    colorArray.forEach(e => {
                        color += `<tr>
                                    <td>${e}</td>
                                    <td><input type="number" name="product-price-origin[]" class="form-control-custom"></td>
                                    <td><input type="number" name="product-price-sale[]" class="form-control-custom"></td>
                                    <td><input type="number" name="product-quantity[]" class="form-control-custom"></td>
                                </tr>`
                    })
                    tableBody.innerHTML = color;
                }
            }
        }

        function applySize(e) {
            applySizeElement.onclick = () => {
                tableBody.innerHTML = "";
                let size = "";
                if (e == 1 || e == 2 || e == 3) {
                    console.log(letterSizesArray)
                    for (let i = 0; i < letterSizesArray.length; i++) {
                        size += `<tr class='text-center'>
                                    <td>${letterSizesArray[i]}</td>
                                    <td class="size-w-color"></td>
                                    <td class="size-w-price-origin"></td>
                                    <td class="size-w-price-sale"></td>
                                    <td class="size-w-quantity"></td>
                                </tr>`;
                    }
                } else {
                    for (let i = 0; i < numberSizesArray.length; i++) {
                        size += `<tr class='text-center'>
                                    <td>${numberSizesArray[i]}</td>
                                    <td class="size-w-color"></td>
                                    <td class="size-w-price-origin"></td>
                                    <td class="size-w-price-sale"></td>
                                    <td class="size-w-quantity"></td>
                                </tr>`;
                    }
                }
                tableBody.innerHTML = size;
            }
        }

        let applyAll = document.querySelector(".apply-all");
        applyAll.onclick = () => {
            let priceOriginAll = document.querySelector(".form-control-custom.price-origin").value;
            let priceSaleAll = document.querySelector(".form-control-custom.price-sale").value;
            let quantityAll = document.querySelector(".form-control-custom.quantity").value;
            document.querySelectorAll("input[name='product-price-origin[]']").forEach(e => {
                e.value = priceOriginAll;
            })
            document.querySelectorAll("input[name='product-price-sale[]']").forEach(e => {
                e.value = priceSaleAll;
            })
            document.querySelectorAll("input[name='product-quantity[]']").forEach(e => {
                e.value = quantityAll;
            })
        }

        $("#product-category").change(function() {
            let idCategory = this.value;
            if (idCategory == "1" || idCategory == "2" || idCategory == "3" || idCategory == "4") {
                tableBody.innerHTML = "";
                $(".form-group.size").removeClass("d-none");
                $(".col-size").removeClass("d-none");
            } else {
                $(".form-group.size").addClass("d-none");
                $(".col-size").addClass("d-none");
                tableBody.innerHTML = "";
            }
            if (idCategory == "1" || idCategory == "2" || idCategory == "3") {
                $(".product-letter-size").removeClass("d-none");
                letterSizes();
            } else {
                $(".product-letter-size").addClass("d-none");
            }

            if (idCategory == "4") {
                $(".product-number-size").removeClass("d-none");
                numberSizes();
            } else {
                $(".product-number-size").addClass("d-none");
            }

            $(".form-group.color").removeClass("d-none");
            $(".form-group.set-up-classify").removeClass("d-none");
            $(".form-group.classify").removeClass("d-none");
            applySize(this.value);
            applyColor(this.value);
        });
        letterSizes();
        numberSizes();
        applySize($("#product-category").val());
        applyColor($("#product-category").val());
    })
</script>