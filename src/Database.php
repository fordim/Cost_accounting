<?php

namespace App;

final class Database
{
    private const HOST = 'localhost';
    private const DATABASE = 'accounting';
    private const USER = 'root';
    private const PASSWORD = '';

    /** @var Database */
    private static $instance = null;

    private $link = null;

    private function __construct()
    {
        $this->link = @mysqli_connect(
            self::HOST,
            self::USER,
            self::PASSWORD,
            self::DATABASE
        ) or die('Ошибка подключения к MySQL' . mysqli_error($this->link));
    }

    public function __destruct()
    {
        @mysqli_close($this->link);
    }

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    private function requestVerification(string $escapestr): string
    {
        return htmlentities(mysqli_real_escape_string($this->link, $escapestr));
    }

    private function insertData(string $sql): int
    {
        $result = mysqli_query($this->link, $sql) or die ('Ошибка, при попытке сделать запись в БД ' . mysqli_error($this->link));
        return mysqli_insert_id($this->link);
    }

    private function fetchData(string $sql): array {
        $result = mysqli_query($this->link, $sql) or die('Ошибка ' . mysqli_error($this->link));
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function fetchAssocData(string $sql): array {
        $result = mysqli_query($this->link, $sql) or die("Ошибка " . mysqli_error($this->link));
        return mysqli_fetch_assoc($result);
    }

    public function findUserByEmail(string $email){
        $sql = "SELECT * FROM users WHERE users.email = '$email'";
        return $this->fetchData($sql);
    }

    public function processFormSignUp(string $name, string $email, string $passwordUser)
    {
        $name = $this->requestVerification($name);
        $email = $this->requestVerification($email);
        $passwordUser = $this->requestVerification($passwordUser);
        $passwordHash = password_hash($passwordUser, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (email, name, password_hash)
                VALUES ('$email', '$name', '$passwordHash')";

        $this->insertData($sql);
    }

    public function processFormSignIn(string $email, string $password){
        $email = $this->requestVerification($email);
        $users = $this->findUserByEmail($email);
        if (count($users) === 1){
            $user = $users[0];
            $password_hash = $user['password_hash'];
            if (password_verify($password, $password_hash)){
                return;
            }
        }
        die ('Пользователя не существует в базе или введен не верный логин/пароль. Повторите попытку.');
    }

    public function getUserName(int $userId): array {
        $sql = "SELECT name FROM users
            WHERE users.id = $userId";
        return $this->fetchAssocData($sql);
    }

    public function getAllCategories(): array {
        $sql = "SELECT id, name FROM categories ORDER BY id";
        return $this->fetchData($sql);
    }

    public function getUserExpenses(int $userId, string $dateFrom, string $dateTo): array {
        $dateFrom = $this->requestVerification($dateFrom);
        $dateTo = $this->requestVerification($dateTo);
        $sql =    "SELECT h.created_at, h.amount,  h.comment, c.name as category
                FROM history AS h
                JOIN users AS u ON h.user_id = u.id
                JOIN categories AS c ON h.category_id = c.id
                WHERE u.id = $userId AND DATE(h.created_at) BETWEEN '$dateFrom' AND '$dateTo'
                ORDER BY h.created_at";

        return $this->fetchData($sql);
    }

    public function getUserExpensesAll(int $userId) : array {
        $sql =    "SELECT h.created_at, h.amount,  h.comment, c.name as category
                FROM history AS h
                JOIN users AS u ON h.user_id = u.id
                JOIN categories AS c ON h.category_id = c.id
                WHERE u.id = $userId
                ORDER BY h.created_at";

        return $this->fetchData($sql);
    }

    public function processFormAddCategory(string $newCategory){
        $newCategory = $this->requestVerification($newCategory);

        $sql = "INSERT INTO categories(name)
             VALUES ('$newCategory')";

        $this->insertData($sql);
    }

    public function processFormChangeCategory(int $categoryId, string $newCategory){
        $newCategory = $this->requestVerification($newCategory);

        $sql = "UPDATE categories
            SET name = '$newCategory'
            WHERE id = $categoryId";

        $this->insertData($sql);
    }

    public function processFormDeleteCategory(int $categoryId){
        $sql = "DELETE FROM categories
            WHERE id = $categoryId";

        $this->insertData($sql);
    }

    public function processFormAddExpense(float $sum, string $comment, int $categoryId, $userId){
        $sum = $this->requestVerification($sum);
        $comment = $this->requestVerification($comment);

        $sql =   "INSERT INTO history(user_id, category_id, amount, comment)
                VALUES ($userId, $categoryId, $sum, '$comment')";

        $this->insertData($sql);
    }

    public function getCategoryName(int $categoryId): array {
        $sql = "SELECT name FROM categories
            WHERE categories.id = $categoryId";

        return $this->fetchAssocData($sql);
    }
}
