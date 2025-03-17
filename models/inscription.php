<?php
function add_user_to_db($data) {
    require('./config/bd.php');

    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $genre = $_POST['genre'];
    $date = $_POST['date'];
    $ville = $_POST['ville'];
    $hobbies = isset($_POST['hobbies']) ? $_POST['hobbies'] : [];

    // Vérifier si l'email est déjà utilisé
    $checkQuery = "SELECT * FROM users WHERE email = :email";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->bindParam(':email', $email);
    $checkStmt->execute();
    if ($checkStmt->fetch(PDO::FETCH_ASSOC)) {
        return "Cet email est déjà utilisé.";
    }

    // Gestion de l'upload de l'image
    $image_path = NULL;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = 'uploads/';

        // Créer le dossier s’il n'existe pas
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Nettoyer le nom du fichier pour éviter les problèmes
        $image_name = time() . '_' . preg_replace("/[^a-zA-Z0-9\._-]/", "_", basename($_FILES['image']['name']));
        $image_path = $upload_dir . $image_name;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
            return "Erreur lors de l'upload de l'image : " . $_FILES['image']['error'];
        }
    }

    // Insérer l'utilisateur dans la table "users"
    $query = "INSERT INTO users (firstname, lastname, email, password, genre, location, date_of_birth, image) 
              VALUES (:firstname, :lastname, :email, :password, :genre, :location, :date_of_birth, :image)";
    $res = $pdo->prepare($query);

    $res->bindParam(':firstname', $firstname);
    $res->bindParam(':lastname', $lastname);
    $res->bindParam(':email', $email);
    $res->bindParam(':password', $password);
    $res->bindParam(':genre', $genre);
    $res->bindParam(':location', $ville);
    $res->bindParam(':date_of_birth', $date);
    $res->bindParam(':image', $image_path);

    try {
        if ($res->execute()) {
            // Récupérer l'id de l'utilisateur inséré
            $user_id = $pdo->lastInsertId();

            // Ajouter l'image dans la session
            $_SESSION['user']['image'] = $image_path;  // Stocke l'image dans la session
            

            // Insérer les hobbies associés
            if (!empty($hobbies)) {
                $hobbyQuery = "INSERT INTO user_hobbies (user_id, hobby_id) VALUES (:user_id, :hobby_id)";
                $hobbyStmt = $pdo->prepare($hobbyQuery);

                foreach ($hobbies as $hobby_id) {
                    $hobbyStmt->bindParam(':user_id', $user_id);
                    $hobbyStmt->bindParam(':hobby_id', $hobby_id);
                    $hobbyStmt->execute();
                }
            }

            return "Inscription réussie !";
        } else {
            $errorInfo = $res->errorInfo();
            return "Erreur lors de l'inscription : " . $errorInfo[2];
        }
    } catch (PDOException $e) {
        return "Erreur SQL : " . $e->getMessage();
    }
}

?>
