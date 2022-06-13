<?php
/** @var array $config */
/** @var array $currentPage */
?>
<ul class="menu">
	<li class="menu-item <?= $currentPage === "index.php" ? "menu-item__active" : "" ?>">
		<a href="<?= "index.php" ?>"><?= $config['menu']['index']?></a>
	</li>
    <li class="menu-item <?= $currentPage === "friends.php" ? "menu-item__active" : "" ?>">
        <a href="<?= "friends.php" ?>"><?= $config['menu']['friends']?></a>
    </li>
    <li class="menu-item <?= $currentPage === "tasks.php" ? "menu-item__active" : "" ?>">
        <a href="<?= "tasks.php" ?>"><?= $config['menu']['tasks']?></a>
    </li>
    <li class="menu-item <?= $currentPage === "tasks.php?status=start" ? "menu-item__active" : "" ?>">
        <a href="<?= "tasks.php?status=start" ?>"><?= $config['menu']['start']?></a>
    </li>
    <li class="menu-item <?= $currentPage === "tasks.php?status=work" ? "menu-item__active" : "" ?>">
        <a href="<?= "tasks.php?status=work" ?>"><?= $config['menu']['work']?></a>
    </li>
    <li class="menu-item <?= $currentPage === "tasks.php?status=stop" ? "menu-item__active" : "" ?>">
        <a href="<?= "tasks.php?status=stop" ?>"><?= $config['menu']['stop']?></a>
    </li>
    <li class="menu-item <?= $currentPage === "logout.php" ? "menu-item__active" : "" ?>">
        <a href="<?= "logout.php" ?>"><?= $config['menu']['logout']?></a>
    </li>
</ul>
<?php
$name = $_SESSION['USER']['NAME'];
$surname = $_SESSION['USER']['SURNAME'];
?>

<div style="height: 50px; border: solid aqua;text-align: center; color: white; margin-top: 50px; font-size: 24px; font-weight: 700;"><?= $name. ' '. $surname?></div>
