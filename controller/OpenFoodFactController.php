<?php
require_once ROOT . 'core/Controller.php';

class OpenFoodFactController extends Controller
{
    public static function getAllStoreFromFrance() {
        return "https://fr.openfoodfacts.org/stores.json" ;
    }

    public static function createNewRequest($user)
    {
        return "https://fr.openfoodfacts.org/cgi/search.pl?action=process&tagtype_0=categories&tag_contains_0=contains&tag_0=breakfast_cereals&tagtype_1=nutrition_grades&tag_contains_1=contains&tag_1=A&additives=without&ingredients_from_palm_oil=without&json=1"
    }

    public static function getFieldsPart($fields) {
        if (empty($fields)) {
            return "";
        } else if (is_array($fields)) {
            $returnValue = "field=_id";
            foreach($fields as $f) {
                if ($f !== "_id") { 
                    $returnValue .= ",$f";
                }
            }
            return "&$returnValue";
        } else if (is_string($fields)) {
            if ($fields == "all" || $fields = "field=") {
                return "";
            }
            $fields = str_replace(";", ",", $fields);
            if preg_match("_id(?:,.*)?$", $fields) {
                $returnValue = $fields;
            } else {
                $returnValue = "$fields,_id";
            }
            $returnValue = str_replace(" ", "", $returnValue);
            if preg_match("^field=[\w_]+(?:,[\w_]+)*$", $returnValue) {
                return "&$returnValue" ;
            } else if preg_match("^[\w_]+(?:,[\w_]+)*$", $returnValue) {
                return "&field=$returnValue" ;
            } else {
                var_dump("ERROR : OpenFoodFactController::getFieldsPart::fields invalid (\"$fields\")") ;
                return "" ;
            }
        }
    }

    public static function getConstraintsPart($constraints, $separator = null) {
        if (is_string($constraints) && !is_null($separator)) {
            $constraints = explode($separator, $constraints) ;
        }
        
        if (is_array($constraints)) {
            $i = 0
            foreach($constraints as $c) {
                if (preg_match("([\w]",$c)) { 
                    $returnValue .= ",$f";
                }
            }
        }
    }

    public static function getListOfProducts($constraints, $fields, $separator) {
        $constraitsForAPI = $constraints;
        $fieldsForAPI = OpenFoodFactController::getFieldsPart($fields) ;
        return "https://fr.openfoodfacts.org/cgi/search.pl?action=process$constraitsForAPI$fields&json=true"
    }
}

