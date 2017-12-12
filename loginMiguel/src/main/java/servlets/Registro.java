package servlets;

import java.io.IOException;
import java.security.NoSuchAlgorithmException;
import java.security.spec.InvalidKeySpecException;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import model.Users;
import servicios.MandarMail;
import servicios.UserLogin;
import util.PasswordHash;
import util.Utils;

/**
 *
 * @author Miguel Palomares
 */
@WebServlet(name = "Registro", urlPatterns = {"/registro"})
public class Registro extends HttpServlet {

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
        String nombre = request.getParameter("nombre");
        String correo = request.getParameter("correo");
        String pass = request.getParameter("password");
        Users u = new Users();
        UserLogin uls = new UserLogin();
        //formateamos la fecha actual
        int ok = 0;
        try {
            
            String cod_act=Utils.randomAlphaNumeric(20);
            u.setNombre(nombre);
            u.setPassword(PasswordHash.getInstance().createHash(pass));
            u.setFecha_activacion(Utils.format_fecha()); 
            u.setCodigo_activacion(cod_act);
            u.setEmail(correo);

            ok = uls.registro(u);
            if (ok == 1) {
                //mandamos el correo con la clave de activacion
                MandarMail mail = new MandarMail();
                mail.mandarMail(correo, cod_act);
                Utils.iniciarTemporizador(nombre);
                request.setAttribute("mensaje", "Usuario registrado. Te hemos enviado un correo para activar tu cuenta. "
                        + "Tienes 10 minutos para su activación.");
            } else {
                request.setAttribute("mensaje", "El nombre de usuario ya existe");
            }

        } catch (NoSuchAlgorithmException | InvalidKeySpecException e) {
            System.out.println("Error en el hash de la password");
        }
        request.getRequestDispatcher("registro.jsp").forward(request, response);

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
