<?php


namespace App\Controller;

use App\Utils;
use App\Settings;
use App\Database;

class CategoryController
{
    public static function getContentCategory(): string
    {
        return Utils::renderTemplate('layout.php',
            [
                'title' => 'Категории',
                'jsStyle' => '',
                'nav' => NavbarController::renderNavBarCabinet(),
                'content' => Utils::renderTemplate('itemCategory.php',
                    [
                        'categories' => Database::getInstance()->getAllCategories(),
                        'categoryChangeRoute' => Settings::ROUTE_CATEGORY_CHANGE
                    ]
                ),
            ]
        );
    }

    public static function getContentCategoryChange(): string
    {
        return Utils::renderTemplate('layout.php',
            [
                'title' => 'Категории',
                'jsStyle' => '',
                'nav' => NavbarController::renderNavBarCabinet(),
                'content' => Utils::renderTemplate('itemCategoryChange.php',
                    [
                        'addNewCategoryRoute' => Settings::ROUTE_CATEGORY_ADD_NEW,
                        'changeCategoryRoute' => Settings::ROUTE_CATEGORY_CHANGE,
                        'deleteCategoryRoute' => Settings::ROUTE_CATEGORY_DELETE,
                        'categories' => Database::getInstance()->getAllCategories(),
                        'categoryRoute' => Settings::ROUTE_CATEGORY
                    ]
                ),
            ]
        );
    }
}
