<?php 

require "../../private/dedicated_functions.php";
require_once ROOT . "models/UserClass.php";
require_once ROOT . "controller/UserController.php";
require_once ROOT . "core/database_connection.php";
require_once ROOT . "models/ErrorClass.php";

<<<<<<< HEAD
$db = new PDO ("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS);
            
=======
>>>>>>> 84812d50531c99e1de6b31aed47e0f51d79e7bb6
header("Access-Control-Allow-Origin: *");

//récupération des données
$email = json_decode(file_get_contents("php://input"));

<<<<<<< HEAD
//$test = UserDao::testLogin($email);

 $emailExist = UserDao::testLogin($email);


if ($emailExist === 2 ){
    $token = uniqid();
    $sql = "INSERT INTO password_reset(email, token) VALUES ('$email', '$token')";

    mb_send_mail($email){
        
        $to = $email,
        $subject = "Réinitialisez votre password";
        $msg   ="";
        $headers = "From: info@examplesite.com";
        mail($to, $subject, $headers);
        header('' . $email);

    }
}
?>
=======
    $test = UserDao::testLogin($email);
    var_dump($test);
>>>>>>> 84812d50531c99e1de6b31aed47e0f51d79e7bb6
