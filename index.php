<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('inc/functions.php');
require_once('inc/database.php');
require_once('inc/download.php');
require_once 'init.php';

if ($_POST['sendFormSignUp'] ?? ''){
    processFormSignUp($link, $_POST['name'], $_POST['email'], $_POST['password']);
    die (renderTemplate('layout.php',
        [
            'title' => 'checkSignUp',
            'cssStyle' => 'css/check.css',
            'content' => renderTemplate(
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
    processFormSignIn($link, $_POST['email'], $_POST['password']);
    die (renderTemplate('layout.php',
        [
            'title' => 'checkSignIn',
            'cssStyle' => 'css/check.css',
            'content' => renderTemplate(
                'checkSignIn.php',
                [
                    'userName' => $_POST['email']
                ]
            ),
        ]
    ));
} elseif ($_POST['sendFormCabinet'] ?? '') {
    processFormAddExpense($link, $_POST['sum'], $_POST['comment'], $_POST['categoryId'], $_SESSION['user']['id']);
    die (renderTemplate('layout.php',
        [
            'title' => 'checkNewCosts',
            'cssStyle' => 'css/check.css',
            'content' => renderTemplate(
                'checkNewCosts.php',
                [
                    'userSum' => $_POST['sum'],
                    'userCategory' => $_POST['categoryId'],
                    'userComment' => $_POST['comment']
                ]
            ),
        ]
    ));
} elseif ($_POST['addNewCategory'] ?? '') {
    processFormAddCategory($link, $_POST['categoryName']);
} elseif ($_POST['changeExistCategory'] ?? '') {
    processFormChangeCategory($link, $_POST['categoryId'], $_POST['categoryName']);
} elseif ($_POST['deleteExistCategory'] ?? '') {
    processFormDeleteCategory($link, $_POST['categoryId']);
} elseif ($_POST['downloadAllHistory'] ?? '') {
    downloadAllHistory($link, $_SESSION['user']['id']);
}

$currentPage = $_GET['page'] ?? 'main';

switch ($currentPage) {
    case 'main':
        die (renderTemplate('layout.php',
            [
                'title' => 'Cost accounting',
                'cssStyle' => "css/main.css",
                'content' => renderTemplate('itemMain.php'),
            ]
        ));
}

if (!isset($_SESSION['user'])) {
    switch ($currentPage){
        case 'signIn':
            die (renderTemplate('layout.php',
                [
                    'title' => 'Sign In',
                    'cssStyle' => 'css/signIn.css',
                    'content' => renderTemplate('itemSignIn.php'),
                ]
            ));
        case 'signUp':
            die (renderTemplate('layout.php',
                [
                    'title' => 'Sign Up',
                    'cssStyle' => 'css/signUp.css',
                    'jsStyle' => 'js/signUp.js',
                    'content' => renderTemplate('itemSignUp.php'),
                ]
            ));
        default:
            echo $_SESSION['user']['email'];
            echo 'Доступ закрыт 403';
    }
} else {
    switch ($currentPage){
        case 'cabinet':
            die (renderTemplate('layout.php',
                [
                    'title' => 'Cabinet',
                    'cssStyle' => 'css/cabinet.css',
                    'jsStyle' => 'js/cabinet.js',
                    'content' => renderTemplate(
                        'itemCabinet.php',
                        [
                            'categories' => getAllCategories($link)
                        ]
                    ),
                ]
            ));
        case 'category':
            die (renderTemplate('layout.php',
                [
                    'title' => 'Category',
                    'cssStyle' => 'css/category.css',
                    'content' => renderTemplate(
                        'itemCategory.php',
                        [
                            'categories' => getAllCategories($link)
                        ]
                    ),
                ]
            ));
        case 'history':
            die (renderTemplate(
                'layout.php',
                [
                    'title' => 'History',
                    'cssStyle' => 'css/history.css',
                    'jsStyle' => 'js/history.js',
                    'content' => renderTemplate(
                        'itemHistory.php',
                        [
                            'dateFrom' => $_POST['dateFrom'] ?? getDateOfLastMonth() ,
                            'dateTo' => $_POST['dateTo'] ?? getCurrentDate(),
                            'expenses' => getUserExpenses($link, $_SESSION['user']['id'], ($_POST['dateFrom'] ?? getDateOfLastMonth()), ($_POST['dateTo'] ?? getCurrentDate()))
                        ]
                    ),
                ]
            ));
        default:
            header("Location: index.php?page=cabinet");
             die();
    }

}
