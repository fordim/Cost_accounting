<?php

namespace App\Controller;

use App\Session;
use App\Utils;
use App\Settings;
use App\Database;

final class HistoryController
{
    public static function getContent(string $dateFrom, string $dateTo): string
    {
        return Utils::renderTemplate('layout.php',
            [
                'title' => 'History',
                'jsStyle' => 'js/history.js',
                'nav' => Utils::renderNavBarCabinet(),
                'content' => Utils::renderTemplate('itemHistory.php',
                    [
                        'dataPickerRoute' => Settings::ROUTE_HISTORY,
                        'dateFrom' => $dateFrom,
                        'dateTo' => $dateTo,
                        'expenses' => Database::getInstance()->getUserExpenses(
                            Session::getInstance()->getUserId(),
                            $dateFrom,
                            $dateTo),
                        'downloadAllHistoryRoute' => Settings::ROUTE_DOWNLOAD_ALL_HISTORY
                    ]
                ),
            ]
        );
    }
}
