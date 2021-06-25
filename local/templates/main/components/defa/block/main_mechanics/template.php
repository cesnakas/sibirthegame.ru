<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$arSection = CIBlockSection::GetList(
    [],
    [
        'CODE' => $arParams['SECTION_CODE'], 'ACTIVE' => 'Y', 'IBLOCK_ID' => $arParams['IBLOCK_ID']
    ], false,
    ['ID', 'CODE', 'IBLOCK_ID', 'DESCRIPTION', 'NAME']
)->Fetch();
$arItems = [];
if ($arSection) {
    $arItems = \CustomBitrix\Tools\Iblock::getElements([
        'FILTER' => ['IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ACTIVE' => 'Y', 'ACTIVE_DATE'=> 'Y', 'SECTION_ID' => $arSection['ID'],],
        'ORDER' => ['sort' => 'asc', 'name' => 'asc',],
    ]);
    $arItems = array_map(function($arItem) {
        $arItem['PREVIEW_PICTURE'] = CFile::GetPath($arItem['PREVIEW_PICTURE']);
        return $arItem;
    }, $arItems);
}

$sTitle = $arSection['NAME'];
$sDesc = $arSection['DESCRIPTION'];
?>

<section id="mechanics" class="mechanics">
    <div class="wrap mechanics-wrap"><h2 class="h2 mechanics__h2"><?=$sTitle;?></h2>
        <p class="mechanics__descr"><?=$sDesc;?></p>
        <div class="mechanics-list">
            <? foreach ($arItems as $arItem): ?>
            <div class="mechanics-item">
                <img src="<?=$arItem['PREVIEW_PICTURE'];?>" alt class="mechanics-item__img">
                <h4 class="mechanics-item__title"><?=$arItem['~NAME'];?></h4>
                <p class="mechanics-item__descr"><?=$arItem['~PREVIEW_TEXT'];?></p>
            </div>
            <? endforeach; ?>
        </div>
    </div>
</section>