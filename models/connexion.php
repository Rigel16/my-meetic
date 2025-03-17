<?php
function connect($data) {
    session_start();
    require('./config/bd.php');

    // Vérifier et nettoyer l'entrée utilisateur
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $password = trim($_POST['password']);

    if (!$email || !$password) {
        return "echec";
    }

    $query = "SELECT email, id, firstname, lastname, genre, location, date_of_birth, created_at, password, image, deleted_at
            FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user['deleted_at'] !== NULL) {
            return "supprime";
        }

        if (password_verify($password, $user['password'])) {
            $queryHobbies = "SELECT hobbies.name 
            FROM hobbies 
            JOIN user_hobbies ON hobbies.id = user_hobbies.hobby_id 
            WHERE user_hobbies.user_id = :user_id";
            $stmtHobbies = $pdo->prepare($queryHobbies);
            $stmtHobbies->bindValue(':user_id', $user['id'], PDO::PARAM_INT);
            $stmtHobbies->execute();
            $hobbies = $stmtHobbies->fetchAll(PDO::FETCH_COLUMN);

            // Stocker les informations de l'utilisateur en session, y compris l'image
            $_SESSION['user'] = [
                'id' => $user['id'],
                'firstname' => $user['firstname'],
                'lastname' => $user['lastname'],
                'genre' => $user['genre'],
                'location' => $user['location'],
                'date_of_birth' => $user['date_of_birth'],
                'created_at' => $user['created_at'],
                'image' => $user['image'],
                'hobbies' => $hobbies,
                'email' => $user['email']
            ];

            return "reussi";
        } else {
            return "echec";
        }
    }

    return "echec";
}
?>
