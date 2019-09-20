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
    die ('Вы успешно зарегистрировались');
} elseif ($_POST['senFormSignIn'] ?? ''){
    processFormSignIn($_POST['email'], $_POST['password']);
} elseif ($_POST['sendFormCabinet'] ?? '') {
    processFormAddExpense($link, $_POST['sum'], $_POST['comment'], $_POST['categoryId']);
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
    case 'checkLogin':
        die (renderTemplate('layout.php',
            [
                'title' => 'checkLogin',
                'cssStyle' => 'css/checkLogIn.css',
                'content' => '',
            ]
        ));
    case 'acceptForm':
        die (renderTemplate('layout.php',
            [
                'title' => 'acceptForm',
                'cssStyle' => 'css/checkLogIn.css',
                'content' => '',
            ]
        ));
}

session_start(); // в инит вынести (и убрать везде)

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
                    'content' => renderTemplate('itemCabinet.php'),
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
                            'expenses' => getUserExpenses($link, 6)
                        ]
                    ),
                ]
            ));
        default:
            header("Location: index.php?page=cabinet");
             die();
    }

}
