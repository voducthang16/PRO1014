<div class="row">
    <div class="col-md-12">
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addCategory">
            <span class="material-icons" style="margin-top: -20px;">add</span>
            Thêm Danh Mục
        </button>
        <div class="card">
            <div class="card-header card-header-rose card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">assignment</i>
                </div>
                <h4 class="card-title">Danh mục</h4>
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
                            <?php foreach ($data['getCategories'] as $item): ?>
                                <tr>
                                    <td width="10%" class="text-center"><?=$count++?></td>
                                    <td width="20%" class="text-center"><?=$item["id"]?></td>
                                    <td width="30%"><?=$item["name"]?></td>
                                    <td width="20%"><?=$item['status'] == 1 ? 'Active' : 'Inactive'?></td>
                                    <td width="20%" class="td-actions text-right">
                                        <button type="button" rel="tooltip" class="btn btn-success update-category">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button type="button" rel="tooltip" class="btn btn-danger delete-category">
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

<!-- Create Category -->
<div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="addCategoryLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryLabel">Thêm Danh Mục</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="category-name">Tên danh mục</label>
                        <input type="text" class="form-control" id="category-name" name="category-name" placeholder="Nhập tên danh mục" required>
                    </div>
                    <div class="form-check">
                        <label>Trạng thái danh mục</label> <br>
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="category-status" value="1" checked> Active
                            <span class="circle"><span class="check"></span></span>
                        </label>
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="category-status" value="0" > Inactive
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

<!-- Update Category -->
<div class="modal fade" id="updateCategory" tabindex="-1" role="dialog" aria-labelledby="updateCategoryLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateCategoryLabel">Cập Nhật Danh Mục</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">

                    <input type="hidden" name="u-category-id" id="u-category-id">

                    <div class="form-group">
                        <label for="category-name">Tên danh mục</label>
                        <input type="text" class="form-control" id="u-category-name" name="u-category-name" placeholder="Nhập tên danh mục" required>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input active" type="radio" name="u-category-status" value="1" > Active
                            <span class="circle"><span class="check"></span></span>
                        </label>
                        <label class="form-check-label">
                            <input class="form-check-input inactive" type="radio" name="u-category-status" value="0" > Inactive
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

<!-- Delete Category-->
<div class="modal fade" id="deleteCategory" tabindex="-1" role="dialog" aria-labelledby="deleteCategoryLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCategoryLabel">Xóa Danh Mục</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <input type="hidden" name="delete-category-id" id="delete-category-id">
                    <div class="form-group">
                        <h3 class="text-center">Bạn có muốn xóa danh mục này không?</h3>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->

<script>
    $(document).ready(function() {
        $(".update-category").on("click", function() {
            $("#updateCategory").modal("show");
            $tr = $(this).closest('tr');
            let data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();
            
            let categoryId = data[1];
            let categoryName = data[2];
            let categoryStatus = data[3] == "Active" ? 1 : 0;

            document.cookie = `update-category-id-temp=${categoryId}`;
            document.cookie = `update-category-name-temp=${categoryName}`;
            document.cookie = `update-category-status-temp=${categoryStatus}`;

            $("#u-category-id").val(categoryId);
            $("#u-category-name").val(categoryName);

            if (categoryStatus == 1) {
                $(".active").prop("checked", true);
            } else {
                $(".inactive").prop("checked", true);
            }
        })
    });
    $(document).ready(function() {
        $(".delete-category").on("click", function() {
            $("#deleteCategory").modal("show");
            $tr = $(this).closest('tr');
            let data2 = $tr.children("td").map(function() {
                return $(this).text();
            }).get();
            let categoryId = data2[1];
            $("#delete-category-id").val(categoryId);
        });
    })
</script>