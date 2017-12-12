package servlets;

import java.io.IOException;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import model.Nota;
import servicios.AlumnosServicios;
import servicios.AsignaturasSevicios;
import servicios.NotasServicios;

/**
 *
 * @author Miguel Palomares
 */
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
        String op = request.getParameter("op");
        String alumnoId = request.getParameter("alumnoId");
        String asigId = request.getParameter("asigId");
        String nota = request.getParameter("nota");
        AlumnosServicios as = new AlumnosServicios();
        AsignaturasSevicios asg = new AsignaturasSevicios();
        NotasServicios ns = new NotasServicios();
        Nota n = new Nota();
        int result;
        try {

            if (!op.equals("notas")) {
                request.setAttribute("alumnos", as.getAllAlumnos());
                request.setAttribute("asignaturas", asg.getAllAsignaturas());
                switch (op) {
                    case "GETALL":

                        break;
                    case "UPDATE":
                        n.setIdAlumno(Long.parseLong(alumnoId));
                        n.setIdAsignatura(Long.parseLong(asigId));
                        n.setNota(Integer.parseInt(nota));
                        result = ns.updateNota(n);
                        if (result == 1) {
                            request.setAttribute("resultado", "La nota del alumno a sido modificada correctamente");
                        }
                        if (result == 2) {
                            request.setAttribute("resultado", "La nota del alumno a sido creada correctamente");
                        }
                        break;
                    case "REMOVE":
                        n.setIdAlumno(Long.parseLong(alumnoId));
                        n.setIdAsignatura(Long.parseLong(asigId));
                        result = ns.removeNota(n);
                        if (result == 1) {
                            request.setAttribute("resultado", "La nota del alumno ha sido eliminada correctamente");
                        }
                        break;
                }
                request.getRequestDispatcher("asignarNotas.jsp").forward(request, response);

            } else {
                n.setIdAlumno(Long.parseLong(alumnoId));
                n.setIdAsignatura(Long.parseLong(asigId));
                Nota notaAsignada = ns.getNota(n);
                response.getWriter().write(Integer.toString(notaAsignada.getNota()));

            }
        } catch (NumberFormatException e) {
            System.out.println("error en la conversion de la nota");
        }

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
