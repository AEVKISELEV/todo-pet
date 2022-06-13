<?php
/** @var array $countries
 * @var array $errors
 */

?>
<div class="container-form">
    <h1>Регистрация TO-DO</h1>
    <form method="post">
        <div class="form-row">
            <div class="form-group col-md-5">
                <label for="login">Логин</label>
                <input type="text" placeholder="Your login" name="login" required>
            </div>
            <div class="form-group col-md-5">
                <label for="password">Пароль</label>
                <input type="password" placeholder="Your password" name="password" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-5">
                <label for="name">Имя</label>
                <input type="text" placeholder="Your name" name="name" required>
            </div>
            <div class="form-group col-md-5">
                <label for="surname">Фамилия</label>
                <input type="text" placeholder="Your surname" name="surname" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="country">Страна</label>
                <select name="country">
                    <?php foreach ($countries as $country):?>
                        <option value="<?= $country['ID']?>"><?= $country['NAME']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
    </form>
    <div class="registr-errors">
        <ul>
            <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

