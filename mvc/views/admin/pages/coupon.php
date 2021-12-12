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
                                <th class="text-left">#</th>
                                <th></th>
                                <th>Mã</th>
                                <th>Loại</th>
                                <th>Giá trị</th>
                                <th>Đơn hàng tối thiểu</th>
                                <th>Số lượng</th>
                                <th>Đã sử dụng</th>
                                <th>Ngày bắt đầu</th>
                                <th>Ngày kết thúc</th>
                                <th class="text-right">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1;?>
                            <?php foreach ($data['getCoupon'] as $item): ?>
                                <tr>
                                    <td width="3%"><?=$count++?></td>
                                    <td style="visibility: hidden"><?=$item["id"]?></td>
                                    <td width="10%"><?=$item["name"]?></td>
                                    <td width="10%"><?=$item['type'] == 1 ? '%' : 'bang tien'?></td>
                                    <td width="10%"><?=number_format($item["value"])?><?=$item['type'] == 1 ? '%' : 'đ'?></td>
                                    <td width="10%"><?=number_format($item["min_order"])?>đ</td>
                                    <td width="10%"><?=$item["quantity"]?></td>
                                    <td width="10%"><?=$item["used"]?></td>
                                    <td width="12%"><?=dateVietnamese($item["created_at"])?></td>
                                    <td width="12%"><?=dateVietnamese($item["ended_at"])?></td>
                                    <td width="10%" class="td-actions text-right">
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
                        <span style="position: absolute; top: 0; right: 0;" class="coupon-random">Random</span>
                    </div>
                    <div class="form-check" style="padding-bottom: 8px;">
                        <label>Loại giảm giá</label> <br>
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="coupon-type" value="0" > Tiền
                            <span class="circle"><span class="check"></span></span>
                        </label>
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="coupon-type" value="1" min=1 max="100"> Phần trăm
                            <span class="circle"><span class="check"></span></span>
                        </label>
                    </div>
                    <div class="form-group money d-none">
                        <label for="coupon-value-money">Số tiền</label>
                        <input type="number" class="form-control" id="coupon-value-money" name="coupon-value-money" placeholder="Nhập số tiền giảm giá" min="0" required>
                    </div>
                    <div class="form-group percent d-none">
                        <label for="coupon-value-percent">Phần trăm giảm giá</label>
                        <input type="number" class="form-control" id="coupon-value-percent" name="coupon-value-percent" placeholder="Nhập % giảm giá" min="0" max="100" required>
                    </div>
                    <div class="form-group min-order d-none">
                        <label for="coupon-value-min-order">Đơn hàng tối thiểu</label>
                        <input type="number" class="form-control" id="coupon-value-min-order" name="coupon-value-min-order" placeholder="Nhập đơn hàng tối thiểu" min="1000" required >
                    </div>
                    <div class="form-group quantity d-none">
                        <label for="coupon-quantity">Số lần giảm giá</label>
                        <input type="number" class="form-control" id="coupon-quantity" name="coupon-quantity" placeholder="Nhập số lần giảm giá" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="coupon-note">Miêu tả coupon</label>
                        <textarea class="form-control" name="coupon-note" rows="3" placeholder="Nhập miêu tả coupon"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="coupon-date-start">Ngày bắt đầu</label>
                        <input type="date" class="form-control coupon-date-start" id="coupon-date-start" name="coupon-date-start" min="<?=date("Y-m-d");?>" >
                    </div>
                    <div class="form-group">
                        <label for="coupon-date-end">Ngày kết thúc</label>
                        <input type="date" class="form-control coupon-date-end" id="coupon-date-end" name="coupon-date-end" min="<?=date("Y-m-d");?>"  disabled>
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


