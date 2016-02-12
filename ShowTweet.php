<?php
require_once ("./src/connection.php");

if(isset($_GET['tweetId'])) {
    $tweetId = $_GET['tweetId'];
}

$tweetToShow = Tweet::ShowTweet($tweetId);

if($tweetToShow !== FALSE){
    echo("{$tweetToShow->getText()}<br>{$tweetToShow->getDate()}<br>{$tweetToShow->getUser_Id()}<br>");
    if(isset($_SESSION['userId'])){
        echo("
        <form action=ShowTweet.php?tweetId=$tweetId method='POST'>
        <label>Dodaj komentarz:</label>
        <input type='text' name='new_comment''>
        <input type='submit'>
        </form>
        ");

        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $comment = Comment::CreateComment($_SESSION['userId'], $tweetId, $_POST['new_comment']);
            if($comment === FALSE){
                echo("Nieprawidlowy wpis.<br>");
            }
        }
    } else {
        echo("Nie jestes zalogowany. Zaloguj sie, aby moc dodawac komentarze.");
    }
    foreach($tweetToShow->loadAllComments() as $comment){
        echo("{$comment->getText()} | {$comment->getUser_Id()}<br>");
    }
} else {
    echo("Nie ma takiego wpisu");
}

