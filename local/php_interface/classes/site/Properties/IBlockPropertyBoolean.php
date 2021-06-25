<?php
namespace CustomBitrix\Properties;

/**
 * boolean iblock property
 * Class IBlockPropertyBoolean
 * @package DEFA\Properties
 */
class IBlockPropertyBoolean
{

    const DEFAULT_TEMPLATE = "#VALUE#";
    const DEFAULT_IS_NUMBER = "N";
    const DEFAULT_DECIMALS = "5";

    public static function getUserTypeDescription()
    {
        return array(
            'PROPERTY_TYPE' => 'S',
            'USER_TYPE' => 'DefaBoolean',
            'DESCRIPTION' => 'Defa: Да/Нет',
            'GetPropertyFieldHtml' => array(__CLASS__, 'getPropertyFieldHtml'),
        );
    }

    public static function getPropertyFieldHtml($arProperty, $value, $strHTMLControlName)
    {
        $html = '';
        $html .= '<input type="hidden" name="' . $strHTMLControlName["VALUE"] . '" value="N">';
        $html .= '<input type="checkbox" name="' . $strHTMLControlName["VALUE"] . '" value="Y" '
            . ($value["VALUE"] == "Y" ? "checked" : "") . '>';

        return $html;
    }
}