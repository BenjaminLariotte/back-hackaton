<?php

define("ROOT", "D:/DevProjects/Hackaton2022/back-hackaton/");

function valid_str_data($data)
{
    if ($data)
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function valid_data($data) {
    if (is_string($data)) {
        return valid_str_data($data) ;
    } else if (is_object($data)) {
        foreach($data as $prop) {
            $prop = valid_data(strval($prop)) ;
        }
        return $data ;
    }
}