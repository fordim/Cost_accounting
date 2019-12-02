<?php


namespace App\Controller;

use App\Database;
use App\Session;
use App\Utils;

class OperationHistoryController
{
    public static function getContent(): string
    {
        return Utils::renderTemplate('layout.php',
            [
                'title' => 'История операций',
                'jsStyle' => '',
                'nav' => NavbarController::renderNavBarCabinet(),
                'content' => Utils::renderTemplate('itemOperationsHistory.php',
                    [
                        'operations' => Database::getInstance()->getUserOperationsHistory(Session::getInstance()->getUserId())
                    ]
                ),
            ]
        );
    }
}
