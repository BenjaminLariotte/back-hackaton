<?php
require_once ROOT . 'dao/UserDao.php';
require_once ROOT . 'core/Controller.php';

class UserController extends Controller
{
    public static function create($userObject)
    {
        UserDao::createNewUser($userObject);
    }

    public static function read($id)
    {

        $userObject = UserDao::readUser($id);

        return $userObject;
    }

    public static function testLogin($login)
    {
        $testResponse = UserDao::testLogin($login);

        return $testResponse;
    }

    public static function tryLogin($login)
    {
        $testResponse = UserDao::tryLogin($login);

        return $testResponse;
    }
}

