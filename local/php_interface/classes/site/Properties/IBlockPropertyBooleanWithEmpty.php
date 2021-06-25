<?php
namespace CustomBitrix\Properties;

/**
 * boolean iblock property
 * Class IBlockPropertyBoolean
 * @package DEFA\Properties
 */
class IBlockPropertyBooleanWithEmpty
{

    const DEFAULT_TEMPLATE = "#VALUE#";
    const DEFAULT_IS_NUMBER = "N";
    const DEFAULT_DECIMALS = "5";

    public static function getUserTypeDescription()
    {
        return array(
            'PROPERTY_TYPE' => 'S',
            'USER_TYPE' => 'DefaBooleanWithEmpty',
            'DESCRIPTION' => 'Defa: Да/Нет/Пустота',
            'GetPropertyFieldHtml' => array(__CLASS__, 'getPropertyFieldHtml'),
            'ConvertToDB' => array(__CLASS__, 'ConvertToDB'),
            'ConvertFromDB' => array(__CLASS__, 'ConvertFromDB'),
        );
    }

    public static function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName)
    {
        $arValues = [
            'Да' => 'Y',
            'Нет' => 'N',
            'Пустота' => '',
        ];
        $html = '';
        foreach ($arValues as $sLabel => $sValue){
            $html .= '<input type="radio" name="' . $strHTMLControlName["VALUE"] . '" value="'.$sValue.'" '
                . ($value["VALUE"] == $sValue ? "checked" : "") . ' id="prop_'.$arProperty['ID'].'_'.$sValue.'">'
                . '<label for="prop_'.$arProperty['ID'].'_'.$sValue.'">'.$sLabel.'</label>';
        }

        return $html;
    }

    public static function ConvertToDB($arProperty, $value)
    {
        switch(trim(strtoupper($value["VALUE"]))) {
            case 'ДА':
            case 'Y':
                $value["VALUE"] = "Y";
                break;
            case 'НЕТ':
            case 'N':
                $value["VALUE"] = "N";
                break;
            default:
                $value["VALUE"] = null;
        }

        return $value;
    }

    public static function ConvertFromDB($arProperty, $value)
    {
        switch(trim(strtoupper($value["VALUE"]))) {
            case 'ДА':
            case 'Y':
                $value["VALUE"] = "Y";
                break;
            case 'НЕТ':
            case 'N':
                $value["VALUE"] = "N";
                break;
            default:
                $value["VALUE"] = null;
        }

        return $value;
    }
}
