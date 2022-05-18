$(document).ready(function() {
    $('.photo-modal-btn_cancel').click(function (e) {
        e.preventDefault();
        $('#photo-file-modal').val('');
        $('#photo-modal').modal('hide');
        $('.ajax-upload-img').attr('src', $('.ajax-upload-img').data('default-src'));
    });
    $('#photo-file-modal').change(function (e) {
        e.preventDefault();
        var file = $(this).val();
        if(file) {
            var formData = new FormData();
            formData.append("image", $('#photo-file-modal')[0].files[0]);
            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                url: '/local/ajax/temp_img.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function (result) {
                    if (result.succes) {
                        if (result.src) {
                            $('.ajax-upload-img').attr('src', result.src);
                            $('.photo-modal-btn_save').show();
                            Swal.fire({
                                title: result.title,
                                text: result.text,
                                icon: result.icon,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
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
        }
    });
});
