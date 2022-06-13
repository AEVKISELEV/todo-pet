<?php
/** @var array $status
 * @var array $types
 * @var array $performers
 * @var array $errors
 */
?>
<div class="create-task" style="display: flex; flex-direction: column; padding: 30px">
<h1>Создание задачи</h1>
<form method="post">
        <div class="form-row">
            <div class="form-group col-md-5">
                <label for="name">Название</label>
                <input class="form-control" type="text" placeholder="Task name" name="name" required>
            </div>
            <div class="form-group col-md-5">
                <label for="description">Описание задачи</label>
                <input class="form-control" type="text" placeholder="Task description" name="description" required>
            </div>
        </div>

        <label for="type">Направления:</label>
        <?php foreach ($types as $type): ?>
             <div class="form-check">
                <input class="form-check-input" type="checkbox" name="type[]" value="<?= $type['ID'] ?>">
                <label class="form-check-label" for="type"><?= $type['NAME']?></label>
             </div>
        <?php endforeach;?>
        <div class="form-row">
            <div class="form-group col-md-2">
                <label for="type">Статус</label>
                <select class="form-control" name="status">
                    <?php foreach ($status as $item):?>
                        <option value="<?= $item['ID']?>"><?= $item['NAME']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-2">
                <label for="responsible">Ответственный</label>
                <select class="form-control" name="responsible">
                    <?php foreach ($performers as $performer):?>
                        <option value="<?= $performer['ID']?>"><?= $performer['NAME'] . ' ' . $performer['SURNAME']?></option>
                    <?php endforeach; ?>
                    <option value="<?= $_SESSION['USER']['ID']?>" selected>Я</option>
                </select>
            </div>
        </div>

        <label for="performers">Исполнители:</label>
        <?php foreach ($performers as $performer): ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="performers[]" value="<?= $performer['ID'] ?>">
                <label class="form-check-label" for="performers"><?= $performer['NAME'] . ' ' . $performer['SURNAME']?></label>
            </div>
        <?php endforeach;?>
         <div class="form-check">
            <input class="form-check-input" type="checkbox" name="performers[]" value="<?= $_SESSION['USER']['ID'] ?>" checked>
            <label class="form-check-label" for="performers">Я</label>
         </div>

        <button type="submit" class="btn btn-primary" style="margin-top: 15px;">Добавить задачу</button>
</form>
    <div class="create-errors">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>