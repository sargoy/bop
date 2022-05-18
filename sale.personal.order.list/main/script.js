$(document).ready(function() {
    $('#ajax-load-orders-button').click(function (e) {
        e.stopPropagation();
        var button = $(this);
        var url = button.data('href');
        if (url) {
            if(!button.hasClass('busy')) {
                button.addClass('busy');
                $.ajax({
                    url: url,
                    data: {
                        zlojAjaxRequest: 'y'
                    },
                    type: 'POST',
                    success: function (result) {
                        var href = $(result).find('#ajax-load-orders-button').data('href');
                        if(href) {
                            $('#ajax-load-orders-button').data('href', $(result).find('#ajax-load-orders-button').data('href'));
                        }else{
                            $('#ajax-load-orders-button').remove();
                        }
                        var items = $(result).find('#ajax-load-orders-wrap').html();
                        $('#ajax-load-orders-wrap').append(items);
                        var title = $(result).find('title').text();
                        button.removeClass('busy');
                    },
                    error: function () {
                        console.log('Ошибка запроса 1');
                        button.removeClass('busy');
                    },
                    timeout: function () {
                        console.log('Ошибка запроса 2');
                        button.removeClass('busy');
                    }
                });
            }
        }
    });
});
