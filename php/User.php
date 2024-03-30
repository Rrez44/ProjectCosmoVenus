<?php

class User {
    private $firstName;
    private $lastName;
    private $userName;
    private $email;
    private $dateOfBirth;
    private $password;

    public function __construct($firstName, $lastName, $userName, $email, $dateOfBirth, $password) {
        $this->firstName = $this->sanitizeInput($firstName);
        $this->lastName = $this->sanitizeInput($lastName);
        $this->userName = strtolower($this->sanitizeInput($userName));
        $this->email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $this->dateOfBirth = $this->sanitizeInput($dateOfBirth);
        $this->password = $this->sanitizeInput($password);
        $this->validateInput();

    }

    private function sanitizeInput($input) {
        return trim(htmlspecialchars($input));
    }

    /**
     * @throws Exception
     */
    private function validateInput() {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }
        if (substr($this->email, -4) !== '.edu') {
            throw new Exception ("Non student account");
        }
        $this->calculateAge($this->dateOfBirth);
    }

    /**
     * @throws Exception
     */
    private function calculateAge($dateOfBirth) {
        $birthDate = new DateTime($dateOfBirth);
        $today = new DateTime('now');
        $age = $today->diff($birthDate)->y;
        if($age<13){
            throw new Exception("Age under 13");
        }
        else return $age;
    }
    public static function getUser($username){
       global $conn;

       $stmt = $conn->prepare("SELECT * FROM users where userName = :userName");
       $stmt->bindParam(':userName', $username);
       $stmt->execute();
       $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($userData) {
            return new User($userData['firstName'], $userData['lastName'], $userData['userName'], $userData['email'], $userData['dateOfBirth'], $userData['password']);
        } else {

            return null;
        }
    }

    public static function login($username,$password){
        session_start();
        $logAttempt = User::getUser($username);
        if ($logAttempt == NULL){
            echo "Log in unsuccessful";
        }
        else{

            if (password_verify($password, $logAttempt->getPassword())){
                $_SESSION['user_id'] = $logAttempt->getUserName();
                $_SESSION['logged_in'] = true;
                $_SESSION['first_register']=false;
                header('Location: ../html/profile.php');
            }
            else{
                echo "Failed to log in";
            }
        }
    }



    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getUserName() {
        return $this->userName;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getDateOfBirth() {
        return $this->dateOfBirth;
    }


    public function getPassword() {
        return $this->password;
    }

    /**
     * @throws Exception
     */
    public function save() {

        global $conn;

        $checkUser = $conn->prepare("SELECT * FROM users WHERE userName = :userName");
        $checkUser->bindParam(':userName', $this->userName);
        $checkUser->execute();

        if ($checkUser->rowCount() > 0) {
            throw new Exception("Username already exists.");
        }


        $registration = $conn->prepare("INSERT INTO users (firstName, lastName, userName, email, dateOfBirth,password) VALUES (:firstName, :lastName, :userName, :email, :dateOfBirth,:password)");

        $registration->bindParam(':firstName', $this->firstName);
        $registration->bindParam(':lastName', $this->lastName);
        $registration->bindParam(':userName', $this->userName);
        $registration->bindParam(':email', $this->email);
        $registration->bindParam(':dateOfBirth', $this->dateOfBirth);
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        $registration->bindParam(':password', $hashedPassword);
        $this->createImagePath();
        return $registration->execute();
    }
    private function createImagePath() :void {

        mkdir("../images/$this->userName", 0755);
        mkdir("../images/$this->userName/postImages", 0755);
        mkdir("../images/$this->userName/profileImages", 0755);
    }
    public function loadPostPath() :string{
        return "../images/$this->userName/postImages";
    }

}


?>