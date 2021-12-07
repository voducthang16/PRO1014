<style>
    .size-w-color{
        width: 30px;
    }
    .color-value{
        width: 30px;
        height: 20px;
        border: solid 1px black;
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
                            <input style="width: 48px;" type="text" id="add-size" class="add-letter-size-input" name="add_size">
                        </div>
                        <div class="product-number-size <?=$data['product']['category_id'] == '4' ? '' : 'd-none'?>">
                            <input style="width: 48px;" type="text" id="add-size" class="add-letter-size-input" name="add_size">
                        </div>
                    </div>
                    <div class="form-group color">
                        <label>Màu sản phẩm</label><br>
                        <!-- <label class="apply-color">Áp dụng</label> -->
                        <input type="color" id="add-color" class="add-color-input" name="add_color">
                        <div class="product-render-color"></div>
                    </div>
                    <div class="form-group">
                        <label class="apply-color-size" style="cursor: pointer;">Thêm size màu</label>
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
                    productId: $("#u-product-id").val(),
                },
                success: function(data) {
                    $("#list-images").html(data);
                }
            })
        }
        
    })
</script>