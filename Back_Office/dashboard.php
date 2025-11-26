<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli('localhost', 'root', 'root', 'GameShift');
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}


$total_users_query = "SELECT COUNT(*) AS total_users FROM users";
$total_users_result = $conn->query($total_users_query);
$total_users = $total_users_result->fetch_assoc()['total_users'];


$sales_today_query = "SELECT COUNT(*) AS sales_today FROM orders WHERE DATE(order_date) = CURDATE()";
$sales_today_result = $conn->query($sales_today_query);
$sales_today = $sales_today_result->fetch_assoc()['sales_today'];

// Nouveaux produits
$new_products_query = "SELECT COUNT(*) AS new_products FROM games WHERE DATE(added_date) = CURDATE()";
$new_products_result = $conn->query($new_products_query);
$new_products = $new_products_result->fetch_assoc()['new_products'];

// Commandes en cours
$ongoing_orders_query = "SELECT COUNT(*) AS ongoing_orders FROM orders WHERE statut = 'En cours'";
$ongoing_orders_result = $conn->query($ongoing_orders_query);
$ongoing_orders = $ongoing_orders_result->fetch_assoc()['ongoing_orders'];




$sales_data = [];
$sales_labels = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
foreach ($sales_labels as $label) {
    $sales_data[$label] = 0; 
}


$sales_data_json = json_encode(array_values($sales_data));
$sales_labels_json = json_encode(array_keys($sales_data));
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Back Office</title>
    <link rel="stylesheet" href="styles1.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <h1>Dashboard</h1>
        <div class="stats">
            <div class="stat-card">
                <h3>Utilisateurs Totaux</h3>
                <p id="total-users"><?php echo $total_users; ?></p>
            </div>
            <div class="stat-card">
                <h3>Ventes Aujourd'hui</h3>
                <p id="sales-today"><?php echo $sales_today; ?></p>
            </div>
            <div class="stat-card">
                <h3>Nouveaux Produits</h3>
                <p id="new-products"><?php echo $new_products; ?></p>
            </div>
            <div class="stat-card">
                <h3>Commandes en Cours</h3>
                <p id="ongoing-orders"><?php echo $ongoing_orders; ?></p>
            </div>
        </div>

        <h2>Graphiques</h2>
        <canvas id="salesChart" width="400" height="200"></canvas>
    </div>

    <script>
        
        const salesLabels = <?php echo $sales_labels_json; ?>;
        const salesData = <?php echo $sales_data_json; ?>;

        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: salesLabels,
                datasets: [{
                    label: 'Ventes Hebdomadaires',
                    data: salesData,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
