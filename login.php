<?php
declare(strict_types=1);
error_reporting(-1);
/** @var array $config */
require_once "./config/app.php";
use Todo\lib\RenderTodo;
use Todo\lib\Authentication;
use Todo\lib\database\UserService;

$user = new UserService($db);
$errors = Authentication::authentication($user);

$movieListPage = RenderTodo::renderTemplate("./resources/pages/login.php",
    [
     'errors' => $errors,
    ]
);

RenderTodo::renderLayout($movieListPage, './resources/pages/mainLogin.php',
    [
    'config' => $config,
    'currentPage' => basename($_SERVER['REQUEST_URI']),
    ]
);
