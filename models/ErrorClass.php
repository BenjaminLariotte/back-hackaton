<?php
require_once ROOT . 'core/id_class.php';

class Error {
    private $errorTitle ;
    private $errorMessage ;
    private $other ;

    public function __construct($errorTtl, $errorMsg) {
        this->$errorTitle = $errorTtl ;
        this->$errorMessage = $errorMsg ;
        this->$other = null ;
    }

    public function __construct($errorTtl, $errorMsg, $oth) {
        this->$errorTitle = $errorTtl ;
        this->$errorMessage = $errorMsg ;
        this->$other = $oth ;
    }

    public function getErrorTitle() {
        return this->$errorTitle ;
    }

    public function setErrorTitle($input) {
        this->$errorTitle = $input ;
    }

    public function getErrorMessage() {
        return this->$errorMessage ;
    }

    public function setErrorMessage($input) {
        this->$errorMessage = $input ;
    }

    public function getOther() {
        return this->$other ;
    }

    public function setOther($input) {
        this->$other = $input ;
    }
}