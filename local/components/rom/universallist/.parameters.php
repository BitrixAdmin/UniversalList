<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arCurrentValues */

if (!CModule::IncludeModule("iblock"))
    return;

$arTypesEx = CIBlockParameters::GetIBlockTypes(array("-" => " "));

$arIBlocks = array();
$db_iblock = CIBlock::GetList(array("SORT" => "ASC"), array("SITE_ID" => $_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"] != "-" ? $arCurrentValues["IBLOCK_TYPE"] : "")));
while ($arRes = $db_iblock->Fetch())
    $arIBlocks[$arRes["ID"]] = "[" . $arRes["ID"] . "] " . $arRes["NAME"];

$arSorts = array("ASC" => GetMessage("T_IBLOCK_DESC_ASC"), "DESC" => GetMessage("T_IBLOCK_DESC_DESC"));
$arSortFields = array(
    "ID" => GetMessage("T_IBLOCK_DESC_FID"),
    "NAME" => GetMessage("T_IBLOCK_DESC_FNAME"),
    "ACTIVE_FROM" => GetMessage("T_IBLOCK_DESC_FACT"),
    "SORT" => GetMessage("T_IBLOCK_DESC_FSORT"),
    "TIMESTAMP_X" => GetMessage("T_IBLOCK_DESC_FTSAMP")
);

$arProperty_LNS = array();
$rsProp = CIBlockProperty::GetList(array("sort" => "asc", "name" => "asc"), array("ACTIVE" => "Y", "IBLOCK_ID" => (isset($arCurrentValues["IBLOCK_ID"]) ? $arCurrentValues["IBLOCK_ID"] : $arCurrentValues["ID"])));
while ($arr = $rsProp->Fetch()) {
    $arProperty[$arr["CODE"]] = "[" . $arr["CODE"] . "] " . $arr["NAME"];
    if (in_array($arr["PROPERTY_TYPE"], array("L", "N", "S"))) {
        $arProperty_LNS[$arr["CODE"]] = "[" . $arr["CODE"] . "] " . $arr["NAME"];
    }
}

//TODO собираем список свойств раздела
//$arPropertySection=array();
//$rsPropSection =

$arComponentParameters = array(
    "GROUPS" => array(),
    "PARAMETERS" => array(
        //"AJAX_MODE" => array(),
        "IBLOCK_TYPE" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("T_IBLOCK_DESC_LIST_TYPE"),
            "TYPE" => "LIST",
            "VALUES" => $arTypesEx,
            "DEFAULT" => "news",
            "REFRESH" => "Y",
        ),
        "IBLOCK_ID" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("T_IBLOCK_DESC_LIST_ID"),
            "TYPE" => "LIST",
            "VALUES" => $arIBlocks,
            "DEFAULT" => '={$_REQUEST["ID"]}',
            "ADDITIONAL_VALUES" => "Y",
            "REFRESH" => "Y",
        ),
        "COUNT_SECTION" => array(
            "PARENT" => "BASE",
            "NAME" => "Количество секций на странице",
            "TYPE" => "STRING",
            "VALUES" => "",
            "DEFAULT" => "10",
        ),
        "COUNT_ELEMENT" => array(
            "PARENT" => "BASE",
            "NAME" => "Количество элементов на странице",
            "TYPE" => "STRING",
            "VALUES" => "",
            "DEFAULT" => "10",
        ),
        "FIELD_CODE" => CIBlockParameters::GetFieldCode(GetMessage("IBLOCK_FIELD"), "DATA_SOURCE"),
        "PROPERTY" => array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => GetMessage("T_IBLOCK_PROPERTY"),
            "TYPE" => "LIST",
            "MULTIPLE" => "Y",
            "VALUES" => $arProperty_LNS,
            "ADDITIONAL_VALUES" => "Y",

        ),
        "VARIABLE_ALIASES" => Array(
            "SECTION_ID" => Array("NAME" => "section"),
            "ELEMENT_ID" => Array("NAME" => "element"),
        ),
        "SEF_MODE" => Array(
            "element_list" => array(
                "NAME" => "секция",
                "DEFAULT" => "#SECTION_ID#/",
                "VARIABLES" => array("SECTION_ID"),
            ),
            "element_detail" => array(
                "NAME" => "Элемент",
                "DEFAULT" => "#SECTION_ID#/#ELEMENT_ID#/",
                "VARIABLES" => array("ELEMENT_ID", "SECTION_ID"),
            ),
        ),


        "CACHE_TIME" => array("DEFAULT" => 36000000),
    ),
);
