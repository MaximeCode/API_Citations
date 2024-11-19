<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// En-tête de la réponse pour spécifier le format JSON
header('Content-Type: application/json');

// Inclure la connexion à la base de données
require_once(__DIR__ . '/db.php');

function date_now()
{
    $date = new DateTime();
    return $date->format('Y-m-d H:i:s');
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Récupérer les citations
        $stmt = $pdo->query('SELECT * FROM Citations ORDER BY date DESC');
        $citations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Retourner les citations au format JSON
        echo json_encode($citations);
        break;

    case 'POST':
        // Récupérer les données envoyées en JSON
        $data = json_decode(file_get_contents('php://input'), true);


        // Vérifier que les données sont valides
        if (isset($data['auteur'])) {


            // Préparer la requête d'insertion
            $stmt = $pdo->prepare('INSERT INTO Citations (contenu, auteur, date) VALUES (:contenu, :auteur, :date)');
            //BindParam
            $stmt->bindParam(':contenu', $data['contenu']);
            $stmt->bindParam(':auteur', $data['auteur']);
//            $stmt->bindParam(':date', $data['date']);
            $date = date_now();
            $stmt->bindParam(':date', $date);
            // Exécuter la requête d'insertion
            $stmt->execute();

            // Retourner un message de succès
            echo json_encode(['message' => 'Citation ajoutée avec succès']);

            // attendre 5 secondes puis redirection vers localhost :8000
//            header("refresh:5;url=http://localhost:8000");
        } else {
            // Retourner un message d'erreur
            echo json_encode(['error' => 'Données invalides']);
        }
        break;
    default:
        // Retourner une erreur pour les méthodes non autorisées
        http_response_code(405);
        echo json_encode(['error' => 'Méthode non autorisée']);
        break;
}

?>