<?php


namespace App;

class CategoryController
{
    public static function getContentCategory(): string
    {
        return Utils::renderTemplate('layout.php',
            [
                'title' => 'Category',
                'nav' => Utils::renderNavBarCabinet(),
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
                'title' => 'Category',
                'nav' => Utils::renderNavBarCabinet(),
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
