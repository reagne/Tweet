<?php
/* Kod wprowadzony do PHPmyadmin:
create table Messages(
    id int AUTO_INCREMENT,
    sender_id int NOT NULL,
    receiver_id int NOT NULL,
    text varchar(1000),
    create_date datetime NOT NULL,
    is_read int NOT NULL DEFAULT 1,
    PRIMARY KEY (id),
    FOREIGN KEY (sender_id) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES Users(id) ON DELETE CASCADE
);
*/

class Message {
    static private $connection = null;

    static public function SetConnection(mysqli $newConncection){
        self::$connection = $newConncection;
    }
    static public function CreateMessage($newSender, $newReceiver, $newText){
        $newDate = date("Y-m-d H:i:s");
        $sql = "INSERT INTO Messages(sender_id, receiver_id, text, create_date)
                values ('$newSender','$newReceiver','$newText', '$newDate')";

        $result = self::$connection->query($sql);
        if($result !== FALSE){
            $newMessageId = self::$connection->insert_id;
            $newStatus = "1";
            $newMessage = new Message($newMessageId, $newSender, $newReceiver, $newText, $newDate, $newStatus);
            return $newMessage;
        }
        return false;
    }
    static public function ReadSendMessageById($id){
        $sql = "SELECT Messages.id, Messages.sender_id, Users.name, Messages.text, Messages.create_date, Messages.is_read
                FROM Messages
                JOIN Users ON Messages.receiver_id = Users.id
                WHERE Messages.id =$id";
        $result = self::$connection->query($sql);

        if($result !== FALSE){
            if($result->num_rows === 1){
                $row = $result->fetch_assoc();
                $message = new message($row["id"], $row["sender_id"], $row["name"], $row["text"], $row["create_date"], $row["is_read"]);
                return $message;
            }
        }
        return false;
    }
    static public function ReadReceiveMessageById($id){
        $sql = "SELECT Messages.id,  Users.name, Messages.receiver_id, Messages.text, Messages.create_date, Messages.is_read
                FROM Messages
                JOIN Users ON Messages.sender_id = Users.id
                WHERE Messages.id =$id";
        $result = self::$connection->query($sql);

        if($result !== FALSE){
            if($result->num_rows === 1){
                $row = $result->fetch_assoc();
                $message = new message($row["id"], $row["name"], $row["receiver_id"], $row["text"], $row["create_date"], $row["is_read"]);
                return $message;
            }
        }
        return false;
    }

    private $id;
    private $sender_id;
    private $receiver_id;
    private $text;
    private $date;
    private $status;

    public function __construct($newId, $newSender, $newReceiver, $newText, $newDate, $newStatus){
        $this->id = intval($newId);
        $this->sender_id = $newSender;
        $this->receiver_id = $newReceiver;
        $this->setText($newText);
        $this->date = $newDate;
        $this->setStatus($newStatus);
    }
    public function getId(){
        return ($this->id);
    }
    public function getSender(){
        return ($this->sender_id);
    }
    public function getReceiver(){
        return ($this->receiver_id);
    }
    public function getText(){
        return ($this->text);
    }
    public function getDate(){
        return ($this->date);
    }
    public function getStatus(){
        return ($this->status);
    }
    public function setText($newText){
        if(is_string($newText) === true){
            $this->text = $newText;
        }
    }
    public function setStatus($newStatus){
        if(is_string($newStatus) === true){
            $this->status = $newStatus;
        }
    }
    public function changeStatus(){
        $sql = "UPDATE Messages SET is_read=$this->status WHERE id='$this->id'";
        $result = self::$connection->query($sql);
        if($result === TRUE){
            return true;
        } else {
            return false;
        }
    }
    public function whatStatus(){
        if($this->status == '1'){
            echo("Wiadomosc nieprzeczytana");
        } else {
            echo("Wiadomosc przeczytana");
        }
    }

}