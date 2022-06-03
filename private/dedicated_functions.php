<?php

define("ROOT", "C:/wamp64/www/hackaton2022/back-hackaton/");

function valid_data($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}