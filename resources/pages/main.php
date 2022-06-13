<?php
/** @var array $config */
/** @var array $currentPage */
/** @var array $content */
?>
<!DOCTYPE html>
<html lang="<?= $config['language'] ?>">
<head>
	<meta charset="<?= $config['charset'] ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $config['title'] ?></title>
    <link rel="stylesheet" href="./resources/css/reset.css">
    <link rel="stylesheet" href="./resources/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>

<div class="wrapper">
	<header>
		<h1 class="logo_h1">
			<?= $config['title'] ?>
		</h1>
		<nav>
			<?= renderTemplate("./resources/blocks/_menu.php", [
				'currentPage' => $currentPage,
				'config' => $config,
			]) ?>
		</nav>
	</header>
	<div class="contain" style="display: flex; flex-direction: column;flex: 1;background: #CCCCCC;">
		<div class="header">
			<div class="header_wapper">
				<form class="form_search" action="tasks.php" method="get">
					<div class="input_container">
						<img src="./icons/search.svg" alt="search">
						<?php if(isset($_GET['s'])): ?>
						<input name="s" placeholder="<?= strip_tags($_GET['s']) ?>" type="search" required>
						<?php else: ?>
						<?= '<input name="s" placeholder="Поиск по задачам... " type="search" required>'?>
						<?php endif; ?>
					</div>
					<button type="submit">Искать</button>
				</form>
				<a href="<?= "createTask.php" ?>">
					<button class="header_button">Добавить задачу</button>
				</a>
			</div>
		</div>
		<div class="content"><?= $content ?></div>
	</div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>