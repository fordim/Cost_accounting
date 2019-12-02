<?php


namespace App;

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
