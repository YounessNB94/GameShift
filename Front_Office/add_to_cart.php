<?php
session_start();
require_once 'utils/bdd/database.php';
require_once 'fonctions/fonctions.php';

LogOrNot();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id']; 
    $game_id = $_POST['game_id'];
    $quantity = $_POST['quantity'];

   
    $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ? AND game_id = ?");
    $stmt->execute([$user_id, $game_id]);
    $item = $stmt->fetch();

    if ($item) {
      
        $new_quantity = $item['quantity'] + $quantity;
        $update_stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE cart_id = ?");
        $update_stmt->execute([$new_quantity, $item['cart_id']]);
    } else {

        $insert_stmt = $pdo->prepare("INSERT INTO cart (user_id, game_id, quantity) VALUES (?, ?, ?)");
        $insert_stmt->execute([$user_id, $game_id, $quantity]);
    }

 
    header("Location: cart.php");
    exit;
}
?>