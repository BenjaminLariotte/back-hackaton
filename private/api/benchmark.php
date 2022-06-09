<?php
require "../../private/dedicated_functions.php";

require_once ROOT . 'controller/KeywordController.php';


header("Access-Control-Allow-Origin: *");

//récupération des données
$data = json_decode(file_get_contents("php://input"));

//vérification des données
foreach ($data as $value)
{
    $value = valid_data($value);
}

if (property_exists($data, "stores")) {
    $stores = strval($data->stores) ;
} else {
    $stores = [];
}

if (property_exists($data, "_keywords")) {
    $keywords = strval($data->_keywords) ;
} else {
    $keywords = [];
}

$response = KeywordController::compareStoreForOneProduct($keywords, $stores) ;

/*var_dump($response);*/

echo json_encode($response); 