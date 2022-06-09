<?php

class Keyword {
    private $id ; 
    private $MAX_VS ; 
    private $keyword ; 
    private $monthly_search_count ; 
    private $NbKeyword ; 
    private $brand ; 
    private $domain_name ; 

    public function __construct($myId, $myMAX_VS, $myKeyword, $myMonthly_search_count, $myNbKeyword, $myBrand, $myDomain_name) {
        $this->id = $myId ;
        $this->MAX_VS = $myMAX_VS ;
        $this->keyword = $myKeyword ;
        $this->monthly_search_count = $myMonthly_search_count ;
        $this->NbKeyword = $myNbKeyword ;
        $this->brand = $myBrand ;
        $this->domain_name = $myDomain_name ;
    }
}