<?php
require_once ("./src/connection.php");

session_unset();
header("Location: Login.php");