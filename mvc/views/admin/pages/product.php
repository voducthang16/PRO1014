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

    /* Custom  */
    .upload-multi {
        opacity: 1 !important;
        position: unset !important;
        width: 100% !important;
    }

    .modal .modal-dialog {
        margin-top: 20px !important;
    }

    .modal-dialog .modal-content {
        max-height: 600px !important;
        overflow-y: scroll !important;
    }

    .modal-dialog .modal-content::-webkit-scrollbar {
        width: 12px;
    }

    .modal-dialog .modal-content::-webkit-scrollbar-track {
        background-color: transparent !important;
    }

    .modal-dialog .modal-content::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 6px;
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
                                <th>Trạng thái</th>
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
                                    <td width="20%"><?=$item['status'] == 1 ? 'Active' : 'Inactive'?></td>
                                    <td width="20%" class="td-actions text-right">
                                        <button type="button" rel="tooltip" class="btn btn-success update-product">
                                            <i class="material-icons">edit</i>
                                        </button>
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
<base href="<?=BASE_URL?>">
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
                        <input type="text" class="form-control" id="product-name" name="product-name" placeholder="Nhập tên sản phẩm" required>
                    </div>
                    <div class="form-group">
                        <label for="product-category">Danh mục sản phẩm</label>
                        <select class="custom-select" id="product-category" name="product-category" required>
                            <option value="" hidden selected>--- Chọn Danh Mục Sản Phẩm ---</option>
                            <?php foreach ($data['getCategories'] as $item): ?>
                                <option value="<?=$item['id']?>"><?=$item['name']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group d-none size">
                        <label>Size sản phẩm</label> <br>
                        <div id="size"></div>
                    </div>
                    <div class="form-group d-none color">
                        <label>Màu sản phẩm</label> <br>
                        <div id="color"></div>
                    </div>
                    <div class="form-group">
                        <label for="product-price">Giá gốc</label>
                        <input type="number" class="form-control" id="product-price-sale" name="product-price-origin" placeholder="Nhập giá gốc" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="product-sale">Giá bán</label>
                        <input type="number" class="form-control" id="product-price-sale" name="product-price-sale" placeholder="Nhập giá bán" min="1" required>
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
                                <input style="z-index: 2 !important;" type="file" name="product-thumbnail" required />
                            </span>
                            <a href="#delImg" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Xóa</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Ảnh sản phẩm</label>
                        <input type="file" class="upload-multi" name="product-list-images[]" multiple="">
                    </div>
                    <div class="form-group">
                        <label for="product-quantity">Số lượng sản phẩm</label>
                        <input type="number" class="form-control" id="product-quantity" name="product-quantity" placeholder="Nhập số lượng sản phẩm" min="1" required>
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
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="<?=BASE_URL?>public/assets/js/plugins/jasny-bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $("#product-category").change(function() {
            let idCategory = this.value;
            let action = "attributes";
            let name = "";
            switch(idCategory) {
                case "1": case "2":
                    name = "letter_size";
                    break;
                case "3":
                    name = "number_size";
                    break;
                default:
                    name = "";
                    break;
            }
            $.ajax({
                url: "admin/getSizes",
                type: "POST",
                data: {
                    action : action,
                    name: name,
                },
                success: function (data) {
                    $("#size").html(data);
                }
            });
            $.ajax({
                url: "admin/getColors",
                type: "POST",
                data: {
                    action : action,
                    name: "color",
                },
                success: function (data) {
                    $("#color").html(data);
                }
            });
            if (idCategory == "1" || idCategory == "2" || idCategory == "3") {
                $(".form-group.size").removeClass("d-none");
            } else {
                $(".form-group.size").addClass("d-none");
            }
            $(".form-group.color").removeClass("d-none");
        })
    });
</script>