<?php

// Détruire toutes les variables de session
$_SESSION = array();

// Effacer le cookie de session
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Détruire la session
session_destroy();

// Rediriger vers la page d'accueil
header("Location: ../view/vueAccueil.php");
exit();
?>
