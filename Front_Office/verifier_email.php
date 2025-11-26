<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); 



require_once 'utils/bdd/database.php';

if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];

    try {
        
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND verification_token = :token AND is_verified = 0");
        $stmt->execute([
            'email' => $email,
            'token' => $token
        ]);

        if ($stmt->rowCount() > 0) {
            
            $updateStmt = $pdo->prepare("UPDATE users SET is_verified = 1, is_verified_mail = 1, verification_token = NULL WHERE email = :email");
            $updateStmt->execute(['email' => $email]);

            echo "Votre compte a été vérifié avec succès! Vous pouvez maintenant vous connecter.";
        
            header("refresh:3;url=login.php");
        } else {
            echo "Lien de vérification invalide ou déjà utilisé.";
        }
    } catch (PDOException $e) {
        echo "Erreur lors de la vérification : " . $e->getMessage();
    }
} else {
    echo "Paramètres manquants.";
}
?>