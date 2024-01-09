import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;

/**
 * Classe pizza. Cette classe permet de créer les pizzas
 * qui seront ajoutés dans la liste des pizzas à préparer.
 * Chaque pizza a un compte à rebours associé qui permet au
 * pizzaiolo de savoir le temps de préparation qui lui reste
 * sans être en retard.
 */
public class pizza {
	private int id;
    private String nom;
    private String ingredients;
    private int quantiteAPreparer; 
    private  CompteARebours cab;

    /**
     * Constructeur de la classe pizza.
     * 
     * @param nom               Nom de la pizza
     * @param ingredients       Liste des ingrédients de la pizza
     * @param quantiteAPreparer Quantité de pizzas à préparer
     * @param cab               Compte à rebours de la pizza
     */
    public pizza(int id, String nom, String ingredients,int quantiteAPreparer, CompteARebours cab) {
    	this.id = id;
        this.nom = nom;
        this.ingredients = ingredients;
        this.quantiteAPreparer = quantiteAPreparer;
        this.cab = cab;
    }
    

    /**
     * Méthode qui permet de récupérer l'id de la pizza.
     * @return l'identifiant unique de la pizza
     */
    public int getId() {
        return id;
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
    public int getQuantiteAPreparer() {
        return quantiteAPreparer;
    }
    
    public void setQuantiteAPreparer(int nouvelleQuantiteAPreparer) {
    	this.quantiteAPreparer = nouvelleQuantiteAPreparer;
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
    
    
    public String getNomById(int id, OutilsJDBC o, Connection c) {
    	 ResultSet monResultat = o.exec1Requete("SELECT * FROM Pizza WHERE etatPizza=false", c, 0);
    	 try {
             while (monResultat.next()) {
            	 if(monResultat.getInt(1)== id) {
            		 return monResultat.getString(2);
            	 }
             }
             
    }catch (SQLException e) {
        System.out.println("Erreur conçernant le ResultSet");
        
    }
    return "";
}
}
