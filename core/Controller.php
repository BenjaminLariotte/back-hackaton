<?php


class Controller
{
    var $vars = array();

    public function __construct()
    {
        if (isset($_POST))
        {
            $this->input = $_POST;
        }

        if (isset($_FILES))
        {
            $this->files = $_FILES;
        }
    }

    public function loadDao($daoName)
    {
        require_once ("back/dao/".$daoName.".php");
        $this->$daoName = new $daoName();
    }
}
