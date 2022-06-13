<?php
/** @var array $errors */
?>
<div class="container-form">
    <h2>Вход на сайт</h2>
    <form action="login.php" method="post">
        <div class="form-group row">
            <label for="email" class="col-sm-4 col-form-label">Логин</label>
            <div class="col-sm-10">
                <input type="text" name="email" placeholder="Login">
            </div>
        </div>
        <div class="form-group row">
            <label for="password" class="col-sm-4 col-form-label">Пароль</label>
            <div class="col-sm-10">
                <input type="password" name="password" placeholder="Password">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Вход</button>
    </form>
    <div class="login-errors">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="login-registr"><a href="registration.php">Регистрация</a></div>
</div>
