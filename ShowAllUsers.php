<?php
require_once ("./src/connection.php");

$allUsers = User::GetAllUsers();

foreach($allUsers as $userToShow){
    echo("<h1>{$userToShow->getName()}</h1><br>");
    echo("<a href='ShowUser.php?userId={$userToShow->getId()}'>Show</a><br>");
}