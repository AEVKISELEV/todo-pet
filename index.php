<?php
declare(strict_types=1);
error_reporting(-1);
/** @var array $config */
/** @var array $genres */
/** @var array $movies */
require_once "./config/app.php";
require_once "./lib/template-functions.php";
use Todo\lib\RenderTodo;
use Todo\lib\database\CountryService;
use Todo\lib\database\FriendsService;
use Todo\lib\database\TaskService;
session_start();
if(!isset($_SESSION['USER']))
{
    header("Location: login.php");
}

$country = new CountryService($db);
$friends = new FriendsService($db);
$tasks = new TaskService($db);

$movieListPage = RenderTodo::renderTemplate("./resources/pages/home.php", [
    'country' => $country->getCountryByID(),
    'friends' => $friends->getAmountFriends(),
    'tasks' => $tasks->getAmountTasks(),
    'statusTasks' => $tasks->getAmountTasksByStatus(),
]);

RenderTodo::renderLayout($movieListPage, './resources/pages/main.php', [
	'config' => $config,
	'currentPage' => basename($_SERVER['REQUEST_URI']),
]);

