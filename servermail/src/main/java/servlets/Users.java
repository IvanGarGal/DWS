/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package servlets;

import java.io.IOException;
import java.security.NoSuchAlgorithmException;
import java.security.spec.InvalidKeySpecException;
import java.time.LocalDate;
import java.time.LocalDateTime;
import java.time.ZoneOffset;
import java.time.format.DateTimeFormatter;
import java.util.Date;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import model.User;
import dao.UsersDAO;
import servicios.MandarMail;
import servicios.NotasServicios;
import servicios.UserServicios;
import util.PasswordHash;
import utils.Utils;


@WebServlet(name = "Users", urlPatterns = {"/user"})
public class Users extends HttpServlet {

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
            throws ServletException, IOException, NoSuchAlgorithmException, InvalidKeySpecException {
 
        String op = request.getParameter("accion");
        String nombre = request.getParameter("nombre");
        String password = request.getParameter("password");
        String pagina;
        String cod_activacion = request.getParameter("cod_activacion");
        LocalDateTime fecha_activacion = LocalDateTime.now();
        String email = request.getParameter("email");
        String hasheo = PasswordHash.getInstance().createHash(password);
        String cod = Utils.randomAlphaNumeric(15);
        String code_act;
        User usuario = new User();
        UsersDAO dao = new UsersDAO();
        if (op != null) {
            switch (op) {
                case "REGISTRO":
                    if (usuario == null) {   
                        usuario.setNombre(nombre);
                        usuario.setPassword(password);
                        usuario.setCodActivacion(cod_activacion);
                        //usuario.setFechaActivacion(fecha_activacion);
                    }
                    else {
                        request.setAttribute("mensaje", "YA EXISTE EL USUARIO");
                    }
                    break;
                case "ACCESO":
                    UserServicios servicios = null;
                    servicios = new UserServicios();
                    servicios.ver(nombre);
                    usuario = servicios.ver(nombre);


                break;
                case "ACTIVACION":
                    UserServicios servicios = null;
                    servicios = new UserServicios();
                    servicios.activar(nombre);
        }
        request.getRequestDispatcher(pagina).forward(request, response);
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
