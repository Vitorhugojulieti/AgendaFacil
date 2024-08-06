import Swiper from 'https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.mjs';

document.addEventListener('DOMContentLoaded', function () {
    const swiper = new Swiper('.swiper-container', {
        direction: 'horizontal', // ou 'vertical'
        slidesPerView: 1, // Número de slides por vez
        loop: true,
        pagination: {
            el: '.swiper-pagination',
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
});