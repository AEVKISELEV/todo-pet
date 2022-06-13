<?php
/** @var array $tasks
 * @var TypeService $types
 * @var FriendService $friend
 */

?>
<div class="task-container" style="display: flex; flex-direction: row; padding: 50px">
<?php foreach ($tasks as $task): ?>
    <div class="card" style="width: 18rem; margin-right: 30px;">
        <div class="card-body">
            <form method="post">
                <input name="delete-task" value="<?= $task['ID']?>" style="display: none">
            <button type="submit" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </form>
            <h5 class="card-title"><?= $task['NAME']?></h5>
            <p class="card-text"><?= $task['DESCRIPTION']?></p>
            <div> Статус: <?= $task['STATUS_NAME']?></div>
            <div>Направления задачи:</div>
            <?php $typeArray = $types->getTypeByIdTask($task['ID'])?>
                <?php foreach ($typeArray as $type): ?>
                <div> <?= $type['NAME']?></div>
                <?php endforeach;?>
            <div>Ответственный:</div>
            <?php $responsible = $friend->getFriendsForResponsibleByID($task['ID'])?>
            <div><?= $responsible['NAME']?></div>
            <div>Исполнители:</div>
            <?php $performersArray = $friend->getFriendsForPerformersByID($task['ID'])?>
            <ul>
                <?php foreach ($performersArray as $type): ?>
                <li> <?= $type['NAME']?></li>
                <?php endforeach;?>
            </ul>
            <div>Дата создания: <?= $task['DATA_CREATE']?></div>
            <?php if($task['STATUS_NAME'] === 'Поставлена'):?>
            <form method="post">
                <input name="task-id" value="<?= $task['ID']?>" style="display: none">
                <button type="submit" class="status" name="status" value="<?= $task['STATUS_ID'] ?>">Начать выполнение</button>
            </form>
            <?php elseif($task['STATUS_NAME'] === 'Выполняется'): ?>
            <form method="post">
                <input name="task-id" value="<?= $task['ID']?>" style="display: none">
                <button type="submit" class="status" name="status" value="<?= $task['STATUS_ID'] ?>">Завершить</button>
            </form>
            <?php endif; ?>
            <a href="editTask.php?id=<?= $task['ID'] ?>" class="btn btn-primary" style="margin-top: 10px">Редактировать задачу</a>
        </div>
    </div>
<?php endforeach;?>
</div>




