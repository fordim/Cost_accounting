<?php


namespace App\Controller;

use App\Utils;
use App\Settings;

class CashingController
{
    public static function getContent(): string
    {
        return Utils::renderTemplate('layout.php',
            [
                'title' => 'Обналичивание',
                'jsStyle' => 'js/cashing.js',
                'nav' => NavbarController::renderNavBarCabinet(),
                'content' => Utils::renderTemplate('itemCashing.php',
                    [
                        'newCashingRoute' => Settings::ROUTE_CASHING
                    ]
                ),
            ]
        );
    }
}
