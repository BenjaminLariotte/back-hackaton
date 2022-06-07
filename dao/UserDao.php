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

    public static function testLogin($login)
    {
        $pseudo = DataBase::databaseRequest("SELECT * from th_user WHERE th_user_pseudo = ?", array($login));
        $email = DataBase::databaseRequest("SELECT * from th_user WHERE th_user_email = ?", array($login));


        if (!empty($email))
        {
            return 2;
        }
        elseif (!empty($pseudo))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public static function tryLogin($login, $password)
    {
        $loginType = UserDao::testLogin($login);

        switch ($loginType) {
            case 0 :
                return -2; 
                break;
            case 1 :
                $request = DataBase::databaseRequest("SELECT th_user_password, th_user_id from th_user WHERE th_user_pseudo = ?", array($login));
                break;
            case 2 :       
                $request = DataBase::databaseRequest("SELECT th_user_password, th_user_id from th_user WHERE th_user_email = ?", array($login));
                break;
            default :
                return -1;
                break;
        }


        if (!empty($request))
        {
            if (password_verify($password, $request[0]["th_user_password"]))
            {
                return $request[0]["th_user_id"]
            }
        }

        return -3
    }

}