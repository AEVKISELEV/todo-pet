<?php


declare(strict_types=1);
error_reporting(-1);
/** @var array $config */
require_once "./config/app.php";
require_once "./lib/template-functions.php";

use Todo\lib\RenderTodo;
use Todo\lib\database\TypeService;
use Todo\lib\database\TaskService;
use Todo\lib\database\FriendsService;

session_start();
if (!isset($_SESSION['USER'])) {
    header("Location: login.php");
}


$task = new TaskService($db);
$type = new TypeService($db);
$friend = new FriendsService($db);
if(isset($_POST['delete-task']))
{
    $task->deleteTask();
}
if(isset($_POST['status']))
{
    $task->updateStatusTask();
}

if(isset($_GET['s']))
{
    $tasks = $task->searchTasks();
}else{
    $tasks = $task->getTasks();
}

if(isset($_GET['status']))
{
    $tasks = $task->getTasksByStatus();
}

$movieListPage = RenderTodo::renderTemplate("./resources/pages/tasks.php", [
    'tasks' => $tasks,
    'types' => $type,
    'friend' => $friend
]);

RenderTodo::renderLayout($movieListPage, './resources/pages/main.php', [
    'config' => $config,
    'currentPage' => basename($_SERVER['REQUEST_URI']),
]);
