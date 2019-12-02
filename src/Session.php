<?php

namespace App;

final class Session
{
    /** @var Database */
    private static $instance = null;

    private function __construct()
    {
        session_start();
    }

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new Session();
        }
        return self::$instance;
    }

    public function isGuest(): bool
    {
        return !$this->isLoggedIn();
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['user']);
    }

    public function getUserId(): ?int
    {
        return $_SESSION['user']['id'] ?? null;
    }

    public function signIn($email){
        $_SESSION['user'] = [
            'id' => Database::getInstance()->findUserByEmail($email)[0]['id'],
            'email' => $email
        ];
    }

    public function logout(){
        session_destroy();
    }
}
