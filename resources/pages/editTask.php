<?php
/** @var array $status
 * @var array $types
 * @var array $performers
 * @var array $errors
 * @var array $task
 */
?>
<div class="create-task" style="display: flex; flex-direction: column; padding: 30px">
    <h1>Редактирование задачи "<?= $task['task']['NAME']?>"</h1>
    <form method="post">
        <div class="form-row">
            <div class="form-group col-md-5">
                <label for="name">Название</label>
                <input class="form-control" type="text" placeholder="Task name" name="name" value="<?= $task['task']['NAME'] ?>" required>
            </div>
            <div class="form-group col-md-5">
                <label for="description">Описание задачи</label>
                <input class="form-control" type="text" placeholder="Task description" name="description" value="<?= $task['task']['DESCRIPTION'] ?>" required>
            </div>
        </div>

        <label for="type">Направления:</label>
        <?php foreach ($types as $type): ?>
            <div class="form-check">
                <?php
                $result = '';
                foreach ($task['types'] as $item)
                {
                    if($type['ID'] === $item['ID_TYPE'])
                    {
                        $result = 'checked';
                    }
                }
                ?>
                <input class="form-check-input" type="checkbox" name="type[]" value="<?= $type['ID'] ?>" <?= $result ?>>
                <label class="form-check-label" for="type"><?= $type['NAME']?></label>
            </div>
        <?php endforeach;?>
        <div class="form-row">
            <div class="form-group col-md-2">
                <label for="type">Статус</label>
                <select class="form-control" name="status">
                    <?php foreach ($status as $item):?>
                        <?php
                        $result = '';
                        if($item['ID'] === $task['task']['STATUS_ID'])
                        {
                            $result = 'selected';
                        }
                        ?>
                        <option value="<?= $item['ID']?>" <?= $result ?>><?= $item['NAME']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-2">
                <label for="responsible">Ответственный</label>
                <select class="form-control" name="responsible">
                    <?php $result2 = '';
                    if($_SESSION['USER']['ID'] === $task['responsible']['ID_USER'])
                    {
                        $result2 = 'selected';
                    }
                    ?>
                    <?php foreach ($performers as $performer):?>
                        <?php
                        $result1 = '';
                        if($performer['ID'] === $task['responsible']['ID_USER'])
                        {
                            $result1 = 'selected';
                        }
                        ?>
                        <option value="<?= $performer['ID']?>" <?= $result1 ?>><?= $performer['NAME'] . ' ' . $performer['SURNAME']?></option>
                    <?php endforeach; ?>
                    <option value="<?= $_SESSION['USER']['ID']?>" <?= $result2 ?>>Я</option>
                </select>
            </div>
        </div>

        <label for="performers">Исполнители:</label>
        <?php foreach ($performers as $performer): ?>
            <?php
            $result = '';
            foreach ($task['performer'] as $item)
            {
                if($performer['ID'] === $item['ID_USER'])
                {
                    $result = 'checked';
                }
            }
            ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="performers[]" value="<?= $performer['ID'] ?>" <?= $result ?>>
                <label class="form-check-label" for="performers"><?= $performer['NAME'] . ' ' . $performer['SURNAME']?></label>
            </div>
        <?php endforeach;?>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="performers[]" value="<?= $_SESSION['USER']['ID'] ?>" checked>
            <label class="form-check-label" for="performers">Я</label>
        </div>

        <button type="submit" class="btn btn-primary" style="margin-top: 15px;">Редактировать задачу</button>
    </form>
    <div class="create-errors">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
