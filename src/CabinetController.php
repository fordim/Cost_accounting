<?php


namespace App;

class CabinetController
{
    public static function getContent(): string
    {
        return Utils::renderTemplate('layout.php',
            [
                'title' => 'Cabinet',
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
