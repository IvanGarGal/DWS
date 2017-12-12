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
import servicios.UserLogin;
import util.PasswordHash;


/**
 *
 * @author Miguel Palomares
 */
@WebServlet(name = "Login", urlPatterns = {"/login"})
public class Login extends HttpServlet {

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
        String action = request.getParameter("action");
        UserLogin uls = null;
        String nextPage="index.jsp";
        switch (action) {
            case "activar":
                
                String code_activ = request.getParameter("cod_act");
                uls = new UserLogin();
                uls.activar(code_activ);
                break;
            case "acceder":
                String nombre = request.getParameter("nombre");
                String pass = request.getParameter("password");
                uls = new UserLogin();
                Users user = uls.acceder(nombre);
                //Comparamos las contraseñas
                try {
                    if (PasswordHash.getInstance().validatePassword(pass, user.getPassword())) {
                        if(user.getActivo()==1){
                            request.getSession().setAttribute("LOGIN", "OK");
                            nextPage="/alumnos";
                        }else{
                            request.setAttribute("error", "El usuario todavia no esta activo");
                        }                        
                    }else{
                        request.setAttribute("error", "usuario o contraseña incorrecto");
                    }
                } catch (NoSuchAlgorithmException | InvalidKeySpecException e) {
                    System.out.println("Error al comparar las password " + e.getMessage());
                }

                break;

        }

        request.getRequestDispatcher(nextPage).forward(request, response);
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
