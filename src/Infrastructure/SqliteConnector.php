<?php
namespace Root\Skorikov\Infrastructure;

class SqliteConnector
{
    public static function getConnector(): \PDO
    {
        return new \PDO('sqlite:' . __DIR__ . '/../../db.sqlite');
    }
}