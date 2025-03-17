<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Rencontre - Connexion & Inscription</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
</head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#hobbies').select2({
            placeholder: "Sélectionnez vos loisirs",
            allowClear: true
        });
    });
</script>

<body>
    <div class="container">
        <div class="form-container" id="register-form">
            <img class="logo" src="../assets/QUEST.jpg" alt="">
            <h2>Inscription</h2>
            <?php if (isset($message)) : ?>
            <p><?php echo $message; ?></p>
            <?php endif; ?>
            <form method="POST" action="/index.php?action=register" enctype="multipart/form-data" onsubmit="return validateAge()">
                <input type="text" placeholder="Nom" name="firstname" required>
                <input type="text" placeholder="Prénom" name="lastname" required>
                <input type="email" placeholder="Email" name="email" required>
                <select name="genre" required>
                    <option value="" disabled selected>--Genre--</option>
                    <option value="homme">Homme</option>
                    <option value="femme">Femme</option>
                    <option value="autre">Autre</option>
                </select>
                <input type="date" placeholder="Date de naissance" name="date" required>
                <input type="text" placeholder="Ville" name="ville" required>
                <input type="password" placeholder="Mot de passe" name="password" required>

                <label for="image">Photo de profil :</label>
                <input type="file" name="image" accept="image/*" required>
                <div class="hobbies-section">
            <label for="hobbies">Loisirs :</label>
            <select name="hobbies[]" id="hobbies"  required multiple>
                <?php
                require('../config/bd.php');
                $stmt = $pdo->query("SELECT id, name FROM hobbies");
                $hobbies = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($hobbies as $hobby) : ?>
                    <option value="<?= $hobby['id']; ?>"><?= htmlspecialchars($hobby['name']); ?></option>
                <?php endforeach; ?>
            </select>
</div>


                <button type="submit">S'inscrire</button>
            </form>
            <p class="switch-form">Déjà un compte? <a href="connexion.php">Se connecter</a></p>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
