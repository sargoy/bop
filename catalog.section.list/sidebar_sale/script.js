$(document).ready(function() {
    $('.collapse-catalog-sidebar .collapse-toggle').click(function () {
        var id = $(this).data('id');
        if(id) {
            var div = $('.collapse-catalog-sidebar .collapse[data-root-id="' + id + '"]');
            if (div.hasClass('show')) {
                window.location.href = $(this).data('href');
                //div.hide().removeClass('show');
                //$(this).addClass('collapsed');
            } else {
                $('.collapse-catalog-sidebar .collapse-toggle').addClass('collapsed');
                $('.collapse-catalog-sidebar .collapse.show').hide('fast').removeClass('show');
                div.show('fast').addClass('show');
                $(this).removeClass('collapsed');
            }
        }else {
            window.location.href = $(this).data('href');
        }
    });
    if ($(document).width() < 767) {
        $('.catalog-sidebar-toggle').click( e => {
            $('.catalog-sidebar-close').fadeIn();
            $('.catalog-sidebar').toggleClass('show')
            $('body').toggleClass('body-mobile-catalog__sidebar--active')
        });
        $('.catalog-sidebar-close').click( e => {
            $('.catalog-sidebar-close').fadeOut(10);
            $('.catalog-sidebar').removeClass('show');
            $('body').removeClass('body-mobile-catalog__sidebar--active');
        })
        // $('.catalog-sidebar .backlink svg').hide();
        $('.catalog-sidebar .backlink').click( e => {
            e.preventDefault();
            $('.collapse-catalog-sidebar').slideToggle(10);
        })
    }
});
