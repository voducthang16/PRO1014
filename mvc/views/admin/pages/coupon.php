<div class="row">
    <div class="col-md-12">
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addCoupon">
            <span class="material-icons" style="margin-top: -20px;">add</span>
            Thêm Coupon
        </button>
        <div class="card">
            <div class="card-header card-header-rose card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">assignment</i>
                </div>
                <h4 class="card-title">Coupon</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">ID</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Value</th>
                                <th>So luong</th>
                                <th>Used</th>
                                <th>ngay bat dau</th>
                                <th>ngay ket thuc</th>
                                <th class="text-right">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1;?>
                            <?php foreach ($data['getCoupon'] as $item): ?>
                                <tr>
                                    <td width="5%"><?=$count++?></td>
                                    <td width="5%"><?=$item["id"]?></td>
                                    <td width="10%"><?=$item["name"]?></td>
                                    <td width="10%"><?=$item['type'] == 1 ? '%' : 'bang tien'?></td>
                                    <td width="10%"><?=$item["value"]?></td>
                                    <td width="10%"><?=$item["quantity"]?></td>
                                    <td width="10%"><?=$item["used"]?></td>
                                    <td width="15%"><?=$item["created_at"]?></td>
                                    <td width="15%"><?=$item["ended_at"]?></td>
                                    <td width="20%" class="td-actions text-right">
                                        <button type="button" rel="tooltip" class="btn btn-success update-coupon">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button type="button" rel="tooltip" class="btn btn-danger delete-coupon">
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

<!-- Create Coupon -->
<div class="modal fade" id="addCoupon" tabindex="-1" role="dialog" aria-labelledby="addCouponLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCouponLabel">Thêm Coupon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="coupon-name">Mã giảm giá</label>
                        <input type="text" class="form-control" id="coupon-name" name="coupon-name" placeholder="Nhập mã giảm giá" >
                        <span style="position: absolute; top: 0; right: 0;" id="coupon-random">Random</span>
                    </div>
                    <div class="form-check" style="padding-bottom: 8px;">
                        <label>Loại giảm giá</label> <br>
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="coupon-type" value="1" > Phần trăm
                            <span class="circle"><span class="check"></span></span>
                        </label>
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="coupon-type" value="0" > Tiền
                            <span class="circle"><span class="check"></span></span>
                        </label>
                    </div>
                    <div class="form-group percent d-none">
                        <label for="coupon-value-percent">Phần trăm giảm giá</label>
                        <input type="number" class="form-control" id="coupon-value-percent" name="coupon-value-percent" placeholder="Nhập % mã giảm giá" min="0" max="100" >
                    </div>
                    <div class="form-group money d-none">
                        <label for="coupon-value-money">So tien giảm giá</label>
                        <input type="number" class="form-control" id="coupon-value-money" name="coupon-value-money" placeholder="Nhập so tien mã giảm giá" min="0" >
                    </div>
                    <div class="form-group quantity d-none">
                        <label for="coupon-quantity">So lan giảm giá</label>
                        <input type="number" class="form-control" id="coupon-quantity" name="coupon-quantity" placeholder="Nhập so lan mã giảm giá" min="0" >
                    </div>
                    <div class="form-group">
                        <label for="coupon-note">Miêu tả coupon</label>
                        <textarea class="form-control" name="coupon-note" rows="3" placeholder="Nhập miêu tả coupon"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="coupon-date-start">ngay bat dau</label>
                        <input type="date" class="form-control" id="coupon-date-start" name="coupon-date-start" min="<?=date("Y-m-d");?>" >
                    </div>
                    <div class="form-group">
                        <label for="coupon-date-end">ngay ket thuc</label>
                        <input type="date" class="form-control" id="coupon-date-end" name="coupon-date-end" min="<?=date("Y-m-d");?>"  disabled>
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
<script>
    $(document).ready(function() {
        $(document).on('click', '.form-check-input', function(event) {
            if (event.target.value == 1) {
                $(".form-group.money").addClass("d-none");
                $(".form-group.percent").removeClass("d-none");
                $(".form-group.quantity").removeClass("d-none");
            } else {
                $(".form-group.percent").addClass("d-none");
                $(".form-group.money").removeClass("d-none");
                $(".form-group.quantity").removeClass("d-none");
            }
        })
        $("#coupon-random").on("click", function() {
            let result = "";
            let characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let charactersLength = characters.length;
            for (let i = 0; i < 8; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            $("#coupon-name").val(result);
        })
        $("#coupon-date-start").on("change", function(e) {
            let dateSelected = $(this).val();
            let last_number = dateSelected.slice(-1);
            let minEnded = dateSelected.slice(0, -1) + (+last_number + 1);
            $("#coupon-date-end").prop("disabled", false);
            $("#coupon-date-end").attr({"min": minEnded});
        })
    })
</script>