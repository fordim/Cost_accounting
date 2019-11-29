<?php

use App\HistoryController;
use App\Middleware\GoToHomeIfLoggedIn;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response as Psr7Response;
use Slim\Factory\AppFactory;

use App\Utils;
use App\Database;
use App\Settings;
use App\Session;

require_once __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$app = AppFactory::create();

// TODO отрефакторить
Session::getInstance();


$app->get(Settings::ROUTE_MAIN_PAGE, function (Request $request, Response $response) {
    $content = Utils::renderTemplate('layout.php',
        [
            'title' => 'Cost accounting',
            'nav' => Utils::renderNavBarMain(),
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
})->add(new GoToHomeIfLoggedIn());



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
            'nav' => Utils::renderNavBarCabinet(),
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
            'nav' => Utils::renderNavBarCabinet(),
            'content' => Utils::renderTemplate(
                'checkNewCosts.php',
                [
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

$app->post(Settings::ROUTE_SIGN_UP, function (Request $request, Response $response) {
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
            'nav' => Utils::renderNavBarCabinet(),
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
                    'newCostRoute' => Settings::ROUTE_NEW_COSTS,
                    'categories' => Database::getInstance()->getAllCategories()
                ]
            ),
        ]
    );
    $response->getBody()->write($content);
    return $response;
});

$app->get(Settings::ROUTE_HISTORY, function (Request $request, Response $response){
    $content = HistoryController::getContent(Utils::getDateOfLastMonth(), Utils::getCurrentDate());
    $response->getBody()->write($content);
    return $response;
});

$app->post(Settings::ROUTE_DATA_PICKER, function (Request $request, Response $response) {
    $dateFrom = $request->getParsedBody()['dateFrom'];
    $dateTo = $request->getParsedBody()['dateTo'];
    $content = HistoryController::getContent($dateFrom, $dateTo);
    $response->getBody()->write($content);
    return $response;
});

$app->get(Settings::ROUTE_CATEGORY, function (Request $request, Response $response){
    $content = Utils::renderTemplate('layout.php',
        [
            'title' => 'Category',
            'nav' => Utils::renderTemplate('navbarCabinet.php',
                [
                    'mainRoute' => Settings::ROUTE_MAIN_PAGE,
                    'cabinetRoute' => Settings::ROUTE_CABINET,
                    'historyRoute' => Settings::ROUTE_HISTORY,
                    'categoryRoute' => Settings::ROUTE_CATEGORY,
                    'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
                ]
            ),
            'content' => Utils::renderTemplate('itemCategory.php',
                [
                    'categories' => Database::getInstance()->getAllCategories(),
                    'categoryChangeRoute' => Settings::ROUTE_CATEGORY_CHANGE
                ]
            ),
        ]
    );
    $response->getBody()->write($content);
    return $response;
});

$app->get(Settings::ROUTE_CATEGORY_CHANGE, function (Request $request, Response $response){
    $content = Utils::renderTemplate('layout.php',
        [
            'title' => 'Category',
            'nav' => Utils::renderTemplate('navbarCabinet.php',
                [
                    'mainRoute' => Settings::ROUTE_MAIN_PAGE,
                    'cabinetRoute' => Settings::ROUTE_CABINET,
                    'historyRoute' => Settings::ROUTE_HISTORY,
                    'categoryRoute' => Settings::ROUTE_CATEGORY,
                    'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
                ]
            ),
            'content' => Utils::renderTemplate('itemCategoryChange.php',
                [
                    'addNewCategoryRoute' => Settings::ROUTE_ADD_NEW_CATEGORY,
                    'changeCategoryRoute' => Settings::ROUTE_CHANGE_CATEGORY,
                    'deleteCategoryRoute' => Settings::ROUTE_DELETE_CATEGORY,
                    'categories' => Database::getInstance()->getAllCategories(),
                    'categoryRoute' => Settings::ROUTE_CATEGORY
                ]
            ),
        ]
    );
    $response->getBody()->write($content);
    return $response;
});

$app->post(Settings::ROUTE_ADD_NEW_CATEGORY, function (Request $request, Response $response){
    $categoryName = $request->getParsedBody()['categoryName'];
    Database::getInstance()->processFormAddCategory($categoryName);
    return Utils::redirect(new Psr7Response(), Settings::ROUTE_CATEGORY_CHANGE);
});

