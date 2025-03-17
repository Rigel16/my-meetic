<?php
// Activer les erreurs PHP pour le debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Définir l'en-tête JSON AVANT toute sortie
header('Content-Type: application/json; charset=UTF-8');

// Inclure la connexion à la base de données
include('../config/bd.php'); // Vérifie que le chemin est correct !

try {
    // Sélectionner les informations de la table users, les hobbies de la table user_hobbies, et l'image de profil
    $stmt = $pdo->query("
        SELECT u.email, u.firstname, u.lastname, u.date_of_birth, u.location, u.image, 
               GROUP_CONCAT(h.name ORDER BY h.name ASC) AS hobbies
        FROM users u
        LEFT JOIN user_hobbies uh ON u.id = uh.user_id
        LEFT JOIN hobbies h ON uh.hobby_id = h.id
        GROUP BY u.id
    ");
    
    // Récupérer les résultats
    $profils = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Vérifier si des résultats existent et envoyer une réponse JSON propre
    echo json_encode(["profils" => $profils], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    echo json_encode(["error" => "Erreur SQL : " . $e->getMessage()]);
}
?>
