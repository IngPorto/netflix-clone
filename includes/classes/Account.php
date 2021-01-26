<?php
require_once 'Constants.php';

class Account
{
    private $con;
    private $errorArray = [];

    public function __construct($connexion)
    {
        $this->con = $connexion;
    }

    public function register($firstName, $lastName, $username, $email, $confirmEmail, $password, $confirmPassword)
    {
        $this->validateFirstName($firstName);
        $this->validateLastName($lastName);
        $this->validateUsername($username);
        $this->validateEmail($email, $confirmEmail);
        $this->validatePassword($password, $confirmPassword);

        if (count($this->errorArray) == 0) {
            return $this->insertUser($firstName, $lastName, $username, $email, $password);
        }

        return false;
    }

    private function insertUser($firstName, $lastName, $username, $email, $password)
    {
        $password = hash('md5', $password);

        try {
            $query = $this->con->prepare("INSERT INTO users (firstName, lastName, username, email, password) VALUES(:firstName, :lastName, :username, :email, :password)");
            $isSuccess = $query->execute([
                'firstName' => $firstName,
                'lastName' => $lastName,
                'username' => $username,
                'email' => $email,
                'password' => $password,
            ]);
            if (!$isSuccess) {
                $this->errorArray['system'][] = 'Account creation fail';
                return false;
            }else {
                $query = $this->con->prepare("SELECT * FROM users WHERE  username = :username");
                $query->execute([ 'username' => $username ]);
                $newUser = $query->fetch(PDO::FETCH_ASSOC);
                return $newUser;
            }
        } catch (PDOException $e) {
            $this->errorArray['system'][] = 'Account creation fail: ' . $e->getMessage();
            //return false;
            exit('User insert fail: ' . $e->getMessage());
        }
    }

    public function login($username, $password)
    {
        
        if (count($this->errorArray) == 0) {
            $password = hash('md5', $password);
            $query = $this->con->prepare("SELECT * FROM users WHERE username= :username AND password= :password");
            $query->execute(['username' => $username, 'password' => $password]);
            if($query->rowCount() > 0){
                return $query->fetch(PDO::FETCH_ASSOC);
            }
        }
        
        $this->errorArray['system'][] = Constants::$USERNAME_PASSWORD_INVALID;
        return false;
    }

    private function validateFirstName($firstName)
    {
        if (strlen($firstName) < 2 || strlen($firstName) > 25) {
            $this->errorArray['firstName'][] = Constants::$FIRST_NAME_LENGTH_ERROR;
            return;
        }
    }

    private function validateLastName($lastName)
    {
        if (strlen($lastName) < 2 || strlen($lastName) > 25) {
            $this->errorArray['lastName'][] = Constants::$LAST_NAME_LENGTH_ERROR;
            return;
        }
    }

    private function validateUsername($username)
    {
        if (strlen($username) < 2 || strlen($username) > 25) {
            $this->errorArray['username'][] = Constants::$USERNAME_LENGTH_ERROR;
            return;
        }

        $query = $this->con->prepare('SELECT id FROM users WHERE username=:username');
        $query->execute(['username' => $username]);
        if ($query->rowCount() > 0) {
            $this->errorArray['username'][] = Constants::$USERNAME_TAKEN_ERROR;
        }
    }

    private function validateEmail($email, $confirmEmail)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errorArray['email'][] = Constants::$EMAIL_INVALID_ERROR;
            return;
        }
        if ($email !== $confirmEmail) {
            $this->errorArray['email'][] = Constants::$EMAIL_MATCH_ERROR;
            return;
        }
        if (strlen($email) < 2 || strlen($email) > 25) {
            $this->errorArray['email'][] = Constants::$EMAIL_LENGTH_ERROR;
            return;
        }

        $query = $this->con->prepare('SELECT id FROM users WHERE email=:email');
        $query->execute(['email' => $email]);
        if ($query->rowCount() > 0) {
            $this->errorArray['email'][] = Constants::$EMAIL_TAKEN_ERROR;
        }
    }

    private function validatePassword($password, $confirmPassword)
    {
        if ($password !== $confirmPassword) {
            $this->errorArray['password'][] = Constants::$PASSWORD_MATCH_ERROR;
            return;
        }
        if (strlen($password) < 4 || strlen($password) > 25) {
            $this->errorArray['password'][] = Constants::$PASSWORD_LENGTH_ERROR;
            return;
        }
    }

    public function getError(string $fieldName)
    {
        if (isset($this->errorArray[$fieldName])) {
            $errors = $this->errorArray[$fieldName];
            for ($i = 0; $i < count($errors); $i++) {
                echo '<span class="errorLabel">' . $errors[$i] . '</span>';
            }
        }
    }
}
