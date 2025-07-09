<?php
$routes = [
    '/' => './views/home.php',       // URL: http://localhost/mon_projet/
    'home' => './views/home.php',       // URL: http://localhost/mon_projet/
    'about' => './views/about.php',   // URL: http://localhost/mon_projet/about
    'contact' => './views/contact.php', // URL: http://localhost/mon_projet/contact
    // Exemple de route avec un paramètre (à gérer avec des regex si vous voulez une solution plus robuste)
    // 'blog/{id}' => 'views/blog_detail.php', // Pour l'instant, ne sera pas matché directement
];