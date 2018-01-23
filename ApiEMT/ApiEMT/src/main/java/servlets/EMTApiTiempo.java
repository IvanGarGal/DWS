/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package servlets;

import com.google.api.client.http.GenericUrl;
import com.google.api.client.http.HttpRequest;
import com.google.api.client.http.HttpRequestFactory;
import com.google.api.client.http.HttpRequestInitializer;
import com.google.api.client.http.HttpTransport;
import com.google.api.client.http.UrlEncodedContent;
import com.google.api.client.http.javanet.NetHttpTransport;
import com.google.api.client.json.GenericJson;
import com.google.api.client.json.JsonFactory;
import com.google.api.client.json.JsonObjectParser;
import com.google.api.client.json.jackson2.JacksonFactory;
import com.google.api.client.util.GenericData;
import java.io.IOException;
import java.io.PrintWriter;
import java.util.ArrayList;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

/**
 *
 * @author IvanGarGal
 */
@WebServlet(name = "EMTApiTiempo", urlPatterns = {"/EMTApiTiempo"})
public class EMTApiTiempo extends HttpServlet {

    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
        throws ServletException, IOException {
        
        //Recibe los datos que le he enviado por la URL escrita en lines.jsp
        //localhost:8080/ApiEMT/EMTApiParadas?line=${line.line}
        String stop = request.getParameter("stop");
        
        //Este apartado se pone siempre
        //------------------------------------------------------------------------------------
        HttpTransport HTTP_TRANSPORT = new NetHttpTransport();
        final JsonFactory JSON_FACTORY = new JacksonFactory();
        HttpRequestFactory requestFactory
          = HTTP_TRANSPORT.createRequestFactory(new HttpRequestInitializer() {
              @Override
              public void initialize(HttpRequest request) {
                  request.setParser(new JsonObjectParser(JSON_FACTORY));
              }
          });
        //------------------------------------------------------------------------------------
        
        // Mandarle los datos por POST (EMT me exige mandarle los datos por POST)
        GenericUrl url = new GenericUrl("https://openbus.emtmadrid.es:9443/emt-proxy-server/last/geo/GetArriveStop.php");

        GenericData data = new GenericData();
        //Introduzco los datos del request de GetListLines
        data.put("idClient", "WEB.SERV.guardar.archivos.importantes@gmail.com ");
        data.put("passKey", "3B72E366-3D6C-45BA-AE93-01A692D8658E");
        data.put("idStop",stop);
        data.put("statistics","");
        data.put("cultureInfo","ES");

        HttpRequest requestGoogle = requestFactory.buildPostRequest(url, new UrlEncodedContent(data));
        GenericJson json = requestGoogle.execute().parseAs(GenericJson.class);
        //El json contiene todos los atributos de response (resultCode, resultDescription, resultValues)
        // A mi interesa el List de resultValues que es lo que mostraré por pantalla
        // Le hago un casting y lo convierto a un ArrayList
        ArrayList tiempos = (ArrayList) json.get("arrives");

        
        //ArrayList stops = ArrayList json.get("stop")

        request.setAttribute("tiempos", tiempos);
        request.getRequestDispatcher("/tiempo.jsp").forward(request, response);
        
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
