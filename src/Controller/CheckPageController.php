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
                'title' => 'Авторизация',
                'jsStyle' => '',
                'nav' => NavbarController::renderNavBarCabinet(),
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
                'title' => 'Внесение расходов',
                'jsStyle' => '',
                'nav' => NavbarController::renderNavBarCabinet(),
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
                'title' => 'Регистрация',
                'jsStyle' => '',
                'nav' => NavbarController::renderNavBarCabinet(),
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

    public static function getContentCashing(string $name, float $sum, string $card, float $percent): string
    {
        return Utils::renderTemplate('layout.php',
            [
                'title' => 'Обналичивание',
                'jsStyle' => '',
                'nav' => NavbarController::renderNavBarCabinet(),
                'content' => Utils::renderTemplate(
                    'checkNewCashing.php',
                    [
                        'userName' => $name,
                        'userSum' => $sum,
                        'userCard' => $card,
                        'userPercent' => $percent,
                        'cashingRoute' => Settings::ROUTE_CASHING,
                        'cashingHistoryRoute' => Settings::ROUTE_CASHING_HISTORY
                    ]
                ),
            ]
        );
    }

    public static function getContentOperation(string $month, float $balance, float $profit, float $deposit, float $expenseFlat): string
    {
        return Utils::renderTemplate('layout.php',
            [
                'title' => 'Операции',
                'jsStyle' => '',
                'nav' => NavbarController::renderNavBarCabinet(),
                'content' => Utils::renderTemplate(
                    'checkNewOperation.php',
                    [
                        'userMonth' => $month,
                        'userBalance' => $balance,
                        'userProfit' => $profit,
                        'userDeposit' => $deposit,
                        'expenseFlat' => $expenseFlat,
                        'operationRoute' => Settings::ROUTE_OPERATION,
                        'operationHistoryRoute' => Settings::ROUTE_OPERATION_HISTORY
                    ]
                ),
            ]
        );
    }
}
