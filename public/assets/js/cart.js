// reload web start function
$(document).ready(function() {

    // fetch data to the screen

    function get_data() {

        // 	cart_temporary
        $.ajax({
            url: "cart/showCart",
            method: "POST",
            success:function(data){
                $('.render-cart').html(data);
            }
        });

        // cart pending
        $.ajax({
            url:"cart/showOrder",
            method:"POST",
            success:function(data){
                $('.container-gd-order').html(data);
            }
        });

        // total cart
        $.ajax({
            url: "cart/totalCart",
            method: "POST",
            success:function(data){
                if (document.getElementById('cart-total-val')) {
                    document.getElementById('cart-total-val').innerHTML = data;
                }
                document.getElementById('cart-total-val-2').innerHTML = data;
            }
        });

        // count cart
        $.ajax({
            url: "cart/countCart",
            method: "POST",
            success:function(data) {
                document.getElementById('cart-quantity-val').innerHTML = data;
            }
        });

        // show product in checkout
        $.ajax({
            url: "checkout/showCheckout",
            method: "POST",
            success:function(data) {
                $('.checkout-product-list').html(data)
            }
        });

        // show total product in checkout
        $.ajax({
            url: "checkout/totalCheckout",
            method: "POST",
            success:function(data) {
                $('#checkout-subtotal-money').html(data)
                $('#order-total-money').html(data)
            }
        });
    }

    // run function
    get_data();

    // add product in cart

    $(document).on('click','.btn-add-cart',function(e) {
        e.preventDefault();
        var parent = $(this).parents('.products-s');
        var id_product = parent.find('.products-id').val();
        var id_category = parent.find('.products-category-id').val();
        var quantity = parent.find('.product-quantity-value').val();
        var maxQtt = parent.find('#type_quantity').text();

        if (quantity == null) {
            quantity = 1;
        }

        if(quantity == 0){
            notification({  title: 'Warning',
                                message: 'Vui l??ng ch???n nh???p s??? l?????ng',
                                type: 'warning',
                                duration: 3000});
            return;
        }
        
        // console.log(id_category);
        // return
        var color = parent.find('.attributes-color-input');
        for(var i = 0; i < color.length; i++) {
            if(color[i].checked == true) {
                // console.log(checkbox[i].value);
                var attributes_color = color[i].value;
            }
        }
        var size = parent.find('.attributes-size-input');
        for(var i = 0; i < size.length; i++) {
            if(size[i].checked == true) {
                // console.log(checkbox[i].value);
                var attributes_size = size[i].value;
            }
        }

        // check category - if =5 => bag no size
        if (id_category != 5) {
            if (attributes_color == null || attributes_size == null) {
                notification({  title: 'Warning',
                                message: 'Vui l??ng ch???n size v?? color ?????y ?????',
                                type: 'warning',
                                duration: 3000});
                return
            }
        } else {
            if (attributes_color == null) {
                notification({  title: 'Warning',
                                message: 'Vui l??ng ch???n color ?????y ?????',
                                type: 'warning',
                                duration: 3000});
                return
            }
        }

        if (attributes_size == null) {
            attributes_size = 0;
        }

        if(Number(quantity) > Number(maxQtt)){
            notification({  title: 'Th??ng b??o',
                            message: 'N???u b???n mua ?????t ????n h??ng s??? l?????ng l???n vui l??ng ibox fanpage ????? ???????c h??? tr??? !!',
                            type: 'info',
                            duration: 10000});
            return;
        }

        // ajax to insertCart
        $.ajax({
            url: "cart/insertCart",
                method: "POST",
                data: {
                    insertCart: 'true',
                    id_product: id_product,
                    id_color: attributes_color,
                    id_size: attributes_size,
                    id_category: id_category,
                    quantity: quantity
                },
                success:function(data) {
                        if(data == 1){
                            notification({  title: 'Success',
                                            message: 'Th??m s???n ph???m th??nh c??ng',
                                            type: 'success',
                                            duration: 3000});
                        }else if(data == 2){
                            notification({  title: 'Error',
                                            message: 'Th??m s???n ph???m th???t b???i',
                                            type: 'error',
                                            duration: 3000});
                        }else if(data == 3){
                            notification({  title: 'Warning',
                                            message: 'Vui l??ng th???c hi???n l???i',
                                            type: 'warning',
                                            duration: 3000});
                        }else if(data == 'sign'){
                            window.location='sign';
                        }else{
                            notification({  title: 'Success',
                                            message: data,
                                            type: 'success',
                                            duration: 3000});
                        }
                        get_data();
                }
        });
    });

    //change quantity in product
    $(document).on('click','.btn-change-quantity-plus',function(e){
        e.preventDefault();
        let parent = $(this).parents('.cart-items__product');
        let id_type = parent.find('.cart-product__link').attr('name');

        $.ajax({
            url:'cart/updateQuantity',
            method:'POST',
            data: {
                updateQtt: 'plus',
                id_type: id_type
            },
            success:function(data){
                if (data == 1) {
                    notification({  title: 'Warning',
                                    message: 'Kh??ng update ???????c',
                                    type: 'warning',
                                    duration: 3000});
                } else if (data == 2) {
                    notification({  title: 'Warning',
                                    message: 'Vui l??ng th???c hi???n l???i',
                                    type: 'warning',
                                    duration: 3000});
                } else {
                    notification({  title: 'Success',
                                    message: '???? update +1 trong gi??? h??ng',
                                    type: 'success',
                                    duration: 3000});
                }
                get_data();
            }
        })
    });
    $(document).on('click','.btn-change-quantity-minus',function(e){
        e.preventDefault();
        let parent = $(this).parents('.cart-items__product');
        let id_type = parent.find('.cart-product__link').attr('name');

        $.ajax({
            url:'cart/updateQuantity',
            method:'POST',
            data: {
                updateQtt: 'minus',
                id_type: id_type
            },
            success:function(data){
                if (data == 1) {
                    notification({  title: 'Warning',
                                    message: 'Kh??ng update ???????c',
                                    type: 'warning',
                                    duration: 3000});
                } else if (data == 2) {
                    notification({  title: 'Warning',
                                    message: 'Vui l??ng th???c hi???n l???i',
                                    type: 'warning',
                                    duration: 3000});
                } else {
                    notification({  title: 'Success',
                                    message: '???? update -1 trong gi??? h??ng',
                                    type: 'success',
                                    duration: 3000});
                }
                get_data();
            }
        })
    });

    function setCookie(name,value,days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    }

    $(document).on('blur', '#note', function(e) {
        e.preventDefault();
        setCookie('note', $(this).val(), 1);
    });
    // delete product in cart
    $(document).on('click','.btn-delete-prd-cart',function(e){
        e.preventDefault();
        let parent = $(this).parents('.cart-items__product');
        let id_type = parent.find('.cart-product__link').attr('name');
        // console.log(id_type)
        $.ajax({
            url: "cart/deleteCart",
                method: "POST",
                data: {
                    deleteCart: 'true',
                    id_type: id_type
                },
                success:function(data){
                    let json = JSON.parse(data);
                    if(json.Load == false){
                        if(json.ketQua == 1) {
                            notification({  title : 'Success',
                                            message : 'Delete s???n ph???m th??nh c??ng',
                                            type : 'success',
                                            duration : 3000});
                        } else {
                            notification({  title : 'Error',
                                            message : 'Delete s???n ph???m th???t b???i',
                                            type : 'error',
                                            duration : 3000});
                        }
                    }else{
                        window.location='home';
                    }
                    get_data();
                }
        })
    });

    // validated input quantity
    $(document).on('keypress','.product-quantity-value',function(e){
        return e.charCode >= 48 && e.charCode <= 57;
    });

    // update quantity after input
    $(document).on('blur','.product-quantity-value-val',function(e) {
        e.preventDefault();
        let value = $(this).val();
        let id_type = $(this).attr('id');

        if (value < 1) {
            value = 1;
        }

        $.ajax({
            url:'cart/updateQtt',
            method:'POST',
            data: {
                updateQtt: 'true',
                quantity: value,
                id_type: id_type
            },
            success:function(data) {
                if(data == 1){
                    notification({  title: 'Th??ng b??o',
                            message: 'N???u b???n mua ?????t ????n h??ng s??? l?????ng l???n vui l??ng ibox fanpage ????? ???????c h??? tr??? !!',
                            type: 'info',
                            duration: 10000});
                }else if(data == 2){
                    notification({  title : 'Error',
                                    message : 'C???p nh???t s??? l?????ng th???t b???i',
                                    type : 'error',
                                    duration : 3000});
                }else if(data == ""){
                    
                }else{
                    notification({  title : 'Success',
                                    message : 'C???p nh???t s??? l?????ng th??nh c??ng',
                                    type : 'success',
                                    duration : 3000});
                }
                get_data();
            }
        })
        
    });
    
})