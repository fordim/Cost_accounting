<?php

//Не должно быть
// Обращения к $_ (глобальные $_GET, $_POST)
//HTML code
// echo, die, print
//Это модель
function renderTemplate(string $name, array $data = []): string
{
    $name = 'templates/' . $name;
    $result = '';
    if (!is_readable($name)) {
        return $result;
    }
    ob_start();
    extract($data);
    require $name;
    $result = ob_get_clean();
    return $result;
}

function processFormSignUp(string $name, string $email, string $password){

}

function processFormSignIn(string $email, string $password){

}

function processFormAddExpense(float $sum, string $comment, int $categoryId){

}

function getUserExpenses(int $userId){ //все расходы пользователя
    return [
        [
            'createdAt' => new DateTime('2019-06-20'),
            'sum' => '400',
            'comment' => 'Строительные материалы',
            'category' => 'Разное',
        ]
    ];
}
