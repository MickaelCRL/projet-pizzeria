import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;

public class controllerPizza {

private OutilsJDBC o;
private ArrayList<pizza> pizzaList;

    public controllerPizza( OutilsJDBC o, ArrayList<pizza> pizzaList) {
        this.o = o;
        this.pizzaList = pizzaList;
    }

    public OutilsJDBC getO() {
        return o;
    }

    public void setO(OutilsJDBC o) {
        this.o = o;
    }

    public ArrayList<pizza> getPizzaList() {
        return pizzaList;
    }

    public void setPizzaList(ArrayList<pizza> pizzaList) {
        this.pizzaList = pizzaList;
    }

    
}
