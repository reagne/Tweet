<?php
require_once ("./src/connection.php");

if(isset($_GET["userId"])){
    $userId = $_GET["userId"];
} else {
    $userId = $_SESSION['userId'];
}

$userId = $_GET["userId"];
$userToShow = User::GetUserById($userId);

if($userToShow !== FALSE){
    echo("<h1>{$userToShow->getName()}</h1>");

    if($userToShow->getId() === $_SESSION['userId']){
        echo("
        <form action='ShowUser.php' method='POST'>
        <input type='text' name='tweet_text''>
        <input type='submit'>
        </form>
        ");
    }

    foreach($userToShow->loadAllTweets() as $tweet){
        echo("Wyswietlic tweeta...");
    }
} else {
    echo("Nie ma takiego uzytkownika");
}