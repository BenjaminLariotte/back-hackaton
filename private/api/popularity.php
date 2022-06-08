<?php
require "../../private/dedicated_functions.php";

require_once ROOT . 'controller/APIController.php';


header("Access-Control-Allow-Origin: *");

//récupération des données
$data = json_decode(file_get_contents("php://input"));

//vérification des données
foreach ($data as $value)
{
    $value = valid_data($value);
}

$response = APIController::compareProductPopularity($data->id1, $data->id2);


var_dump($response);
exit();

echo json_encode($response);