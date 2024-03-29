<?php
    include_once "./userProfileInfo.php";
    include_once "./userDisplayDB.php";


    $db = new mysqli("localhost","root","1234","cosmo");
    session_start();
    $hobbies1 = isset($_POST["check-substitution-1"]) ? $_POST["check-substitution-1"] : null;
    $hobbies2 = isset($_POST["check-substitution-2"]) ? $_POST["check-substitution-2"] : null;
    $hobbies3 = isset($_POST["check-substitution-3"]) ? $_POST["check-substitution-3"] : null;
    $hobbies4 = isset($_POST["check-substitution-4"]) ? $_POST["check-substitution-4"] : null;

    $userRegistered = $_SESSION["user_id"];

    $allHobbies1=[$hobbies1,$hobbies2,$hobbies4];
    $allHobbies =array_filter($allHobbies1,function($value){
        return $value !=null;
    });
    $allHobbies = array_values($allHobbies);

    
   
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
    public function saveUsers($db){

    
$userCount = 0; 
$sqlCount = "SELECT COUNT(*) AS userCount FROM usersDisplayInfo WHERE username = ?";
$statement = $db->prepare($sqlCount);
$statement->bind_param('s', $this->usernamee);
$statement->execute();
$statement->bind_result($userCount);
$statement->fetch();
$statement->close();

        if($userCount ==0){
            $sql  = "insert into usersDisplayInfo (username,profileName,faculty,aboutMe,profpicture) VALUES (?,?,?,?,?)";
            $stmt = $db->prepare($sql);
            mysqli_stmt_bind_param($stmt,'sssss',$this->usernamee,$this->profileName,$this->faculty,$this->aboutMe,$this->profpicture);
            $stmt->execute();
           
        }else{
            $sql  = "update usersDisplayInfo set profileName=?,faculty=?,aboutMe =?,profpicture=? where username ='$this->usernamee'";
            $stmt = $db->prepare($sql);
            mysqli_stmt_bind_param($stmt,'ssss',$this->profileName,$this->faculty,$this->aboutMe,$this->profpicture);
            $stmt->execute();
        
        }
    }
    public function saveHobbies($pdo){
        
        
        $sql = "SELECT hoby_name FROM hobbies WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bind_param('s', $this->usernamee);
        $stmt->execute();
        $result = $stmt->get_result();
        $existingHobbies = array();
        while ($row = $result->fetch_assoc()) {
            $existingHobbies[] = $row['hoby_name'];
        }
    
        if (!is_array($this->hobbies)) {
            return "No hobbies submitted";
        }        
        $sqlDelete = "DELETE FROM hobbies WHERE username = ? AND hoby_name = ?";
        $stmtDelete = $pdo->prepare($sqlDelete);
    
        foreach ($existingHobbies as $existingHobby) {
            if (!in_array($existingHobby, $this->hobbies)) {
                $stmtDelete->bind_param('ss', $this->usernamee, $existingHobby);
                $stmtDelete->execute();
            }
        }
        $sql = "INSERT INTO hobbies (username, hoby_name) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        foreach ($this->hobbies as $hobby) {
            if (in_array($hobby, $existingHobbies)) {
                continue;
            }
            $stmt->bind_param('ss', $this->usernamee, $hobby);
            $stmt->execute();
        
        }
    }
}
    $userProfileInfo = new userProfileInfo($userRegistered,$profileName,$faculty,$aboutme,$targetPath,$allHobbies);
 
        $userProfileInfo->saveUsers($db);
        $userProfileInfo->saveHobbies($db);
    header("Location: ../html/profile.php");
?>