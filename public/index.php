<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

use App\Utils;
use App\Database;
use App\Operations;

if ($_POST['sendFormSignUp'] ?? ''){
    Database::getInstance()->processFormSignUp($_POST['name'], $_POST['email'], $_POST['password']);
    $_SESSION['user'] = [
        'id' => Database::getInstance()->findUserByEmail($_POST['email'])[0]['id'],
        'email' => $_POST['email']
    ];
    die (Utils::renderTemplate('layout.php',
        [
            'title' => 'checkSignUp',
            'nav' => Utils::renderTemplate(
                'navbarCabinet.php',
                [
                    'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
                ]
            ),
            'content' => Utils::renderTemplate(
                'checkSignUp.php',
                [
                    'userName' => $_POST['name'],
                    'userEmail' => $_POST['email'],
                    'userPassword' => $_POST['password']
                ]
            ),
        ]
    ));
} elseif ($_POST['sendFormSignIn'] ?? ''){
    Database::getInstance()->processFormSignIn($_POST['email'], $_POST['password']);
    $_SESSION['user'] = [
        'id' => Database::getInstance()->findUserByEmail($_POST['email'])[0]['id'],
        'email' => $_POST['email']
    ];
    die (Utils::renderTemplate('layout.php',
        [
            'title' => 'checkSignIn',
            'nav' => Utils::renderTemplate(
                'navbarCabinet.php',
                [
                    'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
                ]
            ),
            'content' => Utils::renderTemplate(
                'checkSignIn.php',
                [
                    'userName' => $_POST['email']
                ]
            ),
        ]
    ));
} elseif ($_POST['sendFormCabinet'] ?? '') {
    Database::getInstance()->processFormAddExpense($_POST['sum'], $_POST['comment'], $_POST['categoryId'], $_SESSION['user']['id']);
    die (Utils::renderTemplate('layout.php',
        [
            'title' => 'checkNewCosts',
            'nav' => Utils::renderTemplate(
                'navbarCabinet.php',
                [
                    'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
                ]
            ),
            'content' => Utils::renderTemplate(
                'checkNewCosts.php',
                [
                    'userSum' => $_POST['sum'],
                    'userCategory' => Database::getInstance()->getCategoryName($_POST['categoryId']),
                    'userComment' => $_POST['comment']
                ]
            ),
        ]
    ));
} elseif ($_POST['addNewCategory'] ?? '') {
    Database::getInstance()->processFormAddCategory($_POST['categoryName']);
} elseif ($_POST['changeExistCategory'] ?? '') {
    Database::getInstance()->processFormChangeCategory($_POST['categoryId'], $_POST['categoryName']);
} elseif ($_POST['deleteExistCategory'] ?? '') {
    Database::getInstance()->processFormDeleteCategory($_POST['categoryId']);
} elseif ($_POST['downloadAllHistory'] ?? '') {
    Utils::downloadAllHistory($_SESSION['user']['id']);
} elseif ($_POST['sendCashing'] ?? '') {
    Operations::getInstance()->processFormAddCashing($_POST['name'], $_POST['sum'], $_POST['card'], $_POST['percent'], $_SESSION['user']['id']);
    die (Utils::renderTemplate('layout.php',
        [
            'title' => 'checkNewCashing',
            'nav' => Utils::renderTemplate(
                'navbarCabinet.php',
                [
                    'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
                ]
            ),
            'content' => Utils::renderTemplate(
                'checkNewCashing.php',
                [
                    'userName' => $_POST['name'],
                    'userSum' => $_POST['sum'],
                    'userCard' => $_POST['card'],
                    'userPercent' => $_POST['percent']
                ]
            ),
        ]
    ));
}

$currentPage = $_GET['page'] ?? 'main';

switch ($currentPage) {
    case 'main':
        die (Utils::renderTemplate('layout.php',
            [
                'title' => 'Cost accounting',
                'nav' => Utils::renderTemplate('navbarMain.php'),
                'content' => Utils::renderTemplate('itemMain.php'),
            ]
        ));
}

