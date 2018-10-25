<?php

//dbg($arParams);
//dbg($arResult);
?>

<?=$arResult['NAV_STRING']?>

<?foreach($arResult['LIST'] AS $arItem){?>

<p><img src="<?=$arItem['PICTURE_SRC']?>" width="30"><a href="<?=$arItem['SECTION_PAGE_URL']?>"><?=$arItem['NAME']?></a></p>

<?}?>


<?=$arResult['NAV_STRING']?>


