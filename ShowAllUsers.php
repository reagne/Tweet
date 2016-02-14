<?php
require_once ("./src/connection.php");

if(isset($_SESSION['userId'])){
    echo("
    <a href='ShowUser.php'>Home</a> | <a href='Logout.php'>Wyloguj</a> | <a href='EditUser.php'>Edytuj swoje dane</a>
    <br>");
} else {
    header("Location: Login.php");
}

$allUsers = User::GetAllUsers();

foreach($allUsers as $userToShow){
    echo("<h1>{$userToShow->getName()}</h1><br>");
    echo("<a href='ShowUser.php?userId={$userToShow->getId()}'>Show</a><br>");
}