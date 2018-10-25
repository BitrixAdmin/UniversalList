<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?
$IBlockID = (int)$arParams["IBLOCK_ID"];
$arParams["PAGER_TITLE"] = 'sec';
$arParams["PAGER_TEMPLATE"] = '.default';
$arParams["PAGER_SHOW_ALWAYS"] = 'Y';
$arParams["COUNT_SECTION"] = ($arParams["COUNT_SECTION"] ? $arParams["COUNT_SECTION"] : 5);


//https://dev.1c-bitrix.ru/api_help/iblock/classes/ciblocksection/getlist.php
$arSort = array("SORT" => "ASC");
$arFilter = array("IBLOCK_ID" => $IBlockID, "ACTIVE" => "Y");
$arSelect = array("ID", "IBLOCK_ID", "IBLOCK_TYPE_ID", "IBLOCK_SECTION_ID", "CODE", "SECTION_ID", "NAME", "SECTION_PAGE_URL", "DETAIL_PICTURE", "PICTURE", "PREVIEW_PICTURE","UF_*");
$bDescPageNumbering = false;//ывод обратной навигации
$bShowCount = false; //вывод количества элементов


$arNavParams = array(
    "nPageSize" => $arParams["COUNT_SECTION"],
    "bDescPageNumbering" => $bDescPageNumbering,
    "bShowAll" => $bShowCount,
);
//$arNavigation = CDBResult::GetNavParams($arNavParams);

$dbSection = CIBlockSection::GetList($arSort, $arFilter, $bShowCount, $arSelect, $arNavParams);
$arResult["NAV_STRING"] = $dbSection->GetPageNavStringEx($navComponentObject, $arParams["PAGER_TITLE"], $arParams["PAGER_TEMPLATE"], 'Y');

while ($arSection = $dbSection->GetNext()) {
    $arSection['PICTURE_SRC']= CFile::GetPath($arSection['PICTURE']);
    $arResult["LIST"][] = $arSection;
}

$this->IncludeComponentTemplate($componentPage);
?>