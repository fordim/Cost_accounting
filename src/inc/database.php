<?php

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



function requestVerification($link, $a){
    return htmlentities(mysqli_real_escape_string($link, $a));
}





function processFormAddExpense($link, float $sum, string $comment, int $categoryId, $userId){
    $sum = requestVerification($link, $sum);
    $comment = requestVerification($link, $comment);

    $sql =   "INSERT INTO history(user_id, category_id, amount, comment)
                VALUES ($userId, $categoryId, $sum, '$comment')";

    insertData($link, $sql);
}



function getUserExpenses($link, int $userId, string $dateFrom, string $dateTo): array {
    $dateFrom = requestVerification($link, $dateFrom);
    $dateTo = requestVerification($link, $dateTo);
    $sql =    "SELECT h.created_at, h.amount,  h.comment, c.name as category
                FROM history AS h
                JOIN users AS u ON h.user_id = u.id
                JOIN categories AS c ON h.category_id = c.id
                WHERE u.id = $userId AND DATE(h.created_at) BETWEEN '$dateFrom' AND '$dateTo'
                ORDER BY h.created_at";

    return fetchData($link, $sql);
}

function getUserExpensesAll($link, int $userId) : array {
    $sql =    "SELECT h.created_at, h.amount,  h.comment, c.name as category
                FROM history AS h
                JOIN users AS u ON h.user_id = u.id
                JOIN categories AS c ON h.category_id = c.id
                WHERE u.id = $userId
                ORDER BY h.created_at";

    return fetchData($link, $sql);
}

function getAllCategories($link): array {
    $sql = "SELECT id, name FROM categories ORDER BY id";
    return fetchData($link, $sql);
}

function processFormAddCategory($link, string $newCategory){
    $newCategory = requestVerification($link, $newCategory);

    $sql = "INSERT INTO categories(name)
             VALUES ('$newCategory')";

    insertData($link, $sql);
}

function processFormChangeCategory($link, int $categoryId, string $newCategory){
    $newCategory = requestVerification($link, $newCategory);

    $sql = "UPDATE categories
            SET name = '$newCategory'
            WHERE id = $categoryId";

    insertData($link, $sql);
}

function processFormDeleteCategory($link, int $categoryId){
    $sql = "DELETE FROM categories
            WHERE id = $categoryId";

    insertData($link, $sql);
}

function fetchAssocData($link, string $sql): array {
    $result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));
    return mysqli_fetch_assoc($result);
}

function getCategoryName($link, int $categoryId): array {
    $sql = "SELECT name FROM categories
            WHERE categories.id = $categoryId";
    return fetchAssocData($link, $sql);
}

function getUserName($link, int $userId): array {
    $sql = "SELECT name FROM users
            WHERE users.id = $userId";
    return fetchAssocData($link, $sql);
}
