<?php

session_start();

require_once(dirname(__FILE__)."./config.php");
require_once(dirname(__FILE__)."./User.php");
require_once(dirname(__FILE__)."./Tweet.php");
require_once(dirname(__FILE__)."./Comment.php");
require_once(dirname(__FILE__)."./Message.php");


$conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbBaseName);
/* Sprawdzenie czy połączenie działa
if($conn->connect_errno){
    die("Db connection not initialized properly ". $conn->connect_error."<br>");
} else {
    echo("Db connection is initialized<br>");
}
*/
User::SetConnection($conn);
Tweet::SetConnection($conn);
Comment::SetConnection($conn);
Message::SetConnection($conn);

/* Testy na klasie USER
$user1 = User::RegisterUser("Jacek", "test@test.pl", "12345", "12345", "Opis Jacek");
var_dump($user1);

$user1 = User::LogInUser("test@test.pl", "12345");
var_dump($user1);

$user1 = User::GetUserById(1);
var_dump($user1);

$user1 = User::GetAllUsers();
var_dump($user1);

$user1->setDescription("Opis nowy 2");
$user1->saveToDb();
var_dump($user1);
*/
/* Testy na klasie TWEET
$tweet1 = Tweet::CreateTweet(1,"Testowy Tweet2");
var_dump($tweet1);

$tweet1 = Tweet::LoadTweetById(3);
var_dump($tweet1);
*/