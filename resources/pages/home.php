<?php
/**
 * @var array $country
 * @var array $friends
 * @var array $tasks
 * @var array $statusTasks
 */
?>
<h1 style="text-align: center">Личный кабинет пользователя TO-DO</h1>
<div class="home-container" style="display: flex; flex-direction: column; padding: 30px; ">
    <h3 style="">Личная информация:</h3>
    <div style="font-size: 20px; font-weight: 600; color: #606060;">Логин: <?=$_SESSION['USER']['LOGIN']?></div>
    <div style="font-size: 20px; font-weight: 600; color: #606060;">Имя: <?=$_SESSION['USER']['NAME']?></div>
    <div style="font-size: 20px; font-weight: 600; color: #606060;">Фамилия: <?=$_SESSION['USER']['SURNAME']?></div>
    <div style="font-size: 20px; font-weight: 600; color: #606060;">Страна: <?=$country['NAME']?></div>
    <div style="font-size: 20px; font-weight: 600; color: #606060;">Дата создания аккаунта: <?=$_SESSION['USER']['DATA_CREATE']?></div>
    <h3 style="margin-top: 20px;">Статистика по аккаунту:</h3>
    <div style="font-size: 20px; font-weight: 600; color: #333e8d;">Количество друзей: <?=$friends['AMOUNT']?></div>
    <div style="font-size: 20px; font-weight: 600; color: #333e8d;">Общее количество задач: <?=$tasks['AMOUNT']?></div>
    <div style="font-size: 20px; font-weight: 600; color: #333e8d;">Количество поставленных задач: <?=$statusTasks['start']['AMOUNT']?></div>
    <div style="font-size: 20px; font-weight: 600; color: #333e8d;">Количество выполняющихся задач: <?=$statusTasks['work']['AMOUNT']?></div>
    <div style="font-size: 20px; font-weight: 600; color: #333e8d;">Количество законченных задач: <?=$statusTasks['stop']['AMOUNT']?></div>
</div>

