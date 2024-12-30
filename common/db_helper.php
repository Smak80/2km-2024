<?php

namespace common;
use PDO;
use PDOException;

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
        $res = false;
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare(
                "INSERT INTO users (username, password, realname, email) VALUES (:username, :password, :realname, :email)"
            );
            $pwd_hash = password_hash($password, PASSWORD_DEFAULT);
            $res = $stmt->execute([':username' => $username, ':password' => $pwd_hash, ':realname' => $realname, ':email' => $email]);
            $this->conn->commit();
        } catch (PDOException $e) {
            $res = false;
            $this->conn->rollBack();
        }
        return $res != false;
    }

    public function checkUser(string $login, string $password): bool
    {
        $res = false;
        try{
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('SELECT * FROM users WHERE username = :login');
            $stmt->execute([':login' => $login]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($results as $row) {
                $res = password_verify($password, $row['password']);
            }
            $this->conn->commit();
        } catch (PDOException $e) {
            $this->conn->rollBack();
        }
        return $res;
    }

    public function getRealName(string $login): string
    {
        $name = '';
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('SELECT realname FROM users WHERE username = :login');
            $stmt->execute([':login' => $login]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($results as $row) {
                $name = $row['realname'];
            }
            $this->conn->commit();
        } catch (PDOException $e) {
            $this->conn->rollBack();
        }
        return $name;
    }
}