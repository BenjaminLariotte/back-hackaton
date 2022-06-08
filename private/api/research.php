<?php
require "../../private/dedicated_functions.php";

require_once ROOT . 'controller/APIController.php';
require_once ROOT . 'controller/OpenFoodFactController.php';


header("Access-Control-Allow-Origin: *");

//récupération des données
$data = json_decode(file_get_contents("php://input"));

$data = valid_data($data);

//$response = APIController::researchProduct($data);
if (property_exists($data, "resultPerPage")) {
    $resultPerPage = $data->$resultPerPage ;
} else {
    $resultPerPage = 50;
}

if (property_exists($data, "pageNumber")) {
    $pageNb = "search=".$data->$pageNumber;
} else {
    $pageNb = 1 ;
}

$constraints = []
if (property_exists($data, "searchTerm")) {
    $constraints[] = "search=".$data->$searchTerm;
}
if (property_exists($data, "additionalFilters")) {
    $constraints[] = "search=".$data->$additionalFilters;
}

if (property_exists($data, "fields")) {
    $fields = "search=".$data->$fields;
} else {
    $fields = ["code","product_name_fr","image_url","origin_fr","nutrition_grade_fr","allergens","stores"] ;
}
 

$response = OpenFoodFactController::getListOfProducts($resultPerPage, $pageNb, $constraints, $fields) ;

echo json_encode($response); 