package servlets;

import java.io.IOException;
import java.io.PrintWriter;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import utils.constantes;

@WebServlet(name = "nivel1", urlPatterns = {"/nivel1"})
public class nivel1 extends HttpServlet {
    
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
      throws ServletException, IOException {
        String paginaDestino = constantes.INDEX;
        request.setAttribute("acertado", "error");
        
        //-------------------------------------------
        //AQUÍ EMPIEZA LA BARRERA DEL NIVEL 1
        //-------------------------------------------

        if(request.getParameter(constantes.CLAVE1)!= null){
            //MIRO QUE LA CLAVE Y VALOR INTRODUCIDO COINCIDEN CON LO QUE PIDO
            if (request.getParameter(constantes.CLAVE1).equals(constantes.VALOR1)){
                    request.getSession().setAttribute(constantes.CLAVE1,constantes.VALOR1);
                    request.setAttribute("acertado", "continua");
            } 
        }
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
