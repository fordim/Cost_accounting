<?php
//Контроллер
//Обращение к супер глобальным массивам POST GET ...
//Выводы echo die print
//Нет HTML
//Нет циклов и foreach

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
switch ($currentPage){
    case 'main':
        die (renderTemplate(
            'layout.php',
            [
                'title' => 'Cost accounting',
                'cssStyle' => "css/main.css",
                'content' => renderTemplate('itemMain.php'),
            ]
        ));
    case 'cabinet':
        die (renderTemplate('layout.php',
            [
                'title' => 'Cabinet',
                'cssStyle' => 'css/cabinet.css',
                'jsStyle' => 'js/cabinet.js',
                'content' => renderTemplate('itemCabinet.php'),
            ]
        ));
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
    case 'acceptForm':
        die (renderTemplate('layout.php',
            [
                'title' => 'acceptForm',
            ]
        ));
    case 'history':
        die (renderTemplate(
            'layout.php',
            [
                'title' => 'History',
                'cssStyle' => 'css/history.css',
                'jsStyle' => 'js/history.js',
                'content' => renderTemplate('itemHistory.php'),
                'scriptForDate' =>
                    '<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
                     <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
                     <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>'
            ]
        ));
    default:
        echo '404';
}





