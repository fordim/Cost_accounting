<?php

namespace App;

final class Operations
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
            self::$instance = new Operations();
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

    public function processFormAddCashing(string $name, float $sum, string $card, float $percent, int $userId){
        $name = $this->requestVerification($name);
        $sum = $this->requestVerification($sum);
        $profit = $sum * ($percent/100);

        $sql = "INSERT INTO history_cashing(user_id, name, amount, card, percent, profit)
                VALUE ($userId, '$name', $sum, '$card', $percent, $profit)";

        $this->insertData($sql);
    }
}
