<?php

class Database
{
    private static $connection = null;

    public static function initConnection($driver, $host, $port, $user, $password, $db_name): \PDO {
        if (static::$connection !== null) {
            throw new Exception('Connection is already initialized');
        }

        if (!static::$connection) {
            $connection = new \PDO(
                $driver . ':host=' . $host . ';port=' . $port . ';dbname=' . $db_name,
                $user,
                $password
            );
            $connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            static::$connection = $connection;
        }

        return static::$connection;
    }

    public static function getConnection(): \PDO {
        if (static::$connection === null) {
            throw new Exception('Connection is not initialized');
        }

        return static::$connection;
    }
}
