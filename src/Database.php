<?php

namespace App;

final class Database
{
    private const HOST = 'localhost';
    private const DATABASE = 'accounting';
    private const USER = 'accounting';
    private const PASSWORD = 'accounting';

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
        $result = mysqli_query($this->link, $sql) or die ('Ошибка, при попытке сделать запись в БД' . mysqli_error($this->link));
        return mysqli_insert_id($this->link);
    }

    private function findUserByEmail($email){
        $sql = "SELECT id FROM users WHERE users.email = '$email'";
        $users = $this->fetchData($sql);
        return count($users) === 1 ? (int)$users[0]['id'] : null;
    }

    private function fetchData(string $sql): array {
        $result = mysqli_query($this->link, $sql) or die('Ошибка ' . mysqli_error($this->link));
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }


    public function processFormSignUp(string $name, string $email, string $passwordUser)
    {
        $name = self::requestVerification($name);
        $email = self::requestVerification($email);
        $passwordUser = self::requestVerification($passwordUser);
        $passwordHash = password_hash($passwordUser, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (email, name, password_hash)
                VALUES ('$email', '$name', '$passwordHash')";

        $this->insertData($sql);
        $user = $this->findUserByEmail($email);

        // вынести из модуля Database в index.php (пока)
        $_SESSION['user'] = [
            'id' => (int)$user['id'],
            'email' => $user['email']
        ];
    }
}
