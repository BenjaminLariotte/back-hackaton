<?php

define("ROOT", "D:/DevProjects/Hackaton2022/back-hackaton/");


//Fonction nettoyant le contenu entrant
function valid_data($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}