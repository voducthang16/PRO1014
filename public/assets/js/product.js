$(document).ready(function() {
    
    //change image
    const slideImages = document.querySelectorAll(".product-slide-image");

    slideImages.forEach((slide, index) => {
        slide.onclick = function() {
            document.querySelector('.product-slide-image.active').classList.remove('active');

            this.classList.add('active');

            document.querySelector('#product-thumbnail').src = this.src;
            $('.background-zoom').css("background-image","url('"+this.src+"')") ; 
        }
    })

    // js change quantity
    const changeQuantityButton = document.querySelectorAll('.quantity-btn');
    const quantityValue = document.querySelector('.product-quantity-value');
    changeQuantityButton.forEach(e => {
        e.onclick = function () {
            if (this.classList.contains('quantity-minus')) {
                if (quantityValue.value == 1) {
                    quantityValue.value = 1;
                } else {
                    quantityValue.value = +quantityValue.value - 1;
                }
            } else {
                quantityValue.value = +quantityValue.value + 1;
            }
        }
    });

    // fetch data count quantity product
    $(document).on('change','.radio-box-get-quantity',function(e) {
        e.preventDefault();
        let prdColor = 0;
        let prdSize = 0;
        let parent = $(this).parents('.products-p');
        let id_product = parent.find('.products-id').val();
        let id_category = parent.find('.products-category-id').val();

        let color = parent.find('.attributes-color-input');
        for(var i = 0; i < color.length; i++) {
            if(color[i].checked === true) {
                prdColor = color[i].value;
            }
        }

        let size = parent.find('.attributes-size-input');
        for(var i = 0; i < size.length; i++) {
            if(size[i].checked === true) {
                prdSize = size[i].value;
            }
        }

        if (id_category != 5){
            if(prdColor == 0 || prdSize == 0){
                return;
            }
        }
        
        // alert(prdColor +'\n'+ prdSize +'\n'+ id_category +'\n'+ id_product)

        $.ajax({
            url: "product/getProductTypeId",
                method: "POST",
                data: {
                    get_quantity: 'true',
                    id_product: id_product,
                    id_color: prdColor,
                    id_size: prdSize,
                    id_category: id_category,
                },
                success:function(data) {
                    let json = JSON.parse(data);
                    parent.find('#type_quantity').html(json.quantity);
                    parent.find('.price-sale-value').html(json.price_sale +'đ');
                    parent.find('.price-origin-value').html(json.price_origin +'đ')
                    // alert(json.price_sale +'\n'+ json.price_origin +'\n'+json.quantity)
                }
        });
    })

    $('.btn-add-to-wishlist').click(function(e){
        e.preventDefault();
        let parent = $(this).parents('.products-s');
        let id_product = parent.find('.products-id').val();
        $.ajax({
            url: "account/addWishList",
                method: "POST",
                data: {
                    'action': 'addWishList',
                    'id_product': id_product
                },
                success:function(data) {
                    if (data == "sign") {
                        window.location = "sign";
                    } else {
                        alert(data);
                        get_data();
                    }
                }
        });
    })

})

function zoom(e) {
    var zoom = e.currentTarget;
    e.offsetX ? offsetX = e.offsetX : offsetX = e.touches[0].pageX
    e.offsetY ? offsetY = e.offsetY : offsetX = e.touches[0].pageX
    x = (offsetX / zoom.offsetWidth) * 100
    y = (offsetY / zoom.offsetHeight) * 100
    zoom.style.backgroundPosition = x + "% " + y + "%";
}