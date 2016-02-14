<?php
require_once ("./src/connection.php");

if(isset($_SESSION['userId'])){
    echo("
    <a href='ShowUser.php'>Home</a> | <a href='ShowAllUsers.php'>Znajdz uzytkownika</a> | <a href='Logout.php'>Wyloguj</a> | <a href='EditUser.php'>Edytuj swoje dane</a>
    <br><br>");
} else {
    header("Location: Login.php");
}

if(isset($_GET['tweetId'])) {
    $tweetId = $_GET['tweetId'];
}

$tweetToShow = Tweet::ShowTweet($tweetId);

if($tweetToShow !== FALSE){
    echo("{$tweetToShow->getText()}<br>Opublikowany przez: {$tweetToShow->getUser_Id()} dnia: {$tweetToShow->getDate()} <br><br>");
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

