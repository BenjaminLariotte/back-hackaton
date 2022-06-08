<?php
define("ROOT", "http://localhost/back-hackaton/");

define("ROOT", "D:/DevProjects/Hackaton2022/back-hackaton/");

function valid_data($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}