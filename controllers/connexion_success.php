<?php
require("./models/connexion.php");
function succes(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message= connect($_POST);
    if ($message === "reussi") {
        header("Location: controllers/control_infoUser.php");
        exit();
    }else {
        header("Location: ./views/failureConnexion.php" );
        exit();
    }
    }else {
        require("./views/inscription.php");
    }
}