<?php

namespace CustomBitrix\Tools;


class Text
{
    public static function stripPhone($sPhone)
    {
        return preg_replace('#[^+0-9]]#', '', $sPhone);
    }

    /**
     * Преобразование фисла байт в красивый формат
     * @param int $bytes
     * @return string
     */
    public static function formatFileSize($bytes)
    {
        $bytes = round((int) $bytes, 2);
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }

        elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }

        elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }

        elseif ($bytes > 1) {
            $bytes = $bytes . ' байты';
        }

        elseif ($bytes == 1) {
            $bytes = $bytes . ' байт';
        }

        else {
            $bytes = '0 байтов';
        }

        return $bytes;
    }

    /**
     * Склонение существительных
     *
     * @param string $iValue Значение
     * @param string $sSingularNominative Вариантов в им.пад ед.число, например: 'товар'
     * @param string $sSingularGenitive  Вариантов в род..пад ед.число, например: 'товара'
     * @param string $sPlural  Вариантов в им.пад мн.число, например: 'товаров'
     * @param bool $bShow Включает значение $value в результирующею строку
     * @return string
     */
    public static function declensionOfNouns($iValue, $sSingularNominative, $sSingularGenitive, $sPlural, $bShow = true)
    {
        $num = $iValue % 100;
        if ($num > 19) {
            $num = $num % 10;
        }

        $out = ($bShow) ?  $iValue . ' ' : '';
        switch ($num) {
            case 1:  $out .= $sSingularNominative; break;
            case 2:
            case 3:
            case 4:  $out .= $sSingularGenitive; break;
            default: $out .= $sPlural; break;
        }

        return $out;
    }

    public static function makeDateForDB($iTime)
    {
        global $DB;
        return date($DB->DateFormatToPHP(\CSite::GetDateFormat("FULL")), $iTime);
    }
}