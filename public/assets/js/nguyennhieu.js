$(document).ready(function(){

    function get_data(){
        $.ajax({
            url: "cart/showCart",
            method: "POST",
            success:function(data){
                $('.cart-items__list').html(data);
                cart_quantity();
            }
        });
    }

    get_data();

    $(document).on('click','.btn-add-cart',function(e){
        e.preventDefault();
        var parent = $(this).parents('.products');
        var id_product = parent.find('.products-id').val();
        // console.log(id_product);
        var color = parent.find('.attributes-color-input');
        for(var i=0; i<color.length;i++){
            if(color[i].checked === true){
                // console.log(checkbox[i].value);
                var attributes_color = color[i].value;
            }
        }
        var size = parent.find('.attributes-size-input');
        for(var i=0; i<size.length;i++){
            if(size[i].checked === true){
                // console.log(checkbox[i].value);
                var attributes_size = size[i].value;
            }
        }
        $.ajax({
            url: "cart/insertCart",
                method: "POST",
                data: {
                    insertCart: 'true',
                    id_product: id_product,
                    id_color: attributes_color,
                    id_size: attributes_size
                },
                success:function(data){
                    alert (data);
                }
        });
        get_data();
        cart_quantity();
    });
    $(document).on('click','.btn-delete-prd-cart',function(e){
        e.preventDefault();
        var parent = $(this).parents('.cart-items__product');
        var id_type = parent.find('.cart-product__link').attr('name');
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
                }
        })
        get_data();
        cart_quantity();
    });

    function cart_quantity(){
        let cart_quantity = document.getElementsByClassName('cart-items__product');
        document.getElementById('cart-quantity-val').innerHTML = cart_quantity.length;
    };
})