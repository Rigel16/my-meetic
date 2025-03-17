<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: connexion.php");
    exit();
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LoveMatch - Accueil</title>
    <link rel="stylesheet" href="styles2.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

</head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#hobbies').select2({
        placeholder: "Sélectionnez vos loisirs",
        allowClear: true,
        width: '100%' // Forcer la largeur du select2
    });
});

</script>
<body>

    <header>
    <img src="../assets/QUEST.jpg" alt="LoveMatch Logo" class="logo" width="150">
    <nav>
            <a href="accueil_connexion.php">🏠 Accueil</a>
            <a href="messages.php">💬 Messages</a>
            <button class="burger-btn" onclick="toggleMenu()">🔍</button>
            <a href="compteUser.php" class="profile-icon">
            <img src="<?php echo "../".$user['image'] ; ?>" alt="Avatar" />
            </a>
        </nav>
    </header>
<!-- MENU DE RECHERCHE (Caché au départ) -->
<div id="search-menu" class="search-menu">
    <h2>Recherche avancée</h2>
    <form id="searchForm" action="../controllers/C_search.php" method="POST">
    <label>Genre :</label>
    <select name="genre">
        <option value="all">Tous</option>
        <option value="homme">Homme</option>
        <option value="femme">Femme</option>
    </select>

    <label>Âge min :</label>
    <input type="number" name="age_min" min="18" max="99">

    <label>Âge max :</label>
    <input type="number" name="age_max" min="18" max="99">

    <label>Localisation :</label>
    <input type="text" name="location">

    <div class="hobbies-section">
        <label for="hobbies">Loisirs :</label>
        <select name="hobbies[]" id="hobbies"  multiple>
            <?php
            require('../config/bd.php');
            $stmt = $pdo->query("SELECT id, name FROM hobbies");
            $hobbies = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($hobbies as $hobby) : ?>
                <option value="<?= $hobby['id']; ?>"><?= htmlspecialchars($hobby['name']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit">Rechercher</button>
</form>

</div>

<!-- Zone pour afficher les résultats -->
<div id="search-results">
</div>


    <!-- PROFILS À MATCHER -->
    <section class="match-section">
    <div id="profile-card" class="profile-card">
        <img id="profile-img" src="" alt="Photo de profil">
        <h2 id="profile-name"></h2>
        <p id="profile-info"></p>
        <p id="profile-age"></p>
        <div class="buttons">
            <button onclick="nextProfile(false)">❌ Non</button>
            <button onclick="nextProfile(true)">💖 Oui</button>
        </div>
    </div>
</section>

    <script src="script.js"></script>
</body>
</html>
