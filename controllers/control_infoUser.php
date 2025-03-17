<?php
require('../models/infoUser.php');
function get_user_info() {
    session_start();
// Vérifier si l'utilisateur est connecté        
        if (isset($_SESSION['user'])) {
            header('Location: ../views/accueil_connexion.php');
            exit();
        }
        else {
            header('Location: ../views/connexion.php');
            exit();        
        }

}
get_user_info();

