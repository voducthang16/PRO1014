<style>
    .products-color,
    .products-size {
        display: inline-block;
    }

    .products-size {
        text-align: center;
    }

    .products-attribute-item {
        display: inline-block;
    }

    .products-attribute-input {
        width: 0;
        height: 0;
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
        font-size: unset !important;
        font-weight: normal !important;

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

    /* Custom  */
    .upload-multi {
        opacity: 1 !important;
        position: unset !important;
        width: 100% !important;
    }

    .modal .modal-dialog {
        margin-top: 20px !important;
    }

    .modal-dialog {
        max-width: 800px !important;
    }

    .form-group.color,
    .form-group.size {
        position: relative;
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
    .product-color-order-detail {
        position: relative;
        top: 2px;
        left: 8px;
        display: inline-block;
        width: 16px;
        height: 16px;
        padding: 2px;
        border: 1px solid #e3e9ef;
        border-radius: 50%;
    }

    .products-color {
        margin-top: unset;
    }

    .product-render-color {
        display: flex;
        align-items: center;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addProduct">
            <span class="material-icons" style="margin-top: -20px;">add</span>
            Thêm Sản Phẩm
        </button>
        <div class="card">
            <div class="card-header card-header-rose card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">assignment</i>
                </div>
                <h4 class="card-title">Sản phẩm</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">ID</th>
                                <th>Tên</th>
                                <th class="text-center">Lượt xem</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-right">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1;?>
                            <?php foreach ($data['getProducts'] as $item): ?>
                                <tr>
                                    <td width="10%" class="text-center"><?=$count++?></td>
                                    <td width="20%" class="text-center"><?=$item["id"]?></td>
                                    <td width="30%"><?=$item["name"]?></td>
                                    <td width="10%" class="text-center"><?=$item["view"]?></td>
                                    <td width="10%" class="text-center"><?=$item['status'] == 1 ? 'Active' : 'Inactive'?></td>
                                    <td width="10%" class="td-actions text-right">
                                        <button type="button" rel="tooltip" class="btn btn-info info-product">
                                            <i class="material-icons">person</i>
                                        </button>
                                        <!-- <form style="display: inline-block;" target="_blank" action="<?=BASE_URL?>admin/product_update" method="POST">
                                            <input type="hidden" name="update-product-by-id" value="<?=$item["id"]?>">
                                            <button type="submit" rel="tooltip" class="btn btn-success update-product">
                                                <i class="material-icons">edit</i>
                                            </button>
                                        </form> -->
                                        <a href="<?=BASE_URL?>admin/updatePrd/<?=$item['id']?>" type="submit" rel="tooltip" class="btn btn-success update-product">
                                                <i class="material-icons">edit</i>
                                        </a>
                                        <button type="button" rel="tooltip" class="btn btn-danger delete-product">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Product Details -->
<div class="modal fade" id="productInfo" tabindex="-1" role="dialog" aria-labelledby="productInfo" aria-hidden="true">
    <div style="max-width: 1000px !important" class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="">
                <div class="modal-body render-db">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create Product -->
<div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="addProductLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductLabel">Thêm Sản Phẩm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="product-name">Tên sản phẩm</label>
                        <input type="text" class="form-control" id="product-name" name="product-name" placeholder="Nhập tên sản phẩm" >
                    </div>
                    <div class="form-group">
                        <label for="product-category">Danh mục sản phẩm</label>
                        <select class="custom-select" id="product-category" name="product-category" >
                            <option value="" hidden selected>--- Chọn Danh Mục Sản Phẩm ---</option>
                            <?php foreach ($data['getCategories'] as $item): ?>
                                <option value="<?=$item['id']?>"><?=$item['name']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- Size -->
                    <div class="form-group size d-none">
                        <label>Size sản phẩm</label><br>
                        <!-- <label class="apply-size">Áp dụng</label> -->
                        <!-- Letter Size -->
                        <div class="product-letter-size d-none">
                            
                        </div>
                        <!-- Number Size -->
                        <div class="product-number-size d-none">
                            
                        </div>
                    </div>
                    <!-- Color -->
                    <div class="form-group color d-none">
                        <label>Màu sản phẩm</label><br>
                        <!-- <label class="apply-color">Áp dụng</label> -->
                        <div class="product-render-color">

                        </div>
                    </div>
                    <div class="form-group set-up-classify d-none">
                        <label for="">Thiết lập phân loại sản phẩm</label><br>
                        <input type="number" class="form-control-custom price-origin" placeholder="Giá gốc" min="1" >
                        <input type="number" class="form-control-custom price-sale" placeholder="Giá bán" min="1" >
                        <input type="number" class="form-control-custom quantity" placeholder="Số lượng sản phẩm" min="1" >
                        <span class="apply-all">Áp dụng cho tất cả</span>
                    </div>
                    <div class="form-group classify d-none">
                        <label for="">Phân loại sản phẩm</label><br>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center col-size d-none">Size</th>
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
                        <div class="fileinput fileinput-new text-center" style="width: 100%" data-provides="fileinput">
                            <div class="fileinput-new thumbnail">
                            <img src="<?=BASE_URL?>public/assets/img/image_placeholder.jpg" alt="Product Image">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                            <div>
                            <span class="btn btn-rose btn-round btn-file">
                                <span class="fileinput-new">Chọn ảnh bìa</span>
                                <span class="fileinput-exists">Thay đổi</span>
                                <input style="z-index: 2 !important;" type="file" name="product-thumbnail" required>
                            </span>
                            <a href="#delImg" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Xóa</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Ảnh sản phẩm</label>
                        <input type="file" class="upload-multi" name="product-list-images[]" multiple="" required>
                    </div>
                    <div class="form-group">
                        <label for="product-description">Miêu tả sản phẩm</label>
                        <textarea class="form-control" name="product-description" rows="3" placeholder="Nhập miêu tả sản phẩm"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="product-description">Thông sản phẩm</label>
                        <textarea class="form-control" name="product-parameters" rows="3" placeholder="Nhập thông số sản phẩm"></textarea>
                    </div>
                    <div class="form-check">
                        <label>Trạng thái sản phẩm</label> <br>
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="product-status" value="1" checked> Active
                            <span class="circle"><span class="check"></span></span>
                        </label>
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="product-status" value="0"> Inactive
                            <span class="circle"><span class="check"></span></span>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button id="btn-submit" type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="deleteProduct" tabindex="-1" role="dialog" aria-labelledby="deleteProductLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProductLabel">Xóa Thực Đơn</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <input type="hidden" name="delete-product-id" id="delete-product-id">
                    <div class="form-group">
                        <h3 class="text-center">Bạn có muốn xóa sản phẩm này không?</h3>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="<?=BASE_URL?>public/assets/js/plugins/jasny-bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $(".delete-product").on("click", function() {
            $("#deleteProduct").modal("show");
            $tr = $(this).closest('tr');
            let data2 = $tr.children("td").map(function() {
                return $(this).text();
            }).get();
            let productId = data2[1];
            $("#delete-product-id").val(productId);
        });

        let letterSizesArray = [];
        let numberSizesArray = [];
        let colorArray = [];
        let tableBody = document.querySelector('.table-body');

        let applyAll = document.querySelector(".apply-all");
        applyAll.onclick = () => {
            let priceOriginAll = document.querySelector(".form-control-custom.price-origin").value;
            let priceSaleAll = document.querySelector(".form-control-custom.price-sale").value;
            let quantityAll = document.querySelector(".form-control-custom.quantity").value;
            if (priceOriginAll.trim() == "") {
                alert("Vui long nhập giá gốc")
                return;
            }
            if (priceSaleAll.trim() == "") {
                alert("Vui long nhập giá giảm giá")
                return;
            }
            if (quantityAll.trim() == "") {
                alert("Vui long nhập số lượng")
                return;
            }
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

                $.ajax({
                    url: "admin/updateColorStatus",
                    type: "POST",
                    data: {value: "color"},
                    success: function(data) {
                        colorArray = [];
                    }
                })
                getColor("color");
            } else {
                $.ajax({
                    url: "admin/updateColorStatus",
                    type: "POST",
                    data: {value: "color"},
                    success: function(data) {
                        colorArray = [];
                    }
                })
                getColor("color");
                $(".form-group.size").addClass("d-none");
                $(".col-size").addClass("d-none");
                tableBody.innerHTML = "";
            }

            if (idCategory == "1" || idCategory == "2" || idCategory == "3") {
                $(".product-letter-size").removeClass("d-none");
                $.ajax({
                    url: "admin/updateLetterSizeStatus",
                    type: "POST",
                    data: {value: "letter_size"},
                    success: function(data) {
                        letterSizesArray = [];
                    }
                })
                getLetterSize("letter_size");
            } else {
                $(".product-letter-size").addClass("d-none");
            }

            if (idCategory == "4") {
                $(".product-number-size").removeClass("d-none");
                $.ajax({
                    url: "admin/updateNumberSizeStatus",
                    type: "POST",
                    data: {value: "number_size"},
                    success: function(data) {
                        numberSizesArray = [];
                    }
                })
                getNumberSize("number_size");
            } else {
                $(".product-number-size").addClass("d-none");
            }
            $(".form-group.color").removeClass("d-none");
            $(".form-group.set-up-classify").removeClass("d-none");
            $(".form-group.classify").removeClass("d-none");
        })

        function getLetterSize(value) {
            $.ajax({
                url: "admin/getLetterSize",
                type: "POST",
                data: {value: value},
                success: function (data) {
                    $(".product-letter-size").html(data);
                }
            })
        }

        function getNumberSize(value) {
            $.ajax({
                url: "admin/getNumberSize",
                type: "POST",
                data: {value: value},
                success: function (data) {
                    $(".product-number-size").html(data);
                }
            })
        }

        function getColor(value) {
            $.ajax({
                url: "admin/getColor",
                type: "POST",
                data: {value: value},
                success: function (data) {
                    $(".product-render-color").html(data);
                }
            })
        }

        // Add Letter Size
        $(document).on('click', '.add-size-l', function() {
            let category = $("#product-category").find(":selected").val();

            if (($(".add-letter-size-input").val()).trim() == "") {
                alert('vui long nhap size');
            } else {
                if (letterSizesArray.includes($(".add-letter-size-input").val())) {
                    alert('da co size nay');
                    $(".add-letter-size-input").val("");
                } else {
                    $.ajax({
                        url: "admin/addLetterSize",
                        type: "POST",
                        data: {value: $(".add-letter-size-input").val()},
                        success: function(data) {
                            getLetterSize("letter_size");
                            letterSizesArray.push(data);
                            renderTableSizeColor(category);
                        }
                    })
                }
            }
        })

        // Add Number Size
        $(document).on('click', '.add-size-n', function() {
            let category = $("#product-category").find(":selected").val();
            if ($(".add-number-size-input").val().trim() == "") {
                alert('vui long nhap size');
            } else {
                if (numberSizesArray.includes($(".add-number-size-input").val())) {
                    alert('da co size nay');
                    $(".add-number-size-input").val("");
                } else {
                    $.ajax({
                        url: "admin/addNumberSize",
                        type: "POST",
                        data: {value: $(".add-number-size-input").val()},
                        success: function(data) {
                            getNumberSize("number_size");
                            numberSizesArray.push(data);
                            renderTableSizeColor(category);
                        }
                    })
                }
            }
        })

        // Add Color
        $(document).on('click', '.add-color', function() {
            let category = $("#product-category").find(":selected").val();
            if (colorArray.includes($("#add-color").val())) {
                alert('da co mau nay');
            } else {
                $.ajax({
                    url: "admin/addColor",
                    type: "POST",
                    data: {value: $("#add-color").val()},
                    success: function(data) {
                        getColor("color");
                        colorArray.push(data);
                        renderTableSizeColor(category);
                    }
                })
            }
        })

        function renderTableSizeColor(category) {
            let priceOriginAll = document.querySelector(".form-control-custom.price-origin").value;
            let priceSaleAll = document.querySelector(".form-control-custom.price-sale").value;
            let quantityAll = document.querySelector(".form-control-custom.quantity").value;
            // if (priceOriginAll.trim() == "") {
            //     priceOriginAll;
            //     priceSaleAll;
            //     quantityAll;
            // }
            tableBody.innerHTML = "";
            let size = "";
            if (category == 1 || category == 2 || category == 3) {
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
            if (category == 1 || category == 2 || category == 3 || category == 4) { 
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
                            <input type="number" name="product-price-origin[]" class="form-control-custom" value="${priceOriginAll}">
                        </div>`;
                    }
                    e.innerHTML = priceOrigin;
                    priceOrigin = "";
                });
                sizeWPriceSale.forEach(e => {
                    for (let i = 0; i < colorArray.length; i++) {
                        priceSale += `<div>
                            <input type="number" name="product-price-sale[]" class="form-control-custom" value="${priceSaleAll}">
                        </div>`;
                    }
                    e.innerHTML = priceSale;
                    priceSale = "";
                });
                sizeWQuantity.forEach(e => {
                    for (let i = 0; i < colorArray.length; i++) {
                        quantity += `<div>
                            <input type="number" name="product-quantity[]" class="form-control-custom" value="${quantityAll}">
                        </div>`;
                    }
                    e.innerHTML = quantity;
                    quantity = "";
                });
            } else {
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

        $(document).on('click', '.products-attribute-input.letter', function() {
            let category = $("#product-category").find(":selected").val();
            let value = $(this).attr('id')
            letterSizesArray.splice(letterSizesArray.indexOf(value), 1);
            $.ajax({
                url: "admin/updateRemoveAttribute",
                type: "POST",
                data: {value: value},
                success: function (data) {
                    getLetterSize("letter_size");
                    renderTableSizeColor(category);
                }
            })
        })

        $(document).on('click', '.products-attribute-input.number', function() {
            let category = $("#product-category").find(":selected").val();
            let value = $(this).attr('id')
            numberSizesArray.splice(numberSizesArray.indexOf(value), 1);
            $.ajax({
                url: "admin/updateRemoveAttribute",
                type: "POST",
                data: {value: value},
                success: function (data) {
                    getNumberSize("number_size");
                    renderTableSizeColor(category);
                }
            })
        })

        $(document).on('click', '.products-attribute-input.color', function() {
            let category = $("#product-category").find(":selected").val();
            let value = $(this).attr('id')
            colorArray.splice(colorArray.indexOf(value), 1);
            $.ajax({
                url: "admin/updateRemoveAttribute",
                type: "POST",
                data: {value: value},
                success: function (data) {
                    getColor("color");
                    renderTableSizeColor(category);
                }
            })
        })

        // product information
        $(".info-product").click(function() {
            $tr = $(this).closest('tr');
            let data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();
            let productId = data[1];

            $.ajax({
                url: 'admin/productDetails',
                type: 'POST',
                data: {
                    productId : productId
                },
                success: function(data) {
                    $(".render-db").html(data);
                    $('#productInfo').modal('show');
                }
            })
        });
    });
</script>