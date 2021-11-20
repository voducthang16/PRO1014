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
        })
        $.ajax({
            url: "checkout/showCheckout",
            method: "POST",
            success:function(data) {
                $('.checkout-product-list').html(data)
            }
        })
        $.ajax({
            url: "checkout/totalCheckout",
            method: "POST",
            success:function(data) {
                $('#checkout-subtotal-money').html(data)
                $('#order-total-money').html(data)
            }
        })
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
            alert('vui lòng nhập số lượng');
            return;
        }

        if(quantity > maxQtt){
            alert('nếu bạn muốn đặt đơn hàng sll vui lòng ib fanpage đễ được hỗ trợ');
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
                alert('vui lòng chọn size và color đầy đủ');
                return
            }
        } else {
            if (attributes_color == null) {
                alert('vui lòng chọn color đầy đủ');
                return
            }
        }

        if (attributes_size == null) {
            attributes_size = 0;
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
                    if (data == 'sign') {
                        window.location = "sign";
                    } else {
                        alert(data);
                        get_data();
                    }
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
                alert (data);
                get_data();
            }
        })
    })
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
                alert (data);
                get_data();
            }
        })
    })

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
                    alert (data);
                    get_data();
                }
        })
    });

    // validated input quantity
    $(document).on('keypress','.product-quantity-value',function(e){
        return e.charCode >= 48 && e.charCode <= 57;
    })

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
                alert (data);
                get_data();
            }
        })
        
    })
    
})