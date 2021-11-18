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

if (quantityValue) {
    quantityValue.onchange = function () {
        if (this.value < 0) {
            this.value = 1;
        }
    }
}
const $ = document.querySelector.bind(document);
const $$ = document.querySelectorAll.bind(document);

const tabs = $$(".tab-item");
const panes = $$(".tab-pane");

const tabActive = $(".tab-item.active");
const line = $(".tabs .line");

line.style.left = tabActive.offsetLeft + "px";
line.style.width = tabActive.offsetWidth + "px";

tabs.forEach((tab, index) => {
  const pane = panes[index];

  tab.onclick = function () {
    $(".tab-item.active").classList.remove("active");
    $(".tab-pane.active").classList.remove("active");

    line.style.left = this.offsetLeft + "px";
    line.style.width = this.offsetWidth + "px";

    this.classList.add("active");
    pane.classList.add("active");
  };
});
