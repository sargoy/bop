let form = $('#form__register'),
    emailID = '#email__field',
    loginID = '#login__field';

form.find(loginID).val($(emailID).val());
form.find('#pass_id').val();

$(emailID).on('change', e => {
    form.find(loginID).val($(e.target).val())
})

function CountPass(item) {
    let item_view = 'pass_view',
        item_correct = 'pass_correct';

    document.getElementById(item_view).innerHTML = document.getElementById(item).value.length++;
//если символов 6 и более
    if (document.getElementById(item).value.length >= 6) {
        document.getElementById(item_correct).style.color = 'green';
    }
//Если смволов меньше шести
    else {
        document.getElementById(item_correct).style.color = 'red';
    }
}

function CorrectPass(item) {
//Проверяем совпадение пароля с полем ввода пароля
    let item_pass_value = document.getElementById('pass_id').value,
        item_pass_length = document.getElementById('pass_id').value.length,
        item_correct = 'repass_correct';
    if (item_pass_length >= 6) {

        if (document.getElementById(item).value == item_pass_value) {
            document.getElementById(item_correct).style.color = 'green';
            document.getElementById(item_correct).innerHTML = 'Пароли совпадают';
            document.getElementById('check_repass').value = 1;
        }

        else if (document.getElementById(item).value.length >= 6) {
            document.getElementById(item_correct).style.color = 'red';
            document.getElementById(item_correct).innerHTML = 'Пароли не совпадают!';
            document.getElementById('check_repass').value = 0;
        } else {
            document.getElementById(item_correct).style.color = 'red';
            document.getElementById(item_correct).innerHTML = 'Минимальное количество 6 символов';
        }
    }
}