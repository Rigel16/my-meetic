<?php
require("./models/inscription.php");

function do_user_exists() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Appeler la fonction du modèle pour inscrire l'utilisateur
        $message = add_user_to_db($_POST);

        // Vérifier le message renvoyé par le modèle
        if ($message === "Inscription réussie !") {
            // Rediriger vers la page de succès
            header("Location: ./views/confirmation_inscription.php");
            exit();
        } else if($message === "Cet email est déjà utilisé.") {
            // Rediriger vers la page d'échec
            header("Location: ./views/mail_existing.php" );
            exit();
        }else {
            // Rediriger vers la page d'échec
            header("Location: ./views/failureConnexion.php" );
            exit();
        }
    } else {
        // Si on accède à la page sans soumettre le formulaire, afficher la vue d'inscription
        require("./views/inscription.php");
    }
}
