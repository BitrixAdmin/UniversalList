<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?><?

$arDefaultUrlTemplates404 = array(
    "sections" => "/",
    "element_list" => "#SECTION_ID#/",
    "element_detail" => "#SECTION_ID#/#ELEMENT_ID#/"
);

$arDefaultVariableAliases404 = array();

$arDefaultVariableAliases = array();

$arComponentVariables = array("IBLOCK_ID", "ELEMENT_ID", "SECTION_ID");


$SEF_FOLDER = "";
$arUrlTemplates = array();

if ($arParams["SEF_MODE"] == "Y") {
    $arVariables = array();

    $arUrlTemplates = CComponentEngine::MakeComponentUrlTemplates($arDefaultUrlTemplates404, $arParams["SEF_URL_TEMPLATES"]);
    $arVariableAliases = CComponentEngine::MakeComponentVariableAliases($arDefaultVariableAliases404, $arParams["VARIABLE_ALIASES"]);

    $componentPage = CComponentEngine::ParseComponentPath(
        $arParams["SEF_FOLDER"],
        $arUrlTemplates,
        $arVariables
    );

    if (strlen($componentPage) <= 0) $componentPage = "sections";

    CComponentEngine::InitComponentVariables($componentPage,
        $arComponentVariables,
        $arVariableAliases,
        $arVariables);

    $SEF_FOLDER = $arParams["SEF_FOLDER"];

    $arResult = array(
        "COUNT_SECTION" => 10,
        "COUNT_ELEMENT" => 10,
        "URL_TEMPLATES" => $arUrlTemplates,
    );
} else {
    $arVariables = array();

    $arVariableAliases = CComponentEngine::MakeComponentVariableAliases($arDefaultVariableAliases, $arParams["VARIABLE_ALIASES"]);
    CComponentEngine::InitComponentVariables(false, $arComponentVariables, $arVariableAliases, $arVariables);

    $componentPage = "";
    if (intval($arVariables["ELEMENT_ID"]) > 0)
        $componentPage = "element_detail";
    elseif (intval($arVariables['SECTION_ID']) > 0)
        $componentPage = "element_list";
    else
        $componentPage = "sections";

    $arResult = array(
        "FOLDER" => $APPLICATION->GetCurPage(),
        "URL_TEMPLATES" => $arUrlTemplates,
        "VARIABLES" => $arVariables,
        "ALIASES" => $arVariableAliases,
        "COUNT_SECTION" => 10,
        "COUNT_ELEMENT" => 10,
        "URL_TEMPLATES" => array(
            "sections" => htmlspecialcharsbx($APPLICATION->GetCurPage()),
            "element_list" => htmlspecialcharsbx($APPLICATION->GetCurPage() . '?' . $arVariableAliases['SECTION_ID'] . '=#SECTION_ID#'),
            "element_detail" => htmlspecialcharsbx($APPLICATION->GetCurPage() . '?' . $arVariableAliases['SECTION_ID'] . '=#SECTION_ID#&' . $arVariableAliases['ELEMENT_ID'] . '=#ELEMENT_ID#'),
        ),
    );

}



$this->IncludeComponentTemplate($componentPage);
?>