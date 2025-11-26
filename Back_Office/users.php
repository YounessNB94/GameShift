<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli('localhost', 'root', 'root', 'GameShift');
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

function getUsers() {
    global $conn;
    $query = "SELECT * FROM users"; 
    $result = $conn->query($query);
    if (!$result) {
        die("Erreur SQL : " . $conn->error);
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $user_id = intval($_POST['user_id']); 

        
        $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            echo "Utilisateur avec ID $user_id supprimé.";
        } else {
            echo "Erreur lors de la suppression : " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilisateurs - Back Office</title>
    <link rel="stylesheet" href="stylesu.css">
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
        <h1>Gestion des Utilisateurs</h1>

      
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Adresse</th>
                    <th>Âge</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $users = getUsers();
                foreach ($users as $user) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($user['user_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['first_name'] . " " . $user['last_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['address']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['age']) . "</td>";
                    echo "<td>
                        <form method='POST' style='display:inline-block;'>
                            <input type='hidden' name='user_id' value='" . htmlspecialchars($user['user_id']) . "'>
                            <button type='submit' name='action' value='delete' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet utilisateur ?\")'>Supprimer</button>
                        </form>
                    </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
