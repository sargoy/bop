// Yandex Delivery-Map
function initDeliveryMap() {
    let myMap = new ymaps.Map('delivery_map', {
            center: [55.753774, 37.620147],
            zoom: 10,
            controls: ['geolocationControl', 'searchControl', 'zoomControl']
        }),
        deliveryPoint = new ymaps.GeoObject({
            geometry: {type: 'Point'},
            properties: {iconCaption: 'Адрес'}
        }, {
            preset: 'islands#blackDotIconWithCaption',
            draggable: true,
            iconCaptionMaxWidth: '215'
        }),
        location = ymaps.geolocation,
        searchControl = myMap.controls.get('searchControl');
    searchControl.options.set({noPlacemark: true, placeholderContent: 'Введите адрес доставки'});
    myMap.geoObjects.add(deliveryPoint);
    myMap.behaviors.disable('scrollZoom');
    function highlightResult(obj) {
        // Сохраняем координаты переданного объекта.
        let coords = obj.geometry.getCoordinates(),
            // Находим полигон, в который входят переданные координаты.
            polygon = deliveryZones.searchContaining(coords).get(0);
        if (polygon) {
//      $('#shipping_method input').removeAttr('checked');
            switch(polygon.properties.get('rest')) {
                case 'Сокол':
                    $('#place_order').show();
//          $('#shipping_method_0_free_shipping-4').attr('checked', 'checked');
                    // console.log($('#shipping_method_0_free_shipping-4'));
                    break;
                case 'Марьино':
                    $('#place_order').show();
//          $('#shipping_method_0_flat_rate-2').attr('checked', 'checked');
                    // console.log($('#shipping_method_0_flat_rate-2'));
                    break;
            }
            // Уменьшаем прозрачность всех полигонов, кроме того, в который входят переданные координаты.
            deliveryZones.setOptions('fillOpacity', 0.4);
            polygon.options.set('fillOpacity', 0.8);
            // Перемещаем метку с подписью в переданные координаты и перекрашиваем её в цвет полигона.
            deliveryPoint.geometry.setCoordinates(coords);
            deliveryPoint.options.set('iconColor', polygon.options.get('fillColor'));
            // Задаем подпись для метки.
            if (typeof(obj.getThoroughfare) === 'function') {
                setData(obj);
            } else {
                // Если вы не хотите, чтобы при каждом перемещении метки отправлялся запрос к геокодеру,
                // закомментируйте код ниже.
                ymaps.geocode(coords, {results: 1}).then(function (res) {
                    let obj = res.geoObjects.get(0);
                    setData(obj);
                });
            }
        } else {
            $('.shipping_method').removeAttr('checked');
            $('.place_order_hook').hide();
            showError('Адрес не обслуживается!');
            // Если переданные координаты не попадают в полигон, то задаём стандартную прозрачность полигонов.
            deliveryZones.setOptions('fillOpacity', 0.4);
            // Перемещаем метку по переданным координатам.
            deliveryPoint.geometry.setCoordinates(coords);
            // Задаём контент балуна и метки.
            deliveryPoint.properties.set({
                iconCaption: 'Адрес не обслуживается!',
                balloonContent: 'Cвяжитесь с оператором',
                balloonContentHeader: 'Доставка до этого адреса не осуществляется!'
            });
            // Перекрашиваем метку в чёрный цвет.
            deliveryPoint.options.set('iconColor', 'black');
        }
        function setData(obj){
            let address = [obj.getThoroughfare(), obj.getPremiseNumber(), obj.getPremise()].join(' ');
            if (address.trim() === '') {
                address = obj.getAddressLine();
            }
            deliveryPoint.properties.set({
                iconCaption: address,
                balloonContent: '<b>Адрес ресторана: </b>' + polygon.properties.get('name'),
                balloonContentHeader: '<b>Время доставки: </b>' + polygon.properties.get('time') + ' мин.'
            });
        }
    }
    // Добавляем полигоны на карту из файла data.json
    $.ajax({
        url: template_url + '/assets/js/data.json',
        dataType: 'json',
        success: function (json) {
            // Добавляем зоны на карту.
            deliveryZones = ymaps.geoQuery(json).addToMap(myMap);
            // Задаём цвет и контент балунов полигонов.
            deliveryZones.each(function (obj) {
                let color = obj.options.get('fillColor');
                let stroke = obj.options.get('stroke');
                obj.options.set({fillColor: color, fillOpacity: 0.4, stroke});
                obj.properties.set('balloonContent', obj.properties.get('name'));
                obj.properties.set('balloonContentHeader', 'Время доставки: ' + obj.properties.get('time') + ' мин.')
            });
            // Проверим попадание результата поиска в одну из зон доставки.
            searchControl.events.add('resultshow', function (e) {
                highlightResult(searchControl.getResultsArray()[e.get('index')]);
            });
            // Проверим попадание метки геолокации в одну из зон доставки.
            myMap.controls.get('geolocationControl').events.add('locationchange', function (e) {
                highlightResult(e.get('geoObjects').get(0));
            });
            // При перемещении метки сбрасываем подпись, содержимое балуна и перекрашиваем метку.
            deliveryPoint.events.add('dragstart', function () {
                deliveryPoint.properties.set({iconCaption: '', balloonContent: ''});
                deliveryPoint.options.set('iconColor', 'black');
            });
            // По окончании перемещения метки вызываем функцию выделения зоны доставки.
            deliveryPoint.events.add('dragend', function () {
                highlightResult(deliveryPoint);
            });
        }
    });
    // Подключаем поисковые подсказки к полю ввода.
    let suggestView = new ymaps.SuggestView('billing_address_1');
    // Убираем событие submit с клавиши enter для формы checkout
    $('#removeEnterEvent').keypress(e => {return e.keyCode != 13});
    // При событии инпута запускаем верификацию введёных данных.
    suggestView.events.add('select', function (e) {
        geocode(e.get('item').value)
    });
    function geocode(inputValue) {
        // Геокодируем введённые в input данные.
        ymaps.geocode(inputValue).then(function (res) {
            let obj = res.geoObjects.get(0),
                error, hint;
            if (obj) {
                // Об оценке точности ответа геокодера можно прочитать тут: https://tech.yandex.ru/maps/doc/geocoder/desc/reference/precision-docpage/
                switch (obj.properties.get('metaDataProperty.GeocoderMetaData.precision')) {
                    case 'exact':
                        break;
                    case 'number':
                    case 'near':
                    case 'range':
                        error = 'Неточный адрес, уточните номер дома';
                        break;
                    case 'street':
                        error = 'Неполный адрес, укажите номер дома';
                        break;
                    case 'other':
                        error = 'Неполный адрес, укажите улицу и номер дома';
                        break;
                    default:
                        error = 'Неточный адрес, требуется уточнение';
                }
            } else {
                error = 'Адрес не найден';
            }
            // Если геокодер возвращает пустой массив или неточный результат, то показываем ошибку.
            if (error) {
                showError(error);
            } else {
                showResult(obj);
            }
        }, function (e) {
            console.log(e)
        })
    }
    function showResult(obj) {
        // Удаляем сообщение об ошибке, если найденный адрес совпадает с поисковым запросом.
        $('#billing_address_1').removeClass('input_error');
        $('.gscheckbill label[for="billing_address_1"]').removeClass('has_error');
        // Проверим попадание метки геолокации в одну из зон доставки.
        highlightResult(obj);
    }
    function showError(message) {
        let showErrorMessage = $('.gscheckbill label[for="billing_address_1"]');
        $('#billing_address_1').addClass('input_error');
        showErrorMessage.addClass('has_error');
        showErrorMessage.text(message);
    }
}