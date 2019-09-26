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

function processFormSignIn($link, string $email, string $password){
    $email = requestVerification($link, $email);
    $sql = "SELECT * FROM users AS u WHERE u.email = '$email'";

    $users = fetchData($link, $sql);
    if (count($users) === 1){
        $user = $users[0];
        $password_hash = $user['password_hash'];
        if (password_verify($password, $password_hash)){
            $_SESSION['user'] = [
                'id' => (int)$user['id'],
                'email' => $user['email']
            ];
            return;
        }
    }
    die ("Пользователя не существует в базе или введен не верный логин/пароль. </br>Повторите попытку.");
}

function insertData($link, string $sql): int {
    $result = mysqli_query($link, $sql) or die ("Ошибка, при попытке сделать запись в БД </br>" . mysqli_error($link));
    return mysqli_insert_id($link);
}

function requestVerification($link, $a){
    return htmlentities(mysqli_real_escape_string($link, $a));
}

function processFormSignUp($link, string $name, string $email, string $passwordUser){
    $name = requestVerification($link, $name);
    $email = requestVerification($link, $email);
    $passwordUser = requestVerification($link, $passwordUser);
    $passwordHash = password_hash($passwordUser, PASSWORD_DEFAULT);

    $sql =   "INSERT INTO users (email, name, password_hash)
                VALUES ('$email', '$name', '$passwordHash')";

    insertData($link, $sql);
    $user = findUserByEmail($link, $email);
    $_SESSION['user'] = [
        'id' => (int)$user['id'],
        'email' => $user['email']
    ];
}

function findUserByEmail($link, $email){
    $sql = "SELECT id FROM users WHERE users.email = '$email'";
    $users = fetchData($link, $sql);
    return count($users) === 1 ? (int)$users[0]['id'] : null;
}

function processFormAddExpense($link, float $sum, string $comment, int $categoryId, $userId){
    $sum = requestVerification($link, $sum);
    $comment = requestVerification($link, $comment);

    $sql =   "INSERT INTO history(user_id, category_id, amount, comment)
                VALUES ($userId, $categoryId, $sum, '$comment')";

    insertData($link, $sql);
}

function fetchData($link, string $sql): array {
    $result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getUserExpenses($link, int $userId): array { //все расходы пользователя
    $sql =    "SELECT h.created_at, h.amount,  h.comment, c.name as category
                FROM history AS h
                JOIN users AS u ON h.user_id = u.id
                JOIN categories AS c ON h.category_id = c.id
                WHERE u.id = $userId
                ORDER BY h.created_at";

    return fetchData($link, $sql);
}

function formatDateTime(DateTime $dateTime): string {
    return $dateTime->format('Y-m-d');
}

function getAllCategories($link): array {
    $sql = "SELECT id, name FROM categories";
    return fetchData($link, $sql);
}

function getCategories($link): array {
    $sql = "SELECT id, name FROM categories ORDER BY id";
    return fetchData($link,$sql);
}
