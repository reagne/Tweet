<?php
require_once ("./src/connection.php");

if(isset($_GET['userId'])){
    $userId = $_GET['userId'];
} else {
    $userId = $_SESSION['userId'];
}

$userToShow = User::GetUserById($userId);

if($userToShow !== FALSE) {
    if ($userToShow->getId() === $_SESSION['userId']) {
        // Wyświetlanie wiadomości wysłanych - pierwsze 30 znaków tekstu wiadomości jest wyłuskanych za pomocą substr().
        echo("<h1>Wyslane wiadomosci</h1>");
        foreach($userToShow->loadAllSendMessages() as $sendMessage){
            $shortText = substr("{$sendMessage->getText()}", 0, 30);
            echo("$shortText... | Do: {$sendMessage->getReceiver()} | Data: {$sendMessage->getDate()} <br>");
            echo("<a href='ReadMessage.php?messSenId={$sendMessage->getId()}'>Przeczytaj</a><br>");
        }
        // Wyświetlanie wiadomości odebranych - pierwsze 30 znaków tekstu jest wyłuskanych w zapytaniu SQL "left(text, 30) AS short_text" i przy stworzeniu obiektu zamiast "$row['text']" został użyty "$row['short_text']".
        echo("<h1>Odebrane wiadomosci</h1>");
        foreach($userToShow->loadAllReceiveMessages() as $receivMessage){
            echo("{$receivMessage->getText()}... | Od: {$receivMessage->getSender()} | Data: {$receivMessage->getDate()} | Status: ");
            echo("{$receivMessage->whatStatus()}<br>");
            echo("<a href='ReadMessage.php?messRecId={$receivMessage->getId()}'>Przeczytaj</a><br>");
        }
    }
} else {
    echo("Zaloguj sie, aby sprawdzic wiadomosci.");
}