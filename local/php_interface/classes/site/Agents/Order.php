<?php


namespace CustomBitrix\Agents;


use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Loader;
use Bitrix\Sale;
use \CustomBitrix\Tools;

class Order
{
    protected static $arReportHeaders = [
        'ORDER_ID' => 'Номер заказа',
        'DATE' => 'Дата заказа',
        'USER_ID' => 'Ид покупателя',

        'QUANTITY' => 'Количество товара',

        'BASKET_PRICE' => 'Цена товаров',
        'DELIVERY_PRICE' => 'Цена доставки',
        'FULL_PRICE' => 'Итоговая цена',

        'PAYMENT_NAME' => 'Платежная система',
        'IS_PAID' => 'Заказ оплачен',

        'DELIVERY_NAME' => 'Доставка',

        'NAME' => 'Покупатель',
        'EMAIL' => 'Email',
        'PHONE' => 'Телефон',
        'ZIP' => 'Индекс',
        'LOCATION' => 'Город',
        'ADDRESS' => 'Адрес доставки',
        'ENTRANCE' => 'Подъезд',
        'FLOOR' => 'Этаж',
        'INTERCOM' => 'Домофон',
    ];

    /**
     * Получение всех заказов за период
     * @param \DateTime $oDateStart
     * @param \DateTime $oDateEnd
     * @param array $arFilter
     * @return Sale\Order[]|null
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\NotImplementedException
     */
    protected static function getOrdersByPeriod(\DateTime $oDateStart, \DateTime $oDateEnd, $arFilter = [])
    {
        Loader::includeModule('sale');
        $arFilterOrders = [
            ">=DATE_INSERT" => Tools\Text::makeDateForDB($oDateStart->getTimestamp()),
            "<=DATE_INSERT" => Tools\Text::makeDateForDB($oDateEnd->getTimestamp()),
        ];

        if (is_array($arFilter)) {
            $arFilterOrders = array_merge($arFilterOrders, $arFilter);
        }

        return \Bitrix\Sale\Order::loadByFilter([
            'filter' => $arFilterOrders,
        ]);
    }

    /**
     * Подготовка данных по заказу для отчета
     * @param Sale\Order $oOrder
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\NotImplementedException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    protected static function mapOrder(Sale\Order $oOrder)
    {
        $oPayment = $oOrder->getPaymentCollection()[0]; // массив id способов оплат
        $oDelivery = $oOrder->getShipmentCollection()[0]; // массив id способов доставки

        $arProps = $oOrder->getPropertyCollection()->getArray()['properties'];

        $arMap = [
            'ORDER_ID' => $oOrder->getId(),
            'DATE' => $oOrder->getDateInsert()->format('d.m.Y H:i:s'),
            'USER_ID' => $oOrder->getUserId(),

            'PAYMENT_ID' => $oPayment->getPaymentSystemId(),
            'PAYMENT_NAME' => $oPayment->getPaymentSystemName(),
            'DELIVERY_ID' => $oDelivery->getField('DELIVERY_ID'),
            'DELIVERY_NAME' => $oDelivery->getField('DELIVERY_NAME'),
            'DELIVERY_PRICE' => $oDelivery->getPrice(),

            'IS_PAID' => $oOrder->isPaid() ? 'Да' : 'Нет',
            'QUANTITY' => array_sum($oOrder->getBasket()->getQuantityList()),
            'BASKET_PRICE' => $oOrder->getBasket()->getPrice(),
            'FULL_PRICE' => $oOrder->getPrice(),
        ];

        foreach($arProps as $arProp) {
            $value = is_array($arProp['VALUE']) ? current($arProp['VALUE']) : $arProp['VALUE'];
            if ($arProp['CODE'] === 'LOCATION') {
                $arLoc = \CSaleLocation::GetList([], ['CODE' => $value, "LID" => LANGUAGE_ID])->Fetch();
                $value = $arLoc['CITY_NAME'];
            }
            $arMap[$arProp['CODE']] = $value;
        }

        return $arMap;
    }

    /**
     * Данные для отчета по заказам
     * @param \DateTime $oDateStart - начало периода выборки заказов по дате создания
     * @param \DateTime $oDateEnd - окончание периода выборки заказов по дате создания
     * @param null $sFileName - файл, в который сохранять отчет
     * @return array|string|null - если передан файл, то будет возвращен путь к нему, иначе массив полей, в случае проваоа - null
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\NotImplementedException
     */
    protected static function getDataReport(\DateTime $oDateStart, \DateTime $oDateEnd, $sFileName = null)
    {
        $arOrders = static::getOrdersByPeriod($oDateStart, $oDateEnd);

        $arRows = $arBody = [];
        foreach ($arOrders as $oOrder) {
            $arBody[] = static::mapOrder($oOrder);
        }

        if ($sFileName) {
            if (count($arBody) < 1)
                return null;

            $f = fopen($sFileName, 'w');
            fwrite($f, "\xEF\xBB\xBF");
            fclose($f);

            $oCsv = new \CCSVData('R', true);

            $oCsv->SaveFile($sFileName, array_values(static::$arReportHeaders));

            foreach ($arBody as $arOrder) {
                $arRow = [];
                foreach (static::$arReportHeaders as $sField => $sTitle) {
                    $arRow[] = $arOrder[$sField];
                }
                $oCsv->SaveFile($sFileName, $arRow);
            }
            $oCsv->CloseFile();

            return $sFileName;
        } else {
            $arRows[] = array_values(static::$arReportHeaders);

            foreach ($arBody as $arOrder) {
                $arRow = [];
                foreach (static::$arReportHeaders as $sField => $sTitle) {
                    $arRow[$sField] = $arOrder[$sField];
                }
                $arRows[] = $arRow;
            }

            return $arRows;
        }
    }

    /**
     * Агент для отправки ежедневных отчетов по заказам: CustomBitrix\Agents\Order::getDailyReport();
     * @return string
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\NotImplementedException
     */
    public static function getDailyReport()
    {
        $sFileName = $_SERVER['DOCUMENT_ROOT'].'/upload/daily_report/'.date('Y-m-d').'.csv';
        $sFileReport = static::getDataReport(new \DateTime('yesterday 00:00:00'), new \DateTime('today -1 second'), $sFileName);

        if ($sFileReport) {
            \CEvent::Send(
                'DAILY_ORDER_REPORT', 's1', ['DATE' => date('d.m.Y')],
                'N', '', [$sFileReport]
            );
        }

        return __METHOD__.'();';
    }

    /**
     * Агент для отправки уведослений по неоплаченным заказам: CustomBitrix\Agents\Order::notificationOfUnpaidOrders();
     * @return string
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\NotImplementedException
     */
    public static function notificationOfUnpaidOrders()
    {
        Loader::includeModule('sale');

        $arOrders = \Bitrix\Sale\Order::loadByFilter([
            'filter' => [
                '!CANCELED' => 'Y',
                'PAYED' => 'N',
                "<=DATE_INSERT" => Tools\Text::makeDateForDB(strtotime('-20 min')),
            ],
        ]);

        /** @var Sale\Order $oOrder */
        foreach ($arOrders as $oOrder) {
            if ($arFields = Tools\Order::fillMailFields($oOrder)) {
                \CEvent::Send('UNPAID_ORDER', 's1', $arFields);
                $oOrder->setField('CANCELED', 'Y');
                $oOrder->save();
            }
        }

        return __METHOD__.'();';
    }
}