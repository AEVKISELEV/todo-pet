<?php

namespace Todo\lib\database;

class StatusService
{
    private $pdo;

    public function __construct(DbConnect $database)
    {
        $this->pdo = $database->getPDO();
    }

    public function getStatus()
    {
        return $this->pdo->query('SELECT * FROM todo_status');
    }
}