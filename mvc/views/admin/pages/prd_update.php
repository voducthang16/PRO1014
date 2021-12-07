<style>
    .size-w-color{
        width: 30px;
    }
    .color-value{
        width: 30px;
        height: 20px;
        border: solid 1px black;
    }
    .product-render-color {
        display: flex;
        align-items: center;
    }
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
            </div>
            <div class="card-body">
                <form method="POST" action="" enctype="multipart/form-data" id="form">
                    <input type="hidden" id="u-product-id" name="u-product-id" value="<?=$data['product']['id']?>">
                    <input type="hidden" id="u-product-category" name="u-product-category" value="<?=$data['product']['category_id']?>">
                    <div class="form-group">
                        <label for="u-product-name">Tên sản phẩm</label>
                        <input type="text" class="form-control" id="u-product-name" name="u-product-name" placeholder="Nhập tên sản phẩm" value="<?=$data['product']['name']?>">
                    </div>
                    <div class="form-group">
                        <label for="product-category">Danh mục sản phẩm</label>
                        <select class="custom-select" id="product-category" name="product-category" disabled>
                            <option value="<?=$data['product']['category_id']?>" selected><?=$data['product']['nameCategory']?></option>
                        </select>
                    </div>
                    <div class="form-group size <?=$data['product']['category_id'] == '5' ? 'd-none' : ''?>">
                        <label>Size sản phẩm</label><br>
                        <!-- <label class="apply-size">Áp dụng</label> -->
                        <div class="product-letter-size <?=$data['product']['category_id'] != '4' ? '' : 'd-none'?>">
                            <!-- <input style="width: 48px;" type="text" id="add-size" class="add-letter-size-input" name="add_size"> -->
                        </div>
                        <div class="product-number-size <?=$data['product']['category_id'] == '4' ? '' : 'd-none'?>">
                            <!-- <input style="width: 48px;" type="text" id="add-size" class="add-letter-size-input" name="add_size"> -->
                        </div>
                    </div>
                    <div class="form-group color">
                        <label>Màu sản phẩm</label><br>
                        <!-- <label class="apply-color">Áp dụng</label> -->
                        <div class="product-render-color">
                            <!-- <input type="color" id="add-color" class="add-color-input" name="add_color"> -->
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label for="">Thiết lập phân loại sản phẩm</label><br>
                        <input type="number" class="form-control-custom price-origin apply-price-origin-all" placeholder="Giá gốc" min="1" >
                        <input type="number" class="form-control-custom price-sale apply-price-sale-all" placeholder="Giá bán" min="1" >
                        <input type="number" class="form-control-custom quantity apply-price-quantity" placeholder="Số lượng sản phẩm" min="1" >
                        <span class="apply-all apply-all-attribute">Áp dụng cho tất cả</span>
                    </div>
                    <div class="form-group">
                        <label for="">Phân loại sản phẩm</label><br>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center col-size">Size</th>
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
                            <div class="fileinput-new thumbnail">
                                <img src="<?=BASE_URL?>public/upload/<?=$data['product']['id']?>/<?=$data['product']['thumbnail']?>" alt="Product Image">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                            <div>
                            <span class="btn btn-rose btn-round btn-file">
                                <span class="fileinput-new">Chọn ảnh bìa</span>
                                <span class="fileinput-exists">Thay đổi</span>
                                <input style="z-index: 2 !important;" type="file" name="product-thumbnail" id="u-product-thumbnail" accept="image/*" />
                            </span>
                            <a href="#delImg" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Xóa</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label style="display: block;">Ảnh sản phẩm</label>
                        <div style="display: flex; flex-wrap: wrap" id="list-images"></div>
                    </div>
                    <div class="form-group">
                        <label for="product-description">Miêu tả sản phẩm</label>
                        <textarea class="form-control" name="u-product-description" rows="3" placeholder="Nhập miêu tả sản phẩm"><?=$data['product']['description']?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="product-description">Thông số sản phẩm</label>
                        <textarea class="form-control" name="u-product-parameters" rows="3" placeholder="Nhập thông số sản phẩm"><?=$data['product']['parameters']?></textarea>
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
    $(document).ready(function(){

        function fetch_data(){
            $.ajax({
                url: "admin/getDataPrd/<?=$data['product']['id']?>",
                method: "POST",
                success:function(data){
                    $('.table-body').html(data);
                }
            });
        }

        fetch_data();
        loadImages();

        function loadImages() {
            $.ajax({
                url: 'admin/getProductImages',
                type: 'POST',
                data: {
                    productId: <?=$data['product']['id']?>,
                },
                success: function(data) {
                    $("#list-images").html(data);
                }
            })
        }
        function getLetterSize(value) {
            $.ajax({
                url: "admin/getLetterSizeUpdate",
                type: "POST",
                data: {
                    value: value,
                    id: <?=$data['product']['id']?>
                },
                success: function(data) {
                    $(".product-letter-size").html(data);
                }
            })
        }

        function getNumberSize(value) {
            $.ajax({
                url: "admin/getNumberSizeUpdate",
                type: "POST",
                data: {
                    value: value,
                    id: <?=$data['product']['id']?>
                },
                success: function(data) {
                    $(".product-number-size").html(data);
                }
            })
        }

        function getColor(value) {
            $.ajax({
                url: "admin/getColorUpdate",
                type: "POST",
                data: {
                    value: value,
                    id: <?=$data['product']['id']?>
                },
                success: function(data) {
                    $(".product-render-color").html(data);
                }
            })
        }

        if (<?=$data['product']['category_id']?>== 1 ||<?=$data['product']['category_id']?> == 2 ||<?=$data['product']['category_id']?> == 3) {
            getLetterSize("letter_size");
        }
        if (<?=$data['product']['category_id']?> == 4) {
            getNumberSize("number_size");
        }

        if (<?=$data['product']['category_id']?> == 1 || <?=$data['product']['category_id']?> == 2 || <?=$data['product']['category_id']?> == 3 || <?=$data['product']['category_id']?> == 4) {
            getColor("color")
        } else {
            getColor("color")
        }

        $(document).on('click','.add-size-n',function() {
            const numberSize = $('.add-number-size-input').val();
            if(numberSize == ""){
                alert('vui lòng nhập size');
                return;
            }
            $.ajax({
                url: "admin/addNumberSizeById",
                type: "POST",
                data: {
                    attributes: "number_size",
                    id: <?=$data['product']['id']?>,
                    numberSize : numberSize
                },
                success: function(data) {
                    alert(data);
                    fetch_data();
                    getNumberSize("number_size");
                }
            });
        })
        $(document).on('click','.add-size-l',function() {
            const numberSize = $('.add-letter-size-input').val();
            if(numberSize == ""){
                alert('vui lòng nhập size');
                return;
            }
            $.ajax({
                url: "admin/addNumberSizeById",
                type: "POST",
                data: {
                    attributes: "letter_size",
                    id: <?=$data['product']['id']?>,
                    numberSize : numberSize
                },
                success: function(data) {
                    alert(data);
                    fetch_data();
                    getLetterSize("letter_size");
                }
            });
        })

        $(document).on('click','.add-color',function() {
            const ColorSize = $('.add-color-input').val();
            if(ColorSize == ""){
                alert('vui lòng nhập color');
                return;
            }
            $.ajax({
                url: "admin/addColorById",
                type: "POST",
                data: {
                    attributes: "color",
                    category: <?=$data['product']['category_id']?>,
                    id: <?=$data['product']['id']?>,
                    color : ColorSize
                },
                success: function(data) {
                    alert(data);
                    fetch_data();
                    getColor("color");
                }
            });
        })

        $(document).on('click','.products-attribute-input',function() {
            const value = $(this).val();
            // alert(value);
            $.ajax({
                url: "admin/updateStatusType",
                type: "POST",
                data: {
                    category: <?=$data['product']['category_id']?>,
                    id: <?=$data['product']['id']?>,
                    value : value
                },
                success: function(data) {
                    alert(data);
                    fetch_data();
                    getColor("color");
                    getLetterSize("letter_size");
                    getNumberSize("number_size");
                }
            });
        })

        $(document).on('blur','.change-value-attribute',function(){
            const type_id = $(this).attr('data-typeId');
            const type = $(this).attr('data-type');
            const value = ($(this).text()).split(',').join('');
            $.ajax({
                url: "admin/updateAttribute_type",
                type: "POST",
                data: {
                    id: <?=$data['product']['id']?>,
                    column: type,
                    type_id: type_id,
                    value: value
                },
                success: function(data) {
                    fetch_data();
                }
            });
        })

        $(document).on('click','.apply-all-attribute',function(){
            const value1 = $('.apply-price-origin-all').val();
            const value2 = $('.apply-price-sale-all').val();
            const value3 = $('.apply-price-quantity').val();
            $.ajax({
                url: "admin/updateAttribute_typeAll",
                type: "POST",
                data: {
                    id: <?=$data['product']['id']?>,
                    price_origin: value1,
                    price_sale: value2,
                    quantity: value3
                },
                success: function(data) {
                    fetch_data();
                }
            });
        })
        
    })
</script>