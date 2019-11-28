<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use App\Utils;
use App\Database;
use App\Settings;

require_once __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$app = AppFactory::create();

$app->post(Settings::ROUTE_SIGN_IN, function (Request $request, Response $response) {
    $email = $request->getParsedBody()['email'];
    $password = $request->getParsedBody()['password'];

    Database::getInstance()->processFormSignIn($email, $password);

    $_SESSION['user'] = [
        'id' => Database::getInstance()->findUserByEmail($email)[0]['id'],
        'email' => $email
    ];

    $content = Utils::renderTemplate('layout.php',
        [
            'title' => 'checkSignIn',
            'nav' => Utils::renderTemplate(
                'navbarCabinet.php',
                [
                    'mainRoute' => Settings::ROUTE_MAIN_PAGE,
                    'cabinetRoute' => Settings::ROUTE_CABINET,
                    'historyRoute' => Settings::ROUTE_HISTORY,
                    'categoryRoute' => Settings::ROUTE_CATEGORY,
                    'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
                ]
            ),
            'content' => Utils::renderTemplate(
                'checkSignIn.php',
                [
                    'userName' => $email,
                    'cabinetRoute' => Settings::ROUTE_CABINET
                ]
            ),
        ]
    );

    $response->getBody()->write($content);
    return $response;
});

$app->post(Settings::ROUTE_NEW_COSTS, function (Request $request, Response $response) {
    $sum = $request->getParsedBody()['sum'];
    $comment = $request->getParsedBody()['comment'];
    $categoryId = $request->getParsedBody()['categoryId'];
    $userId = $_SESSION['user']['id'];

    Database::getInstance()->processFormAddExpense($sum, $comment, $categoryId, $userId);

    $content = Utils::renderTemplate('layout.php',
        [
            'title' => 'checkNewCosts',
            'nav' => Utils::renderTemplate(
                'navbarCabinet.php',
                [
                    'mainRoute' => Settings::ROUTE_MAIN_PAGE,
                    'cabinetRoute' => Settings::ROUTE_CABINET,
                    'historyRoute' => Settings::ROUTE_HISTORY,
                    'categoryRoute' => Settings::ROUTE_CATEGORY,
                    'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
                ]
            ),
            'content' => Utils::renderTemplate(
                'checkNewCosts.php',
                [
                    'newCostRoute' => Settings::ROUTE_NEW_COSTS,
                    'userSum' => $sum,
                    'userCategory' => Database::getInstance()->getCategoryName($categoryId),
                    'userComment' => $comment,
                    'cabinetRoute' => Settings::ROUTE_CABINET,
                    'historyRoute' => Settings::ROUTE_HISTORY
                ]
            ),
        ]
    );

    $response->getBody()->write($content);
    return $response;
});

