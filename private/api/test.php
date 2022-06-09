<?php
require "../../private/dedicated_functions.php";

require_once ROOT . 'controller/KeywordController.php';


header("Access-Control-Allow-Origin: *");

//récupération des données
$data = json_decode(file_get_contents("php://input"));

if ($data == "1") {
    $response = KeywordController::Test1() ;
} else {
    $response = KeywordController::Test2() ;
}

/*$response = (array)$response;

var_dump($response);*/

echo json_encode($response); 