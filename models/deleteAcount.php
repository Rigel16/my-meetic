<?php
require('../config/bd.php');

function deleteUser($user_id) {
    global $pdo;

    try {
        $stmt = $pdo->prepare("UPDATE users SET deleted_at = NOW() WHERE id = ?");
        $stmt->execute([$user_id]);
        return true;
    } catch (PDOException $e) {
        return "Erreur: " . $e->getMessage();
    }
}
?>
