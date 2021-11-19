$(document).ready(function() {
    const slideImages = document.querySelectorAll(".product-slide-image");

    slideImages.forEach((slide, index) => {
        slide.onclick = function() {
            document.querySelector('.product-slide-image.active').classList.remove('active');

            this.classList.add('active');

            document.querySelector('#product-thumbnail').src = this.src;
        }
    })

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
                    // console.log(data);
                    $('#type_quantity').html(data);
                }
        });

    })

})