<?php
//Это модель
//Нет Обращения к $_ (глобальные $_GET, $_POST)
//Нет HTML code
//Нет echo, die, print
//Нет session_start(), глобальные $link
//require_once 'init.php'; - это нельзя

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

function processFormSignUp($link, string $name, string $email, string $passwordUser){
    $passwordHash = password_hash($passwordUser, PASSWORD_DEFAULT);

    $query =   "INSERT INTO users (email, name, password_hash)
                VALUES ('$email', '$name', '$passwordHash')";

    $result = mysqli_query($link, $query) or die("Ошибка, не удалось заренистрировать пользователя </br>" . mysqli_error($link));
}

function processFormSignIn(string $email, string $password){
    $adminLogin = 'test@mail.ru';
    $adminPassword = 'test123';
    $adminName = 'Admin';
    $adminPasswordHash = password_hash($adminPassword, PASSWORD_DEFAULT);

    if ($adminLogin === $email && password_verify($password, $adminPasswordHash)) {
        $_SESSION['username'] = $email;
    }
}

function processFormAddExpense($link, float $sum, string $comment, int $categoryId){

        $sum = htmlentities(mysqli_real_escape_string($link, $sum));
        $comment = htmlentities(mysqli_real_escape_string($link, $comment));
        $categoryId = htmlentities(mysqli_real_escape_string($link, $categoryId));

        $query =   "INSERT INTO history(user_id, category_id, amount, comment)
                    VALUES (6, $categoryId, $sum, '$comment')";

        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
}

function fetchData($link, string $sql): array {
    $result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getUserExpenses($link, int $userId): array { //все расходы пользователя

    $query =    "SELECT h.created_at, h.amount,  h.comment, c.name as category
                FROM history AS h
                JOIN users AS u ON h.user_id = u.id
                JOIN categories AS c ON h.category_id = c.id
                WHERE h.user_id = $userId
                ORDER BY h.created_at";

    return fetchData($link, $query);
}

function formatDateTime(DateTime $dateTime): string {
    return $dateTime->format('Y-m-d');
}

