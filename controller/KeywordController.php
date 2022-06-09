<?php
require_once ROOT . 'dao/KeywordDao.php';
require_once ROOT . 'core/Controller.php';

DEFINE('REQUESTS', file_get_contents(ROOT . "dao/SQLrequest.json"));

/*DEFINE('REQUESTS', {"placeholders":{
        "keyword":"?kwd?"
    },
    "requestWithoutKeyword":"SELECT newR.id, newR.MAX_VS,
            newK.keyword, newK.monthly_search_count, newK.NbKeyword,
            REGEXP_REPLACE(W.domain_name, '(?:https://www\.)|(?:\.fr)|(?:\.com)', '') as brand, W.domain_name
    FROM (
        SELECT K.id, K.keyword, K.monthly_search_count, (LENGTH(K.keyword) - LENGTH(REPLACE(K.keyword, " ", "")) + 1) AS NbKeyword 
        FROM market_ranking.keyword as K
        WHERE K.monthly_search_count >= 100) as newK
    INNER JOIN (
        SELECT R.id, MAX(R.visibility_score) AS MAX_VS, R.keyword_id, R.website_id
        FROM market_ranking.ranked_page AS R
        GROUP BY R.keyword_id, R.website_id
    ) as newR
    ON newK.id = newR.keyword_id
    INNER JOIN market_ranking.website AS W 
    ON newR.website_id = W.id;",
    "requestWithKeyword":"SELECT newR.id, newR.MAX_VS,
            newK.keyword, newK.monthly_search_count, newK.NbKeyword,
            REGEXP_REPLACE(W.domain_name, '(?:https://www\.)|(?:\.fr)|(?:\.com)', '') as brand, W.domain_name
    FROM (
        SELECT K.id, K.keyword, K.monthly_search_count, (LENGTH(K.keyword) - LENGTH(REPLACE(K.keyword, " ", "")) + 1) AS NbKeyword 
        FROM market_ranking.keyword as K
        WHERE K.monthly_search_count >= 100 AND K.keyword LIKE '%?kwd?%' ) as newK
    INNER JOIN (
        SELECT R.id, MAX(R.visibility_score) AS MAX_VS, R.keyword_id, R.website_id
        FROM market_ranking.ranked_page AS R
        GROUP BY R.keyword_id, R.website_id
    ) as newR
    ON newK.id = newR.keyword_id
    INNER JOIN market_ranking.website AS W 
    ON newR.website_id = W.id;"}) ;*/

class KeywordController extends Controller
{
    public $requests ;

    public function __construct() {
        $this->requests = file_get_contents("dao/SQLrequests.json") ;
    }

    /*public static function researchForOneProduct($keywords, $stores, $computedKeywords = []) {
        $result = {} ;
        return {"result" : $result, "computedKeywords" : $computedKeywords} ;
    }*/

    public static function getRequests() {
        return $this->requests ;
    }

    public static function Test1() {
        //$temp = KeywordController::getRequests() ;
        return KeywordDao::testNoKeyword() ;
    }

    public static function Test2() {
        //$temp = KeywordController::getRequests() ;
        return KeywordDao::tesWithKeyword() ;
    }
}