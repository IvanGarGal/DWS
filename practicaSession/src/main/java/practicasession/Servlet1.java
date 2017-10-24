/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package practicasession;

import java.io.IOException;
import java.io.PrintWriter;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import utils.Constantes;

/**
 *
 * @author DAW
 */
@WebServlet(name = "Servlet1", urlPatterns = {"/servlet1"})
public class Servlet1 extends HttpServlet {

    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {

        String paginaDestino = Constantes.ERROR;
        String nivel = "0";
        //parameter si viene de formulario o url
        //attribute si viene de Map(como la session)
        if(request.getSession().getAttribute(Constantes.ATTRIBUTE_NAME)==null){
        request.getSession().setAttribute(Constantes.ATTRIBUTE_NAME, nivel);
        }
        if (request.getSession().getAttribute(Constantes.ATTRIBUTE_NAME) == "0") {

            if (request.getParameter(Constantes.PASS) != null) {
                if (request.getParameter(Constantes.PASS).equals(Constantes.NIVEL_1)) {

                    paginaDestino = Constantes.SUPERADO;
                    nivel = "1";
                }

            }

        }
        request.getSession().setAttribute(Constantes.ATTRIBUTE_NAME, nivel);
        request.getRequestDispatcher(paginaDestino).forward(request, response);

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
