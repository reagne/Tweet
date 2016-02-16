<?php
/* Kod wprowadzony do PHPmyadmin:
create table Comments(
    id int AUTO_INCREMENT,
    user_id int NOT NULL,
    tweet_id int NOT NULL,
    text varchar(60),
    post_date datetime NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (tweet_id) REFERENCES Tweets(id) ON DELETE CASCADE
);
*/

class Comment {
    static private $connection = null;

    static public function SetConnection(mysqli $newConnection){
        Comment::$connection = $newConnection;
    }
    static public function CreateComment($newUser_Id, $newTweet_Id, $newText){
        $newDate = date("Y-m-d H:i:s");
        $sql = "INSERT INTO Comments(user_id, tweet_id, text, post_date)
                values ('$newUser_Id', '$newTweet_Id', '$newText', '$newDate')";
        $result = self::$connection->query($sql);
        if($result !== FALSE){
            $newCommentId = self::$connection->insert_id;
            $newComment = new Comment($newCommentId, $newUser_Id, $newTweet_Id, $newText, $newDate);
            return $newComment;
        }
        return false;
    }

    private $id;
    private $user_id;
    private $tweet_id;
    private $text;
    private $post_date;

    public function __construct($newId, $newUser_Id, $newTweet_Id, $newText, $newDate){
        $this->id = intval($newId);
        $this->user_id = $newUser_Id;
        $this->tweet_id = $newTweet_Id;
        $this->setText($newText);
        $this->post_date = $newDate;
    }
    public function getId(){
        return ($this->id);
    }
    public function getUser_Id(){
        return ($this->user_id);
    }
    public function getTweet_Id(){
        return ($this->tweet_id);
    }
    public function getText(){
        return ($this->text);
    }
    public function getDate(){
        return ($this->post_date);
    }
    public function setText($newText){
        if(is_string($newText) === true){
            $this->text = $newText;
        }
    }
}