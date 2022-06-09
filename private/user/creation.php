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

    $cleanResponseArray["id"] = $userObject->getId();
    $cleanResponseArray["th_user_pseudo"] = $userObject->getUserPseudo();
    $cleanResponseArray["th_user_email"] = $userObject->getUserEmail();
    $cleanResponseArray["th_user_password"] = $userObject->getUserPassword();

    $cleanResponseArray["response_code"] = 1;
}
else
{
    $cleanResponseArray["response_code"] = 2;

}
echo json_encode($cleanResponseArray);
