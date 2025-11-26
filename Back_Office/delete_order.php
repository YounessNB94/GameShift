<?php

$conn = new mysqli('localhost', 'root', 'root', 'GameShift');
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']);
    $query = "DELETE FROM orders WHERE order_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $order_id);
    if ($stmt->execute()) {
        echo "Commande supprimée avec succès.";
    } else {
        echo "Erreur : " . $conn->error;
    }
    $stmt->close();
}
$conn->close();
header("Location: orders.php"); 
exit;
?>
