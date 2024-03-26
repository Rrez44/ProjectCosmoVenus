<?php

    $db = new mysqli("localhost","root","1234","cosmo");
    session_start();
    $hobbies1 = isset($_POST["check-substitution-1"]) ? $_POST["check-substitution-1"] : null;
    $hobbies2 = isset($_POST["check-substitution-2"]) ? $_POST["check-substitution-2"] : null;
    $hobbies3 = isset($_POST["check-substitution-3"]) ? $_POST["check-substitution-3"] : null;
    $hobbies4 = isset($_POST["check-substitution-4"]) ? $_POST["check-substitution-4"] : null;

    
    $allHobbies1=[$hobbies1,$hobbies2,$hobbies4];
    $allHobbies =array_filter($allHobbies1,function($value){
        return $value !=null;
    });
    $allHobbies = array_values($allHobbies);

    
    $userRegistered = $_SESSION["user_id"];
    $profileName = $_POST["username"];
    $faculty = $_POST['faculty'];
    $aboutme =$_POST['aboutme'];

    $targetDirectory = "../images/profilePics/"; 
    if(isset($_FILES["inputfile"])) {
    $targetFile = basename($_FILES["inputfile"]["name"]);
        echo "Target file:$targetFile";
    }else{
        echo "Field not set";
    }   

    $targetPath = $targetDirectory .$targetFile;
    echo "TargetPath $targetPath";
    

    move_uploaded_file($_FILES["inputfile"]["tmp_name"], $targetPath);

    class userProfileInfo{
        private $usernamee;
        private $profileName;
        private $faculty;
        private $aboutMe;
        private $profpicture;
        private $hobbies;
        public function __construct($usernamee,$profileName,$faculty,$aboutMe,$profpicture,$hobbies){
            $this->usernamee = $usernamee;
            $this->profileName  =$profileName;
            $this->faculty =$faculty;
            $this->aboutMe = $aboutMe;
            $this->profpicture = $profpicture;
            $this->hobbies =$hobbies;
        }
        public function saveUsers($pdo){
            $sql  = "insert into usersDisplayInfo (username,profileName,faculty,aboutMe,profpicture) VALUES (?,?,?,?,?)";
            $stmt = $pdo->prepare($sql);
            mysqli_stmt_bind_param($stmt,'sssss',$this->usernamee,$this->profileName,$this->faculty,$this->aboutMe,$this->profpicture);
            $stmt->execute();
        }

        public function saveHobbies($pdo){
        
            $sql = "insert into hobbies(username,hoby_name) values (?, ?)";
            $stmt = $pdo->prepare($sql);
            if (!is_array($this->hobbies)) {
                return "ERROR"; 
            }
    
            var_dump($this->hobbies);
            for ($i = 0; $i < count($this->hobbies); $i++) {
            $hobby = $this->hobbies[$i];
            mysqli_stmt_bind_param($stmt, 'ss', $this->usernamee, $hobby);
            $stmt->execute();
        }
        }
        public function editProfile(){
        }
    }
    $userProfileInfo = new userProfileInfo($userRegistered,$profileName,$faculty,$aboutme,$targetPath,$allHobbies);
    $userProfileInfo->saveUsers($db);    
    $userProfileInfo->saveHobbies($db);

    header("Location: ../html/profile.php");
?>