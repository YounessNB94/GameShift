<?php

function LogOrNot() {
if (!isset($_SESSION["email"]) && empty($_SESSION["email"]) && !isset($_SESSION["user_id"]) && empty($_SESSION["user_id"])) {
    header("Location: login.php");
   }
}

?>