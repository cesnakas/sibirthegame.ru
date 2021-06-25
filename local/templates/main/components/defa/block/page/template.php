<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$sTheme = $sPrevTheme = 'main';
foreach ($arResult['BLOCKS'] as $arBlock) {
    if ($arBlock['PROPERTIES']['DARK_TEMPLATE']['VALUE'] === 'Y') {
        $sTheme = 'dark';
    } else {
        $sTheme = 'main';
    }

    // Закрываем предыдущую тему
    switch ($sPrevTheme) {
        case 'dark':
            if ($sPrevTheme !== $sTheme) {
                ?>
                </div>
                </div>
                </div>
                </div>
                </section>
                <?php
            }
            break;
    }

    // Начинае новую тему
    switch ($sTheme) {
        case 'dark':
            if ($sPrevTheme !== $sTheme) {
                ?>
                <section class="page page--content">
                <div class="product--page">
                <div class="container">
                <div class="wrap">
                <div class="product-inner">
                <?php
            }
            break;
    }
    include $arBlock['FILE'];

    $sPrevTheme = $sTheme;
}
// Закрываем предыдущую тему
switch ($sPrevTheme) {
    case 'dark':
        if ($sPrevTheme !== $sTheme) {
            ?>
            </div>
            </div>
            </div>
            </div>
            </section>
            <?php
        }
        break;
}
