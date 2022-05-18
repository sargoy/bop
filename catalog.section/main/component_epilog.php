<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

\Zloj\Portal\Template::setPageAdult($templateData['CURRENT_ADULT']);

if ($_REQUEST['PAGEN_1']) {
    $title = "-страница №{$_REQUEST['PAGEN_1']}";
}
$APPLICATION->SetTitle($arResult['NAME'] . $title);
$APPLICATION->SetPageProperty('description',$arResult['NAME'] . $title);

/*$rsParentSection = CIBlockSection::GetByID($arResult["ID"]);
if ($arParentSection = $rsParentSection->fetch()) {
    $arFilter = Array(
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "ACTIVE" => "Y",
        'SECTION_ID' => $arResult['IBLOCK_SECTION_ID'],
        '>=LEFT_MARGIN' => $arParentSection['RIGHT_MARGIN']
    );
    $arSelect = Array("ID", 'NAME', 'LIST_PAGE_URL');

    $resNext = CIBlockSection::GetList(
        ['left_margin' => 'asc'],
        $arFilter,
        false,
        $arSelect,
        ['nTopCount ' => 1]
    );

    if ($ar_fields = $resNext->fetch()) {
        $get_next = [
            'name' => $ar_fields['NAME'],
            'url' => $ar_fields['LIST_PAGE_URL'] . $ar_fields['CODE'] . '/'
        ];
        $GLOBALS['nextcat'] = '<a href="' . $get_next['url'] . '" id="next-catalog">
                                            <div class="next-catalog__container">
                                                <div>Перейти в следующий раздел</div>
                                                <div>' . $get_next['name'] . '</div>
                                            </div>
                                            <div>
                                                <img src="/images/arrow-next-catalog.svg">
                                            </div>
                                        </a>
                                        <style>
                                            .pagination {
                                                display: inline-flex;
                                            }

                                            #next-catalog {
                                                display: inline-flex;
                                                width: 320px;
                                                padding: 18px 15px;
                                                background: #FFFFFF;
                                                border: 1px solid #EDEDED;
                                                box-sizing: border-box;
                                                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
                                                border-radius: 2px;
                                                vertical-align: middle;
                                                align-items: center;
                                                text-decoration: none;
                                            }

                                            .next-catalog__container+div {
                                                width: 30px;
                                            }

                                            .next-catalog__container {
                                                width: calc(100% - 30px);
                                            }

                                            .next-catalog__container>div {
                                                margin-bottom: 10px;
                                            }

                                            .next-catalog__container>div:last-child {
                                                font-weight: bold;
                                                font-size: 14px;
                                                line-height: 16px;
                                                color: #000000;
                                            }

                                            #ajax-load-catalog-pager {
                                                display: flex !important;
                                                align-items: center;
                                                justify-content: space-between;
                                            }

                                            @media (max-width: 992px) {
                                                #next-catalog {
                                                    width: 100%;
                                                }

                                                #ajax-load-catalog-pager {
                                                    display: block !important;
                                                }

                                                nav[aria-label="Pagination"] {
                                                    width: 100%;
                                                    text-align: center;
                                                    margin-top: 30px;
                                                }
                                            }
                                        </style>';

    }
}*/
