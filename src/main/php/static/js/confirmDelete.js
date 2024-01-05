function confirmDelete() {
    var response = confirm("Êtes-vous sûr de vouloir supprimer votre compte ?");
    if (response) {
        // Si l'utilisateur clique sur OK, redirigez-le vers la page de suppression
        window.location.href = "../actions/deleteCompte.php";
    } else {}
}