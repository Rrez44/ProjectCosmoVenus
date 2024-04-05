<?php

class UserProfileInfo
{
    private string $username;
    private string $profileName;
    private string $faculty;
    private string $aboutMe;
    private string $profilePicture;
    private array $hobbies;
    private string $bannerPicture;

    public function __construct(string $username, string $profileName, string $faculty, string $aboutMe, string $profilePicture, array $hobbies, string $bannerPicture)
    {
        $this->username = $username;
        $this->profileName = $profileName;
        $this->faculty = $faculty;
        $this->aboutMe = $aboutMe;
        $this->profilePicture = $profilePicture;
        $this->hobbies = $hobbies;
        $this->bannerPicture=$bannerPicture;
    }

    public function saveUsers(PDO $db): void
    {
        $sqlCount = "SELECT COUNT(*) FROM usersDisplayInfo WHERE username = :username";
        $statement = $db->prepare($sqlCount);
        $statement->execute([':username' => $this->username]);
        $userCount = (int) $statement->fetchColumn();

        if ($userCount === 0) {
            $sql = "INSERT INTO usersDisplayInfo (username, profileName, faculty, aboutMe, profilePicture,bannerPicture) VALUES (:username, :profileName, :faculty, :aboutMe, :profilePicture,:bannerPicture)";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':username' => $this->username,
                ':profileName' => $this->profileName,
                ':faculty' => $this->faculty,
                ':aboutMe' => $this->aboutMe,
                ':profilePicture' => $this->profilePicture,
                ':bannerPicture' =>$this->bannerPicture
            ]);
        } else {
            $sql = "UPDATE usersDisplayInfo SET profileName = :profileName, faculty = :faculty, aboutMe = :aboutMe, profilePicture = :profilePicture, bannerPicture=:bannerPicture WHERE username = :username";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':username' => $this->username,
                ':profileName' => $this->profileName,
                ':faculty' => $this->faculty,
                ':aboutMe' => $this->aboutMe,
                ':profilePicture' => $this->profilePicture,
                ':bannerPicture' => $this->bannerPicture
            ]);
        }
    }

    public function saveHobbies(PDO $pdo): void
    {
        $sql = "SELECT hobbyName FROM hobbies WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':username' => $this->username]);
        $existingHobbies = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Delete non-existing hobbies
        $sqlDelete = "DELETE FROM hobbies WHERE username = :username AND hobbyName = :hobbyName";
        $stmtDelete = $pdo->prepare($sqlDelete);

        foreach ($existingHobbies as $existingHobby) {
            if (!in_array($existingHobby, $this->hobbies)) {
                $stmtDelete->execute([':username' => $this->username, ':hobbyName' => $existingHobby]);
            }
        }

        // Insert new hobbies
        $sqlInsert = "INSERT INTO hobbies (username, hobbyName) VALUES (:username, :hobbyName)";
        $stmtInsert = $pdo->prepare($sqlInsert);

        foreach ($this->hobbies as $hobby) {
            if (!in_array($hobby, $existingHobbies)) {
                $stmtInsert->execute([':username' => $this->username, ':hobbyName' => $hobby]);
            }
        }
    }
}

