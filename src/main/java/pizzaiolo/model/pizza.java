/**
 * Classe pizza. Cette classe permet de créer les pizzas
 * qui seront ajoutés dans la liste des pizzas à préparer.
 * Chaque pizza a un compte à rebours associé qui permet au
 * pizzaiolo de savoir le temps de préparation qui lui reste
 * sans être en retard.
 */
public class pizza {
    private String nom;
    private String ingredients;
    private String quantiteAPreparer;
    private CompteARebours cab;

    /**
     * Constructeur de la classe pizza.
     * 
     * @param nom               Nom de la pizza
     * @param ingredients       Liste des ingrédients de la pizza
     * @param quantiteAPreparer Quantité de pizzas à préparer
     * @param cab               Compte à rebours de la pizza
     */
    public pizza(String nom, String ingredients, String quantiteAPreparer, CompteARebours cab) {
        this.nom = nom;
        this.ingredients = ingredients;
        this.quantiteAPreparer = quantiteAPreparer;
        this.cab = cab;
    }

    /**
     * Méthode qui permet de récupérer le nom de la pizza.
     * @return Le nom de la pizza
     */
    public String getNom() {
        return nom;
    }

    /**
     * Méthode qui permet de récupérer la liste des ingrédients de la pizza.
     * @return La liste des ingrédients de la pizza
     */
    public String getIngredients() {
        return ingredients;
    }

    /**
     * Méthode qui permet de récupérer la quantité de pizzas à préparer.
     * @return La quantité de pizzas à préparer
     */
    public String getQuantiteAPreparer() {
        return quantiteAPreparer;
    }

    /**
     * Méthode qui permet de récupérer le compte à rebours de la pizza.
     * @return Le compte à rebours de la pizza
     */
    public CompteARebours getCab() {
        return cab;
    }

    /**
     * Méthode qui permet de modifier le nom de la pizza.
     * @param nom Le nouveau nom de la pizza
     */
    public void setCab(CompteARebours cab2) {
        this.cab = cab2;
    }
}
