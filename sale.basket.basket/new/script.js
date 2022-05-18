function showHide(id) {
    let cres = document.querySelector('#cart-item-removed_'+id);
    cres.style.display = 'none';
}
function initFavProducts(element, active) {
    $.ajax({
        url: '/local/ajax/fav.php',
        data: {
            element: element,
            active: active
        },
        success: function (result) {
            if (result.succes) {
                if (result.ok) {
                    if (active === 'remove') {
                        $('.element-fav[data-element-id="' + element + '"]').removeClass('active').html('В избранное');
                    } else {
                        $('.element-fav[data-element-id="' + element + '"]').addClass('active').html('Удалить из избранного');
                    }
                }
                if (result.fav_items > 0) {
                    $('#top-fav-icon').addClass('active');
                    return result.fav_items;
                } else {
                    $('#top-fav-icon').removeClass('active');
                    $('.empty-favorites').show();
                }
            } else {
                Swal.fire({
                    title: 'Ошибка!',
                    text: 'К сожалению с добавлением в избранное временные трудности.',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        },
        error: function () {
            Swal.fire({
                title: 'Ошибка!',
                text: 'К сожалению с добавлением в избранное временные трудности.',
                icon: 'error',
                showConfirmButton: false,
                timer: 1500
            });
        },
        timeout: function () {
            Swal.fire({
                title: 'Ошибка!',
                text: 'К сожалению с добавлением в избранное временные трудности.',
                icon: 'error',
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
}
function toFav(id) {
    let element = id;
    let active = $('.element-fav[data-element-id="' + id + '"]').hasClass('active') ? 'remove' : 'add';
    initFavProducts(element, active);
}
/*
function test(id) {
    let quant = document.querySelector('#basket-item-quantity-' + id).innerHTML;
    // let quant1 = document.querySelector('#top-basket-cnt').innerHTML;
    let str = document.querySelector('.basket-items-list-header-filter-item.active');
    let num = parseInt(str.innerHTML.match(/\d+/))
    str.innerHTML = num - quant;
    // return false;
    // alert(dif);
}*/
