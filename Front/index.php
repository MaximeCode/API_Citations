<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96"/>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg"/>
    <link rel="shortcut icon" href="/favicon.ico"/>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png"/>
    <meta name="apple-mobile-web-app-title" content="Citations.com"/>
    <link rel="manifest" href="/site.webmanifest"/>
</head>

<body class="container my-5">

<div id="insert" class="card p-4">
    <!-- Formulaire pour ajouter une citation -->
    <h2 class="card-title">Ajouter une citation :</h2>
    <form id="myForm">
        <div class="mb-3">
            <label for="contenu" class="form-label">Citation :</label>
            <textarea id="contenu" name="contenu" class="form-control" rows="4" cols="50" required></textarea>
        </div>
        <div class="mb-3">
            <label for="auteur" class="form-label">Auteur :</label>
            <input type="text" id="auteur" name="auteur" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date :</label>
            <input type="date" id="date" name="date" class="form-control" required>
        </div>
        <input type="submit" value="Ajouter" class="btn btn-primary">
    </form>
</div>

<div id="citations" class="mt-5">
    <!-- Les citations seront affichées ici -->
</div>

<script src="./app.js"></script>
<script src="./sw.js"></script>

<script>
    // Fonction pour appeler l'API et afficher les citations
    async function afficherCitations() {
        try {
            // Appel de l'API pour récupérer les citations
            const response = await fetch("https://api_citation.test/Back/get_citations.php");
            console.table(response);

            // Vérifie si la requête a réussi
            if (!response.ok) {
                throw new Error("Erreur lors de la récupération des données");
            }

            // Conversion des données en JSON
            const citations = await response.json();
            console.log(citations); // Afficher les citations

            // Sélection de l'élément HTML où afficher les citations
            const citationsDiv = document.getElementById('citations');

            // Initialisation d'une chaîne HTML pour stocker les citations
            let contenuHTML = "<h2 class='mb-4'>Liste des Citations :</h2>";

            // Boucle pour parcourir les citations et les ajouter au contenu HTML
            citations.forEach(citation => {
                contenuHTML += `
                <div class="citation mb-3 p-3 border rounded">
                    <p class="mb-1">"${citation.contenu}"</p>
                    <p class="mb-0"><strong>— ${citation.auteur}</strong>, le ${citation.date}</p>
                </div>`;
            });

            // Insertion du contenu HTML dans la div des citations
            citationsDiv.innerHTML = contenuHTML;
        } catch (error) {
            console.error("Erreur:", error);
        }
    }


    // Écouteur d'événements pour le formulaire
    document.getElementById('myForm').addEventListener('submit', async function (event) {
        event.preventDefault(); // Empêcher le rechargement de la page

        // Récupération des données du formulaire
        const formData = new FormData(this);
        const data = {};

        // Conversion des données du formulaire en objet
        formData.forEach((value, key) => {
            data[key] = value;
        });
        console.table(data);

        // Envoi des données au format JSON
        try {
            const response = await fetch("https://api_citation.test/Back/get_citations.php", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data) // Conversion de l'objet en JSON
            });

            if (!response.ok) {
                throw new Error('Erreur lors de l\'envoi des données');
            }

            const jsonResponse = await response.json();
            console.log(jsonResponse); // Afficher la réponse du serveur

            // Optionnel : Réinitialiser le formulaire
            this.reset();
        } catch (error) {
            console.error('Erreur:', error);
        }
    });

    // Appel de la fonction pour afficher les citations au chargement de la page
    afficherCitations();
</script>
</body>

</html>