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
        echo("
        <a href='AllMessages.php?userId={$userToShow->getId()}'>Twoje wiadomosci</a>
        ");

        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $tweet = Tweet::CreateTweet($_SESSION['userId'], $_POST['tweet_text']);
            if($tweet === FALSE){
                echo("Nieprawidlowy wpis.<br>");
            }
        }
        echo("
        <form action='ShowUser.php' method='POST'>
        <label>Dodaj Tweet'a:</label>
        <input type='text' name='tweet_text''>
        <input type='submit'>
        </form>
        ");
    }

    foreach($userToShow->loadAllTweets() as $tweet){
       echo("{$tweet->getText()} | Komentarze: {$tweet->numberOfComments()} | ");
       echo("<a href='ShowTweet.php?tweetId={$tweet->getId()}'>Show info</a><br>");
    }

    if($userToShow->getId() !== $_SESSION['userId']){
        echo("
        <form action='ShowUser.php?userId={$userToShow->getId()}' method='POST'>
        <label>Wyslij wiadomosc:</label>
        <input type='text' name='message_text''>
        <input type='submit'>
        </form>
        ");
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $message = Message::CreateMessage($_SESSION['userId'], $userToShow->getId(), $_POST['message_text']);
            if($message === FALSE){
                echo("Blad przy wysylaniu. Sprobuj ponownie.<br>");
            } else {
                echo("Wiadomosc wyslana.<br>");
            }
        }
    }
} else {
    echo("Nie ma takiego uzytkownika");
}