<?php

require 'route.php';

// Récupérer l'URI de la requête.
// $_SERVER['REQUEST_URI'] contient le chemin complet (ex: /test_route/about?param=value)
$requestUri = $_SERVER['REQUEST_URI'];

// Parser l'URL pour n'obtenir que le chemin (sans les paramètres GET)
$requestPath = parse_url($requestUri, PHP_URL_PATH);

// Important pour WampServer:
// Si votre projet est dans un sous-répertoire de www (ex: C:\wamp64\www\test_route),
// $requestPath contiendra /test_route/votre_route.
// Nous devons retirer le chemin de base du projet.
// Assurez-vous que '$basePath' correspond au nom de votre dossier de projet dans 'www'.
$basePath = '/test_route'; // <<< REMPLACEZ 'test_route' PAR LE NOM DE VOTRE DOSSIER DE PROJET

// Supprimer le basePath du début de l'URI et nettoyer les slashes.
if (strpos($requestPath, $basePath) === 0) {
    $requestPath = substr($requestPath, strlen($basePath));
}
$requestPath = trim($requestPath, '/'); // Supprime les slashes en début et fin

// Si le chemin nettoyé est vide, c'est la racine de votre application
if (empty($requestPath)) {
    $requestPath = '/';
}

// --- Définition de vos routes ---
// Un tableau associatif simple pour mapper les chemins aux actions (fichiers, fonctions, etc.)


// --- Logique de routage ---
$foundRoute = false;
foreach ($routes as $routePattern => $actionFile) {
    // Pour les routes simples sans paramètres
    if ($requestPath === $routePattern) {
        $foundRoute = true;
        $filePath = __DIR__ . '/' . $actionFile; // Chemin absolu vers le fichier
        if (file_exists($filePath)) {
            require $filePath;
            break; // Arrête la boucle une fois la route trouvée et traitée
        } else {
            // Gérer le cas où le fichier d'action n'existe pas
            http_response_code(500);
            echo "<h1>Erreur interne du serveur</h1><p>Le fichier de route '$actionFile' est introuvable.</p>";
            exit;
        }
    }
}

// --- Gestion de la page 404 (non trouvée) ---
if (!$foundRoute) {
    http_response_code(404); // Définit le code de statut HTTP 404
    require __DIR__ . '/views/404.php'; // Incluez votre page 404
}

?>