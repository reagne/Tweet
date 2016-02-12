<?php
require_once ("./src/connection.php");

if(isset($_GET['tweetId'])) {
    $tweetId = $_GET['tweetId'];
}

$tweetToShow = Tweet::ShowTweet($tweetId);

if($tweetToShow !== FALSE){
    echo("{$tweetToShow->getText()}<br>{$tweetToShow->getDate()}<br>{$tweetToShow->getUser_Id()}<br>");
} else {
    echo("Nie ma takiego wpisu");
}