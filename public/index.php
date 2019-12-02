<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\MainPageController;
use App\Controller\SignUpController;
use App\Controller\CabinetController;
use App\Controller\HistoryController;
use App\Controller\CategoryController;
use App\Controller\CheckPageController;

use App\Middleware\GoToHomeIfLoggedIn;
use App\Middleware\GoToMainIfGuest;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response as Psr7Response;
use Slim\Factory\AppFactory;

use App\Utils;
use App\Database;
use App\Settings;
use App\Session;

error_reporting(E_ALL);
ini_set('display_errors', 1);

$app = AppFactory::create();

// TODO отрефакторить
Session::getInstance();

/** GET */
$app->get(Settings::ROUTE_ROOT, function (Request $request, Response $response) {
    $content = MainPageController::getContent();
    $response->getBody()->write($content);
    return $response;
});

$app->get(Settings::ROUTE_SIGN_UP, function (Request $request, Response $response) {
    $content = SignUpController::getContent();
    $response->getBody()->write($content);
    return $response;
})->add(new GoToHomeIfLoggedIn());

$app->get(Settings::ROUTE_CABINET, function (Request $request, Response $response) {
    $content = CabinetController::getContent();
    $response->getBody()->write($content);
    return $response;
})->add(new GoToMainIfGuest());

$app->get(Settings::ROUTE_CATEGORY, function (Request $request, Response $response) {
    $content = CategoryController::getContentCategory();
    $response->getBody()->write($content);
    return $response;
})->add(new GoToMainIfGuest());

$app->get(Settings::ROUTE_CATEGORY_CHANGE, function (Request $request, Response $response) {
    $content = CategoryController::getContentCategoryChange();
    $response->getBody()->write($content);
    return $response;
})->add(new GoToMainIfGuest());

$app->get(Settings::ROUTE_HISTORY, function (Request $request, Response $response) {
    $content = HistoryController::getContent(Utils::getDateOfLastMonth(), Utils::getCurrentDate());
    $response->getBody()->write($content);
    return $response;
})->add(new GoToMainIfGuest());

/** POST */
$app->post(Settings::ROUTE_SIGN_IN, function (Request $request, Response $response) {
    $email = $request->getParsedBody()['email'];
    $password = $request->getParsedBody()['password'];
    Database::getInstance()->processFormSignIn($email, $password);
    Session::getInstance()->signIn($email);
    $content = CheckPageController::getContentSignIn($email);
    $response->getBody()->write($content);
    return $response;
});

$app->post(Settings::ROUTE_SIGN_UP, function (Request $request, Response $response) {
    $name = $request->getParsedBody()['name'];
    $email = $request->getParsedBody()['email'];
    $password = $request->getParsedBody()['password'];
    Database::getInstance()->processFormSignUp($name, $email, $password);
    Session::getInstance()->signIn($email);
    $content = CheckPageController::getContentSingUp($name, $email, $password);
    $response->getBody()->write($content);
    return $response;
});

$app->post(Settings::ROUTE_NEW_COSTS, function (Request $request, Response $response) {
    $sum = $request->getParsedBody()['sum'];
    $comment = $request->getParsedBody()['comment'];
    $categoryId = $request->getParsedBody()['categoryId'];
    $userId = Session::getInstance()->getUserId();
    Database::getInstance()->processFormAddExpense($sum, $comment, $categoryId, $userId);
    $content = CheckPageController::getContentNewCosts($sum, $comment, $categoryId);
    $response->getBody()->write($content);
    return $response;
});

$app->post(Settings::ROUTE_HISTORY, function (Request $request, Response $response) {
    $dateFrom = $request->getParsedBody()['dateFrom'];
    $dateTo = $request->getParsedBody()['dateTo'];
    $content = HistoryController::getContent($dateFrom, $dateTo);
    $response->getBody()->write($content);
    return $response;
})->add(new GoToMainIfGuest());

$app->post(Settings::ROUTE_CATEGORY_ADD_NEW, function (Request $request, Response $response) {
    $categoryName = $request->getParsedBody()['categoryName'];
    Database::getInstance()->processFormAddCategory($categoryName);
    return Utils::redirect(new Psr7Response(), Settings::ROUTE_CATEGORY_CHANGE);
});

$app->post(Settings::ROUTE_CATEGORY_CHANGE, function (Request $request, Response $response) {
    $categoryId = $request->getParsedBody()['categoryId'];
    $categoryName = $request->getParsedBody()['categoryName'];
    Database::getInstance()->processFormChangeCategory($categoryId, $categoryName);
    return Utils::redirect(new Psr7Response(), Settings::ROUTE_CATEGORY_CHANGE);
});

$app->post(Settings::ROUTE_CATEGORY_DELETE, function (Request $request, Response $response) {
    $categoryId = $request->getParsedBody()['categoryId'];
    Database::getInstance()->processFormDeleteCategory($categoryId);
    return Utils::redirect(new Psr7Response(), Settings::ROUTE_CATEGORY_CHANGE);
});

$app->post(Settings::ROUTE_DOWNLOAD_ALL_HISTORY, function (Request $request, Response $response) {
    Utils::downloadAllHistory($_SESSION['user']['id']);
    return Utils::redirect(new Psr7Response(), Settings::ROUTE_HISTORY);
});

$app->get(Settings::ROUTE_LOGOUT, function (Request $request, Response $response) {
    Session::getInstance()->logout();
    return Utils::redirect(new Psr7Response(), Settings::ROUTE_ROOT);
});

// TODO





$app->run();






