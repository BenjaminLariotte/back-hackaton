<?php
require_once ROOT . 'core/Controller.php';

class APIController extends Controller
{
    //Recherche d'un produit sur l'api par nom ou tag
    public static function researchProduct($input)
    {
        $result = file_get_contents("https://fr.openfoodfacts.org/api/v2/search?product_name_fr=".$input."|categories_tags_fr=".$input."&fields=code,product_name_fr,image_url,origin_fr,nutrition_grade_fr,allergens,stores");

        //$result[0] = file_get_contents("https://fr.openfoodfacts.org/api/v2/search?categories_tags_fr=".$input."&fields=code,product_name_fr,image_url,origin_fr,nutrition_grade_fr,allergens,stores");

        return $result;
    }

    //Recherche d'un produit sur l'api par code produit
    public static function researchProductByCode($code)
    {
        $result = file_get_contents("https://fr.openfoodfacts.org/api/v2/search?code=".$code."&fields=code,product_name_fr,image_url,origin_fr,nutrition_grade_fr,allergens,stores");

        return $result;
    }

    //Compare la popularité de 2 produits sur les 3 dernières années et renvois le meilleurs en commençant par l'année la plus récente. Et si pas de résultat, tente sur l'année suivante.
    public static function compareProductPopularity($productCode1, $productCode2)
    {
        //Requête pour obtenir les valeurs de popularité d'un produit
        $product1Popularity = json_decode(file_get_contents("https://fr.openfoodfacts.org/api/v2/search?code=".$productCode1."&fields=popularity_tags"));
        $product2Popularity = json_decode(file_get_contents("https://fr.openfoodfacts.org/api/v2/search?code=".$productCode2."&fields=popularity_tags"));

        //Rangement des valeurs dans un tableau bien propre
        $product1Popularity = $product1Popularity->products[0]->popularity_tags;
        $product2Popularity = $product2Popularity->products[0]->popularity_tags;


        //Récupération du meilleur top par année pour le produit 1 en chiffre
        $product1_2022 = APIController::popularity2022($product1Popularity);
        $product1_2021 = APIController::popularity2021($product1Popularity);
        $product1_2020 = APIController::popularity2020($product1Popularity);

        //Récupération du meilleur top par année pour le produit 2 en chiffre
        $product2_2022 = APIController::popularity2022($product2Popularity);
        $product2_2021 = APIController::popularity2021($product2Popularity);
        $product2_2020 = APIController::popularity2020($product2Popularity);

        //Vérification pour savoir si sur l'année 2022 les 2 produit sont dans un top
        if (preg_match("/[0-9]+/", $product1_2022) && preg_match("/[0-9]+/", $product2_2022))
        {
            if ($product1_2022 < $product2_2022)
            {
                $popularityResponse = "Produit 1 est le plus populaire en 2022";
            }
            elseif ($product1_2022 > $product2_2022)
            {
                $popularityResponse = "Produit 2 est le plus populaire en 2022";
            }
            else
            {
                $popularityResponse = "Les 2 produit sont autant populaire en 2022";
            }
        }
        //Autrement vérification pour savoir si le produit 1 est dans un top sur l'année 2022
        elseif (preg_match("/[0-9]+/", $product1_2022))
        {
            $popularityResponse = "Seul le produit 1 est populaire en 2022";
        }
        //Autrement vérification pour savoir si le produit 2 est dans un top sur l'année 2022
        elseif (preg_match("/[0-9]+/", $product2_2022))
        {
            $popularityResponse = "Seul le produit 2 est populaire en 2022";
        }
        else
        {
            //Vérification pour savoir si sur l'année 2021 les 2 produit sont dans un top
            if (preg_match("/[0-9]+/", $product1_2021) && preg_match("/[0-9]+/", $product2_2021))
            {
                if ($product1_2021 < $product2_2021)
                {
                    $popularityResponse = "Produit 1 est le plus populaire en 2021";
                }
                elseif ($product1_2021 > $product2_2021)
                {
                    $popularityResponse = "Produit 2 est le plus populaire en 2021";
                }
                else
                {
                    $popularityResponse = "Les 2 produit sont autant populaire en 2021";
                }
            }
            //Autrement vérification pour savoir si le produit 1 est dans un top sur l'année 2021
            elseif (preg_match("/[0-9]+/", $product1_2021))
            {
                $popularityResponse = "Seul le produit 1 est populaire en 2021";
            }
            //Autrement vérification pour savoir si le produit 2 est dans un top sur l'année 2021
            elseif (preg_match("/[0-9]+/", $product2_2021))
            {
                $popularityResponse = "Seul le produit 2 est populaire en 2021";
            }
            else
            {
                //Vérification pour savoir si sur l'année 2020 les 2 produit sont dans un top
                if (preg_match("/[0-9]+/", $product1_2020) && preg_match("/[0-9]+/", $product2_2020))
                {
                    if ($product1_2020 < $product2_2020)
                    {
                        $popularityResponse = "Produit 1 est le plus populaire en 2020";
                    }
                    elseif ($product1_2020 > $product2_2020)
                    {
                        $popularityResponse = "Produit 2 est le plus populaire en 2020";
                    }
                    else
                    {
                        $popularityResponse = "Les 2 produit sont autant populaire en 2020";
                    }
                }
                //Autrement vérification pour savoir si le produit 1 est dans un top sur l'année 2020
                elseif (preg_match("/[0-9]+/", $product1_2020))
                {
                    $popularityResponse = "Seul le produit 1 est populaire en 2020";
                }
                //Autrement vérification pour savoir si le produit 2 est dans un top sur l'année 2020
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


    // Fonction permettant de récupérer le meilleur classement d'un produit sur une année. Renvoi le chiffre du classement si dispo.
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
            $result = (int)$result;
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
            $result = (int)$result;
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
            $result = (int)$result;
        }
        else
        {
            $result = "no result";
        }
        return $result;
    }

}