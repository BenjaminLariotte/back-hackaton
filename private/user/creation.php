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

//création de l'user dans la bdd et retour de l'objet user si tout va bien
if (!is_null($data->username) && !is_null($data->email) && !is_null($data->password))
{
    $userObject = new User($data->username, $data->email, password_hash($data->password, PASSWORD_DEFAULT));

    UserController::create($userObject);

    $userObject = UserController::read($_SESSION["id"]);

    $responseArray = (array)$userObject;

    echo json_encode($responseArray);
}
else
{
    echo json_encode('erreur mec ! XD');
}