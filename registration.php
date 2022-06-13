<?php

declare(strict_types=1);
error_reporting(-1);
require_once "./config/app.php";
use Todo\lib\RenderTodo;
use Todo\lib\Authentication;
use Todo\lib\database\UserService;
use Todo\lib\database\CountryService;

$user = new UserService($db);
$country = new CountryService($db);
$errors = [];
if(isset($_POST))
{
    $errors = $user->createUser();
}

$movieListPage = RenderTodo::renderTemplate("./resources/pages/registr.php",
    [
        'countries' => $country->getCountries(),
        'errors' => $errors
    ]
);

RenderTodo::renderLayout($movieListPage, './resources/pages/mainRegistr.php',
    [
        'config' => $config,
        'currentPage' => basename($_SERVER['REQUEST_URI']),
    ]
);
