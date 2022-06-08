<?php
require_once "../../private/dedicated_functions.php";
require_once ROOT . 'controller/UserController.php';

header("Access-Control-Allow-Origin: *");

//récupération des données
$data = json_decode(file_get_contents("php://input"));

$data = valid_data($data);

//Test du login et renvoi de réponse 0 si inexistant, 1 si pseudo existant et 2 si email existant
$response = UserController::testLogin($data);

echo json_encode($response);