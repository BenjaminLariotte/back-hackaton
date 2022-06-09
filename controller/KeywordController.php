<?php
require_once ROOT . 'core/Controller.php';

class KeywordController extends Controller
{
    public static function researchForOneProduct($keywords, $stores, $computedKeywords = []) {
        $result = {} ;
        return {"result" : $result, "computedKeywords" : $computedKeywords} ;
    }
}