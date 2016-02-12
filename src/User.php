<?php

/* Kod wprowadzony do PHPmyadmin:
create table Users(
    id int AUTO_INCREMENT,
    name varchar(255),
    mail varchar(255) UNIQUE,
    password char(60),
    description varchar(255),
    PRIMARY KEY (id)
);
*/

class User {
    static private $connection = null;

    static public function SetConnection(mysqli $newConncection){
        User::$connection = $newConncection;
    }
    static public function RegisterUser($newName, $newMail, $password1, $password2, $newDescription){
        if($password1 !== $password2){
            return false;
        }

        $options = ['cost' => 11, 'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)];
        $hashPassword = password_hash($password1, PASSWORD_BCRYPT, $options);

        $sql = "INSERT INTO Users(name, mail, password, description)
                values ('$newName', '$newMail', '$hashPassword', '$newDescription')";

        $result = self::$connection->query($sql);
        if($result === true){
            $newUser = new User(self::$connection->insert_id, $newName, $newMail, $newDescription);
            return $newUser;
        }

        return false;
    }
    static public function LogInUser($mail, $password){
        $sql = "SELECT * FROM Users WHERE mail LIKE '$mail'";
        $result = self::$connection->query($sql);

        if($result !== FALSE){
            if($result->num_rows === 1){
                $row = $result->fetch_assoc();

                $isPasswordOk = password_verify($password, $row["password"]);
                if($isPasswordOk === TRUE){
                    $user = new User($row["id"], $row["name"], $row["mail"], $row["description"]);
                    return $user;
                }
            }
        }
        return false;
    }
    static public function GetUserById($id){
        $sql = "SELECT * FROM Users WHERE id=$id";
        $result = User::$connection->query($sql);

        if($result !== FALSE){
            if($result->num_rows === 1){
                $row = $result->fetch_assoc();
                $user = new User($row["id"], $row["name"], $row["mail"], $row["description"]);
                return $user;
            }
        }
        return false;
    }
    static public function GetAllUsers() {
        $ret = [];
        $sql = "SELECT * FROM Users";
        $result = self::$connection->query($sql);

        if($result !== FALSE){
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $user = new User($row["id"], $row["name"], $row["mail"], $row["description"]);
                    $ret[] = $user;
                }
            }
        }
        return $ret;
    }

    private $id;
    private $name;
    private $mail;
    private $description;

    public function __construct($newId, $newName, $newMail, $newDescription){
         $this->id = intval($newId);
         $this->name = $newName;
         $this->mail = $newMail;
         $this->setDescription($newDescription);
    }
    public function getId(){
         return ($this->id);
    }
    public function getName(){
         return ($this->name);
    }
    public function getMail(){
         return ($this->mail);
    }
    public function getDescription(){
         return ($this->description);
    }
    public function setDescription($newDescription){
         if(is_string($newDescription) === true){
             $this->description = $newDescription;
         }
    }
    public function saveToDb(){  // umożliwiamy użytkownikowi zmianę opisu
         $sql = "UPDATE Users SET description='$this->description' WHERE id='$this->id'";
         $result = self::$connection->query($sql);
         if($result === TRUE){
             return true;
         } else {
             return false;
         }
    }
    public function loadAllTweets(){
        $ret = [];
        $sql = "SELECT * FROM Tweets WHERE user_id='$this->id' ORDER BY post_date DESC";
        $result = self::$connection->query($sql);

        if($result !== FALSE){
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $tweet = new tweet($row["id"], $row["user_id"], $row["text"], $row["post_date"]);
                    $ret[] = $tweet;
                }
            }
        }
        return $ret;
    }
    
    public function loadAllSendMessages(){
        $ret = [];
        // TODO: Finish this function. It should return table of all Messaged send by User (date DESC)
        return $ret;
    }
    public function loadAllReceiveMessages(){
        $ret = [];
        // TODO: Finish this function. It should return table of all Messaged received by User (date DESC)
        return $ret;
    }

 }