<?php

require_once "FailedToLoginException.php";
require_once "AutomaticEmail.php";
require_once "Log/RegisterLog.php";
require_once "Log/LoginLog.php";
//use Random\RandomException;

class User
{

    protected $complexity;
    protected $firstName;
    protected $lastName;
    protected $userName;
    protected $email;
    protected $dateOfBirth;
    protected $password;

    /**
     * @throws Exception
     */
    public function __construct($firstName, $lastName, $userName, $email, $dateOfBirth, $password, $complexity = true)
    {
        $this->firstName = $this->sanitizeInput($firstName);
        $this->lastName = $this->sanitizeInput($lastName);
        $this->userName = strtolower($this->sanitizeInput($userName));
        $this->email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $this->dateOfBirth = $this->sanitizeInput($dateOfBirth);
        $this->password = $this->sanitizeInput($password);
        $this->complexity = $complexity;
        if ($complexity) {
            $this->validateInput();
        }
    }

    private function sanitizeInput($input)
    {
        return trim(htmlspecialchars($input));
    }

    /**
     * @throws Exception
     */
    private function validateInput()
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }
        if (substr($this->email, -4) !== '.edu') {
            throw new Exception ("Non student account");
        }
        $regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
        if ( !preg_match($regex, $this->password)) {
            throw  new Exception("Password Should Contain lowercase letters,uppercase letters, numbers and symbols");
        }

        if(!preg_match('/^\S+@\S+\.\S+$/', $this->email)){
            throw new ("Email not Valid");
        }

        if(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->dateOfBirth)){
            throw  new Exception("Date of Birth not Valid");
        }

        $this->calculateAge($this->dateOfBirth);
    }


    /**
     * @throws Exception
     */
    private function calculateAge($dateOfBirth)
    {
        $birthDate = new DateTime($dateOfBirth);
        $today = new DateTime('now');
        $age = $today->diff($birthDate)->y;
        if ($age < 13) {
            throw new Exception("Age under 13");
        } else return $age;
    }

    /**
     * @throws Exception
     */
    public function saveToken($username)
    {
        $token= &self::getGlobalReference();
        $token = bin2hex(random_bytes(32));
        $db = DbConn::instanceOfDb();
        $conn = $db->getConnection();
        $stmt = $conn->prepare("UPDATE users SET rememberMeToken = ? WHERE userName = ?");
        echo "save:".self::getGlobalReference();
        $stmt->execute([self::getGlobalReference(), $username]);
    }

    public static function getUser($username)
    {
        $db = DbConn::instanceOfDb();
        $conn = $db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM users where userName = :userName");
        $stmt->bindParam(':userName', $username);
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($userData) {
            return new User($userData['firstName'], $userData['lastName'], $userData['userName'], $userData['email'], $userData['dateOfBirth'], $userData['password'], false);
        } else {

            return null;
        }
    }

    public static function &getGlobalReference() {
        global $token;
        return $token;
    }

    public static function setCookie($logAttempt, $username, $logedOrRegister)
    {
        $token =&self::getGlobalReference();
        $expire = time() + 100000;
        if ($logedOrRegister) {
            $logAttempt->saveToken($username);
        }
            setcookie("rememberMeToken", $token, $expire, "/");
    }

    public static function login($username, $password)
    {
        session_start();
        $logAttempt = User::getUser($username);
        if ($logAttempt == NULL) {
           try {
                throw new FailedToLogin("Fjalëkalimi ose Username i Gabuar");
            } catch (FailedToLogin $e) {
                $msg = $e->getMessage();
                echo "<script>alert('$msg');</script>";
                echo "<script>window.location.href = '../views/Login_Register/loginForm.php';</script>";

            }
        } else {

            if (password_verify($password, $logAttempt->getPassword())) {
                $_SESSION['user_id'] = $logAttempt->getUserName();
                $_SESSION['logged_in'] = true;
                self::setCookie($logAttempt, $username, true);
                $date = date('Y/m/d H:i:s');
                writeToLoginFile($logAttempt->userName,$logAttempt->email,$date);
                header('Location: /cosmovenus/views/profile.php');
            } else {
                try {
                    throw new FailedToLogin("Fjalëkalimi ose Username i Gabuar");
                } catch (FailedToLogin $e) {
                    $msg = $e->getMessage();
                    echo "<script>alert('$msg');</script>";
                    echo "<script>window.location.href = '../views/Login_Register/loginForm.php';</script>";

                }
            }

        }
    }


    // Getters
    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }


    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @throws Exception
     */
    public function save()
    {

        $db = DbConn::instanceOfDb();
        $conn = $db->getConnection();
        $checkUser = $conn->prepare("SELECT * FROM users WHERE userName = :userName");
        $checkUser->bindParam(':userName', $this->userName);
        $checkUser->execute();
        if ($checkUser->rowCount() > 0) {
            throw new Exception("Username already exists.");
        }

        $registration = $conn->prepare("INSERT INTO users (firstName, lastName, userName, email, dateOfBirth,password) VALUES (:firstName, :lastName, :userName, :email, :dateOfBirth,:password)");

        $date = date('Y/m/d H:i:s');
        writeToRegisterFile($this->userName,$this->email,$date);
        sendMail($this->email);


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

    private function createImagePath(): void
    {
        mkdir("../images/$this->userName", 0755);
        mkdir("../images/$this->userName/postImages", 0755);
        mkdir("../images/$this->userName/profileImages", 0755);
        mkdir("../images/$this->userName/coverPhoto", 0755);
    }

    public function loadPostPath(): string
    {
        return "../images/$this->userName/postImages";
    }

}


?>