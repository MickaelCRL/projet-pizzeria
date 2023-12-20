import java.io.IOException;
import java.net.URLEncoder;
import java.nio.charset.StandardCharsets;
import org.apache.http.HttpEntity;
import org.apache.http.client.methods.CloseableHttpResponse;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.CloseableHttpClient;
import org.apache.http.impl.client.HttpClients;
import org.apache.http.util.EntityUtils;
import org.json.JSONObject;
import java.io.UnsupportedEncodingException;


public class test
 {
    public static void main(String[] args) {
        String origin = "Avenue des Sciences, Gif-sur-Yvette, 91190, France"; // Adresse de départ
        String destination = "20 bd Thomas Gobert, Palaiseau, 91120, France"; // Adresse d'arrivée
        String apiKey = "AIzaSyCezhZK0sYf1t0WMS_x-T9k0IBGR4soPQA"; // Remplacez par votre clé d'API Google Maps

        try {
            int travelTime = calculateTravelTime(origin, destination, apiKey);
            System.out.println("Le temps de trajet estimé est : " + travelTime + " minutes");
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    public static int calculateTravelTime(String origin, String destination, String apiKey) throws IOException {
        String encodedOrigin = URLEncoder.encode(origin, StandardCharsets.UTF_8);
        String encodedDestination = URLEncoder.encode(destination, StandardCharsets.UTF_8);

        String url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric" +
                "&origins=" + encodedOrigin +
                "&destinations=" + encodedDestination +
                "&key=" + apiKey;

        try (CloseableHttpClient httpClient = HttpClients.createDefault()) {
            HttpGet request = new HttpGet(url);
            try (CloseableHttpResponse response = httpClient.execute(request)) {
                HttpEntity entity = response.getEntity();
                if (entity != null) {
                    String jsonString = EntityUtils.toString(entity);
                    JSONObject jsonObject = new JSONObject(jsonString);

                    int travelTime = jsonObject.getJSONArray("rows")
                            .getJSONObject(0)
                            .getJSONArray("elements")
                            .getJSONObject(0)
                            .getJSONObject("duration")
                            .getInt("value") / 60; // Convertir le temps de trajet en minutes

                    return travelTime;
                }
            }
        }
        return -1; // Valeur par défaut si le calcul échoue
    }
}
