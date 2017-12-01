/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package servlets;

import java.io.IOException;

import java.util.Map;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import model.Nota;
import servicios.AlumnosServicios;
import servicios.AsignaturasServicios;
import servicios.NotasServicios;
import utils.Constantes;

/**
 *
 * @author daw
 */
@WebServlet(name = "NotasServlet", urlPatterns = {"/notas"})
public class NotasServlet extends HttpServlet {

    /**
     * Processes requests for both HTTP <code>GET</code> and <code>POST</code>
     * methods.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {

        NotasServicios serviciosNotas = new NotasServicios();
        AlumnosServicios alumnosServicios = new AlumnosServicios();
        AsignaturasServicios asignaturasServicios = new AsignaturasServicios();
        Nota nota = null;
        Nota claves = null;
        
        String action = request.getParameter(Constantes.actionJSP);
        Map<String, String[]> parametros = null;
        
        if (action != null && !action.isEmpty()) {

            parametros = request.getParameterMap();
            claves = serviciosNotas.tratarParametros(parametros);

            switch (action) {
                case Constantes.VIEW://buscamos la nota 

                    nota = serviciosNotas.getNota(claves);

                    if (nota != null) {
                        request.setAttribute(Constantes.notaResult, nota);
                    } else {
                        request.setAttribute(Constantes.RESULTADO_QUERY, Constantes.messageQueryNotaMissing);
                        claves.setNota(-1);//no tenemos nota la base de datos

                    }

                    break;

                case Constantes.UPDATE:
                    //actualizar nota
                    //1* consultar en notas
                    //si -> update
                    //no -> insert
                    boolean resultado = Boolean.FALSE;
                    if (serviciosNotas.getNota(claves) != null) {
                        resultado = serviciosNotas.updateNota(claves);
                    } else {
                        resultado = serviciosNotas.insertNota(claves);
                    }
                    request.setAttribute(Constantes.notaMessage, (resultado) ? Constantes.messageQueryNotaUpdated : Constantes.messageQueryNotaUpdatedFail);

                    break;

            }

        }

        if (claves != null) {
            request.setAttribute(Constantes.notaResult, claves);
        }
        request.setAttribute(Constantes.asignaturasList, asignaturasServicios.getAllAsignaturasdbUtils());//envia la lista al jsp
        request.setAttribute(Constantes.ALUMNOS_LIST, alumnosServicios.getAllAlumnos());

        request.getRequestDispatcher(Constantes.NOTAS_JSP).forward(request, response);

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
