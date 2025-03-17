<?php
require('../models/searchModel.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $genre = $_POST['genre'] ?? "all";
    $age_min = $_POST['age_min'] ?? null;
    $age_max = $_POST['age_max'] ?? null;
    $location = trim($_POST['location'] ?? "");
    $hobbies = $_POST['hobbies'] ?? [];

    // Appeler la fonction de recherche
    $results = searchUsers($genre, $age_min, $age_max, $location, $hobbies);

    if (empty($results)) {
        echo "<p>Aucun résultat trouvé.</p>";
    } else {
        foreach ($results as $user) {
            $age = calculateAge($user['date_of_birth']);
                        $userHobbies = isset($user['hobbies']) && is_array($user['hobbies']) ? $user['hobbies'] : [];
            $hobbiesList = !empty($userHobbies) ? implode(", ", $userHobbies) : "Aucun hobby renseigné"; // Affichage d'un message par défaut si aucun hobby

            echo "
            <div class='profile-card'>
                <img src='../{$user['image']}' alt='Photo de profil' width='100'>
                <h3>{$user['firstname']} {$user['lastname']}, {$age} ans</h3>
                <p>📍 {$user['location']}</p>
                <p>🎨 Hobbies : {$hobbiesList}</p>
                <div class='match-buttons'>
                    <button onclick='matchProfile(true)'>💖 Oui</button>
                    <button onclick='matchProfile(false)'>❌ Non</button>
                </div>
            </div>";
        }
    }
}

function calculateAge($dateOfBirth) {
    $birthDate = new DateTime($dateOfBirth);
    $today = new DateTime();
    $age = $today->diff($birthDate)->y;
    return $age;
}
?>
