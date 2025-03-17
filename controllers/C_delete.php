<?php
session_start();
require('../models/deleteAcount.php');

if (!isset($_SESSION['user']['id'])) {
    header("Location: ../views/connexion.php");
    exit();
}

// Vérifier si l'action de suppression est demandée
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $user_id = $_SESSION['user']['id'];
    $result = deleteUser($user_id);

    if ($result === true) {
        session_destroy();
        header("Location: ../views/connexion.php?message=Compte supprimé avec succès");
        exit();
    } else {
        $_SESSION['error_message'] = $result;
        header("Location: ../views/compteUser.php");
        exit();
    }
}
?>
