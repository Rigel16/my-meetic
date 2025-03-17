<?php
// Routeur principal
if (isset($_GET['action']) && $_GET['action'] === 'register') {
    require("controllers/registrationController.php");
    do_user_exists();
} else if(isset($_GET['action']) && $_GET['action'] === 'connect') {
    require("controllers/connexion_success.php");
    succes();
}
else{
    header("location: views/connexion.php");
    exit();
}
