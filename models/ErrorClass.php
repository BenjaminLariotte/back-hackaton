<?php

class ErrorResponse {
    private $errorTitle ;
    private $errorMessage ;
    private $other ;

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
}