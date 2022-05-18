$(document).ready(function() {
    var inlineGallery = new Swiper ('#inlineGallery .swiper-catalog .swiper-container', {
        thumbs: {
            swiper: {
                el: '#inlineGallery .swiper-catalog-thumbs .swiper-container',
                slidesPerView: 5,
                direction: 'vertical',
                spaceBetween: 16
            }
        },
        loop: true
    });
    $('#modalGallery').on('shown.bs.modal', function(){
        var modalGallery = new Swiper ('#modalGallery .swiper-catalog .swiper-container', {
            thumbs: {
                swiper: {
                    el: '#modalGallery .swiper-catalog-thumbs .swiper-container',
                    slidesPerView: 5,
                    direction: 'vertical',
                    spaceBetween: 16
                }
            },
            pagination: {
                el: '.swiper-pagination',
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            loop: true
        });
        var index = $('#inlineGallery .swiper.swiper-catalog .swiper-slide.swiper-slide-active').data('swiper-slide-index');
        if(index) {
            modalGallery.slideToLoop(index);
        }
    });
    $('#modalGallery button.close').on('click', function () {
        $('#modalGallery').modal('hide');
    });
    $('.product-tabs.btn-group-toggle input[type="radio"]').change(function (e) {
        e.stopPropagation();
        console.log($(this).val());
        $('.product-tabs.btn-group-toggle .btn.btn-outline-light, .tab-content.product-tabs-content .tab-pane').removeClass('active').removeClass('show');
        if($(this).prop('checked')) {
            $(this).closest('label').addClass('active');
            $('.tab-content.product-tabs-content .tab-'+$(this).val()).addClass('active').addClass('show');
            $('.product-tabs.btn-group-toggle input[type="radio"]').prop('checked', false);
            $(this).prop('checked', true);
        }
    });
    $('.catalog-view-controls input[type="radio"]').change(function (e) {
        var mode = $(this).val();
        console.log(mode);
        if (mode == 'grid') {
            $('.row.catalog-items').removeClass('catalog-items-table').addClass('catalog-items-grid');
            $('.row.catalog-items>div').removeClass().addClass('col-lg-6 col-xl-4 col-12 mb-3 mb-lg-30');
        } else {
            $('.row.catalog-items').removeClass('catalog-items-grid').addClass('catalog-items-table');
            $('.row.catalog-items>div').removeClass().addClass('col-lg-12 col-xl-12 col-12 mb-2');
        }
        $.cookie('zlojViewMode', mode);
        $('.catalog-view-controls label').removeClass('active');
        $(this).closest('label').addClass('active');
    });
    $('.dropdown.b-dropdown .btn.dropdown-toggle').click(function () {
        $(this).next('.dropdown-menu').toggle();
        $(this).toggleClass('active');
    });
    $('#sidebar-load-props button.close').click(function (e) {
        $('#sidebar-load-props').hide();
        $('body').removeClass('menu-open');
    });
    $('#btn-load-props').click(function (e) {
        var loaded = $(this).data('loaded');
        if(!loaded){
            var title, html;
            title = '<p class="font-weight-medium">О товаре</p>';
            html = $('.tab-2 .in-content').html();
            if(html) {
                $('.to-tab-2').html(title + html);
                console.log(html);
            }
            title = '<p class="font-weight-medium">Характеристики</p>';
            html = '';
            $('.tab-1 tr').each(function(index, value) {
                html += '<li><span class="title">' + $(this).find('.prop-title').html() + '</span><span class="value">' + $(this).find('.prop-value').html() + '</span></li>';
            });
            if(html) {
                html = '<ul class="list-unstyled list-specs">' + html + '</ul>';
                $('.to-tab-1').html(title + html);
                console.log(html);
            }
            title = '<p class="font-weight-medium">Документация</p>';
            html = $('.tab-4 .in-content').html();
            if(html) {
                $('.to-tab-4').html(title + html);
                console.log(html);
            }
            $(this).data('loaded', 1);
        }
        $('#sidebar-load-props').show();
        $('body').addClass('menu-open');
    });
    $('#modalReview button.close').on('click', function () {
        $('#modalReview').modal('hide');
    });
    $('.review-comments-open').on('click', function (e) {
        e.stopPropagation();
        $('.product-review[data-review-id="'+$(this).data('review-id')+'"]').toggle('fast');
        return false;
    });
    $('.review-comments-form-open').on('click', function (e) {
        e.stopPropagation();
        var element = $('.review-comments-form[data-review-id="'+$(this).data('review-id')+'"]');
        if($(this).data('toggle')){
            element.toggle('fast');
        }else {
            element.show('fast');
            var scroll = element.offset().top - (($(window).height() - element.height()) / 2);
            $(window).scrollTop(scroll);
        }
        return false;
    });
    $('#form-rewiew-new .custom-styled-radio label').on('click', function () {
        $('#form-rewiew-new .custom-styled-radio label').each(function(index, value) {
            $(this).removeClass('active');
            $(this).find('input[type="radio"]').prop('checked', false);
        });
        $(this).find('input[type="radio"]').prop('checked', true);
        var val = $(this).data('value');
        for(var i = 1; i <= 5; i ++){
            if(i <= val){
                $('#form-rewiew-new .custom-styled-radio label[data-value="'+i+'"]').addClass('active');
            }else{
                $('#form-rewiew-new .custom-styled-radio label[data-value="'+i+'"]').removeClass('active');
            }
        }
    });
    $("#form-rewiew-new").submit(function() {
        var form_data = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: '/local/ajax/review.php',
            data: form_data,
            success: function(result) {
                if (result.succes) {
                    if(result.icon == 'success') {
                        $("#form-rewiew-new").find('input:text, input:password, input:file, select, textarea').val('');
                        $("#form-rewiew-new").find('input:radio, input:checkbox').prop('checked', false);
                        $("#form-rewiew-new").find('label').removeClass('active');
                        $('#modalReview').modal('hide');
                    }
                    Swal.fire({
                        title: result.title,
                        text: result.text,
                        icon: result.icon,
                        confirmButtonText: 'Перейти на страницу отзывов',
                    }).then((button) => {
                        if (result.url) {
                            window.location.href = result.url;
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Ошибка!',
                        text: 'К сожалению с отправкой временные трудности.',
                        icon: 'error'
                    });
                }
            },
            error: function () {
                Swal.fire({
                    title: 'Ошибка!',
                    text: 'К сожалению с отправкой временные трудности.',
                    icon: 'error'
                });
            },
            timeout: function () {
                Swal.fire({
                    title: 'Ошибка!',
                    text: 'К сожалению с отправкой временные трудности.',
                    icon: 'error'
                });
            }
        });
        return false;
    });
    $('.fast-rewiews-filter a').on('click', function (e) {
        //e.stopPropagation();
        var rating = $(this).data('rating');
        if(rating){
            for(var i = 1; i <= 5; i ++){
                if(i == rating){
                    $('.class'+i+'star').show('fast');
                }else {
                    $('.class'+i+'star').hide('fast');
                }
            }
        }
        return false;
    });
    var hash = window.location.hash;
    if(hash){
        $('.fast-rewiews-filter.first-filter a[data-href="'+hash+'"]').trigger('click');
    }
});