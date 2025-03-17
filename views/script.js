function validateAge() {
    const birthDate = new Date(document.getElementsByName('date')[0].value);
    const today = new Date();
    const age = today.getFullYear() - birthDate.getFullYear();
    const month = today.getMonth() - birthDate.getMonth();
    if (month < 0 || (month === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    if (age < 18) {
        alert("Vous devez avoir au moins 18 ans pour vous inscrire.");
        return false;
    }
    return true;
}

// Menu burger pour la recherche
function toggleMenu() {
    let menu = document.getElementById("search-menu");
    if (menu.style.display === "block") {
        menu.style.display = "none";
    } else {
        menu.style.display = "block";
    }
}

document.addEventListener("DOMContentLoaded", function () {
    fetchProfiles();
});

function fetchProfiles() {
    fetch("../models/getProfil.php") // Vérifie le chemin
        .then(response => response.text()) // Récupère le texte brut
        .then(text => {
            console.log("Réponse brute du serveur:", text); 

            try {
                const data = JSON.parse(text); // Convertit en JSON
                if (data.error) {
                    console.error("Erreur:", data.error);
                } else if (!data.profils || data.profils.length === 0) {
                    console.log("Aucun profil trouvé.");
                } else {
                    displayProfile(data.profils); // On passe le tableau de profils
                }
            } catch (error) {
                console.error("Erreur JSON:", error);
            }
        })
        .catch(error => console.error("Erreur lors de la récupération des profils:", error));
}

let currentIndex = 0;
let profiles = [];
document.addEventListener("DOMContentLoaded", function () {
    fetchProfiles();
});

function fetchProfiles() {
    fetch("../models/getProfil.php")
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error("Erreur:", data.error);
            } else {
                displayProfile(data.profils);
            }
        })
        .catch(error => console.error("Erreur lors de la récupération des profils:", error));
}

document.addEventListener("DOMContentLoaded", function () {
    fetchProfiles();
});

function fetchProfiles() {
    fetch("../models/getProfil.php") 
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error("Erreur:", data.error);
            } else {
                displayProfile(data.profils);
            }
        })
        .catch(error => console.error("Erreur lors de la récupération des profils:", error));
}


function displayProfile(profils) {
    profiles = profils; // Stocker tous les profils
    showCurrentProfile();
}

function showCurrentProfile() {
    if (profiles.length === 0 || currentIndex >= profiles.length) {
        document.querySelector(".match-section").innerHTML = "<p>Aucun profil disponible.</p>";
        return;
    }

    let profile = profiles[currentIndex];
    document.getElementById("profile-name").textContent = `${profile.firstname} ${profile.lastname}`;
    document.getElementById("profile-info").textContent = `📍 ${profile.location} | 🎨 ${profile.hobbies}`;

    // Affichage de l'image de profil
let imageUrl = profile.image ? `../${profile.image}` : "default.jpg"; // Utilise le chemin complet depuis uploads ou une image par défaut
document.getElementById("profile-img").src = imageUrl;


    let age = calculateAge(profile.date_of_birth);
    document.getElementById("profile-age").textContent = `${age} ans`;
}

function calculateAge(dateOfBirth) {
    const birthDate = new Date(dateOfBirth);
    const today = new Date();
    let age = today.getFullYear() - birthDate.getFullYear();
    const month = today.getMonth();
    if (month < birthDate.getMonth() || (month === birthDate.getMonth() && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}

function nextProfile(liked) {
    console.log(liked ? "❤️ Match avec" : "❌ Rejet de", profiles[currentIndex].firstname);
    currentIndex++;

    if (currentIndex < profiles.length) {
        document.getElementById("profile-card").classList.add(liked ? "slide-right" : "slide-left");

        setTimeout(() => {
            document.getElementById("profile-card").classList.remove("slide-right", "slide-left");
            showCurrentProfile();
        }, 600); // Correspond au temps de l'animation CSS
    } else {
        document.querySelector(".match-section").innerHTML = "<p class='no-profiles'>Plus de profils à afficher.</p>";
    }
}

// pour modifier 
    function toggleEdit(field) {
        let textElement = document.getElementById(field + "-text");
        let inputElement = document.getElementById(field + "-input");

        if (inputElement.style.display === "none") {
            textElement.style.display = "none"; // Cache le texte
            inputElement.style.display = "inline-block"; // Affiche l'input
            inputElement.focus(); // Focus sur l'input
        } else {
            textElement.style.display = "inline"; // Affiche le texte
            inputElement.style.display = "none"; // Cache l'input
        }
    }


    function confirmDelete() {
        let confirmation = confirm("Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.");
        if (confirmation) {
            window.location.href = '../controllers/C_delete.php?action=delete';
        }
    }

    
