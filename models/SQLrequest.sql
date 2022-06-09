SELECT newR.id, newR.MAX_VS,
		newK.keyword, newK.monthly_search_count, newK.NbKeyword,
		REGEXP_REPLACE(W.domain_name, "(?:https://www\.)|(?:\.fr)|(?:\.com)", "") as brand, W.domain_name
FROM (
	SELECT K.id, K.keyword, K.monthly_search_count, (LENGTH(K.keyword) - LENGTH(REPLACE(K.keyword, " ", "")) + 1) AS NbKeyword 
    FROM market_ranking.keyword as K
	WHERE K.monthly_search_count >= 100 AND K.keyword LIKE "%creme%" ) as newK
INNER JOIN (
	SELECT R.id, MAX(R.visibility_score) AS MAX_VS, R.keyword_id, R.website_id
	FROM market_ranking.ranked_page AS R
    GROUP BY R.keyword_id, R.website_id
) as newR
ON newK.id = newR.keyword_id
INNER JOIN market_ranking.website AS W 
ON newR.website_id = W.id;