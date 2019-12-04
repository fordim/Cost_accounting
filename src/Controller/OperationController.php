<?php


namespace App\Controller;

use App\Database;
use App\Session;
use App\Settings;
use App\Utils;

class OperationController
{
    public static function getContent(): string
    {
        return Utils::renderTemplate('layout.php',
            [
                'title' => 'Операции',
                'jsStyle' => '',
                'nav' => NavbarController::renderNavBarCabinet(),
                'content' => Utils::renderTemplate('itemOperations.php',
                    [
                        'newOperationRoute' => Settings::ROUTE_OPERATION,
                        'thisMonth' => Utils::getFirstDateOfThisMonth(),
                        'lastMonthRealSum' => Database::getInstance()->getReadSumFromLastMonth(Session::getInstance()->getUserId()),
                        'lastMonthProfit' => Database::getInstance()->getSummaryOfCashingProfit(
                            Session::getInstance()->getUserId(), Utils::getFirstDateOfLastMonth(), Utils::getLastDateOfLastMonth()),
                    ]
                ),
            ]
        );
    }
}
