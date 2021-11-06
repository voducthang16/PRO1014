document.addEventListener('scroll', () => {
    const scrollToTop = document.querySelector('.scroll-to-top')
    scrollToTop.classList.toggle('active', window.scrollY > 76);
    scrollToTop.addEventListener('click', () => {
        window.scrollTo({
            top: 0
        });
    })
});

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

// const cart = document.querySelector('.cart');
// const cartItems = document.querySelector('.cart-items');
// console.log(cartItems.parentNode);
// cart.onmouseover = () => {
//     cartItems.classList.add('active');
// }
// window.onmousemove = (e) => {
//     let targetElement = e.target;
//     do {
//         if (targetElement === cart) {
//             console.log(targetElement === cart)
//             return;
//         }
//         // tìm parent element
//         targetElement = targetElement.parentNode;
//     } while (targetElement);
//     cartItems.classList.remove('active');
// }
// cart.onmouseout = () => {
//     // console.log('out');
//     cartItems.classList.remove('active');
// }

