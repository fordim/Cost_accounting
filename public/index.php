<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\MainPageController;
use App\Controller\SignUpController;
use App\Controller\CabinetController;
use App\Controller\HistoryController;
use App\Controller\CategoryController;
use App\Controller\CheckPageController;
use App\Controller\CashingController;
use App\Controller\CashingHistoryController;
use App\Controller\OperationController;
use App\Controller\OperationHistoryController;

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

$app->get(Settings::ROUTE_CASHING, function (Request $request, Response $response) {
    $content = CashingController::getContent();
    $response->getBody()->write($content);
    return $response;
})->add(new GoToMainIfGuest());

$app->get(Settings::ROUTE_CASHING_HISTORY, function (Request $request, Response $response) {
    $content = CashingHistoryController::getContent(Utils::getFirstDateOfThisMonth(), Utils::getCurrentDate());
    $response->getBody()->write($content);
    return $response;
})->add(new GoToMainIfGuest());

$app->get(Settings::ROUTE_OPERATION, function (Request $request, Response $response) {
    $content = OperationController::getContent();
    $response->getBody()->write($content);
    return $response;
})->add(new GoToMainIfGuest());

$app->get(Settings::ROUTE_OPERATION_HISTORY, function (Request $request, Response $response) {
    $content = OperationHistoryController::getContent();
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

$app->post(Settings::ROUTE_CASHING_HISTORY, function (Request $request, Response $response) {
    $dateFrom = $request->getParsedBody()['dateFrom'];
    $dateTo = $request->getParsedBody()['dateTo'];
    $content = CashingHistoryController::getContent($dateFrom, $dateTo);
    $response->getBody()->write($content);
    return $response;
})->add(new GoToMainIfGuest());

$app->post(Settings::ROUTE_CASHING, function (Request $request, Response $response) {
    $name = $request->getParsedBody()['name'];
    $sum = $request->getParsedBody()['sum'];
    $card = $request->getParsedBody()['card'];
    $percent = $request->getParsedBody()['percent'];
    $userId = Session::getInstance()->getUserId();
    Database::getInstance()->processFormAddCashing($name, $sum, $card, $percent, $userId);
    $content = CheckPageController::getContentCashing($name, $sum, $card, $percent);
    $response->getBody()->write($content);
    return $response;
});

$app->post(Settings::ROUTE_OPERATION, function (Request $request, Response $response) {
    $month = $request->getParsedBody()['month'];
    $sum = $request->getParsedBody()['sum'];
    $profit = $request->getParsedBody()['profit'];
    $deposit = $request->getParsedBody()['deposit'];
    $expenseFlat = $request->getParsedBody()['expenseFlat'];
    $userId = Session::getInstance()->getUserId();
    Database::getInstance()->processFormAddOperation($month, $sum, $profit, $deposit, $expenseFlat, $userId);
    $content = CheckPageController::getContentOperation($month, $sum, $profit, $deposit, $expenseFlat);
    $response->getBody()->write($content);
    return $response;
});

$app->run();
