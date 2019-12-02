<?php


namespace App\Controller;

use App\Utils;
use App\Settings;
use App\Database;

class CabinetController
{
    public static function getContent(): string
    {
        return Utils::renderTemplate('layout.php',
            [
                'title' => 'Cabinet',
                'jsStyle' => '',
                'nav' => Utils::renderNavBarCabinet(),
                'content' => Utils::renderTemplate('itemCabinet.php',
                    [
                        'newCostRoute' => Settings::ROUTE_NEW_COSTS,
                        'categories' => Database::getInstance()->getAllCategories()
                    ]
                ),
            ]
        );
    }
}
