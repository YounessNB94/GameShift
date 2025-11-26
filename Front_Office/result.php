<?php

session_start(); 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$servername = "localhost"; 
$username = "root"; 
$password = "root"; 
$dbname = "bdd";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $username = $_POST['username'];
    $email = $_POST['email'];
    $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $age = (int)$_POST['age']; 
    $address = $_POST['address'];

  
    $id_verification = null; 
    $is_verified = 0; 
    $verification_token = null; 
    $is_verified_mail = 0; 

   
    $stmt = $conn->prepare("INSERT INTO utilisateurs (username, email, password, first_name, last_name, age, address, id_verification, is_verified, verification_token, is_verified_mail) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    if ($stmt === false) {
        die("Erreur de préparation : " . $conn->error);
    }

  
    $id_verification_param = $id_verification; 
    $verification_token_param = $verification_token;

    
    $stmt->bind_param("sssssisiii", 
        $username, 
        $email, 
        $passwordHash, 
        $first_name, 
        $last_name, 
        $age, 
        $address, 
        $id_verification_param,
        $is_verified, 
        $verification_token_param, 
        $is_verified_mail
    );

  
    if ($stmt->execute()) {
        echo "Nouveau compte créé avec succès.";
    } else {
        echo "Erreur lors de l'insertion : " . $stmt->error;
    }

    
    $stmt->close();
}


$conn->close();
?>