$app->post(Settings::ROUTE_CHANGE_CATEGORY, function (Request $request, Response $response){
    $categoryId = $request->getParsedBody()['categoryId'];
    $categoryName = $request->getParsedBody()['categoryName'];

    Database::getInstance()->processFormChangeCategory($categoryId, $categoryName);

    $content = Utils::renderTemplate('layout.php',
        [
            'title' => 'Category',
            'nav' => Utils::renderTemplate('navbarCabinet.php',
                [
                    'mainRoute' => Settings::ROUTE_MAIN_PAGE,
                    'cabinetRoute' => Settings::ROUTE_CABINET,
                    'historyRoute' => Settings::ROUTE_HISTORY,
                    'categoryRoute' => Settings::ROUTE_CATEGORY,
                    'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
                ]
            ),
            'content' => Utils::renderTemplate('itemCategoryChange.php',
                [
                    'addNewCategoryRoute' => Settings::ROUTE_ADD_NEW_CATEGORY,
                    'changeCategoryRoute' => Settings::ROUTE_CHANGE_CATEGORY,
                    'deleteCategoryRoute' => Settings::ROUTE_DELETE_CATEGORY,
                    'categories' => Database::getInstance()->getAllCategories(),
                    'categoryRoute' => Settings::ROUTE_CATEGORY
                ]
            ),
        ]
    );
    $response->getBody()->write($content);
    return $response;
});

$app->post(Settings::ROUTE_DELETE_CATEGORY, function (Request $request, Response $response){
    $categoryId = $request->getParsedBody()['categoryId'];

    Database::getInstance()->processFormDeleteCategory($categoryId);

    $content = Utils::renderTemplate('layout.php',
        [
            'title' => 'Category',
            'nav' => Utils::renderTemplate('navbarCabinet.php',
                [
                    'mainRoute' => Settings::ROUTE_MAIN_PAGE,
                    'cabinetRoute' => Settings::ROUTE_CABINET,
                    'historyRoute' => Settings::ROUTE_HISTORY,
                    'categoryRoute' => Settings::ROUTE_CATEGORY,
                    'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
                ]
            ),
            'content' => Utils::renderTemplate('itemCategoryChange.php',
                [
                    'addNewCategoryRoute' => Settings::ROUTE_ADD_NEW_CATEGORY,
                    'changeCategoryRoute' => Settings::ROUTE_CHANGE_CATEGORY,
                    'deleteCategoryRoute' => Settings::ROUTE_DELETE_CATEGORY,
                    'categories' => Database::getInstance()->getAllCategories(),
                    'categoryRoute' => Settings::ROUTE_CATEGORY
                ]
            ),
        ]
    );
    $response->getBody()->write($content);
    return $response;
});

$app->post(Settings::ROUTE_DOWNLOAD_ALL_HISTORY, function (Request $request, Response $response){

    Utils::downloadAllHistory($_SESSION['user']['id']);

    $content = Utils::renderTemplate('layout.php',
        [
            'title' => 'History',
            'nav' => Utils::renderTemplate('navbarCabinet.php',
                [
                    'mainRoute' => Settings::ROUTE_MAIN_PAGE,
                    'cabinetRoute' => Settings::ROUTE_CABINET,
                    'historyRoute' => Settings::ROUTE_HISTORY,
                    'categoryRoute' => Settings::ROUTE_CATEGORY,
                    'userName' => Database::getInstance()->getUserName($_SESSION['user']['id'])
                ]
            ),
            'jsStyle' => 'js/history.js',
            'content' => Utils::renderTemplate('itemHistory.php',
                [
                    'dataPickerRoute' => Settings::ROUTE_DATA_PICKER,
                    'dateFrom' => Utils::getDateOfLastMonth(),
                    'dateTo' => Utils::getCurrentDate(),
                    'expenses' => Database::getInstance()->getUserExpenses($_SESSION['user']['id'], Utils::getDateOfLastMonth(), Utils::getCurrentDate()),
                    'downloadAllHistoryRoute' => Settings::ROUTE_DOWNLOAD_ALL_HISTORY
                ]
            ),
        ]
    );
    $response->getBody()->write($content);
    return $response;
});

$app->run();
