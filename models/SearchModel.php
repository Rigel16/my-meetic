<?php
require('../config/bd.php');

function searchUsers($genre, $age_min, $age_max, $location, $hobbies) {
    global $pdo;
    $query = "SELECT u.*, 
                     TIMESTAMPDIFF(YEAR, u.date_of_birth, CURDATE()) AS age 
              FROM users u 
              LEFT JOIN user_hobbies uh ON u.id = uh.user_id 
              WHERE 1=1";
    $params = [];

    // Filtre par genre
    if ($genre !== "all") {
        $query .= " AND u.genre = ?";
        $params[] = $genre;
    }

    // Filtre par âge minimum
    if (!empty($age_min)) {
        $query .= " AND TIMESTAMPDIFF(YEAR, u.date_of_birth, CURDATE()) >= ?";
        $params[] = $age_min;
    }

    // Filtre par âge maximum
    if (!empty($age_max)) {
        $query .= " AND TIMESTAMPDIFF(YEAR, u.date_of_birth, CURDATE()) <= ?";
        $params[] = $age_max;
    }

    // Filtre par localisation
    if (!empty($location)) {
        $query .= " AND u.location LIKE ?";
        $params[] = "%$location%";
    }

    // Filtre par hobbies
    if (!empty($hobbies)) {
        $placeholders = implode(',', array_fill(0, count($hobbies), '?'));
        $query .= " AND uh.hobby_id IN ($placeholders)";
        $params = array_merge($params, $hobbies);
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
