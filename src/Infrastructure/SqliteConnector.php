<?php
namespace Root\Skorikov\Infrastructure;

class SqliteConnector
{
    protected static $instance;
    protected static $connection;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
            self::$connection = new \PDO('sqlite:' . __DIR__ . '/../../db.sqlite');
        }
        return self::$instance;
    }

    public function getConnector(): \PDO
    {
        if (is_null(self::$instance)) {
            return null;
        }
        return self::$connection;
    }
}