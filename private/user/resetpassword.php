<?php 

require "../../private/dedicated_functions.php";
require_once ROOT . "models/UserClass.php";
require_once ROOT . "controller/UserController.php";
require_once ROOT . "core/database_connection.php";
require_once ROOT . "models/ErrorClass.php";

//récupération des données
$email = json_decode(file_get_contents("php://input"));
$email = DataBase::databaseRequest("SELECT * from th_user WHERE th_user_email = :email");


var_dump($email);

exit;

if (!empty($_POST))
{

    if (!empty($_POST["th_user_email"]))
    {
        
        
        //email control
        if (!filter_var($_POST["th_user_email"], FILTER_VALIDATE_EMAIL)) {
            die ("email non valid");
        }
       
       $sql = "SELECT * FROM `th_user` WHERE `th_user_email`= :email";

       $query = $db->prepare($sql);

       $query->bindValue(":email", $_POST["th_user_email"], PDO::PARAM_STR);

       $query->execute();

       $user = $query->fetch();

      if(!$user){
        die("email ou le mot de passe est invalide ");  
    }

}  
var_dump($email);

exit;
?>