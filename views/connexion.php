<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
        <div class="form-container" id="login-form">
        <img class="logo" src="../assets/QUEST.jpg" alt="">
            <h2>Connexion</h2>
            <?php if (isset($message)) : ?>
            <p><?php echo $message; ?></p>
            <?php endif; ?>
            <form method="POST" action="/index.php?action=connect">
                <input type="email" placeholder="Email" name="email" required>
                <input type="password" placeholder="Mot de passe" name="password" required>
                <button type="submit">Se connecter</button>
            </form>
            <p class="switch-form">Pas encore de compte? <a href="inscription.php">S'inscrire</a></p>
        </div>
</div>
</body>
</html>