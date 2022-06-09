<?php

define("ROOT", "C:/wamp64/www/Hackaton2022/back-hackaton/");


//Fonction nettoyant le contenu entrant
function valid_data($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}