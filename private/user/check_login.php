<?php
require_once "../../private/dedicated_functions.php";
require_once ROOT . 'controller/UserController.php';

header("Access-Control-Allow-Origin: *");

//récupération des données
$data = json_decode(file_get_contents("php://input"));

/*var_dump($data);
foreach ($data as $value)
{
    $value = valid_data($value);
}*/

$response = UserController::testLogin(valid_data($data));

echo json_encode($response);