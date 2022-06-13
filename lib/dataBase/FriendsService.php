<?php

namespace Todo\lib\database;

use PDO;

class FriendsService
{
    private $pdo;

    public function __construct(DbConnect $database)
    {
        $this->pdo = $database->getPDO();
    }

    public function getFriends()
    {
        $ID = $_SESSION['USER']['ID'];
        $stmt = $this->pdo->prepare("SELECT tu.* FROM todo_friend INNER JOIN todo_user tu on todo_friend.ID_FRIEND = tu.ID
        WHERE ID_USER = ?");
        $stmt->execute([$ID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAmountFriends()
    {
        $id = $_SESSION['USER']['ID'];
        $stmt = $this->pdo->prepare("SELECT COUNT(ID_FRIEND) as AMOUNT FROM todo_friend 
        WHERE ID_USER = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getFriendsForResponsibleByID($id)
    {
        $stmt = $this->pdo->prepare("SELECT tu.NAME, todo_performer.ID_USER as ID FROM todo_performer INNER JOIN todo_user tu on todo_performer.ID_USER = tu.ID
        WHERE ID_TASK = ? AND ID_ROLE = 1");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getFriendsForPerformersByID($id)
    {
        $stmt = $this->pdo->prepare("SELECT tu.NAME as NAME, todo_performer.ID_USER as ID FROM todo_performer INNER JOIN todo_user tu on todo_performer.ID_USER = tu.ID
        WHERE ID_TASK = ? AND ID_ROLE = 2");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createFriend(): void
    {
        if(isset($_POST['friend']))
        {
            $ID = $_POST['friend'];
            $user = $_SESSION['USER']['ID'];
            $stmt = $this->pdo->prepare("INSERT INTO todo_friend (ID_USER, ID_FRIEND) VALUES (:user_id, :friend_id)");
            $stmt->execute(['user_id' => $user, 'friend_id' => $ID]);
        }
    }

    public function deleteFriends(): void
    {
        if(isset($_POST['delete_friends']))
        {
            $ID_array = $_POST['delete_friends'];
            $ID_string = implode(',', $ID_array);
            $user = $_SESSION['USER']['ID'];
            $stmt = $this->pdo->prepare("DELETE FROM todo_friend WHERE ID_USER = :user_id AND ID_FRIEND IN (".$ID_string.")");
            $stmt->execute(['user_id' => $user]);
        }
    }
}