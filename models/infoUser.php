<?php

function user(){
    session_start();
    
    if (!isset($_SESSION['user'])) {
        header('Location: ../views/connexion.php');
        exit();
    }

    // L'utilisateur est connecté, on peut récupérer ses données depuis la session
    $id = $_SESSION['user']['id'];
    $firstname = $_SESSION['user']['firstname'];
    $lastname = $_SESSION['user']['lastname'];
    $genre = $_SESSION['user']['genre'];
    $location = $_SESSION['user']['location'];
    $birth = $_SESSION['user']['date_of_birth'];
    $created = $_SESSION['user']['created_at'];
    $email = $_SESSION['user']['email'];

    // Si l'image est définie dans la session, on la récupère, sinon on utilise une image par défaut
    $image = isset($_SESSION['user']['image']) && !empty($_SESSION['user']['image']) 
            ? $_SESSION['user']['image'] 
            : '../assets/default-avatar.jpg';  // Image par défaut
            

    // Vérifier si les hobbies existent en session (évite une erreur si l'utilisateur n'en a pas)
    $hobbies = isset($_SESSION['user']['hobbies']) ? $_SESSION['user']['hobbies'] : [];

    return [
        'id' => $id,
        'firstname' => $firstname,
        'lastname' => $lastname,
        'genre' => $genre,
        'location' => $location,
        'date_of_birth' => $birth,
        'created_at' => $created,
        'hobbies' => $hobbies,
        'image' => $image, // L'image est maintenant définie ou par défaut,
        'email' => $email 
    ];
}

?>
