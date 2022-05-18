<?php
//$dbBasketItems = CSaleBasket::GetList(
//	array(
//		"NAME" => "ASC",
//		"ID" => "ASC"
//	),
//	array(
//		"FUSER_ID" => CSaleBasket::GetBasketUserID(),
//		"LID" => SITE_ID,
//		"ORDER_ID" => "NULL"
//	),
//	false,
//	false,
//	array("ID", "CALLBACK_FUNC", "MODULE",
//		"PRODUCT_ID", "QUANTITY", "DELAY",
//		"CAN_BUY", "PRICE", "WEIGHT")
//);
//$sum=0;
//while ($arItems = $dbBasketItems->Fetch())
//{
//	$sum+=$arItems["QUANTITY"];
//}