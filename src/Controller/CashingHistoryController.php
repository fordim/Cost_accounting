<?php


namespace App\Controller;

use App\Utils;
use App\Database;
use App\Session;
use App\Settings;

class CashingHistoryController
{
    public static function getContent(string $dateFrom, string $dateTo): string
    {
        return Utils::renderTemplate('layout.php',
            [
                'title' => 'История обналичивания',
                'jsStyle' => 'js/history.js',
                'nav' => NavbarController::renderNavBarCabinet(),
                'content' => Utils::renderTemplate('itemCashingHistory.php',
                    [
                        'dataPickerRoute' => Settings::ROUTE_CASHING_HISTORY,
                        'dateFrom' => $dateFrom,
                        'dateTo' => $dateTo,
                        'cashingOut' => Database::getInstance()->getUserCashingHistory(
                            Session::getInstance()->getUserId(),
                            $dateFrom,
                            $dateTo),
                        'allProfit' => Database::getInstance()->getSummaryOfCashingProfit(
                            Session::getInstance()->getUserId(),
                            $dateFrom,
                            $dateTo),
                        'allAmount' => Database::getInstance()->getSummaryOfCashingAmount(
                            Session::getInstance()->getUserId(),
                            $dateFrom,
                            $dateTo),
                    ]
                ),
            ]
        );
    }
}
