<?php


namespace CustomBitrix\Tools;


class Template
{
    public static function getHeaderClass()
    {
        global $APPLICATION;
        $sClass = $APPLICATION->GetPageProperty('header_class');

        return $sClass;
    }
}