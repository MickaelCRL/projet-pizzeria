var choixPaiement = "";

function selectPayment(paymentType) {
  choixPaiement = paymentType;

  var response = confirm(
    "Confirmez-vous votre choix de paiement : " + choixPaiement + " ?"
  );
  if (response) {
    alert("Paiement confirmé");
  } else {
    choixPaiement = "";
  }
}

function confirmCommande() {
  if (choixPaiement === "") {
    alert("Veuillez choisir un mode de paiement.");
  } else {
    alert("Commande confirmé " + choixPaiement);
  }
}
