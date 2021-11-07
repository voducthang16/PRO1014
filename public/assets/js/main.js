// Header
document.addEventListener('scroll', () => {
    const navbar = document.querySelector('.navbar');
    const slide = document.querySelector('.slide');
    navbar.classList.toggle('sticky', window.scrollY > 200);
    slide.classList.toggle('sticky', window.scrollY > 200);

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
    $(".owl-carousel").owlCarousel({
        items: 1,
        loop: true,
        nav: true,
        dots: true,
        // autoplay: true,
        autoplaySpeed: 1000,
        smartSpeed: 500,
        autoplayHoverPause: true
    });
});