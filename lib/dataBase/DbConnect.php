<?php

namespace Todo\lib\database;

use PDO;

class DbConnect
{
    private static $instance;
    private static $pdo;
    private static $DB_CS;
    private static $DB_HOST;
    private static $DB_NAME;
    private static $DB_CHARSET;
    private static $DB_USERNAME;
    private static $DB_PASSWORD;

    protected function __construct(string $DB_CS, string $DB_HOST, string $DB_NAME, string $DB_CHARSET, string $DB_USERNAME, string $DB_PASSWORD)
    {
        self::$DB_CS = $DB_CS;
        self::$DB_HOST = $DB_HOST;
        self::$DB_NAME = $DB_NAME;
        self::$DB_CHARSET = $DB_CHARSET;
        self::$DB_USERNAME = $DB_USERNAME;
        self::$DB_PASSWORD = $DB_PASSWORD;
        self::$pdo = self::getOrConnectPDO();
    }

    private static function connectPDOToDB(): void
    {
        $dsn = sprintf('%s:host=%s;dbname=%s;charset=%s', self::$DB_CS, self::$DB_HOST, self::$DB_NAME, self::$DB_CHARSET);

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];
        try {
            self::$pdo = new PDO($dsn, self::$DB_USERNAME, self::$DB_PASSWORD, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    private static function getOrConnectPDO(): PDO
    {
        if(self::$pdo=== null)
        {
            self::connectPDOToDB();
        }
        return self::$pdo;
    }
    
    public function getPDO(): PDO
    {
        return self::$pdo;
    }

    public static function getInstance(string $dbCS, string $dbHost, string $dbName, string $dbCharset, string $dbUserName, string $dbPassword): DbConnect
    {
        if(self::$instance === null)
        {
            self::$instance = new self($dbCS, $dbHost, $dbName, $dbCharset, $dbUserName, $dbPassword);
        }
        return self::$instance;
    }

    private function __clone()
    {

    }

    private function __wakeup()
    {

    }
}