<?php

namespace Todo\lib\database;

use PDO;

class TaskService
{
    private $pdo;

    public function __construct(DbConnect $database)
    {
        $this->pdo = $database->getPDO();
    }

    public function createTask(): array
    {
        $errors = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if(!(isset($_POST['name']) && isset($_POST['description']) && isset($_POST['status']) && isset($_POST['type']) && isset($_POST['responsible']) && isset($_POST['performers']))){
                $errors[] = 'Все поля должны быть заполнены';
                return $errors;
            }
            $name = $_POST['name'];
            if($this->validateName($_POST['name']))
            {
                $errors[] = $this->validateName($_POST['name']);
            }
            $descr = $_POST['description'];
            if($this->validateDescription($_POST['description']))
            {
                $errors[] = $this->validateDescription($_POST['description']);
            }
            $status = $_POST['status'];
            $types = $_POST['type'];
            $responsible = $_POST['responsible'];
            $performers = $_POST['performers'];
            $user_id = $_SESSION['USER']['ID'];
            if(!empty($errors)){
                return $errors;
            }
            $stmtTask = $this->pdo->prepare('INSERT INTO todo_tasks(NAME, DESCRIPTION, ID_STATUS, ID_USER)
            VALUES (:name, :description, :id_status, :user_id)');
            $stmtTask->execute(['name' => $name, 'description' => $descr, 'id_status' => $status, 'user_id' => $user_id]);
            $id = $this->pdo->lastInsertId();
            foreach ($types as $type){
                $stmtType = $this->pdo->prepare('INSERT INTO todo_task_type(ID_TASK, ID_TYPE)
                VALUES (:id_task, :id_type)
                ');
                $stmtType->execute(['id_task' => $id, 'id_type' => $type]);
            }
            $stmtResponsible = $this->pdo->prepare('INSERT INTO todo_performer(ID_TASK, ID_USER, ID_ROLE)
                VALUES (:id_task, :id_responsible, 1)
                ');
            $stmtResponsible ->execute(['id_task' => $id, 'id_responsible' => $responsible]);
            foreach ($performers as $performer)
            {
                $stmtResponsible = $this->pdo->prepare('INSERT INTO todo_performer(ID_TASK, ID_USER, ID_ROLE)
                VALUES (:id_task, :id_performer, 2)
                ');
                $stmtResponsible ->execute(['id_task' => $id, 'id_performer' => $performer]);
            }
        }
        return $errors;
    }

    public function getTasks()
    {
        $user_id = $_SESSION['USER']['ID'];
        $stmt = $this->pdo->prepare('
        SELECT tt.ID, tt.NAME, tt.DESCRIPTION, tt.DATA_CREATE, ts.NAME as STATUS_NAME, tt.ID_STATUS as STATUS_ID 
        FROM todo_tasks as tt
        INNER JOIN todo_status ts on tt.ID_STATUS = ts.ID
        WHERE ID_USER = :user_id
        ');
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAmountTasks()
    {
        $user_id = $_SESSION['USER']['ID'];
        $stmt = $this->pdo->prepare('SELECT COUNT(ID) as AMOUNT FROM todo_tasks
        WHERE ID_USER = :user_id
        ');
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAmountTasksByStatus(): array
    {
        $user_id = $_SESSION['USER']['ID'];
        $stmt = $this->pdo->prepare('SELECT COUNT(ID) as AMOUNT FROM todo_tasks
        WHERE ID_USER = :user_id AND ID_STATUS = :status_id
        ');
        $stmt->execute(['user_id' => $user_id, 'status_id' => 1]);
        $work = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = $this->pdo->prepare('SELECT COUNT(ID) as AMOUNT FROM todo_tasks
        WHERE ID_USER = :user_id AND ID_STATUS = :status_id
        ');
        $stmt->execute(['user_id' => $user_id, 'status_id' => 2]);
        $stop = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = $this->pdo->prepare('SELECT COUNT(ID) as AMOUNT FROM todo_tasks
        WHERE ID_USER = :user_id AND ID_STATUS = :status_id
        ');
        $stmt->execute(['user_id' => $user_id, 'status_id' => 3]);
        $start = $stmt->fetch(PDO::FETCH_ASSOC);
        return ['start' => $start, 'work' => $work, 'stop' => $stop];
    }

    public function getTaskById()
    {
        $id = $_GET['id'];
        $stmt = $this->pdo->prepare('
        SELECT tt.ID, tt.NAME, tt.DESCRIPTION, tt.DATA_CREATE, ts.NAME as STATUS_NAME, tt.ID_STATUS as STATUS_ID 
        FROM todo_tasks as tt
        INNER JOIN todo_status ts on tt.ID_STATUS = ts.ID
        WHERE tt.ID = ?
        ');
        $stmt->execute([$id]);
        $task = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = $this->pdo->prepare('
        SELECT tt.ID_TYPE
        FROM todo_task_type as tt
        WHERE tt.ID_TASK = ?
        ');
        $stmt->execute([$id]);
        $types = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = $this->pdo->prepare('
        SELECT tp.ID_USER
        FROM todo_performer as tp
        WHERE tp.ID_TASK = ? and tp.ID_ROLE = 1
        ');
        $stmt->execute([$id]);
        $responsible = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = $this->pdo->prepare('
        SELECT tp.ID_USER
        FROM todo_performer as tp
        WHERE tp.ID_TASK = ? and tp.ID_ROLE = 2
        ');
        $stmt->execute([$id]);
        $performer = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return ['task' => $task, 'types' => $types,'responsible' => $responsible, 'performer' => $performer];
    }

    public function updateTask(): array
    {
        $errors = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if(!(isset($_POST['name']) && isset($_POST['description']) && isset($_POST['status']) && isset($_POST['type']) && isset($_POST['responsible']) && isset($_POST['performers']))){
                $errors[] = 'Все поля должны быть заполнены';
                return $errors;
            }
            $name = $_POST['name'];
            if($this->validateName($_POST['name']))
            {
                $errors[] = $this->validateName($_POST['name']);
            }
            $descr = $_POST['description'];
            if($this->validateDescription($_POST['description']))
            {
                $errors[] = $this->validateDescription($_POST['description']);
            }
            $status = $_POST['status'];
            $types = $_POST['type'];
            $responsible = $_POST['responsible'];
            $performers = $_POST['performers'];
            $id = $_GET['id'];
            if(!empty($errors)){
                return $errors;
            }
            $stmtTask = $this->pdo->prepare('UPDATE todo_tasks 
            SET NAME = :name, DESCRIPTION = :description, ID_STATUS= :id_status, DATA_EDITING = NOW()
            WHERE ID = :id
            ');
            $stmtTask->execute(['name' => $name, 'description' => $descr, 'id_status' => $status, 'id' => $id]);
            $stmtType = $this->pdo->prepare('DELETE FROM todo_task_type
            WHERE ID_TASK = :id
            ');
            $stmtType->execute(['id' => $id]);

            foreach ($types as $type){
                $stmtType = $this->pdo->prepare('INSERT INTO todo_task_type(ID_TASK, ID_TYPE)
                VALUES (:id_task, :id_type)
                ');
                $stmtType->execute(['id_task' => $id, 'id_type' => $type]);
            }
            $stmtTask->execute(['name' => $name, 'description' => $descr, 'id_status' => $status, 'id' => $id]);
            $stmtResponsible = $this->pdo->prepare('DELETE FROM todo_performer
            WHERE ID_TASK = :id
            ');
            $stmtResponsible->execute(['id' => $id]);
            $stmtResponsible = $this->pdo->prepare('INSERT INTO todo_performer(ID_TASK, ID_USER, ID_ROLE)
                VALUES (:id_task, :id_responsible, 1)
                ');
            $stmtResponsible ->execute(['id_task' => $id, 'id_responsible' => $responsible]);
            foreach ($performers as $performer)
            {
                $stmtResponsible = $this->pdo->prepare('INSERT INTO todo_performer(ID_TASK, ID_USER, ID_ROLE)
                VALUES (:id_task, :id_performer, 2)
                ');
                $stmtResponsible ->execute(['id_task' => $id, 'id_performer' => $performer]);
            }
        }
        return $errors;
    }

    public function deleteTask(): void
    {
        $id = $_POST['delete-task'];
        $this->deletePerformes($id);
        $this->deleteTypes($id);
        $stmtTask = $this->pdo->prepare('DELETE FROM todo_tasks
        WHERE ID = ?
        ');
        $stmtTask->execute([$id]);
        header('Location: tasks.php');
    }

    public function updateStatusTask()
    {
        var_dump($_POST);
        $id = $_POST['status'];
        $taskID = $_POST['task-id'];
        if($id === '3')
        {
            $id = 1;
        }
        if($id === '1')
        {
            $id = 2;
        }
        $stmtTask = $this->pdo->prepare('UPDATE todo_tasks SET ID_STATUS = :status_id, DATA_EDITING = NOW() 
        WHERE ID = :task_id
        ');
        $stmtTask->execute(['status_id' => $id, 'task_id' => $taskID]);
        header('Location: tasks.php');
    }

    public function searchTasks()
    {
        $search = $_GET['s'];
        $user_id = $_SESSION['USER']['ID'];
        $stmt = $this->pdo->prepare("
        SELECT tt.ID, tt.NAME, tt.DESCRIPTION, tt.DATA_CREATE, ts.NAME as STATUS_NAME, tt.ID_STATUS as STATUS_ID 
        FROM todo_tasks as tt
        INNER JOIN todo_status ts on tt.ID_STATUS = ts.ID
        WHERE ID_USER = :user_id AND tt.NAME LIKE '{$search}%'
        ");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTasksByStatus()
    {
        $user_id = $_SESSION['USER']['ID'];
        $status_id = 1;
        if($_GET['status'] === 'start')
        {
            $status_id = 3;
        }
        elseif($_GET['status'] === 'work')
        {
           $status_id = 1;
        }
        elseif ($_GET['status'] === 'stop')
        {
            $status_id = 2;
        }
            $stmt = $this->pdo->prepare("
        SELECT tt.ID, tt.NAME, tt.DESCRIPTION, tt.DATA_CREATE, ts.NAME as STATUS_NAME, tt.ID_STATUS as STATUS_ID 
        FROM todo_tasks as tt
        INNER JOIN todo_status ts on tt.ID_STATUS = ts.ID
        WHERE ID_USER = :user_id and ID_STATUS = :status_id
        ");
            $stmt->execute(['user_id' => $user_id, 'status_id' => $status_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    private function validateName(string $name): string
    {
        if(strlen($name) > 30)
        {
            return 'Название должно быть не более 80 символов';
        }
        return '';
    }

    private function validateDescription(string $descr): string
    {
        if(strlen($descr) > 500)
        {
            return 'Описание должно быть не более 500 символов';
        }
        return '';
    }

    private function deleteTypes($id)
    {
        $stmtType = $this->pdo->prepare('DELETE FROM todo_task_type
        WHERE ID_TASK = ?
        ');
        $stmtType->execute([$id]);
    }
    private function deletePerformes($id)
    {
        $stmtPrepare = $this->pdo->prepare('DELETE FROM todo_performer
        WHERE ID_TASK = ?
        ');
        $stmtPrepare->execute([$id]);
    }
}