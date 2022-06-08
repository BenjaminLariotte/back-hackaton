<?php
require_once ROOT . 'core/Controller.php';

class APIController extends Controller
{
    public static function researchProduct($name)
    {
        $result = file_get_contents("https://fr.openfoodfacts.org/api/v2/search?categories_tags_fr=".$name."&fields=code,product_name,image_url,origin_fr,nutrition_grade_fr,allergens,stores");

        return $result;
    }

    public static function compareProductPopularity($productCode1, $productCode2)
    {
        $product1Popularity = json_decode(file_get_contents("https://fr.openfoodfacts.org/api/v2/search?code=".$productCode1."&fields=popularity_tags"));

        $product2Popularity = file_get_contents("https://fr.openfoodfacts.org/api/v2/search?code=".$productCode2."&fields=popularity_tags");

        var_dump(json_decode($product1Popularity));
        $product1Popularity = (array)$product1Popularity->product;


        exit();

        foreach ($product1Popularity as $value)
        {
            preg_match("2022", $value, $result);
            return $result;
        }

        $test = [$product1Popularity, $product2Popularity];

        return $test;
    }
}