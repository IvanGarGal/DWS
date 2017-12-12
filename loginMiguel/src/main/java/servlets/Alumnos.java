package servlets;

import java.io.IOException;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import model.Alumno;
import servicios.AlumnosServicios;

/**
 *
 * @author Miguel Palomares
 */
@WebServlet(name = "Alumnos", urlPatterns = {"/alumnos"})
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
        String op = request.getParameter("op");
        if (op != null) {
            String fecha_nacimiento = request.getParameter("fecha_nac");
            String nombre = request.getParameter("nombre");
            String idAlumno = request.getParameter("idAlumno");
            Date fecha = null;
            Alumno a = new Alumno();
            SimpleDateFormat format = new SimpleDateFormat("dd-MM-yyyy");
            switch (op) {
                case "INSERT":
                    try {
                        fecha = format.parse(fecha_nacimiento);
                        a.setFecha_nacimiento(fecha);
                        a.setNombre(nombre);
                        a.setMayor_edad(Boolean.TRUE);
                        //Si el usuario ha sido añadido correctamente
                        int add = as.addAlumno(a);
                        if (add == 1) {
                            request.setAttribute("estado", "El alumno ha sido insertado correctamente");
                            request.setAttribute("number_state", "1");
                        } else {
                            request.setAttribute("estado", "El usuario no se ha podido insertar");
                            request.setAttribute("number_state", "0");
                        }
                    } catch (ParseException ex) {
                        System.out.println("Error en la conversión de fecha");
                        System.out.println(ex.getCause());
                    }

                    break;
                case "UPDATE":
                    try {

                        fecha = format.parse(fecha_nacimiento);
                        a.setFecha_nacimiento(fecha);
                        a.setNombre(nombre);
                        a.setMayor_edad(Boolean.TRUE);
                        a.setId(Long.parseLong(idAlumno));
                        int up = as.updateAlumno(a);
                        if (up == 1) {
                            request.setAttribute("estado", "El alumno ha sido actualizado correctamente");
                            request.setAttribute("number_state", "1");
                        } else {
                            request.setAttribute("estado", "El usuario no se ha podido actualizar");
                            request.setAttribute("number_state", "0");
                        }
                    } catch (ParseException ex) {
                        System.out.println("Error en la conversión de fecha");
                        System.out.println(ex.getCause());
                    }
                    break;
                case "REMOVE":
                    int rm=as.deleteAlumno(Long.parseLong(idAlumno));
                    if (rm == 1) {
                        request.setAttribute("estado", "El alumno ha sido eliminado correctamente");
                        request.setAttribute("number_state", "1");
                    } else {
                        request.setAttribute("estado", "El usuario no se ha podido eliminar");
                        request.setAttribute("number_state", "0");
                    }
                    break;
            }
        }
        request.setAttribute("alumnos", as.getAllAlumnos());

        request.getRequestDispatcher("pintarListaAlumnos.jsp").forward(request, response);
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
