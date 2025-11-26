<?php

session_start();
include 'utils/bdd/database.php';


if (isset($_SESSION['user_id'])) {
   
    $stmt = $pdo->prepare("UPDATE users SET session_token = NULL WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
}


session_destroy();


setcookie("session_token", "", time() - 3600, "/");


header("Location: login.php");
exit;
?>