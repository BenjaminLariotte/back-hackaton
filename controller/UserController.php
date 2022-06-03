<?php

class UserController extends Controller
{
    public function read($id)
    {
        $this->loadDao("UserDao");

        $userObject = $this->UserDao->readUser($id);

        return $userObject;
    }
}