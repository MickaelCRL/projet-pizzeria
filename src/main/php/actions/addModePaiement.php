<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['choixPaiement'])) {
    $choixPaiement = $_POST['choixPaiement'];
    $_SESSION['modePaiement'] = $choixPaiement;
}

header('Location: ../view/vuePaiement.php');
exit();
?>