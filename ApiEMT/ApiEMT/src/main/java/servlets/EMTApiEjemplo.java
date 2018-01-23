/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package servlets;

import com.google.api.client.http.EmptyContent;
import com.google.api.client.http.GenericUrl;
import com.google.api.client.http.HttpRequest;
import com.google.api.client.http.HttpRequestFactory;
import com.google.api.client.http.HttpRequestInitializer;
import com.google.api.client.http.HttpTransport;
import com.google.api.client.http.UrlEncodedContent;
import com.google.api.client.http.javanet.NetHttpTransport;
import com.google.api.client.json.JsonFactory;
import com.google.api.client.json.GenericJson;
import com.google.api.client.json.JsonObjectParser;
import com.google.api.client.json.jackson2.JacksonFactory;
import com.google.api.client.util.ArrayMap;
import com.google.api.client.util.GenericData;
import java.io.IOException;
import java.io.PrintWriter;
import java.util.ArrayList;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import model.Arrives;

/**
 *
 * @author IvanGarGal
 */
@WebServlet(name = "EMTApi", urlPatterns = {"/api"})
public class EMTApiEjemplo extends HttpServlet {

    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
        throws ServletException, IOException {
        //------------------------------------------------------------------------------------
        //String action = request.getParameter(lineas);
        HttpTransport HTTP_TRANSPORT = new NetHttpTransport();
        JsonFactory JSON_FACTORY = new JacksonFactory();
        HttpRequestFactory requestFactory
          = HTTP_TRANSPORT.createRequestFactory(new HttpRequestInitializer() {
              @Override
              public void initialize(HttpRequest request) {
        //          request.setParser(new JsonObjectParser(JSON_FACTORY));
              }
          });
        //------------------------------------------------------------------------------------
        // Mandarle los datos por POST (EMT me exige mandarle los datos por POST)
        GenericUrl url = new GenericUrl("https://openbus.emtmadrid.es:9443/emt-proxy-server/last/geo/GetArriveStop.php");
        //GenericUrl url = new GenericUrl("https://openbus.emtmadrid.es:9443/emt-proxy-server/last/bus/GetListLines.php");
        //GenericUrl url = new GenericUrl("https://openbus.emtmadrid.es:9443/emt-proxy-server/last/bus/GetRouteLines.php");

        GenericData data = new GenericData();
        data.put("idClient", "WEB.SERV.guardar.archivos.importantes@gmail.com ");
        data.put("passKey", "3B72E366-3D6C-45BA-AE93-01A692D8658E");
        data.put("idStop", "3727");
        HttpRequest requestGoogle = requestFactory.buildPostRequest(url, new UrlEncodedContent(data));
        //------------------------------------------------------------------------------------
        
        // Mandarle los datos por GET (Aplicación de Fútbol)
        
        /*
            GenericUrl url = new GenericUrl("http://api.football-data.org/v1/competitions/");
            url.set("season", "2017");
        
            HttpRequest requestGoogle = requestFactory.buildGetRequest(url);
        */
        
        // La aplicación de fútbol me obliga a mandarle los datos mediante una cabecera
        
        /*
            requestGoogle.getHeaders().set("X-Auth-Token", "2deee83e549c4a6e9709871d0fd58a0a");      
        */
        
        // Cuando lo ejecute, me manda una cadena String ( mediante HttpResponse ) ( A la acción de mandarme una cadena se llama "parsear" )
        /*
            
            HttpResponse responseee =requestGoogle.execute();
        */
        
        // Lo muestro por pantalla
        /*
            response.getWriter().print(responseee.parseAsString());
        */
        
       //
       /*
            Type type = new TypeToken<List<GenericJson>>() {}.getType();
       */
        /*
       // Imprimir un lista de objetos por pantalla
        HttpResponse responseee =requestGoogle.execute();
          
        response.getWriter().print(responseee.parseAsString());
       
       */
        /*
        // Imprimir un objeto por pantalla
        HttpResponse responseee =requestGoogle.execute();
        Type type = new TypeToken<List<GenericJson>>() {}.getType(); 
        List<GenericJson> json = (List) responsee.parseAs(type);
        response.getWriter().print(json.get(0).toPrettyString());
        */
        //------------------------------------------------------------------------------------
        
    }

    // <editor-fold defaultstate="collapsed" desc="HttpServlet methods. Click on the + sign on the left to edit the code.">
    /**
     * Handles the HTTP <code>GET</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    /**
     * Handles the HTTP <code>POST</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    /**
     * Returns a short description of the servlet.
     *
     * @return a String containing servlet description
     */
    @Override
    public String getServletInfo() {
        return "Short description";
    }// </editor-fold>

}
