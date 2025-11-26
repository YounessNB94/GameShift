<?php
require_once __DIR__ . '/libs/tcpdf/tcpdf.php';
require_once 'utils/bdd/database.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    die("Erreur : utilisateur non connecté.");
}

$user_id = $_SESSION['user_id'];

$query = "SELECT username, email, first_name, last_name, age, address FROM users WHERE user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    die("Erreur : utilisateur introuvable.");
}

$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

$html = '<h1>Profil utilisateur</h1>';
$html .= '<p><strong>Pseudo :</strong> ' . htmlspecialchars($user['username']) . '</p>';
$html .= '<p><strong>Email :</strong> ' . htmlspecialchars($user['email']) . '</p>';
$html .= '<p><strong>Prénom :</strong> ' . htmlspecialchars($user['first_name']) . '</p>';
$html .= '<p><strong>Nom :</strong> ' . htmlspecialchars($user['last_name']) . '</p>';
$html .= '<p><strong>Âge :</strong> ' . htmlspecialchars($user['age']) . '</p>';
$html .= '<p><strong>Adresse :</strong> ' . htmlspecialchars($user['address']) . '</p>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('Profil_utilisateur.pdf', 'D');
