<?php


namespace App;

class MainPageController
{
    public static function getContent(): string
    {
        return Utils::renderTemplate('layout.php',
            [
                'title' => 'Cost accounting',
                'nav' => Utils::renderNavBarMain(),
                'content' => Utils::renderTemplate('itemMain.php'),
            ]
        );
    }
}
