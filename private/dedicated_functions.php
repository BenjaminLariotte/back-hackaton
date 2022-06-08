<?php

define("ROOT", "http://localhost/back-hackaton/");

function valid_data($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}