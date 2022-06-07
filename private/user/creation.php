<?php
require_once "../../private/dedicated_functions.php";
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

//création de l'user dans la bdd et retour de l'objet user
if (!is_null($data->username) && !is_null($data->email) && !is_null($data->password))
{
    $userObject = new User($data->username, $data->email, password_hash($data->password, PASSWORD_DEFAULT));

    UserController::create($userObject);

    $userObject = UserController::read($_SESSION["id"]);

    $responseArray = (array)$userObject;

    $responseArray["response_code"] = 1;

    echo json_encode($responseArray);
}
else
{
    $responseArray["response_code"] = 2;

    echo json_encode($responseArray);
}