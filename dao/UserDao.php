<?php
require_once ROOT . "models/UserClass.php";
require_once ROOT . "controller/UserController.php";
require_once ROOT . "core/database_connection.php";


class UserDao
{
    public static function createNewUser($user)
    {
        DataBase::databaseRequest("INSERT INTO th_user (th_user_pseudo, th_user_email, th_user_password)
VALUES (?, ?, ?)", array($user->getUserPseudo(), $user->getUserEmail(), $user->getUserPassword()));

        $_SESSION['id'] = DataBase::databaseLastId();

    }


    public static function readUser($id)
    {
        $userArray = DataBase::databaseRequest("SELECT * from th_user WHERE th_user_id = ?", array($id));

        $userObject = new User($userArray[0]["th_user_pseudo"], $userArray[0]["th_user_email"], $userArray[0]["th_user_password"]);
        $userObject->setId((int)$id);

        return $userObject;
    }

    public static function pseudoExist($pseudo)
    {
        $userArray = DataBase::databaseRequest("SELECT * from th_user WHERE th_user_pseudo = ? OR th_user_email = ?", array($pseudo));

        if (!empty($userArray))
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    public function checkLogin($login)
    {
        $userArray = DataBase::databaseRequest("SELECT * from user WHERE user_email = ? OR user_pseudo = ?", array($login, $login));

        if (!empty($userArray))
        {
            return $userArray;
        }
        else
        {
            $userArray = "";
            return $userArray;
        }
    }
}