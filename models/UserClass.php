<?php
require_once ROOT . 'core/id_class.php';

class User extends IdClass
{
    private $th_user_pseudo;
    private $th_user_email;
    private $th_user_password;

    public function __construct($user_pseudo, $user_email, $password)
    {
        $this->th_user_pseudo = $user_pseudo;
        $this->th_user_email = $user_email;
        $this->th_user_password = $password;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserPseudo()
    {
        return $this->th_user_pseudo;
    }
    public function setUserPseudo($user_pseudo)
    {
        $this->th_user_pseudo = $user_pseudo;
    }

    public function getUserEmail()
    {
        return $this->th_user_email;
    }
    public function setUserEmail($user_email)
    {
        $this->th_user_email = $user_email;
    }

    public function getUserPassword()
    {
        return $this->th_user_password;
    }
    public function setUserPassword($user_password)
    {
        $this->th_user_password = $user_password;
    }

}