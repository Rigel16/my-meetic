<?php
$serveur = "localhost";
$utilisateur = "root";
$motDePasse = "root";
$baseDeDonnees = "meetic";
$port = 8889;

// Spécifie le chemin du socket
$socket = "/Applications/MAMP/tmp/mysql/mysql.sock";

try {
    // Chaîne de connexion PDO (DSN)
    $dsn = "mysql:host=$serveur;dbname=$baseDeDonnees;port=$port;unix_socket=$socket";

    // Création de l'objet PDO
    $pdo = new PDO($dsn, $utilisateur, $motDePasse);

    // Configure PDO pour afficher les erreurs
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "Connexion réussie à la base de données.\n";

} catch (PDOException $e) {
    // Gestion des erreurs
    die("Échec de la connexion : " . $e->getMessage());
}

// Fermeture explicite de la connexion (facultatif, PDO se ferme automatiquement en fin de script)
$connexion = null;
?>