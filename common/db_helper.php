<?php

namespace common;

use PgSql\Connection;

class db_helper
{
    private static string $host = 'localhost';
    private static int $port = 5432;
    private static string $dbname = '2km_2024';
    private static string $user = 'postgres';
    private static string $password = 'postgres';

    private static ?db_helper $helper = null;
    private static Connection $conn;

    private function __construct(){
        self::$conn = pg_connect("host=" . self::$host . " port=" . self::$port . " user=" . self::$user . " password=" . self::$password . " dbname=" . self::$dbname);
    }

    public static function getInstance(){
        if (self::$helper === null){
            self::$helper = new db_helper();
        }
        return self::$helper;
    }
}