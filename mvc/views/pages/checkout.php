<div class="checkout">
    <div class="page-header co">
        <div class="container wide">
            <div class="page-wrapper">
                <h2 class="page-title">Checkout</h2>
                <nav class="page-navbar">
                    <ul class="page-list">
                        <li class="page-item">
                            <a href="<?=BASE_URL?>" class="page-link"><i class="fal fa-home"></i>Trang chủ<i class="fal fa-chevron-right"></i></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link">Checkout</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container wide">
            <form class="row mlr-12" method="POST">
                <div class="col l-8 c-12 form-wrapper">
                    <h3 class="checkout-title">Shipping address</h3>
                    <div class="row">
                        <div class="col l-6 c-12">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="city">Tỉnh / Thành phố</label>
                                <select id="city" class="form-control" name="city"></select>
                                <input type="hidden" id="city_selected" name="city_selected" required>
                            </div>
                            <div class="form-group">
                                <label for="ward">Phường</label>
                                <select id="ward" class="form-control" name="ward"></select>
                                <input type="hidden" id="ward_selected" name="ward_selected" required>
                            </div>
                        </div>
                        <div class="col l-6 c-12">
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="number" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="form-group">
                                <label for="district">Quận / Huyện</label>
                                <select id="district" class="form-control" name="district"></select>
                                <input type="hidden" id="district_selected" name="district_selected" required>
                            </div>
                            <div class="form-group">
                                <label for="street">Đường</label>
                                <input type="text" class="form-control" id="street" name="street" required>
                            </div>
                        </div>
                    </div>
                    <h3 class="checkout-title">Thanh toán</h3>
                    <div class="form-group">
                        <label for="order_method">Phương thức thanh toán</label>
                        <select id="order_method" class="form-control" name="order_method">
                            <option hidden selected required>--- Chọn Phương Thức Thanh Toán ---</option>
                            <?php foreach ($data['order_method'] as $method):?>
                                <option value="<?=$method['id']?>"><?=$method['name']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-footer sm--hide">
                        <a href="cart" class="btn"><i style="font-size: 1.6rem; margin-right: 8px" class="fal fa-chevron-left"></i>Back to cart</a>
                        <button type="submit" class="btn">Đặt hàng<i style="font-size: 1.6rem; margin-left: 8px" class="fal fa-chevron-right"></i></button>
                    </div>
                </div>
                <div class="col l-4 c-12">
                    <div class="order-summary">
                        <h4>Order Summary</h4>

                        <div class="checkout-product-list">

                        </div>

                        <div class="order-note c">
                            <label for="note">
                                <span class="label-button">Note</span>
                                <span class="label-note">Ghi chú</span>
                            </label>
                            <textarea name="note" id="note" rows="10"></textarea>
                        </div>
                        <div class="order-number">
                            <ul>
                                <li class="order-number-li">
                                    Subtotal: <span id="checkout-subtotal-money"></span>
                                </li>
                                <li class="order-number-li">
                                    Shipping: <span id="order-ship">-</span>
                                </li>
                                <li class="order-number-li">
                                    Discount: <span id="order-discount">-</span>
                                </li>
                            </ul>
                        </div>
                        <h2 id="order-total-money"></h2>
                        <div class="order-coupon">
                            <!-- add class error-coupon-->
                            <input type="text" class="form-control" id="coupon" name="coupon" placeholder="Promo Code">
                            <input type="hidden" id="coupon_id" name="coupon_id">
                            <!-- add class active-->
                            <span class="order-coupon-error ">Please provide promo code.</span>
                            <button class="btn order-coupon-submit">Apply promo code</button>
                        </div>
                        <div class="form-footer pc">
                            <a href="cart" class="btn"><i style="font-size: 1.6rem; margin-right: 8px" class="fal fa-chevron-left"></i>Back to cart</a>
                            <button type="submit" class="btn">Đặt hàng<i style="font-size: 1.6rem; margin-left: 8px" class="fal fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        function getCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for(var i=0;i < ca.length;i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1,c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
            }
            return null;
        }

        // function eraseCookie(name) {   
        //     document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        // }

        let note = getCookie('note');
        if (note) {
            document.querySelector('#note').innerHTML = note
        }

        const city = $("#city");
        const district = $("#district");
        const ward = $("#ward");
        let list_city = "<option hidden selected>--- Chọn Tỉnh / Thành phố ---</option>";
        let list_district = "<option hidden selected>--- Chọn Quận / Huyện ---</option>";
        let list_ward = "<option hidden selected>--- Chọn Xã / Phường ---</option>";
        let address = "";

        $.ajax({
            url: "https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/province",
            type: "GET",
            beforeSend: function(request) {
                request.setRequestHeader("Token", "f2a7666f-4923-11ec-ac64-422c37c6de1b");
            },
            success: function(data) {
                let length = data.data.length;
                for (let i = length - 1; i > 0; i--) {
                    list_city += `<option value=${data.data[i].ProvinceID}>${data.data[i].ProvinceName}</option>`
                }
                city.html(list_city);
            }
        })

        city.change(function() {
            $("#city_selected").val(city.find(':selected').text());
            list_district = "<option hidden selected>--- Chọn Quận / Huyện ---</option>";
            list_ward = "";
            $("#order-ship").html("-");
            $.ajax({
                url: "https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/district",
                type: "GET",
                beforeSend: function(request) {
                    request.setRequestHeader("Token", "f2a7666f-4923-11ec-ac64-422c37c6de1b");
                },
                data: {
                    "province_id": $(this).val()
                },
                success: function(data) {
                    let length = data.data.length;
                    for (let i = length - 1; i > 0; i--) {
                        list_district += `<option value=${data.data[i].DistrictID}>${data.data[i].DistrictName}</option>`
                    }
                    district.html(list_district);
                    ward.html(list_ward);
                }
            })
            $.ajax({
                url: "checkout/totalCheckout",
                method: "POST",
                success:function(data) {
                    $('#order-total-money').html(data)
                }
            })
        })

        district.change(function() {
            $("#district_selected").val(district.find(':selected').text());
            list_ward = "<option hidden selected>--- Chọn Xã / Phường ---</option>";
            $.ajax({
                url: `https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/ward?district_id=${$(this).val()}`,
                type: "GET",
                beforeSend: function(request) {
                    request.setRequestHeader("Token", "f2a7666f-4923-11ec-ac64-422c37c6de1b");
                },
                success: function(data) {
                    let length = data.data.length;
                    for (let i = 0; i < length; i++) {
                        list_ward += `<option value=${data.data[i].WardCode}>${data.data[i].WardName}</option>`
                    }
                    ward.html(list_ward);
                }
            })
        })

        ward.change(function() {
            $("#ward_selected").val(ward.find(':selected').text());
            let cityChecked = city.find(':selected').val()
            let ship = $("#order-ship");
            if (cityChecked == 202) {
                ship.html("20,000đ");
                ship = 20000;
            } else {
                ship.html("30,000đ")
                ship = 30000;
            }
            $.ajax({
                url: "checkout/totalCheckout",
                method: "POST",
                data: {
                    ship: ship
                },
                success:function(data) {
                    $('#order-total-money').html(data)
                }
            })
        })

        $(".order-coupon-submit").on('click', function(e) {
            e.preventDefault();
            const couponName = $("#coupon").val();
            const total = $('#checkout-subtotal-money').text().replace('đ','').split(',').join('');
            
            let formatNumber = new Intl.NumberFormat('vn-VN', {
                style: 'currency',
                currency: 'VND'
            })
            $.ajax({
                url: "checkout/checkCoupon",
                method: "POST",
                data: {
                    couponName: couponName,
                    total : total
                },
                success:function(data) {
                    console.log(data);
                    if ($("#coupon").hasClass("error-coupon")) {
                        $("#coupon").removeClass('error-coupon');
                        $(".order-coupon-error").removeClass('active');
                    }
                    if (data == 'coupon not found') {
                        $("#coupon").addClass('error-coupon');
                        $(".order-coupon-error").addClass('active');
                        notification({  title: 'Warning',
                                            message: 'Mã coupon không hợp lệ',
                                            type: 'warning',
                                            duration: 3000});
                    } else {
                        const subtotal = $('#checkout-subtotal-money').text().replace('đ','').split(',').join('');
                        let json = JSON.parse(data);
                        if(json.type_coupon == 0){
                            var value = json.value_coupon;
                            const Discount = formatNumber.format(value);
                            $('#order-discount').html(Discount);
                        } else {
                            var value =(subtotal/100)*json.value_coupon;
                            const Discount = formatNumber.format(value);
                            $('#order-discount').html(Discount);
                        }
                        $("#coupon_id").val(json.id_coupon)
                        let ship = $('#order-ship').text();
                        if (ship === '-') {
                            ship = 0;
                        } else {
                            ship = ship.replace('đ','').split(',').join('');
                        }
                        const total = formatNumber.format(subtotal - value + Number(ship));
                        $('#order-total-money').html(total);
                    }
                }
            })
        })
    })
</script>