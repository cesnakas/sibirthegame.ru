<?php
$arUrlRewrite = [
    [
        'CONDITION' => '#^/api/#',
        'RULE' => '',
        'ID' => 'defa:controller',
        'PATH' => '/local/ajax.php',
        'SORT' => 100,
    ],
    [
        'CONDITION' => '#^/personal/order/success/#',
        'RULE' => 'result=success',
        'ID' => '',
        'PATH' => '/local/order_result.php',
        'SORT' => 100,
    ],
    [
        'CONDITION' => '#^/personal/order/fail/#',
        'RULE' => 'result=fail',
        'ID' => '',
        'PATH' => '/local/order_result.php',
        'SORT' => 100,
    ],
    [
        'CONDITION' => '#^/personal/order/show/#',
        'RULE' => '',
        'ID' => '',
        'PATH' => '/local/order_result_paysistem.php',
        'SORT' => 100,
    ],
];