<?php

//Création d'une constante pour début d'adresse des fichiers.
define("ROOT", "C:/wamp64/www/Hackaton2022/back-hackaton/");


//Fonction nettoyant le contenu entrant
function valid_data($data)
{
    if ($data)
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}