//
//
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
//
//require_once __DIR__ . '/../vendor/autoload.php';
//
//session_start();
//
//use App\Utils;
//use App\Database;
//use App\Operations;
//
//if ($_POST['sendFormSignUp'] ?? ''){
//    Database::getInstance()->processFormSignUp($_POST['name'], $_POST['email'], $_POST['password']);
//    $_SESSION['user'] = [
//        'id' => Database::getInstance()->findUserByEmail($_POST['email'])[0]['id'],
//        'email' => $_POST['email']
//    ];
//    die (Utils::renderTemplate('layout.php',
//        [
//            'title' => 'Регистрация',
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
//            'title' => 'Аутентификация',
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
//            'title' => 'Внесение расходов',
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
//} elseif ($_POST['sendCashing'] ?? '') {
//    Operations::getInstance()->processFormAddCashing($_POST['name'], $_POST['sum'], $_POST['card'], $_POST['percent'], $_SESSION['user']['id']);
//    die (Utils::renderTemplate('layout.php',
//        [
//            'title' => 'Обналичивание',
//            'nav' => Utils::renderTemplate(
//                'navbarCabinet.php',
//                [
//                    'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
//                ]
//            ),
//            'content' => Utils::renderTemplate(
//                'checkNewCashing.php',
//                [
//                    'userName' => $_POST['name'],
//                    'userSum' => $_POST['sum'],
//                    'userCard' => $_POST['card'],
//                    'userPercent' => $_POST['percent']
//                ]
//            ),
//        ]
//    ));
//} elseif ($_POST['sendOperation'] ?? '') {
//    Operations::getInstance()->processFormAddOperation($_POST['month'], $_POST['sum'], $_POST['profit'], $_POST['deposit'], $_POST['expenseFlat'], $_POST['expensePetrol'], $_SESSION['user']['id']);
//    die (Utils::renderTemplate('layout.php',
//        [
//            'title' => 'Операции',
//            'nav' => Utils::renderTemplate(
//                'navbarCabinet.php',
//                [
//                    'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
//                ]
//            ),
//            'content' => Utils::renderTemplate(
//                'checkNewOperation.php',
//                [
//                    'userMonth' => $_POST['month'],
//                    'userSum' => $_POST['sum'],
//                    'userProfit' => $_POST['profit'],
//                    'userDeposit' => $_POST['deposit'],
//                    'expenseFlat' => $_POST['expenseFlat'],
//                    'expensePetrol' => $_POST['expensePetrol']
//                ]
//            ),
//        ]
//    ));
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
//                    'title' => 'Регистрация',
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
//                    'title' => 'Внесение расходов',
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
//                    'title' => 'Категории',
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
//                    'title' => 'Категории',
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
//                    'title' => 'История',
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
//        case 'cashing':
//            die (Utils::renderTemplate('layout.php',
//                [
//                    'title' => 'Обналичивание',
//                    'nav' => Utils::renderTemplate(
//                        'navbarCabinet.php',
//                        [
//                            'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
//                        ]
//                    ),
//                    'jsStyle' => 'js/cashing.js',
//                    'content' => Utils::renderTemplate('itemCashing.php'),
//                ]
//            ));
//        case 'cashingHistory':
//            die (Utils::renderTemplate('layout.php',
//                [
//                    'title' => 'История обналичивания',
//                    'nav' => Utils::renderTemplate(
//                        'navbarCabinet.php',
//                        [
//                            'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
//                        ]
//                    ),
//                    'jsStyle' => 'js/history.js',
//                    'content' => Utils::renderTemplate(
//                        'itemCashingHistory.php',
//                        [
//                            'dateFrom' => $_POST['dateFrom'] ?? Utils::getFirstDateOfThisMonth(),
//                            'dateTo' => $_POST['dateTo'] ?? Utils::getCurrentDate(),
//                            'cashingOut' => Operations::getInstance()->getUserCashingHistory($_SESSION['user']['id'], ($_POST['dateFrom'] ?? Utils::getFirstDateOfThisMonth()), ($_POST['dateTo'] ?? Utils::getCurrentDate())),
//                            'allProfit' => Operations::getInstance()->getSummaryOfCashingProfit($_SESSION['user']['id'], ($_POST['dateFrom'] ?? Utils::getFirstDateOfThisMonth()), ($_POST['dateTo'] ?? Utils::getCurrentDate())),
//                            'allAmount' => Operations::getInstance()->getSummaryOfCashingAmount($_SESSION['user']['id'], ($_POST['dateFrom'] ?? Utils::getFirstDateOfThisMonth()), ($_POST['dateTo'] ?? Utils::getCurrentDate()))
//                        ]
//                    ),
//                ]
//            ));
//        case 'operations':
//            die (Utils::renderTemplate('layout.php',
//                [
//                    'title' => 'Операции',
//                    'nav' => Utils::renderTemplate(
//                        'navbarCabinet.php',
//                        [
//                            'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
//                        ]
//                    ),
//                    'content' => Utils::renderTemplate(
//                        'itemOperations.php',
//                        [
//                            'thisMonth' => Utils::getFirstDateOfThisMonth(),
//                            'lastMonthProfit' => Operations::getInstance()->getSummaryOfCashingProfit($_SESSION['user']['id'], Utils::getFirstDateOfLastMonth(), Utils::getLastDateOfLastMonth()),
//                        ]
//                    ),
//                ]
//            ));
//        case 'operationsHistory':
//            die (Utils::renderTemplate('layout.php',
//                [
//                    'title' => 'История операций',
//                    'nav' => Utils::renderTemplate(
//                        'navbarCabinet.php',
//                        [
//                            'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
//                        ]
//                    ),
//                    'content' => Utils::renderTemplate(
//                        'itemOperationsHistory.php',
//                        [
//                            'operations' => Operations::getInstance()->getUserOperationsHistory($_SESSION['user']['id'])
//                        ]
//                    ),
//                ]
//            ));
//        default:
//            header("Location: index.php?page=cabinet");
//             die();
//    }
//}
