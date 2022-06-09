<?php

class Keyword {
    public $id ; 
    public $MAX_VS ; 
    public $keyword ; 
    public $monthly_search_count ; 
    public $NbKeyword ; 
    public $brand ; 
    public $domain_name ; 

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