<?php
require_once ROOT . 'core/Controller.php';

class APIController extends Controller
{
    public static function researchProduct($name)
    {
        $result = file_get_contents("https://fr.openfoodfacts.org/api/v2/search?product_name_fr=".$name."|categories_tags_fr=".$name."&fields=code,product_name_fr,image_url,origin_fr,nutrition_grade_fr,allergens,stores");

        //$result[0] = file_get_contents("https://fr.openfoodfacts.org/api/v2/search?categories_tags_fr=".$name."&fields=code,product_name_fr,image_url,origin_fr,nutrition_grade_fr,allergens,stores");

        return $result;
    }

    public static function researchProductByCode($code)
    {
        $result = file_get_contents("https://fr.openfoodfacts.org/api/v2/search?code=".$code."&fields=code,product_name_fr,image_url,origin_fr,nutrition_grade_fr,allergens,stores");

        return $result;
    }

    public static function compareProductPopularity($productCode1, $productCode2)
    {
        $product1Popularity = json_decode(file_get_contents("https://fr.openfoodfacts.org/api/v2/search?code=".$productCode1."&fields=popularity_tags"));

        $product2Popularity = json_decode(file_get_contents("https://fr.openfoodfacts.org/api/v2/search?code=".$productCode2."&fields=popularity_tags"));

        $product1Popularity = $product1Popularity->products[0]->popularity_tags;

        $product2Popularity = $product2Popularity->products[0]->popularity_tags;


        $product1_2022 = APIController::popularity2022($product1Popularity);
        $product1_2021 = APIController::popularity2021($product1Popularity);
        $product1_2020 = APIController::popularity2020($product1Popularity);


        $product2_2022 = APIController::popularity2022($product2Popularity);
        $product2_2021 = APIController::popularity2021($product2Popularity);
        $product2_2020 = APIController::popularity2020($product2Popularity);

        if (preg_match("/[0-9]+/", $product1_2022) && preg_match("/[0-9]+/", $product2_2022))
        {
            $product1_2022 = (int)$product1_2022;
            $product2_2022 = (int)$product2_2022;

            if ($product1_2022 > $product2_2022)
            {
                $popularityResponse = "Produit 1 est le plus populaire en 2022";
            }
            elseif ($product1_2022 < $product2_2022)
            {
                $popularityResponse = "Produit 2 est le plus populaire en 2022";
            }
            else
            {
                $popularityResponse = "Les 2 produit sont autant populaire en 2022";
            }
        }
        elseif (preg_match("/[0-9]+/", $product1_2022))
        {
            $popularityResponse = "Seul le produit 1 est populaire en 2022";
        }
        elseif (preg_match("/[0-9]+/", $product2_2022))
        {
            $popularityResponse = "Seul le produit 2 est populaire en 2022";
        }
        else
        {
            if (preg_match("/[0-9]+/", $product1_2021) && preg_match("/[0-9]+/", $product2_2021))
            {
                $product1_2021 = (int)$product1_2021;
                $product2_2021 = (int)$product2_2021;

                if ($product1_2021 > $product2_2021)
                {
                    $popularityResponse = "Produit 1 est le plus populaire en 2021";
                }
                elseif ($product1_2021 < $product2_2021)
                {
                    $popularityResponse = "Produit 2 est le plus populaire en 2021";
                }
                else
                {
                    $popularityResponse = "Les 2 produit sont autant populaire en 2021";
                }
            }
            elseif (preg_match("/[0-9]+/", $product1_2021))
            {
                $popularityResponse = "Seul le produit 1 est populaire en 2021";
            }
            elseif (preg_match("/[0-9]+/", $product2_2021))
            {
                $popularityResponse = "Seul le produit 2 est populaire en 2021";
            }
            else
            {
                if (preg_match("/[0-9]+/", $product1_2020) && preg_match("/[0-9]+/", $product2_2020))
                {
                    $product1_2020 = (int)$product1_2020;
                    $product2_2020 = (int)$product2_2020;

                    if ($product1_2020 > $product2_2020)
                    {
                        $popularityResponse = "Produit 1 est le plus populaire en 2020";
                    }
                    elseif ($product1_2020 < $product2_2020)
                    {
                        $popularityResponse = "Produit 2 est le plus populaire en 2020";
                    }
                    else
                    {
                        $popularityResponse = "Les 2 produit sont autant populaire en 2020";
                    }
                }
                elseif (preg_match("/[0-9]+/", $product1_2020))
                {
                    $popularityResponse = "Seul le produit 1 est populaire en 2020";
                }
                elseif (preg_match("/[0-9]+/", $product2_2020))
                {
                    $popularityResponse = "Seul le produit 2 est populaire en 2020";
                }
                else
                {
                    $popularityResponse = "Aucun des 2 produits n'est populaire depuis 2020";
                }
            }
        }

        return $popularityResponse;
    }

    public static function popularity2022($popularityArray)
    {
        $popularity2022 = [];

        foreach ($popularityArray as $value)
        {
            $ok = preg_match('/top-([0-9]+)-scans-2022/', $value, $matches);
            if ($ok === 1)
            {
                $popularity2022[] = $value;
            }
        }
        if (array_key_exists("0", $popularity2022))
        {
            $search = ["top-", "-scans-2022"];
            $result = str_replace($search, "", $popularity2022[0]);
        }
        else
        {
            $result = "no result";
        }
        return $result;
    }

    public static function popularity2021($popularityArray)
    {
        $popularity2021 = [];

        foreach ($popularityArray as $value)
        {
            $ok = preg_match('/top-([0-9]+)-scans-2021/', $value, $matches);
            if ($ok === 1)
            {
                $popularity2021[] = $value;
            }
        }
        if (array_key_exists("0", $popularity2021))
        {
            $search = ["top-", "-scans-2021"];
            $result = str_replace($search, "", $popularity2021[0]);
        }
        else
        {
            $result = "no result";
        }
        return $result;
    }

    public static function popularity2020($popularityArray)
    {
        $popularity2020 = [];

        foreach ($popularityArray as $value)
        {
            $ok = preg_match('/top-([0-9]+)-scans-2020/', $value, $matches);
            if ($ok === 1)
            {
                $popularity2020[] = $value;
            }
        }
        if (array_key_exists("0", $popularity2020))
        {
            $search = ["top-", "-scans-2020"];
            $result = str_replace($search, "", $popularity2020[0]);
        }
        else
        {
            $result = "no result";
        }
        return $result;
    }

}