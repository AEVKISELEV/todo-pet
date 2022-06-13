<?php

namespace Todo\lib\database;

use PDO;

class TypeService
{
    private $pdo;

    public function __construct(DbConnect $database)
    {
        $this->pdo = $database->getPDO();
    }

    public function getTypes()
    {
        return $this->pdo->query('SELECT * FROM todo_type');
    }

    public function getTypeByIdTask($id_task)
    {
        $stmt = $this->pdo->prepare('SELECT todo_task_type.ID_TYPE, tt.NAME FROM todo_task_type
        INNER JOIN todo_type tt on todo_task_type.ID_TYPE = tt.ID
        WHERE todo_task_type.ID_TASK = :id_task
        ');
        $stmt->execute(['id_task' => $id_task]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}