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

//Vérification que les champ requis sont remplis
if (!is_null($data->login && !is_null($data->password)))
{

    //Vérification du login et mot de passe, puis renvoi de l'id si validé
    $catchLogin = UserController::tryLogin($data->login, $data->password);

    if (is_int($catchLogin))
    {
        $userObject = UserController::read($catchLogin);

        //Transformation de l'objet user dans un tableau
        $cleanResponseArray["id"] = $userObject->getId();
        $cleanResponseArray["th_user_pseudo"] = $userObject->getUserPseudo();
        $cleanResponseArray["th_user_email"] = $userObject->getUserEmail();
        $cleanResponseArray["th_user_password"] = $userObject->getUserPassword();

        echo json_encode($cleanResponseArray);
    }
else
    {
        $cleanResponse = $catchLogin;

        echo json_encode($cleanResponse);
    }

}