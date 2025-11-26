<?php

session_start();
include 'utils/bdd/database.php';

if (isset($_COOKIE['session_token'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE session_token = ?");
    $stmt->execute([$_COOKIE['session_token']]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user_id'] = $user['user_id'];
    }
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>