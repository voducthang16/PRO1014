<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-rose card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">assignment</i>
                </div>
                <h4 class="card-title">Bình luận</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th style="visibility: hidden"></th>
                                <th>User's Name</th>
                                <th>ID SP</th>
                                <th>Nội dung</th>
                                <th>Sao</th>
                                <th>Ngay BL</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-right">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1;?>
                            <?php foreach ($data['getComments'] as $item): ?>
                                <tr>
                                    <td width="10%" class="text-center"><?=$count++?></td>
                                    <td style="visibility: hidden"><?=$item["id"]?></td>
                                    <td width="15%"><?=$item["name"]?></td>
                                    <td width="10%"><?=$item["product_id"]?></td>
                                    <td width="30%"><?=$item["content"]?></td>
                                    <td width="5%"><?=$item["star"]?></td>
                                    <td width="10%"><?=$item["date"]?></td>
                                    <td width="10%" class="text-center"><?=$item['status'] == 1 ? 'Active' : 'Inactive'?></td>
                                    <td width="10%" class="td-actions text-right">
                                        <button type="button" rel="tooltip" class="btn btn-success update-comment">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button type="button" rel="tooltip" class="btn btn-danger delete-comment">
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

<!-- Update Comment -->
<div class="modal fade" id="updateComment" tabindex="-1" role="dialog" aria-labelledby="updateCommentLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateCommentLabel">Cập Nhật Comment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">

                    <input type="hidden" name="u-comment-id" id="u-comment-id">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input active" type="radio" name="u-comment-status" value="1" > Active
                            <span class="circle"><span class="check"></span></span>
                        </label>
                        <label class="form-check-label">
                            <input class="form-check-input inactive" type="radio" name="u-comment-status" value="0" > Inactive
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

<!-- Delete Comment-->
<div class="modal fade" id="deleteComment" tabindex="-1" role="dialog" aria-labelledby="deleteCommentLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCommentLabel">Xóa Bình Luận</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <input type="hidden" name="delete-comment-id" id="delete-comment-id">
                    <div class="form-group">
                        <h3 class="text-center">Bạn có muốn bình luận mục này không?</h3>
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
<script>
    $(document).ready(function() {
        $(".update-comment").on("click", function(e) {
            $("#updateComment").modal("show");
            $tr = $(this).closest("tr");
            let data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();
            let commentId = data[1];
            let commentStatus = data[7] == "Active" ? 1 : 0;
            $("#u-comment-id").val(commentId);
            if (commentStatus == 1) {
                $(".form-check-input.active").prop("checked", true);
            } else {
                $(".inactive").prop("checked", true);
            }
        })
        $(".delete-comment").on("click", function() {
            $("#deleteComment").modal("show");
            $tr = $(this).closest("tr");
            let data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();
            let commentId = data[1];
            $("#delete-comment-id").val(commentId);
        })
    })
</script>