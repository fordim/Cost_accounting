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
                'title' => 'Sign Up',
                'nav' => Utils::renderNavBarMain(),
                'jsStyle' => 'js/signUp.js',
                'content' => Utils::renderTemplate('itemSignUp.php',
                    [
                        'signUpRoute' => Settings::ROUTE_SIGN_UP
                    ]
                ),
            ]
        );
    }
}
