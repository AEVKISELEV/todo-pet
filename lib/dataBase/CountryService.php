<?php

namespace Todo\lib\database;

use PDO;

class CountryService
{
    private $pdo;

    public function __construct(DbConnect $database)
    {
        $this->pdo = $database->getPDO();
    }

    public function getCountries()
    {
        return $this->pdo->query("SELECT * FROM todo_country")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCountryByID()
    {
        $id = $_SESSION['USER']['ID_COUNTRY'];
        return $this->pdo->query("SELECT * FROM todo_country WHERE ID = {$id}")->fetch(PDO::FETCH_ASSOC);
    }
}