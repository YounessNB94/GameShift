<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclure l'autoloader généré par Composer
require 'phpmailerANDvortex/vendor/autoload.php';

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;

// Configuration de l'API PayPal
$apiContext = new ApiContext(
    new OAuthTokenCredential(
        'AcUvZONJ3rNGU7bm-CHL_Gz0W3zfRvv0Xrhw3fOfs_YzSYbWtd8skTolG1C7ePcYLMRzncdVpR-4N-Fa', // Remplacez par votre Client ID PayPal
        'EL8bVZ5-l3WrzNOrLsbyMsXjJagjFVGPQ9mVfmrudif-ruSarYy1jiOPelYPD92lB95mP4rBdX5Llv39' // Remplacez par votre Secret PayPal
    )
);

// Configurer les logs PayPal
$apiContext->setConfig([
    'mode' => 'sandbox', // Passez à 'live' en production
    'log.LogEnabled' => true,
    'log.FileName' => '/var/www/html/logs/PayPal.log', // Changez vers un répertoire accessible
    'log.LogLevel' => 'DEBUG',
]);

// Vérifiez si un montant a été reçu
if (!isset($_POST['total']) || !is_numeric($_POST['total']) || $_POST['total'] <= 0) {
    die("Montant non spécifié ou invalide.");
}

$total = number_format($_POST['total'], 2, '.', '');

try {
    // Créer un paiement PayPal
    $payer = new Payer();
    $payer->setPaymentMethod('paypal');

    $amount = new Amount();
    $amount->setTotal($total);
    $amount->setCurrency('EUR');

    $transaction = new Transaction();
    $transaction->setAmount($amount);
    $transaction->setDescription('Paiement sur votre site.');

    $redirectUrls = new RedirectUrls();
    $redirectUrls->setReturnUrl("http://5.135.149.31/success.php")
                 ->setCancelUrl("http://5.135.149.31/cancel.php");

    $payment = new Payment();
    $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions([$transaction])
            ->setRedirectUrls($redirectUrls);

    $payment->create($apiContext);

    header("Location: " . $payment->getApprovalLink());
    exit;

} catch (Exception $e) {
    // Afficher les erreurs pour déboguer
    echo "<pre>";
    print_r($e->getMessage());
    echo "</pre>";
    die("Erreur lors de la création du paiement PayPal.");
}

?>
