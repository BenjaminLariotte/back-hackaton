<?php
require "../../private/dedicated_functions.php";

require_once ROOT . 'models/UserClass.php';
require_once ROOT . 'controller/UserController.php';

header("Access-Control-Allow-Origin: *");

//récupération des données
$data = json_decode(file_get_contents("php://input"));

//vérification des données
foreach ($data as $value)
{
    $value = valid_data($value);
}

if (!is_null($data->login && !is_null($data->password)))
{

    $userId = UserController::tryLogin($data->login, $data->password);

    $userObject = UserController::read($userId);

    $responseArray = (array)$userObject;

    $testArray = [];

    foreach ($responseArray as $value)
    {
        $testArray[] = $value;

    }

    $testArray["response_code"] = 1;



    echo json_encode($testArray);
}