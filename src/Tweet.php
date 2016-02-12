<?php
/* Kod wprowadzony do PHPmyadmin:
create table Tweets(
    id int AUTO_INCREMENT,
    user_id int,
    text varchar(140),
    post_date date,
    PRIMARY KEY (id),
    FOREIGN KEY user_id REFERENCES Users(id) on delete cascade
);
*/

class Tweet {
    static private $connection = null;

    static public function SetConnection(mysqli $newConncection){
        Tweet::$connection = $newConncection;
    }

    private $id;
    private $user_id;
    private $text;
    private $post_date;
}