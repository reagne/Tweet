<?php
require_once("./src/connection.php");

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $user = User::RegisterUser($_POST['name'], $_POST['mail'], $_POST['password1'], $_POST['password2'], $_POST['description']);
    if($user !== FALSE){
        $_SESSION['userId'] = $user->getId();
        header("Location: ShowUser.php");
    } else {
        echo("Zle dane rejestracji.<br>");
    }
}
?>

<form action="Register.php" method="POST">
    <p><label>
        Email:
        <input type="email" name="mail">
    </label></p>
    <p><label>
        Name:
        <input type="text" name="name">
    </label></p>
    <p><label>
        Password 1:
        <input type="password" name="password1">
    </label></p>
    <p><label>
        Password 2:
        <input type="password" name="password2">
    </label></p>
    <p><label>
        Opis:
        <input type="text" name="description">
    </label></p>
    <label>
        <input type="submit" name="wyslij">
    </label>
</form>