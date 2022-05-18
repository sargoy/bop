BX.namespace('BX.Sale.OrderAjaxComponent.Maps');

(function() {

	BX.Sale.OrderAjaxComponent.Maps = {
		init: function(ctx)
		{
			this.context = ctx || {};
			this.pickUpOptions = this.context.options.pickUpMap;
			this.propsOptions = this.context.options.propertyMap;
			this.maxWaitTimeExpired = false;
			return this;
		},
		//	Delivery Custom Map
		initDeliveryMap: function(selected, globalObj)
		{
			// Инициализация карты
			var custDeliveryMap = new ymaps.Map('delivery_custom_map', {
					center: [55.753774, 37.620147],
					zoom: 8,
					controls: ['geolocationControl', 'searchControl', 'zoomControl']
				}),

				// Инициализируем стандартные значения для метки
				deliveryPoint = new ymaps.GeoObject({
						geometry: {type: 'Point'},
						properties: {}
					},
					{
						preset: 'islands#blueDotIcon',
						draggable: true,
						iconCaptionMaxWidth: '215'
					}),

				// Подключаем поиск текущего местоположения.
				location = ymaps.geolocation,

				// Инициализируем переменную зон для глобальной области видимости
				deliveryZones = {};

			// Подключаем Поиск на карту.
			searchControl = custDeliveryMap.controls.get('searchControl');

			// Проверка поля адреса в зависимости от типа плательщика для установки подсказок
			if (document.getElementById('soa-property-19') !== null) {
				var addressField = 'soa-property-19';
			} else {
				var addressField = 'soa-property-7';
			}
			// Подключаем поисковые подсказки к полю ввода.
			var suggestView = new ymaps.SuggestView(addressField);


			// Настройки для поиска на карте
			searchControl.options.set({
				noPlacemark: true,
				placeholderContent: 'Введите адрес доставки'
			});
			// Добавление метки на карте
			custDeliveryMap.geoObjects.add(deliveryPoint);
			// Отключение зума на карте при скролле
			// custDeliveryMap.behaviors.disable('scrollZoom');

			// Функция проверяет координаты полученного объекта на зону доставки
			function highlightResult(obj) {

				// Сохраняем координаты переданного объекта.
				var coords = obj.geometry.getCoordinates();

				// обрезка долготы и широты до 8-ти значной концовки
				// coords = [coords[0].toPrecision(8), coords[1].toPrecision(8)]

				// Находим полигон, в который входят переданные координаты.
				var	polygon = deliveryZones.searchContaining(coords).get(0);

				// Устанавливаем метку на карту и задаем цвет
				deliveryPoint.geometry.setCoordinates(coords);

				// Устанавка координат метки в скрытое поле координаты метки
				$('#soa-property-71').val(coords);

				// Если точка в зоне полигона
				if (polygon) {

					// Выделяем активную зону увеличивая прозрачность
					// deliveryZones.setOptions('fillOpacity', 0.4);
					// polygon.options.set('fillOpacity', 0.8);

					// Устанавливаем цвет метки
					deliveryPoint.options.set('iconColor', '#04BECA');

					// Если тип function который возвращает путь сообщения (улица, шоссе, проезд и т.д.), которому принадлежит топоним
					if (typeof obj.getThoroughfare === 'function') {
						setData(obj);
					} else {
						// иначе используем обратное геокодирование
						ymaps.geocode(coords, {results: 1}).then(function (res) {
							var obj = res.geoObjects.get(0);
							setData(obj);
						});
					}
				} else {
					// Иначе координаты не попадают в полигон.

					// Выводим ошибку
					showError('Адрес не обслуживается!');

					// Задаём контент балуна и метки.
					deliveryPoint.properties.set({
						iconCaption: 'Адрес не обслуживается!',
						balloonContent: 'Cвяжитесь с оператором',
						balloonContentHeader: 'Доставка до этого адреса не осуществляется!'
					});
					// Перекрашиваем метку
					deliveryPoint.options.set('iconColor', '#4A969B');
				}

				// Функция получает объект метки, получает полный адрес и сверяется с id зоны доставки текущего полигона и id текущей выбранной доставки
				function setData(obj) {

					// Получаем полный адрес
					var address = obj.getAddressLine();

					// Устанавливаем адрес в поле ввода адреса
					$('#'+addressField).val(address + ' ');

					// Устанавливаем адрес в поле поиска на карте
					$('.ymaps-2-1-77-searchbox-input__input').val(address+' ');

					// Если есть id зоны доставки текущего полигона и id текущей выбранной доставки неравно id зоны доставки текущего полигона
					if (polygon.properties.get('cardId') && selected.ID !== polygon.properties.get('cardId')) {

						// Имитируем клик по выбранной доставке
						$('#ID_DELIVERY_ID_'+polygon.properties.get('cardId')).trigger('click');

						// Реализация смены доставки без перезагрузки
						// console.log(selected.ID);
						// console.log(polygon.properties.get('cardId'));
						// 	$('#ID_DELIVERY_ID_'+selected.ID).removeAttr('checked');
						// $('#bx-soa-delivery .bx-soa-pp-company.bx-selected')
						// 	.removeClass('bx-selected')
						// 	.hide();

						// $('#ID_DELIVERY_ID_'+polygon.properties.get('cardId'))
						// 	.attr('checked', 'true')
						// 	.closest('.bx-soa-pp-company')
						// 	.addClass('bx-selected')
						// 	.show();

						// selected.CHECKED = 'N';
						// selected.ID = polygon.properties.get('cardId');
						// selected.CHECKED = 'Y';
						// selected.PRICE = polygon.properties.get('price');
						// selected.PRICE_FORMATED = polygon.properties.get('price') + ' руб';

						// globalObj.sendRequest();

					}

					// Приближаем карту к метке
					custDeliveryMap.panTo(coords, {
						delay: 0,
						flying: false
					}).then(function () {
						custDeliveryMap.setZoom(17);
					})

					// Устанавливает центр карты на первом городе из списка
					// custDeliveryMap.setCenter(obj.geometry.getCoordinates(), 17);

					// console.log(selected);
					// console.log(globalObj);
					// console.log(polygon.properties.get('cardId'));

					// Задаём контент балуна и метки.
					deliveryPoint.properties.set({
						iconCaption: address,
						balloonContentHeader: '<b style="font-size: 14px">Информация по доставке</b>',
						balloonContent: '<b>Адрес: </b> ' + address + '<br class="mb-1">'+'<b style="font-size: 14px">Цена доставки: </b>' + '<span style="font-size: 16px">' + selected.PRICE_FORMATED + '</span>'
					});
				}

			}

			// Добавляем полигоны на карту из файла data.json
			BX.ajax({
				url:'/local/templates/new/components/bitrix/sale.order.ajax/intec.order-custom/scripts/dataDelivery.json',
				method: 'POST',
				dataType: 'json',
				onsuccess: function (json) {

					// Добавляем зоны на карту.
					deliveryZones = ymaps.geoQuery(json).addToMap(custDeliveryMap);

					// Задаём цвет и контент балунов полигонов.
					deliveryZones.each(function (obj) {
						var color = obj.options.get('fillColor');
						var stroke = obj.options.get('stroke');
						obj.options.set({
							fillColor: color,
							interactivityModel: "default#transparent",
							fillOpacity: 0.1,
							stroke,openBalloonOnClick: false,
							openHintOnHover: false,
							geodesic: true
						});
						obj.properties.set('balloonContent', obj.properties.get('description'));
						obj.properties.set('balloonContentHeader', 'Время доставки: ~' + obj.properties.get('delivery_time') + ' мин.');
					});
				}
			});

			// Проверка попадания результата поиска на карте в одну из зон доставки.
			searchControl.events.add('resultshow', function (e) {
				highlightResult(searchControl.getResultsArray()[e.get('index')]);
			});

			// Проверка попадания метки в одну из зон доставки.
			custDeliveryMap.controls.get('geolocationControl').events.add('locationchange', function (e) {
				highlightResult(e.get('geoObjects').get(0));
			});

			// При перемещении метки сбрасываем содержимое балуна.
			deliveryPoint.events.add('dragstart', function () {
				deliveryPoint.properties.set({iconCaption: ''});
				deliveryPoint.options.set('iconColor', '#4A969B');
			});

			// По окончании перемещения метки выделяем зоны доставки.
			deliveryPoint.events.add('dragend', function () {
				// geocode(deliveryPoint.geometry.getCoordinates())

				highlightResult(deliveryPoint);
			});

			// Если адрес подставился автоматически запускаем верификацию введёных данных.
			if ($('#'+addressField).val() !== '') {
				geocode($('#'+addressField).val()+' ');
			}

			// При событии инпута запускаем верификацию введёных данных.
			suggestView.events.add('select', function (e) {
				geocode(e.get('item').value+' ');
			});

			// При событии Клика по карте запускаем верификацию введёных данных.
			custDeliveryMap.events.add('click', function (e) {
				var coords = e.get('coords');
				coords = [coords[0].toPrecision(8), coords[1].toPrecision(8)]

				geocode(coords)

			});

			function geocode(inputValue) {
				deliveryPoint.properties.set('iconCaption', 'поиск...');
				// Геокодируем введённые в input данные.
				ymaps.geocode(inputValue, {kind: 'house'}).then(function (res) {
					var obj = res.geoObjects.get(0),
						error;

					// Верификация введенного адреса
					if (obj) {
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
						$('#'+addressField).val('')
						$('.ymaps-2-1-77-searchbox-input__input').val('');
						error = 'Неточный адрес, требуется уточнение';
					}

					// Если геокодер возвращает неточный адрес или пустой массив
					if (error) {
						showError(error);
					} else {
						removeError(obj);
					}
					// передаем данные о метке
					highlightResult(obj);
				}, function (err) {
					console.log(err);
				});
			}

			// Функция убирает вывод ошибки
			function removeError(obj) {
				// Удаляем сообщение об ошибке.
				$('#custom_tooltip-soa-property-7').detach();
			}

			// Функция выводит ошибки
			function showError(message) {
				deliveryPoint.properties.set('iconCaption', message);
				$('#custom_tooltip-soa-property-7').detach();
				$('#'+addressField).before('<div id="custom_tooltip-soa-property-7" class="bx-soa-tooltip bx-soa-tooltip-static bx-soa-tooltip-danger tooltip top" data-state="opened" style="opacity: 1; display: block;"><div class="tooltip-arrow"></div><div class="tooltip-inner">'+message+'</div></div>')
				console.log('error: ' + message);
			}
		},

		// default map
		initializePickUpMap: function(selected)
		{
			if (!ymaps)
				return;

			this.pickUpMap = new ymaps.Map('pickUpMap', {
				center: !!selected
					? [selected.GPS_N, selected.GPS_S]
					: [this.pickUpOptions.defaultMapPosition.lat, this.pickUpOptions.defaultMapPosition.lon],
				zoom: this.pickUpOptions.defaultMapPosition.zoom
			});

			this.pickUpMap.behaviors.disable(['rightMouseButtonMagnifier','scrollZoom','ruler','routeEditor']);

			this.pickUpMap.events.add('click', BX.delegate(function(){
				if (this.pickUpMap.balloon.isOpen())
				{
					this.pickUpMap.balloon.close();
				}
			}, this));
		},

		pickUpMapFocusWaiter: function()
		{
			if (this.pickUpMap && this.pickUpMap.geoObjects)
			{
				this.setPickUpMapFocus();
			}
			else
			{
				setTimeout(BX.proxy(this.pickUpMapFocusWaiter, this), 100);
			}
		},

		setPickUpMapFocus: function()
		{
			var bounds, diff0, diff1;

			bounds = this.pickUpMap.geoObjects.getBounds();
			if (bounds && bounds.length)
			{
				diff0 = bounds[1][0] - bounds[0][0];
				diff1 = bounds[1][1] - bounds[0][1];

				bounds[0][0] -= diff0/10;
				bounds[0][1] -= diff1/10;
				bounds[1][0] += diff0/10;
				bounds[1][1] += diff1/10;

				this.pickUpMap.setBounds(bounds, {checkZoomRange: true});
			}
		},

		showNearestPickups: function(successCb, failCb)
		{
			if (!ymaps)
				return;

			var provider = this.pickUpOptions.secureGeoLocation && BX.browser.IsChrome() && !this.context.isHttps
				? 'yandex'
				: 'auto';
			var maxTime = this.pickUpOptions.geoLocationMaxTime || 5000;

			ymaps.geolocation.get({
				provider: provider,
				timeOut: maxTime
			}).then(
				BX.delegate(function(result){
					if (!this.maxWaitTimeExpired)
					{
						this.maxWaitTimeExpired = true;

						result.geoObjects.options.set('preset', 'islands#darkGreenCircleDotIcon');
						this.pickUpMap.geoObjects.add(result.geoObjects);

						successCb(result);
					}
				}, this),
				BX.delegate(function() {
					if (!this.maxWaitTimeExpired)
					{
						this.maxWaitTimeExpired = true;

						failCb();
					}
				}, this)
			);
		},

		buildBalloons: function(activeStores)
		{
			if (!ymaps)
				return;

			var that = this;

			this.pickUpPointsJSON = [];

			for (var i = 0; i < activeStores.length; i++)
			{
				var storeInfoHtml = this.getStoreInfoHtml(activeStores[i]);

				this.pickUpPointsJSON.push({
					type: 'Feature',
					geometry: {type: 'Point', coordinates: [activeStores[i].GPS_N, activeStores[i].GPS_S]},
					properties: {storeId: activeStores[i].ID}
				});

				var geoObj = new ymaps.Placemark([activeStores[i].GPS_N, activeStores[i].GPS_S], {
					hintContent: BX.util.htmlspecialchars(activeStores[i].TITLE) + '<br />' + BX.util.htmlspecialchars(activeStores[i].ADDRESS),
					storeTitle: activeStores[i].TITLE,
					storeBody: storeInfoHtml,
					id: activeStores[i].ID,
					text: this.context.params.MESS_SELECT_PICKUP
				}, {
					balloonContentLayout: ymaps.templateLayoutFactory.createClass(
						'<h3>{{ properties.storeTitle }}</h3>' +
						'{{ properties.storeBody|raw }}' +
						'<br /><a class="btn btn-sm btn-default d-none" data-store="{{ properties.id }}">{{ properties.text }}</a>',
						{
							build: function() {
								this.constructor.superclass.build.call(this);

								var button = document.querySelector('a[data-store]');
								if (button)
									BX.bind(button, 'click', this.selectStoreByClick);
							},
							clear: function() {
								var button = document.querySelector('a[data-store]');
								if (button)
									BX.unbind(button, 'click', this.selectStoreByClick);

								this.constructor.superclass.clear.call(this);
							},
							selectStoreByClick: function(e) {
								var target = e.target || e.srcElement;

								if (that.pickUpMap.container.isFullscreen())
								{
									that.pickUpMap.container.exitFullscreen();
								}

								that.context.selectStore(target.getAttribute('data-store'));
								that.context.clickNextAction(e);
								that.pickUpMap.balloon.close();
							}
						}
					)
				});

				if (BX('BUYER_STORE').value === activeStores[i].ID)
				{
					geoObj.options.set('preset', 'islands#blueDotIcon');
				}

				this.pickUpMap.geoObjects.add(geoObj);
			}
		},

		selectBalloon: function(storeItemId)
		{
			if (this.pickUpMap && this.pickUpMap.geoObjects)
			{
				this.pickUpMap.geoObjects.each(BX.delegate(function(placeMark){
					if (placeMark.properties.get('id'))
					{
						placeMark.options.unset('preset');
					}

					if (placeMark.properties.get('id') === storeItemId)
					{
						placeMark.options.set({preset: 'islands#redDotIcon'});
						this.pickUpMap.panTo([placeMark.geometry.getCoordinates()])
					}
				}, this));
			}
		},

		pickUpFinalAction: function()
		{
			if (this.pickUpMap && this.pickUpMap.geoObjects)
			{
				var buyerStoreInput = BX('BUYER_STORE');

				this.pickUpMap.geoObjects.each(function(geoObject){
					if (geoObject.properties.get('id') === buyerStoreInput.value)
					{
						geoObject.options.set({preset: 'islands#redDotIcon'});
					}
					else if (parseInt(geoObject.properties.get('id')) > 0)
					{
						geoObject.options.unset('preset');
					}
				});
			}
		},

		initializePropsMap: function(propsMapData)
		{
			if (!ymaps)
				return;

			this.propsMap = new ymaps.Map('propsMap', {
				center: [propsMapData.lat, propsMapData.lon],
				zoom: propsMapData.zoom
			});

			this.propsMap.behaviors.disable('scrollZoom');

			this.propsMap.events.add('click', BX.delegate(function(e){
				var coordinates = e.get('coords'), placeMark;

				if (this.propsMap.geoObjects.getLength() === 0)
				{
					placeMark = new ymaps.Placemark([coordinates[0], coordinates[1]], {}, {
						draggable:true,
						preset: 'islands#redDotIcon'
					});
					placeMark.events.add(['parentchange', 'geometrychange'], function() {
						var orderDesc = BX('orderDescription'),
							coordinates = placeMark.geometry.getCoordinates(),
							ind, before, after, string;

						if (orderDesc)
						{
							ind = orderDesc.value.indexOf(BX.message('SOA_MAP_COORDS') + ':');
							if (ind === -1)
							{
								orderDesc.value = BX.message('SOA_MAP_COORDS') + ': ' + coordinates[0] + ', '
									+ coordinates[1] + '\r\n' + orderDesc.value;
							}
							else
							{
								string = BX.message('SOA_MAP_COORDS') + ': ' + coordinates[0] + ', ' + coordinates[1];
								before = orderDesc.value.substring(0, ind);
								after = orderDesc.value.substring(ind + string.length);
								orderDesc.value = before + string + after;
							}
						}
					});

					this.propsMap.geoObjects.add(placeMark);
				}
				else
				{
					this.propsMap.geoObjects.get(0).geometry.setCoordinates([coordinates[0], coordinates[1]]);
				}
			}, this));
		},

		canUseRecommendList: function()
		{
			return (this.pickUpPointsJSON && this.pickUpPointsJSON.length);
		},

		getRecommendedStoreIds: function(geoLocation)
		{
			if (!geoLocation)
				return [];

			var storeIds = [];
			var length = this.pickUpPointsJSON.length < this.pickUpOptions.nearestPickUpsToShow
				? this.pickUpPointsJSON.length
				: this.pickUpOptions.nearestPickUpsToShow;

			this.storeQueryResult = {};

			for (var i = 0; i < length; i++)
			{
				var pointsGeoQuery = ymaps.geoQuery({
					type: 'FeatureCollection',
					features: this.pickUpPointsJSON
				});
				var res = pointsGeoQuery.getClosestTo(geoLocation);
				var storeId = res.properties.get('storeId');

				this.storeQueryResult[storeId] = res;
				storeIds.push(storeId);
				this.pickUpPointsJSON.splice(pointsGeoQuery.indexOf(res), 1);
			}

			return storeIds;
		},

		getDistance: function(geoLocation, storeId)
		{
			if (!geoLocation || !storeId)
				return false;

			var storeGeoQuery = this.storeQueryResult[storeId];
			var distance = ymaps.coordSystem.geo.getDistance(geoLocation.geometry.getCoordinates(), storeGeoQuery.geometry.getCoordinates());
			distance = Math.round(distance / 100) / 10;

			return distance;
		},

		propsMapFocusWaiter: function(){},

		getStoreInfoHtml: function(currentStore)
		{
			var html = '';

			if (currentStore.ADDRESS)
				html += BX.message('SOA_PICKUP_ADDRESS') + ': ' + BX.util.htmlspecialchars(currentStore.ADDRESS) + '<br />';

			if (currentStore.PHONE)
				html += BX.message('SOA_PICKUP_PHONE') + ': ' + BX.util.htmlspecialchars(currentStore.PHONE) + '<br />';

			if (currentStore.SCHEDULE)
				html += BX.message('SOA_PICKUP_WORK') + ': ' + BX.util.htmlspecialchars(currentStore.SCHEDULE) + '<br />';

			if (currentStore.DESCRIPTION)
				html += BX.message('SOA_PICKUP_DESC') + ': ' + BX.util.htmlspecialchars(currentStore.DESCRIPTION) + '<br />';

			return html;
		}


	};
})();