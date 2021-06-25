<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$arSection = CIBlockSection::GetList(
    [],
    [
        'CODE' => $arParams['SECTION_CODE'], 'ACTIVE' => 'Y', 'IBLOCK_ID' => $arParams['IBLOCK_ID']
    ], false,
    ['ID', 'CODE', 'IBLOCK_ID', 'DESCRIPTION', 'PICTURE']
)->Fetch();

$arBlocks = [];
if ($arSection) {
    $arBlocks = \CustomBitrix\Tools\Iblock::getElements([
        'FILTER' => ['SECTION_CODE' => $arParams['SECTION_CODE'], 'ACTIVE' => 'Y', 'IBLOCK_ID' => $arParams['IBLOCK_ID']],
        'ID' => 'CODE',
    ]);

    $arBlocks = array_map(function($arBlock) {
        $arBlock['PREVIEW_PICTURE'] = CFile::GetPath($arBlock['PREVIEW_PICTURE']);
        return $arBlock;
    }, $arBlocks);


    $sBanner = CFile::GetPath(current($arBlocks['banner']['PROPERTIES']['FILES']['VALUE'])) ?: $arBlock['banner']['PREVIEW_PICTURE'];
}

$sTitle = $arSection['NAME'];
$sDesc = $arSection['DESCRIPTION'];
?>

<section class="vocabulary">
    <div class="wrap vocabulary-wrap">
        <div class="vocabulary-content">
            <img src="<?=$arBlocks['mini-logo']['PREVIEW_PICTURE'];?>" alt class="vocabulary-content__logo">
            <img src="<?=$sBanner;?>" alt class="vocabulary-content__title">
            <p class="vocabulary-content__descr"><?=$sDesc;?></p>
            <img src="<?=$arBlocks['after']['PREVIEW_PICTURE'];?>" alt class="vocabulary-content__characters">
            <?=$arBlocks['after']['~PREVIEW_TEXT'];?>
        </div>
    </div>
</section>