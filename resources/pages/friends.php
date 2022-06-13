<?php
/** @var array $friends */
/** @var array $users */
?>
<div class="friend-container" style="display: flex;flex-direction: column; align-items: flex-start; align-content: center; padding: 30px">
    <div class="form-group">
        <h3>Добавление друга</h3>
        <form method="post">
            <label for="friend">Выберите из списка пользователей TO-DO</label>
            <select class="form-control" name="friend">
                <?php foreach ($users as $user):?>
                    <option value="<?= $user['ID']?>"><?= $user['LOGIN']?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-primary" style="margin-top: 10px">Добавить в друзья</button>
        </form>
        <h3 style="margin-top: 30px;">Список друзей:</h3>
        <form method="post">
            <?php foreach ($friends as $friend): ?>
                <div class="form-check">
                    <input type="checkbox" name="delete_friends[]" value="<?= $friend ['ID'] ?>">
                    <label for="delete_friends"><?= $friend['LOGIN'] . ': ' . $friend['NAME'] . ' ' . $friend['SURNAME']?></label>
                </div>
            <?php endforeach;?>
            <button type="submit" class="btn btn-danger">Удалить</button>
        </form>
    </div>
</div>

