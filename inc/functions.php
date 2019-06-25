<?php
//Это модель
//Нет Обращения к $_ (глобальные $_GET, $_POST)
//Нет HTML code
//Нет echo, die, print

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
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    print("<br>Name: " . $name);
    print("<br>Email: " . $email);
    print("<br>Password: " . $password);
    print("<br>PasswordHash: " . $passwordHash);
}

function processFormSignIn(string $email, string $password){
    print("<br>Email: " . $email);
    print("<br>Password: " . $password);
}

function processFormAddExpense(float $sum, string $comment, int $categoryId){
    print("<br>Sum: " . $sum);
    print("<br>Comment: " . $comment);
    print("<br>Category: " . $categoryId);
}

function getUserExpenses(int $userId){ //все расходы пользователя
    return [
        [
            'createdAt' => new DateTime('2019-06-20'),
            'sum' => '400',
            'comment' => 'Строительные материалы',
            'category' => 'Разное',
        ],
        [
            'createdAt' => new DateTime('2019-06-22'),
            'sum' => '300',
            'comment' => 'Строительные материалы',
            'category' => 'Разное',
        ],
        [
            'createdAt' => new DateTime('2019-06-23'),
            'sum' => '500',
            'comment' => 'Строительные материалы',
            'category' => 'Разное',
        ],
        [
            'createdAt' => new DateTime('2019-06-24'),
            'sum' => '600',
            'comment' => 'Строительные материалы',
            'category' => 'Разное',
        ],
    ];
}
