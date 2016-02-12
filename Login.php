<?php
require_once("./src/connection.php");

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $user = User::LogInUser($_POST['mail'], $_POST['password']);

    if($user !== FALSE){
        $_SESSION['userId'] = $user->getId();
        header("Location: ShowUser.php");
    } else {
        echo("Zle dane rejestracji");
    }
}

?>

<form action="Login.php" method="POST">
    <p><label>
            Podaj swoj e-mail:
            <input type="email" name="mail">
        </label></p>
    <p><label>
            Podaj swoje haslo:
            <input type="password" name="password">
        </label></p>
    <label>
        <input type="submit" name="wyslij">
    </label>
</form>
