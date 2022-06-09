<?php
require_once ROOT . "models/KeywordClass.php";
require_once ROOT . "controller/KeywordController.php";
require_once ROOT . "core/keyword_database_connection.php";
require_once ROOT . "models/ErrorClass.php";


class KeywordDao
{
    public static function makeRequest($request, $placeholders = [], $values = []) {
        $actualRequest = $request ;
        for($i = 0; $i < min(count($placeholders), count($values)); $i++) {
            str_replace($placeholders[$i], $values[$i], $actualRequest) ;
        }
        $responseArray = KwdDataBase::databaseRequest($actualRequest) ;
        $keywordsArray = [] ;
        foreach ($responseArray as $piece) {
            $keywordObject = new Keyword($piece["id"], $piece["MAX_VS"], $piece["keyword"], $piece["monthly_search_count"], $piece["NbKeyword"], $piece["brand"], $piece["domain_name"])  ;
            $keywordsArray[] = $keywordObject ;
        }
        return $keywordsArray;
    }

    public static function getAllKeywords() {
        $keywordsArray = KeywordDao::makeRequest("SELECT newR.id, newR.MAX_VS,
                    newK.keyword, newK.monthly_search_count, newK.NbKeyword,
                    REGEXP_REPLACE(W.domain_name, '(?:https://www\.)|(?:\.fr)|(?:\.com)', '') as brand, W.domain_name
            FROM (
                SELECT K.id, K.keyword, K.monthly_search_count, (LENGTH(K.keyword) - LENGTH(REPLACE(K.keyword, ' ', '')) + 1) AS NbKeyword 
                FROM market_ranking.keyword as K
                WHERE K.monthly_search_count >= 100) as newK
            INNER JOIN (
                SELECT R.id, MAX(R.visibility_score) AS MAX_VS, R.keyword_id, R.website_id
                FROM market_ranking.ranked_page AS R
                GROUP BY R.keyword_id, R.website_id
            ) as newR
            ON newK.id = newR.keyword_id
            INNER JOIN market_ranking.website AS W 
            ON newR.website_id = W.id;") ;

        return $keywordsArray ;
    }

    public static function compareStoreForOneProduct($keywords = [], $stores = []) {
        $keywordsArray = KeywordDao::getAllKeywords() ;
        foreach($keywordsArray as $piece) {
            $applicable = [] ;
            foreach($keywords as $k) {
                if (str_contains(strtolower($piece->keyword), strtolower($k))) {
                    if (!empty($stores)) {
                        foreach ($stores as $s) {
                            if (str_contains(strtolower($s), strtolower($piece->$store))) {
                                $applicable[] = $piece ;
                                break ;
                            }
                        }
                    } else {
                        $applicable[] = $piece ;
                    }
                }
            }
        }
        $result = [] ;
        foreach ($stores as $s) {
            $result[$s] = 0 ;
        }
        foreach ($applicable as $a) {
            set($result[$s], $result[$s] + ($a->monthly_search_count * $a->MAX_VS)) ;
        }
    }

    public static function testNoKeyword () {
        $startTime = time() ;
        for ($i = 0; $i < 3; $i++) {
            var_dump("Executing Request #$i");
            KeywordDao::getAllKeywords() ;
        }        
        $requestTime = time() - $startTime ;
        echo "Result = $requestTime s" ;

    }

    public static function testWithKeyword () {
        $startTime = time() ;
        $keywords = ["yaourt", "creme", "dessert", "cafe", "the"] ;
        for ($i = 0; $i < 3; $i++) {
            var_dump("Executing Request #$i") ;
            KeywordDao::makeRequest("SELECT newR.id, newR.MAX_VS,
            newK.keyword, newK.monthly_search_count, newK.NbKeyword,
            REGEXP_REPLACE(W.domain_name, '(?:https://www\.)|(?:\.fr)|(?:\.com)', '') as brand, W.domain_name
    FROM (
        SELECT K.id, K.keyword, K.monthly_search_count, (LENGTH(K.keyword) - LENGTH(REPLACE(K.keyword, ' ', '')) + 1) AS NbKeyword 
        FROM market_ranking.keyword as K
        WHERE K.monthly_search_count >= 100 AND K.keyword LIKE '%?kwd?%' ) as newK
    INNER JOIN (
        SELECT R.id, MAX(R.visibility_score) AS MAX_VS, R.keyword_id, R.website_id
        FROM market_ranking.ranked_page AS R
        GROUP BY R.keyword_id, R.website_id
    ) as newR
    ON newK.id = newR.keyword_id
    INNER JOIN market_ranking.website AS W 
    ON newR.website_id = W.id;", "?kwd?", $keywords[i]) ;
        }
        $requestTime = time() - $startTime ;
        echo "Result = $requestTime s" ;
    }

}