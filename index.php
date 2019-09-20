<?php
//Контроллер
//Обращение к супер глобальным массивам POST GET ...
//Выводы echo die print
//Нет HTML
//Нет циклов и foreach

error_reporting(E_ALL);
ini_set('display_errors', 1); // в инит вынести

require_once('inc/functions.php');
require_once 'init.php'; // подключаем скрипт

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
} elseif ($_POST['senFormSignIn'] ?? ''){
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
    processFormAddExpense($link, $_POST['sum'], $_POST['comment'], $_POST['categoryId'], $_SESSION['username']);
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

if (!isset($_SESSION['username'])) {
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
            echo $_SESSION['username'];
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
                            'expenses' => getUserExpenses($link, $_SESSION['username'])
                        ]
                    ),
                ]
            ));
        default:
            header("Location: index.php?page=cabinet");
             die();
    }

}
