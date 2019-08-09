<?php
//Контроллер
//Обращение к супер глобальным массивам POST GET ...
//Выводы echo die print
//Нет HTML
//Нет циклов и foreach


error_reporting(E_ALL);
ini_set('display_errors', 1);



require_once('inc/functions.php');

if (isset($_POST)) {
    if ($_POST['sendFormSignUp']){
        processFormSignUp($_POST['name'], $_POST['email'], $_POST['password']);
    } elseif ($_POST['senFormSignIn']){
        processFormSignIn($_POST['email'], $_POST['password']);
    } elseif ($_POST['sendFormCabinet']) {
        processFormAddExpense($_POST['sum'], $_POST['comment'], $_POST['categoryId']);
    }
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
            ]
        ));
    case 'acceptForm':
        echo $_SESSION['username'];
        die (renderTemplate('layout.php',
            [
                'title' => 'acceptForm',
            ]
        ));
}

session_start();

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
                    'content' => renderTemplate('itemSignUp.php')
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
                            'expenses' => getUserExpenses(1)
                        ]
                    ),
                    'scriptForDate' =>
                        '<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
                        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
                        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>'
                ]
            ));
        default:
            header("Location: index.php?page=cabinet");
             die();
    }

}
