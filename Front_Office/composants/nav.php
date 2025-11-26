<?php
require_once 'utils/bdd/database.php'; 
$query = "SELECT DISTINCT genre FROM games WHERE genre IS NOT NULL ORDER BY genre";
$stmt = $pdo->query($query);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000000d8;
        }

        .navbar {
            border: 1px solid #000000;
            position: fixed; 
            top: 20px;
            left: 50%; 
            transform: translateX(-50%); 
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 90%; 
            background-color: rgba(0, 0, 0, 0.7); 
            color: #fff;
            padding: 10px 20px;
            border-radius: 50px;
            backdrop-filter: blur(10px); 
            -webkit-backdrop-filter: blur(10px); 
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3); 
            z-index: 1000; 
        }

        .navbar-brand img {
            height: 80px;
            width: 80px;
        }

        .navbar-nav {
            display: flex;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-item {
            margin-right: 20px;
            position: relative;
        }

        .nav-link {
            text-decoration: none;
            color: white;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #007bff;
        }

        .dropdown-menu {
            display: none; 
            position: absolute;
            top: 40px;
            left: 0;
            background-color: #444;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            padding: 10px;
            z-index: 1000;
        }

        .dropdown-menu.show {
            display: block; 
        }

        .dropdown-item {
            color: white;
            text-decoration: none;
            display: block;
            padding: 5px 10px;
            transition: background-color 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: #007bff;
        }

        .form-inline {
            display: flex;
            align-items: center;
            margin-right: 20px;
            position: relative;
        }

        .form-inline input {
            padding: 5px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 3px;
            width: 250px;
        }

        .form-inline button {
            padding: 5px 10px;
            margin-left: 5px;
            border: none;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            border-radius: 3px;
        }

        .form-inline button:hover {
            background-color: #0056b3;
        }

        .suggestions {
            position: absolute;
            top: 40px;
            background-color: #1e1e1e;
            color: white;
            border-radius: 5px;
            max-height: 200px;
            overflow-y: auto;
            display: none;
            width: 100%;
            z-index: 1000;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.3);
        }

        .suggestions div {
            padding: 10px;
            cursor: pointer;
        }

        .suggestions div:hover {
            background-color: #007bff;
        }

        .navbar-session {
            display: flex;
            align-items: center;
        }

        .status-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-left: 8px;
        }

        .connected {
            background-color: green;
        }

        .disconnected {
            background-color: red;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a class="navbar-brand" href="index.php">
            <img src="img/DALL_E-2024-11-21-14.52-removebg-preview.png" alt="Logo Game Shift">
        </a>
        <ul class="navbar-nav" id="navbarNav">
            <form class="form-inline" action="search_results.php" method="GET">
    <input id="searchInput" type="search" name="query" placeholder="Rechercher un jeu..." aria-label="Search" oninput="showSuggestions()">
    <button type="submit"><i class="fas fa-search"></i></button>
    <div id="suggestions" class="suggestions"></div>
</form>
            <li class="nav-item">
                <a class="nav-link" href="jeux.php"><i class="fas fa-gamepad"></i> Jeux</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" onclick="toggleDropdown(event)">
                    <i class="fas fa-th-large"></i> Cat&eacutegories
                    <i class="fas fa-caret-down"></i>
                </a>
                <div class="dropdown-menu">
                    <?php foreach ($categories as $category): ?>
                        <a class="dropdown-item" href="category.php?genre=<?= urlencode($category['genre']); ?>">
                            <?= htmlspecialchars($category['genre']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> Panier</a>
            </li>
            <div class="navbar-session">
                <?php
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                if (isset($_SESSION["email"]) && !empty($_SESSION["email"])) {
                    echo '<ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> D&eacuteconnexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php"><i class="fas fa-user"></i> Compte</a>
                        </li>
                    </ul>';
                    echo '<span class="status-indicator connected"></span>';
                } else {
                    echo '<ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php"><i class="fas fa-user-plus"></i> Inscription</a>
                        </li>
                    </ul>';
                    echo '<span class="status-indicator disconnected"></span>';
                }
                ?>
            </div>
        </ul>
    </nav>

    <script>
        async function showSuggestions() {
            const searchInput = document.getElementById('searchInput');
            const suggestions = document.getElementById('suggestions');
            const query = searchInput.value.trim();

            if (query.length === 0) {
                suggestions.style.display = 'none';
                suggestions.innerHTML = '';
                return;
            }

            try {
                const response = await fetch(`search.php?query=${encodeURIComponent(query)}`);
                const results = await response.json();

                if (results.length > 0) {
                    suggestions.style.display = 'block';
                    suggestions.innerHTML = results
                        .map(result => `<div onclick="goToGame(${result.game_id})">${result.title}</div>`)
                        .join('');
                } else {
                    suggestions.style.display = 'none';
                    suggestions.innerHTML = '';
                }
            } catch (error) {
                console.error('Erreur lors de la r�cup�ration des suggestions:', error);
            }
        }

        function goToGame(gameId) {
            window.location.href = `achat.php?game_id=${gameId}`;
        }

        function performSearch() {
            const searchInput = document.getElementById('searchInput').value.trim();
            if (searchInput) {
                window.location.href = `search_results.php?query=${encodeURIComponent(searchInput)}`;
            }
        }

        function toggleDropdown(event) {
            event.preventDefault(); 
            const dropdownMenu = event.target.closest('.nav-item').querySelector('.dropdown-menu');
            dropdownMenu.classList.toggle('show');
        }
async function showSuggestions() {
    const searchInput = document.getElementById('searchInput');
    const suggestions = document.getElementById('suggestions');
    const query = searchInput.value.trim();

    if (query.length === 0) {
        suggestions.style.display = 'none';
        suggestions.innerHTML = '';
        return;
    }

    try {
        const response = await fetch(`search.php?query=${encodeURIComponent(query)}`);
        const results = await response.json();

        if (results.length > 0) {
            suggestions.style.display = 'block';
            suggestions.innerHTML = results
                .map(result => `<div onclick="goToGame(${result.game_id})">${result.title}</div>`)
                .join('');
        } else {
            suggestions.style.display = 'none';
            suggestions.innerHTML = '';
        }
    } catch (error) {
        console.error('Erreur lors de la r�cup�ration des suggestions:', error);
    }
}

function goToGame(gameId) {
    window.location.href = `achat.php?game_id=${gameId}`;
}

    </script>
</body>
</html>
