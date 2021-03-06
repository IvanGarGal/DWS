package servlets;

import java.io.IOException;
import java.io.PrintWriter;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import utils.constantes;

@WebServlet(name = "nivel2", urlPatterns = {"/nivel2"})
public class nivel2 extends HttpServlet {

    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
      throws ServletException, IOException {
        String paginaDestino = constantes.INDEX;
        request.setAttribute("acertado", "error");
        
        //parameter si viene de formulario o URL
        //attribute si viene de Map(como la session)
        
        //-----------------------------------------------------------------
        //AQUÍ EMPIEZA LA PRIMERA BARRERA DEL NIVEL 2
        //-----------------------------------------------------------------
        if (request.getSession().getAttribute(constantes.CLAVE1) != null){   
            if(request.getParameter(constantes.CLAVE2_1)!= null){
                //MIRO QUE LA CLAVE Y VALOR INTRODUCIDO COINCIDEN CON LO QUE PIDO
                if (request.getParameter(constantes.CLAVE2_1).equals(constantes.VALOR2_1)){
                    request.getSession().setAttribute (constantes.CLAVE2_1,constantes.VALOR2_1);
                    request.setAttribute("acertado", "continua");
                }          
            }       
        }

        //-----------------------------------------------------------------
        //AQUÍ EMPIEZA LA SEGUNDA BARRERA DEL NIVEL 2 SI SUPERAS LA PRIMERA
        //-----------------------------------------------------------------
        
        if (request.getSession().getAttribute(constantes.CLAVE2_1) != null){   
            if(request.getParameter(constantes.CLAVE2_2)!= null){
                //MIRO QUE LA CLAVE Y VALOR INTRODUCIDO COINCIDEN CON LO QUE PIDO
                if (request.getParameter(constantes.CLAVE2_2).equals(constantes.VALOR2_2)){
                    request.getSession().setAttribute (constantes.CLAVE2_2,constantes.VALOR2_2);
                    request.setAttribute("acertado", "continua");
                }          
            }       
        }
        //------------------------------------------------------------------------------
        //AQUÍ EMPIEZA LA TERCERA BARRERA DEL NIVEL 2 SI SUPERAS LA PRIMERA Y LA SEGUNDA
        //------------------------------------------------------------------------------

        if (request.getSession().getAttribute(constantes.CLAVE2_2) != null){   
            if(request.getParameter(constantes.CLAVE2_3)!= null){
                //MIRO QUE LA CLAVE Y VALOR INTRODUCIDO COINCIDEN CON LO QUE PIDO
                if (request.getParameter(constantes.CLAVE2_3).equals(constantes.VALOR2_3)){
                    request.getSession().setAttribute (constantes.CLAVE2_3,constantes.VALOR2_3);
                    request.setAttribute("acertado", "continua");
                }          
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
