var choixPaiement = "";

function selectPayment(paymentType) {
  choixPaiement = paymentType;

  var response = confirm(
    "Confirmez-vous votre choix de paiement : " + choixPaiement + " ?"
  );
  if (response) {
    alert("Paiement confirmé");
    $.ajax({
      type: "POST",
      url: "../../actions/addModePaiement.php",
      data: { choixPaiement: choixPaiement },
    });
  } else {
    choixPaiement = "";
  }
}

function enregistrer() {
  enregistrerClique = true;
  alert("Informations enregistrées !");
}

var enregistrerClique = false;

function test2() {
  enregistrerClique = true;
  alert("Informations enregistrées !" + enregistrerClique);
}

function test(enregistrerClique) {
  if (enregistrerClique) {
    if (choixPaiement === "") {
      alert("Veuillez choisir un mode de paiement.");
    } else {
      alert("Commande confirmée avec " + choixPaiement);
      window.location.href =
        "https://projets.iut-orsay.fr/pizzeria/actions/creerCommande.php?";
    }
  } else {
    alert(
      "Veuillez enregistrer vos informations avant de confirmer la commande." +
        enregistrerClique
    );
  }
}
