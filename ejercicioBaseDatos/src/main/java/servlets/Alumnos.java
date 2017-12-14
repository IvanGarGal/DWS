/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package servlets;

import java.io.IOException;
import java.time.LocalDate;
import java.time.ZoneOffset;
import java.time.format.DateTimeFormatter;
import java.util.Date;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import servicios.AlumnosServicios;
import model.Alumno;

/**
 *
 * @author Miguel Angel Diaz
 */
@WebServlet(name = "Alumnos", urlPatterns = {"/sesion/alumnos"})
public class Alumnos extends HttpServlet {

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

        AlumnosServicios as = new AlumnosServicios();
        String op = request.getParameter("accion");

        if (op != null) {
            String nombre = request.getParameter("nombre");
            String fecha = request.getParameter("fecha");
            DateTimeFormatter dtf = DateTimeFormatter.ofPattern("dd-MM-yyyy");
            LocalDate fechaNacimiento = LocalDate.parse(fecha, dtf);
            boolean mayor;
            mayor = request.getParameter("mayor") != null;
            Alumno a = new Alumno();
            a.setNombre(nombre);
            a.setFecha_nacimiento(Date.from(fechaNacimiento.atStartOfDay().toInstant(ZoneOffset.UTC)));
            a.setMayor_edad(mayor);
            int filas = 0;
            boolean errorBorrar = false;

            switch (op) {
                case "actualizar":
                    a.setId(Long.parseLong(request.getParameter("idalumno")));
                    filas = as.updateAlumno(a);
                    break;
                case "insertar":
                    a = as.addAlumno(a);
                    if (a != null) {
                        filas = 1;
                    }
                    break;
                case "borrar":
                    a.setId(Long.parseLong(request.getParameter("idalumno")));
                    filas = as.delAlumno(a);
                    if (filas == -1) {
                        request.setAttribute("errorBorrar", "Si borras este alumno se borrarán todas sus notas.");
                        request.setAttribute("idAlumno", a.getId());
                        request.setAttribute("fecha", fecha);
                        errorBorrar = true;
                    }
                    break;
                case "borrar2":
                    a.setId(Long.parseLong(request.getParameter("idalumno")));
                    filas = as.delAlumno2(a);
            }
            if (errorBorrar == false) {
                if (filas != 0) {
                    request.setAttribute("mensaje", filas + " filas modificadas correctamente");
                } else {
                    request.setAttribute("mensaje", "No se han hecho modificaciones");
                }
            }
        }
        // getAll siempre se hace
        request.setAttribute("alumnos", as.getAllAlumnos());
        request.getRequestDispatcher("/pintarListaAlumnos.jsp").forward(request, response);

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
