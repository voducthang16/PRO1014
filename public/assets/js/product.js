const slideImages = document.querySelectorAll(".product-slide-image");

slideImages.forEach((slide, index) => {
    slide.onclick = function() {
        document.querySelector('.product-slide-image.active').classList.remove('active');

        this.classList.add('active');

        document.querySelector('#product-thumbnail').src = this.src;
    }
})