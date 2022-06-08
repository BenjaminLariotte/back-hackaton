<?php
require_once ROOT . 'core/Controller.php';

class APIController extends Controller
{
    public static function researchProduct($name)
    {
        $result = file_get_contents("https://world.openfoodfacts.org/api/v2/search?categories_tags_fr=".$name."&fields=code,product_name,origin_fr,nutrition_grade_fr,allergens,stores");

        return $result;
    }
}