if (!isset($_SESSION['user'])) {
    switch ($currentPage){
        case 'signUp':
            die (Utils::renderTemplate('layout.php',
                [
                    'title' => 'Sign Up',
                    'nav' => Utils::renderTemplate('navbarMain.php'),
                    'jsStyle' => 'js/signUp.js',
                    'content' => Utils::renderTemplate('itemSignUp.php'),
                ]
            ));
        default:
            echo 'Доступ закрыт 403';
    }
} else {
    switch ($currentPage){
        case 'cabinet':
            die (Utils::renderTemplate('layout.php',
                [
                    'title' => 'Cabinet',
                    'nav' => Utils::renderTemplate(
                        'navbarCabinet.php',
                        [
                            'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
                        ]
                    ),
                    'content' => Utils::renderTemplate(
                        'itemCabinet.php',
                        [
                            'categories' => Database::getInstance()->getAllCategories()
                        ]
                    ),
                ]
            ));
        case 'category':
            die (Utils::renderTemplate('layout.php',
                [
                    'title' => 'Category',
                    'nav' => Utils::renderTemplate(
                        'navbarCabinet.php',
                        [
                            'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
                        ]
                    ),
                    'content' => Utils::renderTemplate(
                        'itemCategory.php',
                        [
                            'categories' => Database::getInstance()->getAllCategories()
                        ]
                    ),
                ]
            ));
        case 'categoryChange':
            die (Utils::renderTemplate('layout.php',
                [
                    'title' => 'Category',
                    'nav' => Utils::renderTemplate(
                        'navbarCabinet.php',
                        [
                            'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
                        ]
                    ),
                    'content' => Utils::renderTemplate(
                        'itemCategoryChange.php',
                        [
                            'categories' => Database::getInstance()->getAllCategories()
                        ]
                    ),
                ]
            ));
        case 'history':
            die (Utils::renderTemplate(
                'layout.php',
                [
                    'title' => 'History',
                    'nav' => Utils::renderTemplate(
                        'navbarCabinet.php',
                        [
                            'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
                        ]
                    ),
                    'jsStyle' => 'js/history.js',
                    'content' => Utils::renderTemplate(
                        'itemHistory.php',
                        [
                            'dateFrom' => $_POST['dateFrom'] ?? Utils::getDateOfLastMonth() ,
                            'dateTo' => $_POST['dateTo'] ?? Utils::getCurrentDate(),
                            'expenses' => Database::getInstance()->getUserExpenses($_SESSION['user']['id'], ($_POST['dateFrom'] ?? Utils::getDateOfLastMonth()), ($_POST['dateTo'] ?? Utils::getCurrentDate()))
                        ]
                    ),
                ]
            ));
        case 'cashing':
            die (Utils::renderTemplate('layout.php',
                [
                    'title' => 'Cashing out',
                    'nav' => Utils::renderTemplate(
                        'navbarCabinet.php',
                        [
                            'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
                        ]
                    ),
                    'jsStyle' => 'js/cashing.js',
                    'content' => Utils::renderTemplate('itemCashing.php'),
                ]
            ));
        case 'cashingHistory':
            die (Utils::renderTemplate('layout.php',
                [
                    'title' => 'Cashing History',
                    'nav' => Utils::renderTemplate(
                        'navbarCabinet.php',
                        [
                            'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
                        ]
                    ),
                    'jsStyle' => 'js/history.js',
                    'content' => Utils::renderTemplate(
                        'itemCashingHistory.php',
                        [
                            'dateFrom' => $_POST['dateFrom'] ?? Utils::getDateOfLastMonth() ,
                            'dateTo' => $_POST['dateTo'] ?? Utils::getCurrentDate(),
                            'cashingOut' => Operations::getInstance()->getUserCashingHistory($_SESSION['user']['id'], ($_POST['dateFrom'] ?? Utils::getDateOfLastMonth()), ($_POST['dateTo'] ?? Utils::getCurrentDate())),
                            'allProfit' => Operations::getInstance()->getSummaryOfCashingHistory($_SESSION['user']['id'], ($_POST['dateFrom'] ?? Utils::getDateOfLastMonth()), ($_POST['dateTo'] ?? Utils::getCurrentDate()))
                        ]
                    ),
                ]
            ));
        default:
            header("Location: index.php?page=cabinet");
             die();
    }
}
