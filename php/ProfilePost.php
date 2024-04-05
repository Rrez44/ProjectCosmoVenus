<?php

require_once 'dbconfig.php';
require_once '../php/User.php';

class ProfilePost implements JsonSerializable
{
    private $postId;
    private User $poster;
    private $imagePath;
    private $description;
    private int $likes;
    private DateTime $timeOfPost;


    /**
     * @param $postId ;
     * @param $poster
     * @param $imagePath
     * @param $description
     * @param $likes
     * @param $timeOfPost ;
     */
    public function __construct($poster, $description, $imagePath = null ,$postId = null, $timeOfPost = null, $likes = 0)
    {
        $this->poster = $poster;
        if ($imagePath == null){
            $this->imagePath = $this->generatePath();
        }
        else{
            $this->imagePath = $imagePath;
        }
        if ($likes == 0){
            $this->likes = 0;
        }
        else{
            $this->likes = $likes;
        }

        $this->description = $description;
        $this->timeOfPost = $timeOfPost ? new DateTime($timeOfPost) : new DateTime();
        if ($postId == null){
            $this->postId = $this->generatePostId();
        }
        else{
            $this->postId = $postId;
        }
    }


    /**
     * @return mixed
     */
    public function getPoster(): User
    {
        return $this->poster;
    }

    public function getTimeOfPost()
    {
        return $this->timeOfPost->format('Y-m-d');
    }

    /**
     * @return mixed
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    public function setImagePath(mixed $imagePath): void
    {
        $this->imagePath = $imagePath;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getLikes()
    {
        return $this->likes;
    }

    private function generatePostId(): string
    {
        $id = $this->poster->getUserName() . $this->timeOfPost->format('YmdHisu') . random_int(1, 69);
        return trim($id);
    }

    /**
     * @throws Exception
     */
    public function save()
    {
//        global $conn;
        $db = DbConn::instanceOfDb();
        $conn=$db->getConnection();

        $checkExisting = $conn->prepare("SELECT * from userPosts where postId = :postId");
        $checkExisting->bindParam(':postId', $this->postId);
        $checkExisting->execute();

        if ($checkExisting->rowCount() > 0) {
            throw new Exception("Post already in database");
        } else {
            $post = $conn->prepare("INSERT INTO userPosts (postId, poster, imagePath, description, likes, timeOfPost) VALUES (:postId, :poster, :imagePath, :description, :likes,:timeOfPost)");

            $post->bindParam(':postId', $this->postId);
            $userName = $this->poster->getUserName();
            $post->bindParam(':poster', $userName);
            $post->bindParam(':imagePath', $this->imagePath);
            $post->bindParam(':description', $this->description);
            $post->bindParam(':likes', $this->likes);
            $timeOfPostFormatted = $this->timeOfPost->format('Y-m-d H:i:s');
            $post->bindParam(':timeOfPost', $timeOfPostFormatted);

            return $post->execute();
        }
    }

    public static function loadPost($postId): ?ProfilePost
    {
        try {
//            global $conn;
            $db = DbConn::instanceOfDb();

            $conn=$db->getConnection();
            $post = $conn->prepare("SELECT * FROM userposts WHERE postId = :postId");
            $post->bindParam(":postId", $postId);
            $post->execute();
            $profileData = $post->fetch(PDO::FETCH_ASSOC);
            if ($profileData) {
                return new ProfilePost(User::getUser($profileData['poster']), $profileData['description'], $profileData['imagePath'],$profileData['postId'], $profileData['timeOfPost'], $profileData['likes']);
            } else {

                return null;
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return null;
    }

    private function generatePath() :string{
        return $this->poster->loadPostPath() . "/" .$this->postId;
    }
    public static function isLiked($liker, $postId) :bool
    {
        global $conn;
        $checkLiked = $conn->prepare("SELECT * FROM postlikes WHERE liker = :liker and postId = :postId");
        $checkLiked->bindParam(":liker", $liker);
        $checkLiked->bindParam(":postId", $postId);
        $checkLiked->execute();
        if ($checkLiked->rowCount() > 0){
            return true;
        }
        return false;

    }
    public function jsonSerialize() {
        return [
            'postId' => $this->postId,
            'poster' => $this->poster->getUserName(),
            'imagePath' => $this->imagePath,
            'description' => $this->description,
            'likes' => $this->likes,
            'timeOfPost' => $this->getTimeOfPost(),
        ];
    }
}
?>