<?php


define("ROOT", "c://xampp/htdocs/back-hackaton/");

function valid_data($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>