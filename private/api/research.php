<?php
require "../../private/dedicated_functions.php";

require_once ROOT . 'controller/APIController.php';


header("Access-Control-Allow-Origin: *");

//récupération des données
$data = json_decode(file_get_contents("php://input"));

$data = valid_data($data);

$response = APIController::researchProduct($data);

echo json_encode($response);