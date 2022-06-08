<?php
require_once ROOT . 'core/Controller.php';

class OpenFoodFactController extends Controller
{
    public static function makeRequest($req) {
        $result = file_get_contents($req) ;

        return $result ;
    }
  
    public static function getAllStoreFromFrance() {
        return "https://fr.openfoodfacts.org/stores.json" ;
    }

    public static function createNewRequest($user)
    {
        return "https://fr.openfoodfacts.org/cgi/search.pl?action=process&tagtype_0=categories&tag_contains_0=contains&tag_0=breakfast_cereals&tagtype_1=nutrition_grades&tag_contains_1=contains&tag_1=A&additives=without&ingredients_from_palm_oil=without&json=1" ;
    }

    public static function getFieldsPart($fields) {
        if (empty($fields)) {
            return "";
        } else if (is_array($fields)) {
            $returnValue = "fields=_id";
            foreach($fields as $f) {
                if ($f !== "_id") { 
                    $returnValue .= ",$f";
                }
            }
            return "&$returnValue";
        } else if (is_string($fields)) {
            if ($fields == "all" || $fields = "fields=") {
                return "";
            }
            $fields = str_replace(";", ",", $fields);
            if (preg_match("/_id(?:,.*)?$/", $fields)) {
                $returnValue = $fields;
            } else {
                $returnValue = "$fields,_id";
            }
            $returnValue = str_replace(" ", "", $returnValue);
            if (preg_match("/^fields=[\w_]+(?:,[\w_]+)*$/", $returnValue)) {
                return "&$returnValue" ;
            } else if (preg_match("/^[\w_]+(?:,[\w_]+)*$/", $returnValue)) {
                return "&fields=$returnValue" ;
            } else {
                var_dump("ERROR : OpenFoodFactController::getFieldsPart::fields invalid (\"$fields\")") ;
                return "" ;
            }
        }
    }

    public static function getOneConstraintPart($constraint, $tagIndex, $nutrIndex) {
        if (!preg_match("/([\w_]*)([<>=!]+)(\[?[\w_\,\;]+\]?)/", $constraint, $matches)) {
            var_dump("ERROR : OpenFoodFactController::getOneConstraintPart::constraint invalid (\"$constraint\")") ;
            return "" ;
        }
        #Ex: "A <= B" -> matches[1] = "A", matches[2] = "<=", matches[3] = "B"
        switch ($matches[2]) {
            case "=" :
                if ($matches[1] == "search") {
                    return "search_terms=$matches[3]" ;
                } else {
                    return "tagtype_$tagIndex=$matches[1]&tag_contains_$tagIndex=contains&tag_$tagIndex=$matches[3]";
                } 
                break;
            case "!=" :
                return "tagtype_$tagIndex=$matches[1]&tag_contains_$tagIndex=does_not_contain&tag_$tagIndex=$matches[3]";
                break;
            case "<>" :
                if (!preg_match("/\[?([\w_]*(?:[,\|\&][\w_]*)*)\]?/", str_replace(";", ",", $matches[3]), $values)) {
                    var_dump("ERROR : OpenFoodFactController::getOneConstraintPart::constraint invalid for an \"in\" operator (\"$constraint\")") ;
                    return "" ;
                }
                $values = str_replace("&", ",", $values[1]) ;
                switch ($matches[1]) {
                    case "tags" :
                        $resultValue = "labels_tags=$values" ;
                        break ;
                    default : 
                        var_dump("ERROR : OpenFoodFactController::getOneConstraintPart::constraint not yet implemented (\"$constraint\")") ;
                        $resultValue = "" ;
                        break ;
                    }
                return $resultValue;
                break;
            case "><" :
                if (!preg_match("/\[?([\w_]*(?:[,\&][\w_]*)*)\]?/", str_replace(";", ",", $matches[3]), $values)) {
                    var_dump("ERROR : OpenFoodFactController::getOneConstraintPart::constraint invalid for an \"not_in\" operator (\"$constraint\")") ;
                    return "" ;
                }
                $values = str_replace("&", ",", $values[1]) ;
                $values = str_replace(",", ",-", $values) ;
                switch ($matches[1]) {
                    case "tags" :
                        $resultValue = "labels_tags=-$values" ;
                        break ;
                    case "ingredients" : 
                        if (!preg_match("/\[?([\w_]*(?:[,\|\&][\w_]*)*)\]?/", str_replace(";", ",", $matches[3]), $values)) {
                            if (!preg_match("/[\w_]/", str_replace(";", ",", $matches[3]), $values)) { 
                                var_dump("ERROR : OpenFoodFactController::getOneConstraintPart::constraint invalid for an \"not_in\" operator (\"$constraint\")") ;
                                return "" ;
                            } else {
                                $values = [$values[1]] ;
                            }
                        } else {
                            $values = explode(",", str_replace(["|", "&"], ",", $values[1])) ;
                        }
                        $resultValue = "";
                        foreach ($values as $v) {
                            if (in_array($v, ["additives", "ingredients_from_palm_oil", "ingredients_that_may_be_from_palm_oil", "ingredients_from_or_that_may_be_from_palm_oil"])) {
                                $resultValue .= "&$v=without" ;
                            } else {
                                var_dump("ERROR : OpenFoodFactController::getOneConstraintPart::constraint contains an invalid ingredients (\"$constraint\")") ;
                            }
                        }
                        break ;
                    default : 
                        var_dump("ERROR : OpenFoodFactController::getOneConstraintPart::constraint not yet implemented (\"$constraint\")") ;
                        $resultValue = "" ;
                        break ;
                    }
                return $resultValue;
                break;
            /*Nutriments*/
            case "<=" :
                $operator = "lte" ;
            case "<" :
                $operator = "lt" ;
            case ">=" :
                $operator = "gte" ;
            case ">" :
                $operator = "gt" ;
            case "=" :
                $operator = "eq" ;
            default :
                if (isset($operator)) {
                    return "nutriment_$nutrIndex=$matches[1]&nutriment_compare_$nutrIndex=$operator&nutriment_value_$nutrIndex=$matches[3]" ;
                } else {
                    var_dump("ERROR : OpenFoodFactController::getOneConstraintPart::constraint not yet implemented (\"$constraint\")") ;
                    return "" ;
                }
                break;
        }
    } 

