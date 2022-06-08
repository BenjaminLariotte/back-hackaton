<?php 

require "../../private/dedicated_functions.php";
require_once ROOT . "models/UserClass.php";
require_once ROOT . "controller/UserController.php";
require_once ROOT . "core/database_connection.php";
require_once ROOT . "models/ErrorClass.php";


header("Access-Control-Allow-Origin: *");

//récupération des données
$email = json_decode(file_get_contents("php://input"));

valid_data($email);

$test = UserDao::testLogin($email);

if ($test === 2)
{
    mb_send_mail($email, "Récupération du mot de passe", "Voici le lien pour créer un nouveau mot de passe : ");
}