$app->post(Settings::ROUTE_SIGN_UP, function (Request $request, Response $response){
    $name = $request->getParsedBody()['name'];
    $email = $request->getParsedBody()['email'];
    $password = $request->getParsedBody()['password'];

    Database::getInstance()->processFormSignUp($name, $email, $password);

    $_SESSION['user'] = [
        'id' => Database::getInstance()->findUserByEmail($email)[0]['id'],
        'email' => $email
    ];

    $content = Utils::renderTemplate('layout.php',
        [
            'title' => 'checkSignUp',
            'nav' => Utils::renderTemplate(
                'navbarCabinet.php',
                [
                    'mainRoute' => Settings::ROUTE_MAIN_PAGE,
                    'cabinetRoute' => Settings::ROUTE_CABINET,
                    'historyRoute' => Settings::ROUTE_HISTORY,
                    'categoryRoute' => Settings::ROUTE_CATEGORY,
                    'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
                ]
            ),
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

    $response->getBody()->write($content);
    return $response;
});

$app->get(Settings::ROUTE_MAIN_PAGE, function (Request $request, Response $response) {
    $content = Utils::renderTemplate('layout.php',
        [
            'title' => 'Cost accounting',
            'nav' => Utils::renderTemplate(
                'navbarMain.php',
                [
                    'mainRoute' => Settings::ROUTE_MAIN_PAGE,
                    'signUpPageRoute' => Settings::ROUTE_SIGN_UP_PAGE,
                    'signInRoute' => Settings::ROUTE_SIGN_IN
                ]
            ),
            'content' => Utils::renderTemplate('itemMain.php'),
        ]
    );

    $response->getBody()->write($content);
    return $response;
});

$app->get(Settings::ROUTE_SIGN_UP_PAGE, function (Request $request, Response $response){
   $content = Utils::renderTemplate('layout.php',
       [
           'title' => 'Sign Up',
           'nav' => Utils::renderTemplate('navbarMain.php',
               [
                   'mainRoute' => Settings::ROUTE_MAIN_PAGE,
                   'signUpPageRoute' => Settings::ROUTE_SIGN_UP_PAGE,
                   'signInRoute' => Settings::ROUTE_SIGN_IN
               ]
           ),
           'jsStyle' => 'js/signUp.js',
           'content' => Utils::renderTemplate('itemSignUp.php',
               [
                   'signUpRoute' => Settings::ROUTE_SIGN_UP
               ]
           ),
       ]
   );
    $response->getBody()->write($content);
    return $response;
});

$app->get(Settings::ROUTE_CABINET, function (Request $request, Response $response){
    $content = Utils::renderTemplate('layout.php',
        [
            'title' => 'Cabinet',
            'nav' => Utils::renderTemplate('navbarCabinet.php',
                [
                    'mainRoute' => Settings::ROUTE_MAIN_PAGE,
                    'cabinetRoute' => Settings::ROUTE_CABINET,
                    'historyRoute' => Settings::ROUTE_HISTORY,
                    'categoryRoute' => Settings::ROUTE_CATEGORY,
                    'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
                ]
            ),
            'content' => Utils::renderTemplate('itemCabinet.php',
                [
                    'categories' => Database::getInstance()->getAllCategories()
                ]
            ),
        ]
    );
    $response->getBody()->write($content);
    return $response;
});

//$app->get(Settings::ROUTE_HISTORY, function (Request $request, Response $response){
//    $content = Utils::renderTemplate('layout.php',
//        [
//            'title' => 'Cabinet',
//            'nav' => Utils::renderTemplate('navbarCabinet.php',
//                [
//                    'mainRoute' => Settings::ROUTE_MAIN_PAGE,
//                    'cabinetRoute' => Settings::ROUTE_CABINET,
//                    'historyRoute' => Settings::ROUTE_HISTORY,
//                    'categoryRoute' => Settings::ROUTE_CATEGORY,
//                    'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
//                ]
//            ),
//            'content' => Utils::renderTemplate('itemCabinet.php',
//                [
//                    'categories' => Database::getInstance()->getAllCategories()
//                ]
//            ),
//        ]
//    );
//    $response->getBody()->write($content);
//    return $response;
//});
//
//$app->run();

//case 'history':
//            die (Utils::renderTemplate(
//                'layout.php',
//                [
//                    'title' => 'History',
//                    'nav' => Utils::renderTemplate(
//                        'navbarCabinet.php',
//                        [
//                            'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
//                        ]
//                    ),
//                    'jsStyle' => 'js/history.js',
//                    'content' => Utils::renderTemplate(
//                        'itemHistory.php',
//                        [
//                            'dateFrom' => $_POST['dateFrom'] ?? Utils::getDateOfLastMonth() ,
//                            'dateTo' => $_POST['dateTo'] ?? Utils::getCurrentDate(),
//                            'expenses' => Database::getInstance()->getUserExpenses($_SESSION['user']['id'], ($_POST['dateFrom'] ?? Utils::getDateOfLastMonth()), ($_POST['dateTo'] ?? Utils::getCurrentDate()))
//                        ]
//                    ),
//                ]
//            ));

//if ($_POST['sendFormSignUp'] ?? ''){
//    Database::getInstance()->processFormSignUp($_POST['name'], $_POST['email'], $_POST['password']);
//    $_SESSION['user'] = [
//        'id' => Database::getInstance()->findUserByEmail($_POST['email'])[0]['id'],
//        'email' => $_POST['email']
//    ];
//    die (Utils::renderTemplate('layout.php',
//        [
//            'title' => 'checkSignUp',
//            'nav' => Utils::renderTemplate(
//                'navbarCabinet.php',
//                [
//                    'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
//                ]
//            ),
//            'content' => Utils::renderTemplate(
//                'checkSignUp.php',
//                [
//                    'userName' => $_POST['name'],
//                    'userEmail' => $_POST['email'],
//                    'userPassword' => $_POST['password']
//                ]
//            ),
//        ]
//    ));
//} elseif ($_POST['sendFormSignIn'] ?? ''){
//    Database::getInstance()->processFormSignIn($_POST['email'], $_POST['password']);
//    $_SESSION['user'] = [
//        'id' => Database::getInstance()->findUserByEmail($_POST['email'])[0]['id'],
//        'email' => $_POST['email']
//    ];
//    die (Utils::renderTemplate('layout.php',
//        [
//            'title' => 'checkSignIn',
//            'nav' => Utils::renderTemplate(
//                'navbarCabinet.php',
//                [
//                    'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
//                ]
//            ),
//            'content' => Utils::renderTemplate(
//                'checkSignIn.php',
//                [
//                    'userName' => $_POST['email']
//                ]
//            ),
//        ]
//    ));
//} elseif ($_POST['sendFormCabinet'] ?? '') {
//    Database::getInstance()->processFormAddExpense($_POST['sum'], $_POST['comment'], $_POST['categoryId'], $_SESSION['user']['id']);
//    die (Utils::renderTemplate('layout.php',
//        [
//            'title' => 'checkNewCosts',
//            'nav' => Utils::renderTemplate(
//                'navbarCabinet.php',
//                [
//                    'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
//                ]
//            ),
//            'content' => Utils::renderTemplate(
//                'checkNewCosts.php',
//                [
//                    'userSum' => $_POST['sum'],
//                    'userCategory' => Database::getInstance()->getCategoryName($_POST['categoryId']),
//                    'userComment' => $_POST['comment']
//                ]
//            ),
//        ]
//    ));
//} elseif ($_POST['addNewCategory'] ?? '') {
//    Database::getInstance()->processFormAddCategory($_POST['categoryName']);
//} elseif ($_POST['changeExistCategory'] ?? '') {
//    Database::getInstance()->processFormChangeCategory($_POST['categoryId'], $_POST['categoryName']);
//} elseif ($_POST['deleteExistCategory'] ?? '') {
//    Database::getInstance()->processFormDeleteCategory($_POST['categoryId']);
//} elseif ($_POST['downloadAllHistory'] ?? '') {
//    Utils::downloadAllHistory($_SESSION['user']['id']);
//}
//
//$currentPage = $_GET['page'] ?? 'main';
//
//switch ($currentPage) {
//    case 'main':
//        die (Utils::renderTemplate('layout.php',
//            [
//                'title' => 'Cost accounting',
//                'nav' => Utils::renderTemplate('navbarMain.php'),
//                'content' => Utils::renderTemplate('itemMain.php'),
//            ]
//        ));
//}
//
//if (!isset($_SESSION['user'])) {
//    switch ($currentPage){
//        case 'signUp':
//            die (Utils::renderTemplate('layout.php',
//                [
//                    'title' => 'Sign Up',
//                    'nav' => Utils::renderTemplate('navbarMain.php'),
//                    'jsStyle' => 'js/signUp.js',
//                    'content' => Utils::renderTemplate('itemSignUp.php'),
//                ]
//            ));
//        default:
//            echo 'Доступ закрыт 403';
//    }
//} else {
//    switch ($currentPage){
//        case 'cabinet':
//            die (Utils::renderTemplate('layout.php',
//                [
//                    'title' => 'Cabinet',
//                    'nav' => Utils::renderTemplate(
//                        'navbarCabinet.php',
//                        [
//                            'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
//                        ]
//                    ),
//                    'content' => Utils::renderTemplate(
//                        'itemCabinet.php',
//                        [
//                            'categories' => Database::getInstance()->getAllCategories()
//                        ]
//                    ),
//                ]
//            ));
//        case 'category':
//            die (Utils::renderTemplate('layout.php',
//                [
//                    'title' => 'Category',
//                    'nav' => Utils::renderTemplate(
//                        'navbarCabinet.php',
//                        [
//                            'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
//                        ]
//                    ),
//                    'content' => Utils::renderTemplate(
//                        'itemCategory.php',
//                        [
//                            'categories' => Database::getInstance()->getAllCategories()
//                        ]
//                    ),
//                ]
//            ));
//        case 'categoryChange':
//            die (Utils::renderTemplate('layout.php',
//                [
//                    'title' => 'Category',
//                    'nav' => Utils::renderTemplate(
//                        'navbarCabinet.php',
//                        [
//                            'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
//                        ]
//                    ),
//                    'content' => Utils::renderTemplate(
//                        'itemCategoryChange.php',
//                        [
//                            'categories' => Database::getInstance()->getAllCategories()
//                        ]
//                    ),
//                ]
//            ));
//        case 'history':
//            die (Utils::renderTemplate(
//                'layout.php',
//                [
//                    'title' => 'History',
//                    'nav' => Utils::renderTemplate(
//                        'navbarCabinet.php',
//                        [
//                            'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
//                        ]
//                    ),
//                    'jsStyle' => 'js/history.js',
//                    'content' => Utils::renderTemplate(
//                        'itemHistory.php',
//                        [
//                            'dateFrom' => $_POST['dateFrom'] ?? Utils::getDateOfLastMonth() ,
//                            'dateTo' => $_POST['dateTo'] ?? Utils::getCurrentDate(),
//                            'expenses' => Database::getInstance()->getUserExpenses($_SESSION['user']['id'], ($_POST['dateFrom'] ?? Utils::getDateOfLastMonth()), ($_POST['dateTo'] ?? Utils::getCurrentDate()))
//                        ]
//                    ),
//                ]
//            ));
//        default:
//            header("Location: index.php?page=cabinet");
//             die();
//    }
//}
