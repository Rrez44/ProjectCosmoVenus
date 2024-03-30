<?php
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


?>