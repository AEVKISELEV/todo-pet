<?php

declare(strict_types=1);
error_reporting(-1);
/** @var array $config */
require_once "./config/app.php";
require_once "./lib/template-functions.php";

use Todo\lib\RenderTodo;
use Todo\lib\database\FriendsService;
use Todo\lib\database\UserService;

session_start();
if (!isset($_SESSION['USER'])) {
    header("Location: login.php");
}

$friend = new FriendsService($db);
$user = new UserService($db);
$friend->createFriend();
$friend->deleteFriends();

$movieListPage = RenderTodo::renderTemplate("./resources/pages/friends.php", [
    'friends' => $friend->getFriends(),
    'users' => $user->getUsersForFriend()
]);

RenderTodo::renderLayout($movieListPage, './resources/pages/main.php', [
    'config' => $config,
    'currentPage' => basename($_SERVER['REQUEST_URI']),
]);