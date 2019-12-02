<?php


namespace App\Controller;

use App\Utils;
use App\Settings;
use App\Database;

class CheckPageController
{
    public static function getContentSignIn(string $email): string
    {
        return Utils::renderTemplate('layout.php',
            [
                'title' => 'checkSignIn',
                'jsStyle' => '',
                'nav' => Utils::renderNavBarCabinet(),
                'content' => Utils::renderTemplate(
                    'checkSignIn.php',
                    [
                        'userName' => $email,
                        'cabinetRoute' => Settings::ROUTE_CABINET
                    ]
                ),
            ]
        );
    }

    public static function getContentNewCosts(float $sum, string $comment, int $categoryId): string
    {
        return Utils::renderTemplate('layout.php',
            [
                'title' => 'checkNewCosts',
                'jsStyle' => '',
                'nav' => Utils::renderNavBarCabinet(),
                'content' => Utils::renderTemplate(
                    'checkNewCosts.php',
                    [
                        'userSum' => $sum,
                        'userCategory' => Database::getInstance()->getCategoryName($categoryId),
                        'userComment' => $comment,
                        'cabinetRoute' => Settings::ROUTE_CABINET,
                        'historyRoute' => Settings::ROUTE_HISTORY
                    ]
                ),
            ]
        );
    }

    public static function getContentSingUp(string $name, string $email, string $password): string
    {
        return Utils::renderTemplate('layout.php',
            [
                'title' => 'checkSignUp',
                'jsStyle' => '',
                'nav' => Utils::renderNavBarCabinet(),
                'content' => Utils::renderTemplate(
                    'checkSignUp.php',
                    [
                        'userName' => $name,
                        'userEmail' => $email,
                        'userPassword' => $password,
                        'cabinetRoute' => Settings::ROUTE_CABINET
                    ]
                ),
            ]
        );
    }
}
