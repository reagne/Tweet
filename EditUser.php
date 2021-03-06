<?php
require_once ("./src/connection.php");

if(isset($_SESSION['userId'])){
    echo("
    <a href='ShowUser.php'>Home</a> | <a href='Logout.php'>Wyloguj</a>
    <br>");
} else {
    header("Location: Login.php");
}

if(isset($_GET['userId'])){
    $userId = $_GET['userId'];
} else {
    $userId = $_SESSION['userId'];
}

$userToEdit = User::GetUserById($userId);

if($userToEdit !== FALSE){
    if($userToEdit->getId() === $_SESSION['userId']){
    echo("Twoj obecny opis: {$userToEdit->getDescription()}<br>");
    echo("Zmien: <br>");
        echo("
        <form action=EditUser.php method='POST'>
        <input type='text' name='new_description''>
        <input type='submit'>
        </form>
        ");

        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $userToEdit->setDescription($_POST["new_description"]);
            $userToEdit->saveToDb();
            if($userToEdit !== FALSE){
                echo("Twoj opis zostal zmieniony");
            } else {
                echo("Opis nieprawidlowy");
            }
        }
    }
} else {
    echo("Nie ma takiego uzytkownika");
}