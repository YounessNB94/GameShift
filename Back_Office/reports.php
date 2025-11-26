<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
// $conn = new mysqli('localhost', 'root', 'root', 'GameShift');
    $conn = new mysqli('localhost', 'root', '', 'GameShift');

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$total_sales_query = "SELECT SUM(total_amount) AS total_sales FROM orders";
$total_sales_result = $conn->query($total_sales_query);
$total_sales = $total_sales_result->fetch_assoc()['total_sales'] ?? 0;

$active_clients_query = "SELECT COUNT(DISTINCT user_id) AS active_clients FROM orders";
$active_clients_result = $conn->query($active_clients_query);
$active_clients = $active_clients_result->fetch_assoc()['active_clients'] ?? 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapports - Back Office</title>
    <link rel="stylesheet" href="stylesr.css">
</head>
<body>
    <div class="sidebar">
        <h2>Back Office</h2>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="products.php">Produits</a></li>
            <li><a href="users.php">Utilisateurs</a></li>
            <li><a href="orders.php">Commandes</a></li>
            <li><a href="reports.php">Rapports</a></li>
            <li><a href="settings.html">Paramètres</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Rapports de ventes</h1>

        <div class="report-summary">
            <div class="summary-box">
                <h3>Total des ventes</h3>
                <p><?php echo number_format($total_sales, 2, ',', ' ') . ' €'; ?></p>
            </div>
            <div class="summary-box">
                <h3>Clients actifs</h3>
                <p><?php echo number_format($active_clients, 0, ',', ' '); ?></p>
            </div>
        </div>
    </div>
</body>
</html>
