import java.util.ArrayList;

public class modelData {

     /**
     * Fonction pour supprimer une ligne du tableau.
     * Elle supprime la pizza de la liste des pizzas à préparer et met à jour le
     * tableau.
     * 
     * @param originalArray    tableau originel des pizzas à préparer
     * @param rowIndexToRemove ligne du tableau à supprimer
     * @return le tableau des pizzas à préparer sans la ligne supprimée
     */
    public String[][] removeRowFromData(String[][] originalArray, int rowIndexToRemove, ArrayList<pizza> pizzaList) {
        int idPizzaASupp = Integer.valueOf(originalArray[rowIndexToRemove][5]);
        // Supprimer la pizza de la liste des pizzas
        for (int i = 0; i < pizzaList.size(); i++) {
            if (pizzaList.get(i).getId() == idPizzaASupp) {
                pizzaList.remove(i);
            }
        }
        if (rowIndexToRemove >= 0 && rowIndexToRemove < originalArray.length) {
            String[][] newArray = new String[originalArray.length - 1][originalArray[0].length];
            int newIndex = 0;

            for (int i = 0; i < originalArray.length; i++) {
                if (i != rowIndexToRemove) {
                    newArray[newIndex++] = originalArray[i];
                }
            }

            return newArray;
        } else {
            // Si l'index est invalide, retournez le tableau original sans modification
            return originalArray;
        }
    }
    
}
