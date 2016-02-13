<?php
require_once ("./src/connection.php");

if(isset($_GET['messSenId'])){
    $messSenId = $_GET['messSenId'];
    $userId = $_SESSION['userId'];

    $userToShow = User::GetUserById($userId);
    $messageToShow = Message::ReadSendMessageById($messSenId);

    if($userToShow !== FALSE && $messageToShow !== FALSE) {
        echo("Od: {$userToShow->getName()} <br>");
        echo("Do: {$messageToShow->getReceiver()} <br>");
        echo("Data: {$messageToShow->getDate()} <br>");
        echo("Tekst:<br>");
        echo("{$messageToShow->getText()} <br>");
    } else {
        echo("Wiadomosc nie istnieje. Sprawdz czy jestes poprawnie zalogowany.<br>");
    }
} elseif (isset($_GET['messRecId'])){
    $messRecId = $_GET['messRecId'];
    $userId = $_SESSION['userId'];

    $userToShow = User::GetUserById($userId);
    $messageToShow = Message::ReadReceiveMessageById($messRecId);
    if($userToShow !== FALSE && $messageToShow !== FALSE) {
        echo("Od: {$messageToShow->getSender()} <br>");
        echo("Do: {$userToShow->getName()} <br>");
        echo("Data: {$messageToShow->getDate()} <br>");
        echo("Tekst:<br>");
        echo("{$messageToShow->getText()} <br>");
        // Zmiana statusu przeczytania wiadomości
        $messageToShow->setStatus("0");
        $messageToShow->changeStatus();
    } else {
        echo("Wiadomosc nie istnieje. Sprawdz czy jestes poprawnie zalogowany.<br>");
    }
}

