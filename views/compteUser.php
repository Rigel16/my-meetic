<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Utilisateur</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background: linear-gradient(120deg, #6a11cb, #2575fc);
            color: #fff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .profile-card {
            background: #fff;
            color: #333;
            width: 400px;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            overflow: hidden;
        }

        .profile-card .header {
            background: linear-gradient(120deg, #f093fb, #f5576c);
            padding: 50px 20px;
            border-radius: 15px 15px 0 0;
            position: relative;
        }

        .profile-card .header .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #fff;
            border: 5px solid #fff;
            position: absolute;
            bottom: -50px;
            left: 50%;
            transform: translateX(-50%);
            overflow: hidden;
        }

        .profile-card .header .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-card h2 {
            margin-top: 60px;
            font-size: 24px;
            color: #333;
        }

        .profile-card p {
            font-size: 16px;
            color: #666;
        }

        .profile-card .details {
            margin-top: 20px;
            text-align: left;
        }

        .profile-card .details li {
            margin: 10px 0;
            font-size: 16px;
            list-style: none;
        }

        .profile-card .details li strong {
            color: #333;
        }

        .profile-card button {
            margin-top: 20px;
            background: linear-gradient(120deg, #6a11cb, #2575fc);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .profile-card button:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        button a{
            text-decoration: none;
            color: white;
        }
        .edit-input {
    display: none;
    width: 80%;
    padding: 5px;
    margin-left: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
.btn-retour-accueil {
        position: absolute;
        right: 90%;
        top: 5%;
        background: linear-gradient(120deg, #f093fb, #f5576c);
        color: white;
        border-radius: 20px;
        padding: 15px 25px;
        border: none;
        cursor: pointer;
        font-size: 15px;
        font-weight: bold;
        z-index: 10;
        overflow: hidden;
    }





    </style>
</head>
<body>
<?php
require('../models/infoUser.php');
$user = user();
?>
        <button class="btn-retour-accueil" onclick="history.back();">
        ← Retour
        </button>
<form method="POST" action="../controllers/C_update.php">

<div class="profile-card">
        <div class="header">
        <div class="avatar">
                    <!-- Affichage de l'image de l'utilisateur -->
                    <img src="<?php echo "../".$user['image'] ; ?>" alt="Avatar" />
                    </div>
        </div>
        <h2>

        <?php echo htmlspecialchars($user['firstname']) . ' ' . htmlspecialchars($user['lastname']); ?></h2>
        <p>🟢</p>
        <ul class="details">
            <li><strong>Numéro de compte:</strong> <?php echo htmlspecialchars($user['id']); ?></li>
            <li>
            <strong>Nom:</strong>
            <span id="lastname-text"><?php echo htmlspecialchars($user['lastname']); ?></span>
            <input type="text" name="lastname" id="lastname-input" value="<?php echo htmlspecialchars($user['lastname']); ?>" style="display: none;">
            <a href="#" class="update" onclick="toggleEdit('lastname'); return false;">🖋️</a>
        </li>            
        <li>
            <strong>Prénom:</strong>
            <span id="firstname-text"><?php echo htmlspecialchars($user['firstname']); ?></span>
            <input type="text" name="firstname" id="firstname-input" value="<?php echo htmlspecialchars($user['firstname']); ?>" style="display: none;">
            <a href="#" class="update" onclick="toggleEdit('firstname'); return false;">🖋️</a>
        </li>           
        <li>
            <strong>Email:</strong>
            <span id="email-text"><?php echo htmlspecialchars($user['email']); ?></span>
            <input type="text" name="email" id="email-input" value="<?php echo htmlspecialchars($user['email']); ?>" style="display: none;">
            <a href="#" class="update" onclick="toggleEdit('email'); return false;">🖋️</a>
        </li>           
        <li>
            <strong>Genre:</strong>
            <span id="genre-text"><?php echo htmlspecialchars($user['genre']); ?></span>
            <select name="genre" id="genre-input" style="display: none;">
                <option value="Homme" <?php if ($user['genre'] == "Homme") echo "selected"; ?>>Homme</option>
                <option value="Femme" <?php if ($user['genre'] == "Femme") echo "selected"; ?>>Femme</option>
                <option value="Autre" <?php if ($user['genre'] == "Autre") echo "selected"; ?>>Autre</option>
            </select>
            <a href="#" class="update" onclick="toggleEdit('genre'); return false;">🖋️</a>
        </li>           
    <li><strong>Date de naissance:</strong> <?php echo date('d/m/Y', strtotime($user['date_of_birth'])); ?></li>
    <li>
            <strong>Location:</strong>
            <span id="location-text"><?php echo htmlspecialchars($user['location']); ?></span>
            <input type="text" name="location" id="location-input" value="<?php echo htmlspecialchars($user['location']); ?>" style="display: none;">
            <a href="#" class="update" onclick="toggleEdit('location'); return false;">🖋️</a>
        </li>          
    <li><strong>Loisirs:</strong> <?php echo htmlspecialchars(implode(", ", $user['hobbies'])); ?></li>
            </ul>
            <button type="submit">Enregistrer les modifications</button>
            <button><a href="../controllers/C_delete.php" onclick="confirmDelete()">Supprimer</a></button>
        <button><a href="../controllers/logout.php">Deconnexion</a></button>

    </div>
</form>
<script src="script.js"></script>
</body>
</html>
