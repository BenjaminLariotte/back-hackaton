<?php
require_once ROOT . 'dao/UserDao.php';
require_once ROOT . 'core/Controller.php';

class UserController extends Controller
{
    //rée un utilisateur dans la base de donnée
    public static function create($userObject)
    {
        UserDao::createNewUser($userObject);
    }

    //Récupère le pseudo, email, mdp haché et id d'un utilisateur
    public static function read($id)
    {

        $userObject = UserDao::readUser($id);

        return $userObject;
    }

    //Teste si un login est dans la base de donnée, renvois 0 si négatif, 1 si pseudo et 2 si email
    public static function testLogin($login)
    {
        $testResponse = UserDao::testLogin($login);

        return $testResponse;
    }

    //Teste la connexion à un compte avec un login et un mot de passe puis renvoie l'id du compte si succès
    public static function tryLogin($login, $password)
    {
        $tryResponse = UserDao::tryLogin($login, $password);

        return $tryResponse;
    }
}

