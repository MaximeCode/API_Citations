<?php

switch ($_SERVER['REQUEST_METHOD']) {
  case 'POST':
    // Récupérer les données du formulaire
    $contenu = $_POST['contenu'] ?? '';
    $auteur = $_POST['auteur'] ?? '';
    $date = $_POST['date'] ?? '';

    // Vérifier si les données sont valides
    if (!empty($contenu) && !empty($auteur) && !empty($date)) {
      // Ajouter la nouvelle citation
      $citations[] = [
        'contenu' => $contenu,
        'auteur' => $auteur,
        'date' => $date
      ];

      // Envoyer les citations au format JSON
      header('Content-Type: application/json');
      echo json_encode($citations);
    } else {
      // Envoyer un message d'erreur
      header('HTTP/1.1 400 Bad Request');
      echo json_encode(['message' => 'Veuillez remplir tous les champs']);
    }
    break;
  default:
    // Envoyer un message d'erreur pour les autres méthodes
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['message' => 'Méthode non autorisée']);
}
