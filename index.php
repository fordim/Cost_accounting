<?php
//Контроллер
//Обращение к супер глобальным массивам POST GET ...
//Выводы echo die print
//Нет HTML
//Нет циклов и foreach

require_once('inc/functions.php');

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
    case 'history':
        die (renderTemplate(
            'layout.php',
            [
                'title' => 'History',
                'cssStyle' => 'css/history.css',
                'jsStyle' => 'js/history.js',
                'content' => renderTemplate('itemHistory.php'),
            ]
        ));
    default:
        echo '404';
}





