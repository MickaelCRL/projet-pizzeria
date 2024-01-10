function addPanier(enregistrerClique) {
  if (enregistrerClique) {
    window.location.href =
      "https://projets.iut-orsay.fr/pizzeria/actions/ajoutPizzaPersonaliserPanier.php?";
  } else {
    alert(
      "Veuillez enregistrer vos modification avant d'ajouter au panier." +
        enregistrerClique
    );
  }
}
