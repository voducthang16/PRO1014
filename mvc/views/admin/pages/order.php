<style>
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

</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-rose card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">assignment</i>
                </div>
                <h4 class="card-title"><?=$data['title']?></h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">ID</th>
                                <th style="visibility: hidden;">></th>
                                <th class="text-center">Người đặt</th>
                                <th class="text-center">Ngày đặt</th>
                                <th class="text-right">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1;?>
                            <?php foreach($data['getOrder'] as $item): ?>
                                <tr>
                                    <td width="10%" class="text-center"><?=$count++?></td>
                                    <td width="10%" class="text-center"><?=$item["id"]?></td>
                                    <td style="visibility: hidden;"><?=$item['order_status']?></td>
                                    <td width="30%" class="text-center"><?=$item["name"]?></td>
                                    <td width="30%" class="text-center"><?=dateVietnamese($item["orderDate"])?></td>
                                    <td width="20%" class="td-actions text-right">
                                        <button type="button" rel="tooltip" class="btn btn-info order-info">
                                            <i class="material-icons">person</i>
                                        </button>
                                        <button type="button" rel="tooltip" class="btn btn-success order-update">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button style="display: <?=$data['status'] == 3 ? '' : 'none'?>" type="button" rel="tooltip" class="btn btn-danger order-delete">
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

<!-- Order Details -->
<div class="modal fade" id="orderInfo" tabindex="-1" role="dialog" aria-labelledby="orderInfo" aria-hidden="true">
    <div style="max-width: 1000px !important" class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderInfo">Chi tiết hóa đơn</h5>
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

<!-- Order Update -->
<div class="modal fade" id="updateOrder" tabindex="-1" role="dialog" aria-labelledby="updateOrderLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateOrderLabel">Trạng Thái Đơn Hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <input type="hidden" name="update-order-id" id="update-order-id">
                    <div class="form-check">
                        <label style="display: <?=$data['status'] == 1 || $data['status'] == 2 ? 'none' : ''?>" class="form-check-label">
                            <input class="form-check-input dh-ux" type="radio" name="u-order-status" value="0" > Chưa xử lý
                            <span class="circle"><span class="check"></span></span>
                        </label>
                        <label style="display: <?=$data['status'] == 2 ? 'none' : ''?>" class="form-check-label">
                            <input class="form-check-input dh-bx" type="radio" name="u-order-status" value="1" > Đang xử lý
                            <span class="circle"><span class="check"></span></span>
                        </label>
                        <label class="form-check-label">
                            <input class="form-check-input dh-dx" type="radio" name="u-order-status" value="2" > Đã xử lý
                            <span class="circle"><span class="check"></span></span>
                        </label>
                        <label style="display: <?=$data['status'] == 2 ? 'none' : ''?>" class="form-check-label">
                            <input class="form-check-input dh-cx" type="radio" name="u-order-status" value="3" > Hủy
                            <span class="circle"><span class="check"></span></span>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button style="display: <?=$data['status'] == 2 ? 'none' : ''?>" type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Order Delete -->
<div class="modal fade" id="deleteOrder" tabindex="-1" role="dialog" aria-labelledby="deleteOrderLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteOrderLabel">Xóa Đơn Hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <input type="hidden" name="delete-order-id" id="delete-order-id">
                    <div class="form-group">
                        <h3 class="text-center">Bạn có muốn xóa đơn hàng này không?</h3>
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
        $(".order-info").click(function() {
            $tr = $(this).closest('tr');
            let data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();
            let orderId = data[1];
            $.ajax({
                url: 'admin/getOrderInfo',
                type: 'POST',
                data: {
                    orderId : orderId
                },
                success: function(data) {
                    $(".render-db").html(data);
                    $('#orderInfo').modal('show');
                }
            })
        });
        $(".order-update").on("click", function() {
            $("#updateOrder").modal("show");
            $tr = $(this).closest('tr');
            let data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();
            
            let orderId = data[1];
            let orderStatus = data[2];

            $("#update-order-id").val(orderId);

            if (orderStatus == 0) {
                $(".dh-ux").prop("checked", true);
            } else if (orderStatus == 1) {
                $(".dh-bx").prop("checked", true);
            } else if (orderStatus == 2) {
                $(".dh-dx").prop("checked", true);
            } else if (orderStatus == 3) {
                $(".dh-cx").prop("checked", true);
            }
        })
        $(".order-delete").on("click", function() {
            $("#deleteOrder").modal("show");
            $tr = $(this).closest('tr');
            let data2 = $tr.children("td").map(function() {
                return $(this).text();
            }).get();
            let orderId = data2[1];
            $("#delete-order-id").val(orderId);
        });
    })
</script>