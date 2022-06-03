<?php
require "../../private/dedicated_functions.php";

header("Access-Control-Allow-Origin: *");
$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

$_POST = valid_data($_POST);