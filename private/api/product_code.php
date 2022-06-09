<?php
require "../../private/dedicated_functions.php";

require_once ROOT . 'controller/APIController.php';

header("Access-Control-Allow-Origin: *");

//récupération des données
$data = json_decode(file_get_contents("php://input"));

$data = valid_data($data);

//Recherche d'un produit par son code
$response = APIController::researchProductByCode($data);

$response = $response->products[0];

$responseArray["allergens"] = $response->allergens ?? null;
$responseArray["allergens_imported"] = $response->allergens_imported ?? null;
$responseArray["code"] = $response->code ?? null;
$responseArray["generic_name"] = $response->generic_name ?? null;
$responseArray["image_url"] = $response->image_url ?? null;
$responseArray["ingredients_text_fr"] = $response->ingredients_text_fr ?? null;
$responseArray["_keywords"] = $response->_keywords ?? null;
$responseArray["nutrition_grade_fr"] = $response->nutrition_grade_fr ?? null;
$responseArray["origin_fr"] = $response->origin_fr ?? null;
$responseArray["product_name_fr"] = $response->product_name_fr ?? null;
$responseArray["stores"] = $response->stores ?? null;

echo json_encode($responseArray);