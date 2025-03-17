<?php
session_start();
require('../models/updateProfile.php');
require('../models/infoUser.php');

$user = user(); 
$user_id = $user['id'];
$lastname = trim($_POST['lastname']);
$firstname = trim($_POST['firstname']);
$genre = trim($_POST['genre']);
$location = trim($_POST['location']);
$email = trim($_POST['email']);

$result = updateUser($email,$user_id, $lastname, $firstname, $genre, $location);

if ($result === true) {
    $_SESSION['user']['email'] = $email;
    $_SESSION['user']['lastname'] = $lastname;
    $_SESSION['user']['firstname'] = $firstname;
    $_SESSION['user']['genre'] = $genre;
    $_SESSION['user']['location'] = $location;
    $_SESSION['success_message'] = "Votre profil a été mis à jour avec succès !";
} else {
    $_SESSION['error_message'] = $result;
}

header("Location: ../views/compteUser.php");
exit;
?>
