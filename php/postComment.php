<?php

class PostComment
{

    private $commentId;

    private $postId;
    private $commenter;
    private $text;

    private DateTime $postTime;

    /**
     * @param $postId
     * @param $commenter
     * @param $text
     */
    public function __construct($postId, $commenter, $text)
    {
        $this->postId = $postId;
        $this->commenter = $commenter;
        $this->text = $text;
        $this->postTime = new DateTime();;
        $this->commentId = $this->generateCommentId();

    }


    public function saveComment(){
//        global $conn;
        $db = DbConn::instanceOfDb();

        $conn=$db->getConnection();
            $stmt = $conn->prepare("INSERT INTO postComments (commentId, postId, userName, text,postTime) VALUES (:commentId, :postId,:commenter, :text, :postTime)");
            $stmt->bindParam(":commentId", $this->commentId);
            $stmt->bindParam(":postId", $this->postId);
            if (strlen($this->text)>512 || strlen(trim($this->text) <= 0)){throw new Exception("Invalid comment");}
            $stmt->bindParam(":text", $this->text);
            $stmt->bindParam(":commenter", $this->commenter);
            $postTimeFormatted = $this->postTime->format('Y-m-d H:i:s');
            $stmt->bindParam(":postTime", $postTimeFormatted);
            $stmt->execute();


    }

    private function generateCommentId(){
        return $this->commenter . $this->postTime->format('YmdHisu');    }
    public static function loadPostComments($postId){
//        global $conn;
        $db = DbConn::instanceOfDb();

        $conn=$db->getConnection();
        try {
            $stmt = $conn->prepare("SELECT userName,text,postTime FROM postcomments where postId = :postId order by postTime desc");
            $stmt->bindParam(":postId", $postId);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        catch (Exception $e){
            echo "Server failure try again";
        }
    }



}