<?php

namespace Todo\lib;
use Todo\lib\database\UserService;

class Authentication
{
    private const ERROR_AUTHENTICATION = 'Неправильный пароль или логин';

    public static function authentication(UserService $user): array
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $user = $user->getUser($email);
            if($user['LOGIN'] !== $email)
            {
                $errors[] = self::ERROR_AUTHENTICATION;
            }
            else
            {
                $isCorrectPassword = password_verify($password, $user['PASSWORD']);
                if(!$isCorrectPassword)
                {
                    $errors[] = self::ERROR_AUTHENTICATION;
                }
                if(empty($errors))
                {
                    session_start();
                    $_SESSION['USER'] = $user;
                    header("Location: index.php");
                }
            }
        }
        return $errors;
    }
}