<?php
session_start();
require_once 'utils/bdd/database.php';
require_once 'fonctions/fonctions.php';
LogOrNot();
$user_id = $_SESSION['user_id']; 

// Récupération des articles du panier
$stmt = $pdo->prepare("SELECT c.cart_id, c.quantity, g.title, g.price, g.image_url 
                       FROM cart c 
                       JOIN games g ON c.game_id = g.game_id 
                       WHERE c.user_id = ?");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll();

// Gestion des actions sur le panier
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $cart_id = $_POST['cart_id'];
        if ($_POST['action'] === 'increase') {
            $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity + 1 WHERE cart_id = ?");
            $stmt->execute([$cart_id]);
        } elseif ($_POST['action'] === 'decrease') {
            $stmt = $pdo->prepare("UPDATE cart SET quantity = GREATEST(quantity - 1, 1) WHERE cart_id = ?");
            $stmt->execute([$cart_id]);
        } elseif ($_POST['action'] === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM cart WHERE cart_id = ?");
            $stmt->execute([$cart_id]);
        }
        header("Location: cart.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Panier</title>
    <link rel="stylesheet" href="css/cart.css">
</head>
<style>
    body {
    margin: 0;
    padding-top: 120px;
    font-family: Arial, sans-serif;
    background-color: #000000d8;
}
    
.cart-container {
    display: flex;
    justify-content: space-between;
    margin: 20px auto;
    max-width: 1200px;
    padding: 20px;
    background-color: #1e1e1e;
    border-radius: 8px;
    color: white;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
}


.cart-items {
    flex: 3;
    margin-right: 20px;
}

.cart-items h2 {
    margin-bottom: 20px;
}


.cart-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding: 10px;
    background-color: #2a2a2a;
    border-radius: 8px;
}

.cart-item img {
    width: 80px;
    height: 80px;
    border-radius: 4px;
}

.item-details {
    flex: 2;
    margin-left: 20px;
}

.item-actions {
    display: flex;
    align-items: center;
    margin-top: 10px;
}

.item-actions button {
    background-color: #007bff;
    border: none;
    color: white;
    padding: 5px 10px;
    margin: 0 5px;
    border-radius: 4px;
    cursor: pointer;
}

.item-actions button:hover {
    background-color: #0056b3;
}

.item-actions .delete-btn {
    background-color: #ff4d4d;
}

.item-actions .delete-btn:hover {
    background-color: #cc0000;
}

.item-total {
    flex: 1;
    text-align: right;
}


.cart-summary {
    flex: 1;
    padding: 20px;
    background-color: #2a2a2a;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
}

.cart-summary h3 {
    margin-bottom: 20px;
}

.cart-summary p {
    margin-bottom: 10px;
    font-size: 18px;
}

.checkout-btn {
    width: 100%;
    padding: 10px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    margin-bottom: 10px;
}

.checkout-btn:hover {
    background-color: #218838;
}

.continue-shopping {
    display: block;
    text-align: center;
    color: #007bff;
    text-decoration: none;
    margin-top: 10px;
}

.continue-shopping:hover {
    text-decoration: underline;
}

    </style>
<body>
<?php require_once('composants/nav.php'); ?>

<div class="cart-container">
    <div class="cart-items">
        <h2>Panier</h2>
        <?php if (empty($cart_items)): ?>
            <p>Votre panier est vide.</p>
        <?php else: ?>
            <?php
            $total = 0;
            foreach ($cart_items as $item) {
                $item_total = $item['quantity'] * $item['price'];
                $total += $item_total;
                ?>
                <div class="cart-item">
                    <img src="<?= htmlspecialchars($item['image_url']); ?>" alt="<?= htmlspecialchars($item['title']); ?>" />
                    <div class="item-details">
                        <h3><?= htmlspecialchars($item['title']); ?></h3>
                        <p>Prix unitaire: <?= $item['price']; ?> €</p>
                        <div class="item-actions">
                            <form method="POST" action="cart.php">
                                <input type="hidden" name="cart_id" value="<?= $item['cart_id']; ?>">
                                <button type="submit" name="action" value="decrease">-</button>
                                <span><?= $item['quantity']; ?></span>
                                <button type="submit" name="action" value="increase">+</button>
                                <button type="submit" name="action" value="delete" class="delete-btn">Supprimer</button>
                            </form>
	
                        </div>
                    </div>
                    <p class="item-total"><?= $item_total; ?> €</p>
                </div>
            <?php } ?>
        <?php endif; ?>
    </div>

		

    <div class="cart-summary">
        <h3>Résumé</h3>
        <p>Total: <?= $total; ?> €</p>
<form action="checkout.php" method="POST">
    <input type="hidden" name="total" value="<?= $total; ?>">
    <button type="submit" class="checkout-btn">Payer avec PayPal</button>
</form>
        <button class="checkout-btn">Procéder au paiement</button>
        <a href="jeux.php" class="continue-shopping">Continuer vos achats</a>
    </div>
</div>
</body>
</html>
