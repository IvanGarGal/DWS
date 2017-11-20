package servlets;

import java.io.IOException;
import java.io.PrintWriter;
import java.time.LocalDate;
import java.time.Month;
import java.time.ZoneOffset;
import java.time.format.DateTimeFormatter;
import java.util.Date;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import servicios.AlumnosServicios;
import servicios.NotasServicios;
import servicios.AsignaturasServicios;
import model.Alumno;
import model.Asignatura;
import model.Nota;

@WebServlet(name = "Notas", urlPatterns = {"/notas"})
public class Notas extends HttpServlet {

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

        NotasServicios ns = new NotasServicios();
        AlumnosServicios alums = new AlumnosServicios();
        AsignaturasServicios asigs = new AsignaturasServicios();
        String op = request.getParameter("accion");
        String idAlu = request.getParameter("idAlumno");
        String idAsig = request.getParameter("idAsignatura");
        String nomAlu = request.getParameter("nombreAlumno");
        String nomAsig = request.getParameter("nombreAsignatura");
        String nota = request.getParameter("nota");
        boolean cargar = false;

        if (op != null) {
            Nota n = new Nota();
            n.setIdAlumno(Long.parseLong(idAlu));
            n.setIdAsignatura(Long.parseLong(idAsig));
            int filas = 0;

            switch (op) {
                case "guardar":
                    n.setNota(Integer.parseInt(nota));
                    n = ns.guardarNota(n);
                    if (n != null) {
                        filas = 1;
                    }
                    request.setAttribute("nota", n);
                    break;
                case "borrar":
                    filas = ns.delNota(n);
                    break;
                case "cargar":
                    n = ns.getNota(n.getIdAlumno(), n.getIdAsignatura());
                    cargar = true;
                    if (n == null) {
                        request.setAttribute("mensaje", "No hay notas");
                    }else{
                        request.setAttribute("nota", n);
                    }
                    break;
            }
            if (filas != 0 && cargar == false) {
                request.setAttribute("mensaje", filas + " filas modificadas correctamente");
            } else if (filas == 0 && cargar == false) {
                request.setAttribute("mensaje", "No se han hecho modificaciones");
            }
        }
        // getAll siempre se hace
        
        // LE MANDO LA INFORMACIÓN AL " <c:forEach items="${alumnos}" var="alumno"> " DE pintarAlumnos.jsp
        // "alumnos" está enlazado con "${alumnos}"
        // "alumnos" contiene dentro la función "as.getAllAlumnos()" que lo que hace es mostrar los alumnos que hay dentro de la tabla
        // a "${alumnos}" le cambio el nombre "alumno" mediante var="alumno"
        request.setAttribute("asignaturas", asigs.getAllAsignaturas());
        request.setAttribute("alumnos", alums.getAllAlumnos());
        request.setAttribute("nomAlu", nomAlu);
        request.setAttribute("idAlu", idAlu);
        request.setAttribute("nomAsig", nomAsig);
        request.setAttribute("idAsig", idAsig);
        request.getRequestDispatcher("pintarListaNotas.jsp").forward(request, response);

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