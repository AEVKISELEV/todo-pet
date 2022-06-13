<?php

namespace Todo\lib\database;

use PDO;

class UserService
{
    private $pdo;

    public function __construct(DbConnect $database)
    {
        $this->pdo = $database->getPDO();
    }

    public function getUser(string $login)
    {
       $stmt = $this->pdo->prepare("SELECT * FROM todo_user WHERE LOGIN = ?");
       $stmt->execute([$login]);
       return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUsers()
    {
        return $this->pdo->query("SELECT * FROM todo_user")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsersForFriend()
    {
        $ID = $_SESSION['USER']['ID'];
        $stmt = $this->pdo->prepare("SELECT * FROM todo_user WHERE (ID NOT IN (SELECT ID_FRIEND FROM todo_friend WHERE ID_USER = :rule_1)) AND ID != :rule_2");
        $stmt->execute([
            'rule_1' => $ID,
            'rule_2' => $ID
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUser(): array
    {
        $errors = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if(!($_POST['login'] && $_POST['password'] && $_POST['name'] && $_POST['surname']))
            {
                $errors[] = 'Все поля обязательны к заполнению.';
                return $errors;
            }
            if($this->validateLogin($_POST['login']))
            {
                $errors[] = $this->validateLogin($_POST['login']);
                return $errors;
            }
            if($this->validatePassword($_POST['password']))
            {
                $errors[] = $this->validatePassword($_POST['password']);
            }

            if($this->validateName($_POST['name']))
            {
                $errors[] = $this->validateName($_POST['name']);
            }

            if($this->validateName($_POST['surname']))
            {
                $errors[] = $this->validateName($_POST['surname']);
            }

            if(!empty($errors)){
                return $errors;
            }
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmtUser = $this->pdo->prepare('INSERT INTO todo_user SET LOGIN = :login, PASSWORD = :password, NAME = :name, SURNAME = :surname, ID_COUNTRY = :country');
            $stmtUser->execute([
               'login' => $_POST['login'],
               'password'=> $password,
               'name' => $_POST['name'],
               'surname' => $_POST['surname'],
               'country' => $_POST['country']
            ]);
            header('Location: login.php');
            exit();
        }

        return $errors;
    }

    private function validateLogin(string $login): ?string
    {
        $pattern = '/^[a-z0-9-_]+$/i';
        if(strlen($login) > 50){
            return 'Логин должен быть меньше 50 символов.';
        }
        if(!preg_match($pattern, $login))
        {
            return 'Логин должен содержать толоко латинские буквы, тире и подчёркивания.';
        }
        $stmt = $this->pdo->prepare('SELECT * FROM todo_user WHERE LOGIN = ?');
        $stmt->execute([$login]);
        if($stmt->fetch(PDO::FETCH_ASSOC))
        {
            return 'Пользователь с таким логином уже существует.';
        }
        return null;
    }

    private function validatePassword(string $password): ?string
    {
        $pattern = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{12,25}$/';
        if(!preg_match($pattern, $password))
        {
            return 'Пароль должен быть от 12 до 25 символов, содержать хотя бы одну маленькую, большую букву и цифру.';
        }
        return '';
    }

    private function validateName(string $name): ?string
    {
        $pattern = '/^[a-zA-Zа-яёА-ЯЁ\s\-]+$/u';
        if(strlen($name) > 30)
        {
            return 'Имя и фамилия должны быть не больше 30 символов';
        }
        if(!preg_match($pattern, $name))
        {
           return 'Имя и фамилия только русскими и латинскими буквами.';
        }
        return '';
    }

}