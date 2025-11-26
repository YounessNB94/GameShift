<?php
session_start();
require_once '/var/www/html/utils/bdd/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = !empty($_POST['password']) ? password_hash(trim($_POST['password']), PASSWORD_BCRYPT) : null;
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $age = (int) htmlspecialchars(trim($_POST['age']));
    $address = htmlspecialchars(trim($_POST['address']));

    if (empty($username) || empty($email)) {
        $_SESSION['message'] = "Pseudo et email sont obligatoires.";
        header("Location: profile.php");
        exit();
    }

    $query = "UPDATE users SET username = ?, email = ?, first_name = ?, last_name = ?, age = ?, address = ?";
    if ($password) {
        $query .= ", password = ?";
    }
    $query .= " WHERE user_id = ?";
    $stmt = $conn->prepare($query);

    if ($password) {
        $stmt->bind_param("ssssisi", $username, $email, $first_name, $last_name, $age, $address, $password, $user_id);
    } else {
        $stmt->bind_param("ssssis", $username, $email, $first_name, $last_name, $age, $address, $user_id);
    }

    if ($stmt->execute()) {
        $_SESSION['message'] = "Profil mis à jour avec succès.";
    } else {
        $_SESSION['message'] = "Erreur lors de la mise à jour : " . $stmt->error;
    }

    $stmt->close();
    header("Location: profile.php");
    exit();
}
?>