<!-- Update Coupon -->
<div class="modal fade" id="updateCoupon" tabindex="-1" role="dialog" aria-labelledby="updateCouponLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateCouponLabel">Cập Nhật Coupon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <input type="hidden" id="u-coupon-id" name="u-coupon-id" value="">
                    <div class="form-group">
                        <label for="coupon-name">Mã giảm giá</label>
                        <input type="text" class="form-control" id="u-coupon-name" name="u-coupon-name" placeholder="Nhập mã giảm giá" >
                        <span style="position: absolute; top: 0; right: 0;" class="coupon-random">Random</span>
                    </div>
                    <div class="form-check" style="padding-bottom: 8px;">
                        <label>Loại giảm giá</label> <br>
                        <label class="form-check-label">
                            <input class="form-check-input m" type="radio" name="u-coupon-type" value="0"> Tiền
                            <span class="circle"><span class="check"></span></span>
                        </label>
                        <label class="form-check-label">
                            <input class="form-check-input p" type="radio" name="u-coupon-type" value="1" min=1 max="100"> Phần trăm
                            <span class="circle"><span class="check"></span></span>
                        </label>
                    </div>
                    <div class="form-group money d-none">
                        <label for="coupon-value-money">So tien giảm giá</label>
                        <input type="number" class="form-control" id="u-coupon-value-money" name="u-coupon-value-money" placeholder="Nhập so tien mã giảm giá" min="0" >
                    </div>
                    <div class="form-group percent d-none">
                        <label for="coupon-value-percent">Phần trăm giảm giá</label>
                        <input type="number" class="form-control" id="u-coupon-value-percent" name="u-coupon-value-percent" placeholder="Nhập % mã giảm giá" min="0" max="100" >
                    </div>
                    <div class="form-group min-order d-none">
                        <label for="coupon-value-min-order">Don hang toi thieu</label>
                        <input type="number" class="form-control" id="u-coupon-value-min-order" name="u-coupon-value-min-order" placeholder="Nhập Don hang toi thieu" min="1000"  >
                    </div>
                    <div class="form-group quantity">
                        <label for="coupon-quantity">So lan giảm giá</label>
                        <input type="number" class="form-control" id="u-coupon-quantity" name="u-coupon-quantity" placeholder="Nhập so lan mã giảm giá" min="0" >
                    </div>
                    <!-- <div class="form-group">
                        <label for="coupon-note">Miêu tả coupon</label>
                        <textarea class="form-control" name="u-coupon-note" rows="3" placeholder="Nhập miêu tả coupon"></textarea>
                    </div> -->
                    <div class="form-group">
                        <label for="coupon-date-start">ngay bat dau</label>
                        <input type="date" class="form-control coupon-date-start" id="u-coupon-date-start" name="u-coupon-date-start" min="<?=date("Y-m-d");?>" >
                    </div>
                    <div class="form-group">
                        <label for="coupon-date-end">ngay ket thuc</label>
                        <input type="date" class="form-control coupon-date-end" id="coupon-date-end" name="u-coupon-date-end" disabled>
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

<!-- Delete Coupon -->
<div class="modal fade" id="deleteCoupon" tabindex="-1" role="dialog" aria-labelledby="deleteCouponLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCouponLabel">Xóa Coupon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <input type="hidden" name="delete-coupon-id" id="delete-coupon-id">
                    <div class="form-group">
                        <h3 class="text-center">Bạn có muốn xóa coupon này không?</h3>
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
        $(document).on('click', '.form-check-input', function(event) {
            if (event.target.value == 1) {
                $(".form-group.money").addClass("d-none");
                $(".form-group.min-order").addClass("d-none");
                $(".form-group.percent").removeClass("d-none");
                $(".form-group.quantity").removeClass("d-none");
            } else {
                $(".form-group.percent").addClass("d-none");
                $(".form-group.min-order").removeClass("d-none");
                $(".form-group.money").removeClass("d-none");
                $(".form-group.quantity").removeClass("d-none");
            }
        })
        $(".coupon-random").on("click", function() {
            let result = "";
            let characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let charactersLength = characters.length;
            for (let i = 0; i < 8; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            $("#coupon-name").val(result);
            $("#u-coupon-name").val(result);
        })
        $(".coupon-date-start").on("change", function(e) {
            let dateSelected = $(this).val();
            let last_number = dateSelected.slice(-1);
            let minEnded = dateSelected.slice(0, -1) + (+last_number + 1);
            $(".coupon-date-end").prop("disabled", false);
            $(".coupon-date-end").attr({"min": minEnded});
        })
        $(".update-coupon").on("click", function() {
            $("#updateCoupon").modal("show");
            $tr = $(this).closest('tr');
            let data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();
            let id = data[1];
            let name = data[2];
            let type = data[3] == '%' ? '1' : '0';
            let value = data[4].replace(',', '').slice(0, -1);
            let min_order = data[5].replaceAll(',', '').slice(0, -1);
            let quantity = data[6];
            let dateStart = data[8];
            let dateStartF = dateStart.substr(6, 12);
            let dateStartE = dateStart.substr(2, 6);
            dateStart = dateStartF + dateStartE;
            $("#u-coupon-id").val(id);
            $("#u-coupon-name").val(name);
            if (type == '0') {
                // tien
                $(".form-group.percent").addClass("d-none");
                $(".form-check-input.m").prop("checked", true);
                $(".form-group.money").removeClass("d-none");
                $("#u-coupon-value-money").val(value);
                $(".form-group.min-order").removeClass("d-none");
                $("#u-coupon-value-min-order").val(min_order);
            } else {
                // %
                $(".form-group.min-order").addClass("d-none");
                $(".form-group.money").addClass("d-none");
                $(".form-check-input.p").prop("checked", true);
                $(".form-group.percent").removeClass("d-none");
                $("#u-coupon-value-percent").val(value);
            }
            $("#u-coupon-quantity").val(quantity);
            $("#u-coupon-date-start").val(dateStart);
        })
        $(".delete-coupon").on("click", function() {
            $("#deleteCoupon").modal("show");
            $tr = $(this).closest('tr');
            let data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();
            $("#delete-coupon-id").val(data[1]);
        })
    })
</script>