<?php
class userProfileInfo{
    private $usernamee;
    private $profileName;
    private $faculty;
    private $aboutMe;
    private $profilePicture;
    private $hobbies;
    private $bannerPicture;
    public function __construct($usernamee,$profileName,$faculty,$aboutMe,$profilePicture,$hobbies,$bannerPicture){
        $this->usernamee = $usernamee;
        $this->profileName  =$profileName;
        $this->faculty =$faculty;
        $this->aboutMe = $aboutMe;
        $this->profilePicture = $profilePicture;
        $this->hobbies =$hobbies;
        $this->bannerPicture=$bannerPicture;
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
            $sql  = "insert into usersDisplayInfo (username,profileName,faculty,aboutMe,profilePicture,bannerPicture) VALUES (?,?,?,?,?,?)";
            $stmt = $db->prepare($sql);
            mysqli_stmt_bind_param($stmt,'ssssss',$this->usernamee,$this->profileName,$this->faculty,$this->aboutMe,$this->profilePicture,$this->bannerPicture);
            $stmt->execute();
        }else{
            $sql  = "update usersDisplayInfo set profileName=?,faculty=?,aboutMe =?,profilePicture=?,bannerPicture=? where username ='$this->usernamee'";
            $stmt = $db->prepare($sql);
            mysqli_stmt_bind_param($stmt,'sssss',$this->profileName,$this->faculty,$this->aboutMe,$this->profilePicture,$this->bannerPicture);
            $stmt->execute();
        
        }
    }



    public function saveHobbies($pdo){
        
        
        $sql = "SELECT hobbyName FROM hobbies WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bind_param('s', $this->usernamee);
        $stmt->execute();
        $result = $stmt->get_result();
        $existingHobbies = array();
        while ($row = $result->fetch_assoc()) {
            $existingHobbies[] = $row['hobbyName'];
        }
    
        if (!is_array($this->hobbies)) {
            return "No hobbies submitted";
        }        
        $sqlDelete = "DELETE FROM hobbies WHERE username = ? AND hobbyName = ?";
        $stmtDelete = $pdo->prepare($sqlDelete);
    
        foreach ($existingHobbies as $existingHobby) {
            if (!in_array($existingHobby, $this->hobbies)) {
                $stmtDelete->bind_param('ss', $this->usernamee, $existingHobby);
                $stmtDelete->execute();
            }
        }
        $sql = "INSERT INTO hobbies (username, hobbyName) VALUES (?, ?)";
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


?>