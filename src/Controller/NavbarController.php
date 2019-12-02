<?php


namespace App\Controller;

use App\Session;
use App\Utils;
use App\Settings;
use App\Database;

class NavbarController
{
    public static function renderNavBarCabinet(): string
    {
        return Utils::renderTemplate(
            'navbarCabinet.php',
            [
                'mainRoute' => Settings::ROUTE_ROOT,
                'cabinetRoute' => Settings::ROUTE_CABINET,
                'historyRoute' => Settings::ROUTE_HISTORY,
                'categoryRoute' => Settings::ROUTE_CATEGORY,
                'userName' => Database::getInstance()->getUserName(Session::getInstance()->getUserId()),
                'logoutRoute' => Settings::ROUTE_LOGOUT,
                'cashingRoute' => Settings::ROUTE_CASHING,
                'cashingHistoryRoute' => Settings::ROUTE_CASHING_HISTORY,
                'operationRoute' => Settings::ROUTE_OPERATION,
                'operationHistoryRoute' => Settings::ROUTE_OPERATION_HISTORY,
            ]
        );
    }

    public static function renderNavBarMain(): string
    {
        return Utils::renderTemplate(
            'navbarMain.php',
            [
                'mainRoute' => Settings::ROUTE_ROOT,
                'signUpPageRoute' => Settings::ROUTE_SIGN_UP,
                'signInRoute' => Settings::ROUTE_SIGN_IN
            ]
        );
    }
}
