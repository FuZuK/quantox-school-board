<?php

class Database
{
    private static $connection = null;

    public static function initConnection($driver, $host, $port, $user, $password, $db_name): \PDO {
        if (static::$connection !== null) {
            throw new Exception('Connection is already initialized');
        }

        static::$connection = new \PDO(
            $driver . ':host=' . $host . ';port=' . $port . ';dbname=' .$db_name,
            $user,
            $password
        );

        return static::$connection;
    }

    public static function getConnection(): \PDO {
        if (static::$connection === null) {
            throw new Exception('Connection is not initialized');
        }

        return static::$connection;
    }
}
