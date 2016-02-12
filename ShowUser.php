<?php
require_once ("./src/connection.php");

if(isset($_GET['userId'])){
    $userId = $_GET['userId'];
} else {
    $userId = $_SESSION['userId'];
}

$userToShow = User::GetUserById($userId);

if($userToShow !== FALSE){
    echo("<h1>{$userToShow->getName()}</h1>");

    if($userToShow->getId() === $_SESSION['userId']){
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $tweet = Tweet::CreateTweet($_SESSION['userId'], $_POST['tweet_text']);
            if($tweet === FALSE){
                echo("Nieprawidlowy wpis.<br>");
            }
        }
        echo("
        <form action='ShowUser.php' method='POST'>
        <input type='text' name='tweet_text''>
        <input type='submit'>
        </form>
        ");
    }

    foreach($userToShow->loadAllTweets() as $tweet){
       echo("{$tweet->getText()} | ");
       echo("<a href='ShowTweet.php?tweetId={$tweet->getId()}'>Show info</a><br>");
    }
} else {
    echo("Nie ma takiego uzytkownika");
}