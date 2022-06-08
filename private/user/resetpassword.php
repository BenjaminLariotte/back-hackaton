<?php 

require "../../private/dedicated_functions.php";
require_once ROOT . "models/UserClass.php";
require_once ROOT . "controller/UserController.php";
require_once ROOT . "core/database_connection.php";
require_once ROOT . "models/ErrorClass.php";

header("Access-Control-Allow-Origin: *");

//récupération des données
$email = json_decode(file_get_contents("php://input"));
var_dump($email);
