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

quantityValue.onchange = function () {
    if (this.value < 0) {
        this.value = 1;
    }
}