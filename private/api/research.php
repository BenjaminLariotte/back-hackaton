<?php
require "../../private/dedicated_functions.php";

require_once ROOT . 'controller/APIController.php';
require_once ROOT . 'controller/OpenFoodFactController.php';


header("Access-Control-Allow-Origin: *");

//récupération des données
$data = json_decode(file_get_contents("php://input"));

$data = valid_data($data);

//$response = APIController::researchProduct($data);
$response = OpenFoodFactController::getListOfProducts("50", "search=$data", "fields=code,product_name,image_url,origin_fr,nutrition_grade_fr,allergens,stores") ;

echo json_encode($response);