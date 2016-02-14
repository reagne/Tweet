<?php
/* Kod wprowadzony do PHPmyadmin:
create table Tweets(
    id int AUTO_INCREMENT,
    user_id int NOT NULL,
    text varchar(140),
    post_date datetime NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE
);
*/

class Tweet {
    static private $connection = null;

    static public function SetConnection(mysqli $newConnection){
        Tweet::$connection = $newConnection;
    }
    static public function CreateTweet($newUser_Id, $newText){
        $sql = "INSERT INTO Tweets(user_id, text, post_date)
                values ('$newUser_Id','$newText', now())";

        $result = self::$connection->query($sql);
        if($result === true){
            $newTweetId = self::$connection->insert_id;

            $sql2 = "SELECT post_date FROM Tweets WHERE id=$newTweetId";
            $result2 = self::$connection->query($sql2);
            $newDate = $result2;

            $newTweet = new Tweet($newTweetId, $newUser_Id, $newText, $newDate);
            return $newTweet;
        }
        return false;
    }
    static public function ShowTweet($id){
        $sql = "SELECT Tweets.id, Tweets.text, Tweets.post_date, Users.name FROM Tweets JOIN Users ON Tweets.user_id=Users.id WHERE Tweets.id='$id'";
        $result = self::$connection->query($sql);

        if($result !== FALSE){
            if($result->num_rows === 1){
                $row = $result->fetch_assoc();
                $tweet = new tweet($row["id"], $row["name"], $row["text"], $row["post_date"]);
                return $tweet;
            }
        }
        return false;
    }

    private $id;
    private $user_id;
    private $text;
    private $post_date;

    public function __construct($newId, $newUser_Id, $newText, $newDate){
        $this->id = intval($newId);
        $this->user_id = $newUser_Id;
        $this->setText($newText);
        $this->post_date = $newDate;
    }
    public function getId(){
        return ($this->id);
    }
    public function getUser_Id(){
        return ($this->user_id);
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
    public function loadAllComments(){
        $ret = [];
        $sql = "SELECT Comments.id, Comments.tweet_id, Comments.text, Comments.post_date, Users.name FROM Comments JOIN Users ON Comments.user_id=Users.id
                WHERE Comments.tweet_id='$this->id' ORDER BY post_date DESC";
        $result = Tweet::$connection->query($sql);

        if($result !== FALSE){
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $comment = new Comment($row["id"], $row["name"], $row["tweet_id"], $row["text"], $row["post_date"]);
                    $ret[] = $comment;
                }
            }
        }
        return $ret;
    }
    public function numberOfComments(){
        $number = 0;
        $sql = "SELECT * FROM Comments WHERE Comments.tweet_id='$this->id'";
        $result = Tweet::$connection->query($sql);

        if($result !== FALSE){
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $number++;
                }
            }
        }
        return $number;
    }
}