<?

require_once("../config/connexion.php");

function calculerPrix($id)
{
    connexion::connect();
    $pdo = connexion::pdo();
    $requete2 = "SELECT calculerPrixPizza($id) AS prix";
    $resultat2 = $pdo->query($requete2);
    $row2 = $resultat2->fetch(PDO::FETCH_ASSOC);
    $prix = htmlspecialchars($row2['prix']);
    echo "<p class='pizza-price'>$prix €</p>";
}
?>