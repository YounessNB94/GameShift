<?php
require 'html\phpmailerANDvortex\vendor\autoload.php';

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

// Configurer l'API PayPal
$apiContext = new ApiContext(
    new OAuthTokenCredential(
        'AcUvZONJ3rNGU7bm-CHL_Gz0W3zfRvv0Xrhw3fOfs_YzSYbWtd8skTolG1C7ePcYLMRzncdVpR-4N-Fa', // Remplacez par votre Client ID
        'EL8bVZ5-l3WrzNOrLsbyMsXjJagjFVGPQ9mVfmrudif-ruSarYy1jiOPelYPD92lB95mP4rBdX5Llv39' // Remplacez par votre Secret
    )
);

// Récupérer les détails de la transaction
$paymentId = $_GET['paymentId'];
$payerId = $_GET['PayerID'];
$game_id = $_GET['game_id']; // L'ID du jeu acheté

$payment = Payment::get($paymentId, $apiContext);

$execution = new PaymentExecution();
$execution->setPayerId($payerId);

try {
    $result = $payment->execute($execution, $apiContext);

    // Marquer le jeu comme vendu ou déduire le stock
    $stmt = $pdo->prepare("UPDATE games SET stock = stock - 1 WHERE game_id = ?");
    $stmt->execute([$game_id]);

    echo "Paiement réussi pour le jeu : " . htmlspecialchars($game_id);
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
