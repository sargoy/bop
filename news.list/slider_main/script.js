$(document).ready(function () {
    var mainSwiper = new Swiper ('.swiper-main .swiper-container', {
        pagination: {
            el: '.swiper-pagination',
        },
        navigation: {
            nextEl: '.swiper-main .swiper-button-next',
            prevEl: '.swiper-main .swiper-button-prev',
        },
        loop: true,
        autoplay: {
            delay: 5000,
        }
    });
});