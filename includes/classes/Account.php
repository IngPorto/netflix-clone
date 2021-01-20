<?php
require_once('Constants.php');

class Account{
    private $con;
    private $errorArray = [];

    public function __construct($connexion){
        $this->con= $connexion;
    }

    public function validateFirstName($firstName){
        if(strlen($firstName) < 2 || strlen($firstName) > 25){
            $this->errorArray['firstName'][] = Constants::$FIRST_NAME_LENGTH_ERROR;
        }
    }

    public function validateLastName($lastName){
        if(strlen($lastName) < 2 || strlen($lastName) > 25){
            $this->errorArray['lastName'][] = Constants::$LAST_NAME_LENGTH_ERROR;
        }
    }

    public function getError(string $error){
        if(isset($this->errorArray[$error])){
            //return $this->errorArray[$error];
            $errors = $this->errorArray[$error];
            for($i = 0; $i < count($errors); $i++){
                echo '<span class="errorLabel">' . $errors[$i] . '</span>';
            }
        }
    }
}