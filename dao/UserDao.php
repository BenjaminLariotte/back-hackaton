<?php
require_once ROOT . "models/UserClass.php";
require_once ROOT . "controller/UserController.php";
require_once ROOT . "core/database_connection.php";
require_once ROOT . "models/ErrorClass.php";


class UserDao
{

    //Création d'un nouvel utilisateur dans la base de donnée
    public static function createNewUser($user)
    {
        DataBase::databaseRequest("INSERT INTO th_user (th_user_pseudo, th_user_email, th_user_password)
VALUES (?, ?, ?)", array($user->getUserPseudo(), $user->getUserEmail(), $user->getUserPassword()));

        //Récupération de l'id fraichement créé dans la SESSION
        $_SESSION['id'] = DataBase::databaseLastId();
    }


    //Récupération d'un utilisateur dans la base de donnée
    public static function readUser($id)
    {
        $userArray = DataBase::databaseRequest("SELECT * from th_user WHERE th_user_id = ?", array($id));

        $userObject = new User($userArray[0]["th_user_pseudo"], $userArray[0]["th_user_email"], $userArray[0]["th_user_password"]);
        $userObject->setId((int)$id);

        return $userObject;
    }


    //test pour savoir si un pseudo ou un email est d♪0jà présent dans la base de donnée
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

    //Connexion à un compte utilisateur
    public static function tryLogin($login, $password)
    {

        $testLogin = UserDao::testLogin($login);

        if ($testLogin === 2 || $testLogin === 1)
        {
            $request = DataBase::databaseRequest("SELECT th_user_password, th_user_id from th_user WHERE th_user_pseudo = ? OR th_user_email = ?", array($login, $login));

            if (password_verify($password, $request[0]["th_user_password"]))
            {
                return $request[0]["th_user_id"];
            }
            else
            {
                return "mauvais mot de passe";
            }
        }
        else
        {
            return "Pseudo ou email inexistant";
        }
    }
}