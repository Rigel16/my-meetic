<?php
require('../config/bd.php');

function updateUser($email, $user_id, $lastname, $firstname, $genre, $location) {
    global $pdo;

    try {
        $stmt = $pdo->prepare("UPDATE users SET email = ?, lastname = ?, firstname = ?, genre = ?, location = ? WHERE id = ?");
        $stmt->execute([$email , $lastname, $firstname, $genre, $location, $user_id]);
        return true;
    } catch (PDOException $e) {
        return "Erreur: " . $e->getMessage();
    }
}
?>
