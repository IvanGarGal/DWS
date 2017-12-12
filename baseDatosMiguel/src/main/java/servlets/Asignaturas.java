/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package servlets;

import java.io.IOException;
import java.io.PrintWriter;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import model.Asignatura;
import servicios.AsignaturasSevicios;

/**
 *
 * @author daw
 */
@WebServlet(name = "Asignaturas", urlPatterns = {"/asignaturas"})
public class Asignaturas extends HttpServlet {

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
        AsignaturasSevicios as = new AsignaturasSevicios();
        String op = request.getParameter("op");
        if (op != null) {
            String id = request.getParameter("id");
            String nombre = request.getParameter("nombre");
            String ciclo = request.getParameter("ciclo");
            String curso = request.getParameter("curso");
            Asignatura a = new Asignatura();
            switch (op) {
                case "INSERT":
                    System.out.println("INSERT");
                    a.setCiclo(ciclo);
                    a.setCurso(curso);
                    a.setNombre(nombre);
                    as.addAsignatura(a);

                    break;
                case "UPDATE":
                    try {
                        System.out.println("UPDATE");
                        a.setId(Long.parseLong(id));
                        a.setNombre(nombre);
                        a.setCurso(curso);
                        a.setCiclo(ciclo);
                        as.updateAsignatura(a);
                    } catch (NumberFormatException e) {
                        System.out.println("Error en la conversión del "
                                + "identificador de asignatura");
                    }

                    break;
                case "REMOVE":
                    try {
                         as.deleteAsignatura(Long.parseLong(id));
                    } catch (NumberFormatException e) {
                        System.out.println("Error en la conversión del"
                                + " identificador de asignatura");
                    }
                   
                    break;
            }
        }

        request.setAttribute("asignaturas", as.getAllAsignaturas());
        request.getRequestDispatcher("pintarListaAsignaturas.jsp").forward(request, response);
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