    public static function getConstraintsPart($constraints, $separator = null) {
        
        if (is_string($constraints)){
            if (!is_null($separator)) {
                $constraints = explode($separator, $constraints) ;
            }
            if (!is_array($constraints)) {
                $constraints = [$constraints] ;
            }
        }
        
        if (is_array($constraints)) {
            $tagIndex = 0 ;
            $nutrIndex = 0 ;

            $resultValue = "" ;
            foreach($constraints as $c) {
                $resultForOne = OpenFoodFactController::getOneConstraintPart($c, $tagIndex, $nutrIndex) ;
                if (!empty($resultForOne)) {
                    $resultValue .= "&$resultForOne" ;
                    if (substr_count($resultForOne, "tagtype_$tagIndex") > 0) {
                        $tagIndex += substr_count($resultForOne, "tagtype_$tagIndex") ;
                    } else if (substr_count($resultForOne, "nutriment_$nutrIndex") > 0) {
                        $nutrIndex += substr_count($resultForOne, "nutriment_$nutrIndex") ;
                    } 
                }
            }

            return $resultValue ;
        }
    }

    public static function getListOfProductsURL($resultPerPage, $pageNb, $constraints, $fields, $separator = null) {
        $constraintsForAPI = ltrim(str_replace("&&", "&", OpenFoodFactController::getConstraintsPart($constraints, $separator)), "&") ;
        $fieldsForAPI = OpenFoodFactController::getFieldsPart($fields) ;
        return "https://fr.openfoodfacts.org/cgi/search.pl?$constraintsForAPI&$$fieldsForAPI&json=true&page_size=$resultPerPage&page=$pageNb" ;
    }

    public static function getListOfProducts($resultPerPage, $pageNb, $constraints, $fields, $separator = null) {
        $url = OpenFoodFactController::getListOfProductsURL($resultPerPage, $pageNb, $constraints, $fields, $separator) ;
        //var_dump($url) ;
        return OpenFoodFactController::makeRequest($url) ;
    }

    public static function getProductDetailByBarcode($barcode, $fields = "") {
        $url = OpenFoodFactController::getListOfProductsURL($resultPerPage, $pageNb, $constraints, $fields, $separator) ;
        return OpenFoodFactController::makeRequest($url) ;
    }
}