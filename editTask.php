<?php
declare(strict_types=1);
error_reporting(-1);
/** @var array $config */
require_once "./config/app.php";
require_once "./lib/template-functions.php";

use Todo\lib\RenderTodo;
use Todo\lib\database\TypeService;
use Todo\lib\database\TaskService;
use Todo\lib\database\StatusService;
use Todo\lib\database\FriendsService;

session_start();
if (!isset($_SESSION['USER'])) {
    header("Location: login.php");
}

$errors = [];
$status = new StatusService($db);
$type = new TypeService($db);
$task = new TaskService($db);
$friend = new FriendsService($db);
if(isset($_GET['id'])){
    $errors = $task->updateTask();
    $task = $task->getTaskByID();
}



$movieListPage = RenderTodo::renderTemplate("./resources/pages/editTask.php", [
    'status' => $status->getStatus(),
    'types' => $type->getTypes(),
    'performers' => $friend->getFriends(),
    'task' => $task,
    'errors' => $errors
]);

RenderTodo::renderLayout($movieListPage, './resources/pages/main.php', [
    'config' => $config,
    'currentPage' => basename($_SERVER['REQUEST_URI']),
]);

