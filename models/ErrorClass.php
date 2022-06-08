<?php

define("ALLOWED_TYPES", ["error", "warning"]);

class ErrorResponse {
    private $errorTitle ;
    private $errorMessage ;
    private $errorType ;
    private $other ;

    public function checkValues() {
        if in_array(strtolower($this->$errorType), ALLOWED_TYPES) {
            var_dump("WIP") ;
        }
    }

    public function __construct($errorTtl, $errorMsg, $oth = null) {
        $this->errorTitle = $errorTtl ;
        $this->errorMessage = $errorMsg ;
        $this->other = $oth ;
    }

    public function getErrorTitle() {
        return $this->errorTitle ;
    }

    public function setErrorTitle($input) {
        $this->errorTitle = $input ;
    }

    public function getErrorMessage() {
        return $this->errorMessage ;
    }

    public function setErrorMessage($input) {
        $this->errorMessage = $input ;
    }

    public function getOther() {
        return $this->other ;
    }

    public function setOther($input) {
        $this->other = $input ;
    }

    public function getOther() {
        return $this->other ;
    }

    public function setOther($input) {
        $this->other = $input ;
    }
}