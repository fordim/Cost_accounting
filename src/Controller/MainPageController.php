<?php


namespace App\Controller;

use App\Utils;

class MainPageController
{
    public static function getContent(): string
    {
        return Utils::renderTemplate('layout.php',
            [
                'title' => 'Cost accounting',
                'jsStyle' => '',
                'nav' => NavbarController::renderNavBarMain(),
                'content' => Utils::renderTemplate('itemMain.php'),
            ]
        );
    }
}
