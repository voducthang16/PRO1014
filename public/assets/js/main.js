// Header
document.addEventListener('scroll', () => {
    const navbar = document.querySelector('.navbar');
    navbar.classList.toggle('sticky', window.scrollY > 200);

    if (document.querySelector(".category")) {
        const category = document.querySelector(".category");
        category.classList.toggle("sticky", window.scrollY > 200);
    }

    if (document.querySelector(".wishlist-page")) {
        const wishlist = document.querySelector(".wishlist-page");
        wishlist.classList.toggle("sticky", window.scrollY > 200);
    }

    if (document.querySelector(".order-page")) {
        const order = document.querySelector(".order-page");
        order.classList.toggle("sticky", window.scrollY > 200);
    }

    if (document.querySelector(".profile-page")) {
        const profile = document.querySelector(".profile-page");
        profile.classList.toggle("sticky", window.scrollY > 200);
    }
    
    if (document.querySelector(".checkout")) {
        const checkout = document.querySelector(".checkout");
        checkout.classList.toggle("sticky", window.scrollY > 200);
    }

    if (document.querySelector(".cart-page")) {
        const cart_page = document.querySelector(".cart-page");
        cart_page.classList.toggle("sticky", window.scrollY > 200);
    }

    if (document.querySelector(".product")) {
        const product = document.querySelector(".product");
        product.classList.toggle("sticky", window.scrollY > 200);
    }

    if (document.querySelector(".error-404")) {
        const errorPage = document.querySelector(".error-404");
        errorPage.classList.toggle("sticky", window.scrollY > 200);
    }

    if (document.querySelector('.slide')) {
        const slide = document.querySelector('.slide');
        slide.classList.toggle('sticky', window.scrollY > 200);
    }

    if (document.querySelector('.sign')) {
        const sign = document.querySelector('.sign');
        sign.classList.toggle('sticky', window.scrollY > 200);
    }

    const scrollToTop = document.querySelector('.scroll-to-top')
    scrollToTop.classList.toggle('active', window.scrollY > 76);
    scrollToTop.addEventListener('click', () => {
        window.scrollTo({
            top: 0
        });
    })
});

const expand = document.querySelector('.expand');
const navbarMenu = document.querySelector('.navbar-menu');
expand.onclick = () => {
    navbarMenu.classList.toggle('active');
}


const texts = document.querySelector('.animate-text').children;
const textsLength = texts.length;
const textInnerTime = 3000;
const textOuterTime = 2800;

let index = 0;

function animateText() {
    for (let i = 0; i < textsLength; i++) {
        texts[i].classList.remove('text-in', 'text-out');
    }

    texts[index].classList.add('text-in');

    setTimeout(() => {
        texts[index].classList.add('text-out');
    }, textOuterTime);

    setTimeout(() => {
        if (index == textsLength - 1) {
            index = 0;
        } else {
            index++;
        }
        animateText();
    }, textInnerTime);
}

window.onload = animateText;

// Home Slider
$(document).ready(function(){
    $(".home-slide").owlCarousel({
        items: 1,
        loop: true,
        nav: true,
        dots: true,
        // autoplay: true,
        autoplaySpeed: 1000,
        smartSpeed: 500,
        autoplayHoverPause: true,
    });
    // $(".home-hoodie-slide").owlCarousel({
    //     items: 3,
    //     loop: true,
    //     nav: true,
    //     dots: true,
    //     // autoplay: true,
    //     autoplaySpeed: 1000,
    //     smartSpeed: 500,
    //     autoplayHoverPause: true
    // });
});


