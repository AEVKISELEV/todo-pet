<?php
require_once __DIR__ . "/../vendor/autoload.php";

use Todo\lib\database\DbConnect;

$config = [
	'title' => "TO-DO",
	'charset' => "UTF-8",
	'language' => "ru",
	'menu' => [
		'index' => 'Главная',
		'friends' =>'Друзья',
        'tasks' => 'Список задач',
        'logout' => 'Выход',
        'start' => 'Поставленные задачи',
        'work' => 'Выполняющиеся задачи',
        'stop' => 'Законченные задачи'
    ],
];

$users = [
    [
      'ID' => 1,
      'FIRST_NAME' => 'ARTEM',
      'LAST_NAME' => 'KISELEV',
      'EMAIL' => 'imbatvink@gmail.com',
      'PASSWORD' => '$2y$10$FqCPHSNTV8j4VP307ZqOuef8zN0hPsY35W8Lb6RT8qMMdGDbtQ3hW'
    ],
];

$iniArray = parse_ini_file('db_config.ini');
define('DB_HOST', $iniArray['db_host']);
define('DB_USERNAME', $iniArray['db_userName']);
define('DB_PASSWORD', $iniArray['db_password']);
define('DB_NAME', $iniArray['db_name']);
define('DB_CS', $iniArray['db_cs']);
define('DB_CHARSET', $iniArray['db_charset']);


$db = DbConnect::getInstance(DB_CS, DB_HOST, DB_NAME, DB_CHARSET, DB_USERNAME, DB_PASSWORD);
