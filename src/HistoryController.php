<?php

namespace App;

final class HistoryController
{
    public static function getContent(string $dateFrom, string $dateTo): string
    {
        return Utils::renderTemplate('layout.php',
            [
                'title' => 'History',
                'nav' => Utils::renderNavBarCabinet(),
                'jsStyle' => 'js/history.js',
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
