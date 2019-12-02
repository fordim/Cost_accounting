<?php


namespace App\Controller;

use App\Utils;
use App\Settings;

class SignUpController
{
    public static function getContent(): string
    {
        return Utils::renderTemplate('layout.php',
            [
                'title' => 'Регистрация',
                'jsStyle' => 'js/signUp.js',
                'nav' => NavbarController::renderNavBarMain(),
                'content' => Utils::renderTemplate('itemSignUp.php',
                    [
                        'signUpRoute' => Settings::ROUTE_SIGN_UP
                    ]
                ),
            ]
        );
    }
}
