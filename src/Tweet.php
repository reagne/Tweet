<?php
/* Kod wprowadzony do PHPmyadmin:
create table Tweets(
    id int AUTO_INCREMENT,
    user_id int NOT NULL,
    text varchar(140),
    post_date date NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE
);
*/

class Tweet {
    static private $connection = null;

    static public function SetConnection(mysqli $newConncection){
        Tweet::$connection = $newConncection;
    }
    static public function CreateTweet($newUser_Id, $newText){
        $sql = "INSERT INTO Tweets(user_id, text, post_date)
                values ('$newUser_Id','$newText', now())";

        $result = self::$connection->query($sql);
        if($result === true){
            $newTweet = new Tweet(self::$connection->insert_id, $newUser_Id, $newText);
            return $newTweet;
        }
        return false;
    }
    static public function GetTweetById($id){
        $sql = "SELECT * FROM Tweets WHERE id=$id";
        $result = Tweet::$connection->query($sql);

        if($result !== FALSE){
            if($result->num_rows === 1){
                $row = $result->fetch_assoc();
                $tweet = new Tweet($row["id"], $row["user_id"], $row["text"], $row["post_date"]);
                return $tweet;
            }
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
    public function saveToDb(){  // umożliwiamy użytkownikowi zmianę tweeta
        $sql = "UPDATE Tweets SET text='$this->text' WHERE id='$this->id'";
        $result = self::$connection->query($sql);
        if($result === TRUE){
            return true;
        } else {
            return false;
        }
    }

    public function getAllComments(){
        $ret = [];
        // TODO: Finish this function. It should return table of all Comments linked to Tweet
        return $ret;
    }
}