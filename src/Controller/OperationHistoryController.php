<?php


namespace App\Controller;

use App\Database;
use App\Session;
use App\Settings;
use App\Utils;

class OperationHistoryController
{
    public static function getContentOperationHistory(): string
    {
        return Utils::renderTemplate('layout.php',
            [
                'title' => 'История операций',
                'jsStyle' => '',
                'nav' => NavbarController::renderNavBarCabinet(),
                'content' => Utils::renderTemplate('itemOperationsHistory.php',
                    [
                        'operations' => Database::getInstance()->getUserOperationsHistory(Session::getInstance()->getUserId()),
                        'operationHistoryChangeRoute' => Settings::ROUTE_OPERATION_HISTORY_CHANGE
                    ]
                ),
            ]
        );
    }

    public static function getContentOperationHistoryChange(): string
    {
        return Utils::renderTemplate('layout.php',
            [
                'title' => 'История операций',
                'jsStyle' => '',
                'nav' => NavbarController::renderNavBarCabinet(),
                'content' => Utils::renderTemplate('itemOperationsHistoryChange.php',
                    [
                        'operations' => Database::getInstance()->getUserOperationsHistory(Session::getInstance()->getUserId()),
                        'changeRealSumRoute' => Settings::ROUTE_OPERATION_REAL_SUM_CHANGE,
                        'operationHistoryRoute' => Settings::ROUTE_OPERATION_HISTORY
                    ]
                ),
            ]
        );
    }
}
