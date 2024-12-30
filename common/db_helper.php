<?php

namespace common;
use PDO;

class db_helper
{
    private static string $host = 'localhost';
    private static int $port = 5432;
    private static string $dbname = '2km_2024';
    private static string $user = 'postgres';
    private static string $password = 'postgres';

    private static ?db_helper $helper = null;
    private PDO $conn;

    private function __construct(){
        $this->conn = new PDO('pgsql:host='
            .self::$host
            .';port='.self::$port
            .';dbname='.self::$dbname,
            username: self::$user,
            password: self::$password
        );
    }

    public static function getInstance(){
        if (self::$helper === null){
            self::$helper = new db_helper();
        }
        return self::$helper;
    }

    public function registerUser(string $username, // логин
                                 string $password, // пароль, введенный пользователем
                                 string $realname, // имя пользователя
                                 string $email // электронная почта пользователя
    ): bool {
        $stmt = $this->conn->prepare(
            "INSERT INTO users (username, password, realname, email) VALUES (:username, :password, :realname, :email)"
        );
        $pwd_hash = password_hash($password, PASSWORD_DEFAULT);
        $res = $stmt->execute([':username' => $username, ':password' => $pwd_hash, ':realname' => $realname, ':email' => $email]);
        return $res != false;
    }
}