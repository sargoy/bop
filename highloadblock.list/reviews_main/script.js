$(document).ready(function () {
    var mainSwiper = new Swiper ('.swiper-reviews .swiper-container', {
        pagination: {
            el: '.swiper-pagination',
        },
        slidesPerView: 1,
        spaceBetween: 0,
        breakpoints: {
            768: {
                slidesPerView: 2,
                slidesPerView: 2,
                spaceBetween: 15,
            },
            992: {
                slidesPerView: 3,
                slidesPerView: 3,
                spaceBetween: 20,
            },
            1200: {
                slidesPerView: 4,
                slidesPerView: 4,
                spaceBetween: 30,
            }
        },
        loop: true
    });
});