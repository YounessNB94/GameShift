<?php

session_start(); 


include 'utils/bdd/database.php';

$email = $_GET['email'];
$token = $_GET['token'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND verification_token = ?");
$stmt->execute([$email, $token]);
$user = $stmt->fetch();

if ($user && $user['is_verified_mail'] == 0) {
    $stmt = $pdo->prepare("UPDATE users SET is_verified_mail = 1 WHERE email = ?");
    $stmt->execute([$email]);
    echo "Votre compte a été vérifié avec succès.";
} else {
    echo "Lien de vérification invalide ou compte déjà vérifié.";
}
?>
