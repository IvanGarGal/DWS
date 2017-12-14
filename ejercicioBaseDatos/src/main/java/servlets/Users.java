/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package servlets;

import java.io.IOException;
import java.time.LocalDateTime;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import model.User;

import servicios.UsersServicios;
import utils.Constantes;

/**
 *
 * @author Miguel Angel Diaz
 */
@WebServlet(name = "Users", urlPatterns = {"/users"})
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
      throws ServletException, IOException {

        String accion = request.getParameter("accion");
        UsersServicios us = new UsersServicios();

        if (accion != null) {

            switch (accion) {
                case "registro":
                    String nombreRegistro = request.getParameter("nombreRegistro");

                    User u = new User();
                    String email = request.getParameter("emailRegistro");

                    u.setNombre(nombreRegistro);
                    u.setPassword(request.getParameter("passRegistro"));
                    u.setEmail(email);
                    
                    u = us.registrar(u);
                    if (u == null) {
                        request.setAttribute("mensaje", Constantes.ERROR_REGISTRO);
                    } else {

                        request.setAttribute("mensaje", Constantes.REGISTRO_CORRECTO);
                        request.setAttribute("mensaje2", Constantes.REGISTRO_CORRECTO_2);
                    }

                    //     request.setAttribute("errorNombre", Constantes.ERROR_NOMBRE);
                    break;
                // activarUsuario
                case "validarUsuario":
                    String codigo = request.getParameter("codigo");
                    int valido = us.activar(codigo);
                    switch (valido) {
                        case 0:
                            request.setAttribute("mensaje", Constantes.ERROR_TIEMPO);
                            request.setAttribute("mensaje2", Constantes.ERROR_TIEMPO_2);
                            break;
                        case 1:
                            request.setAttribute("mensaje", Constantes.CUENTA_ACTIVADA);
                            request.setAttribute("mensaje2", Constantes.CUENTA_ACTIVADA_2);
                            break;
                        case 2:
                            request.setAttribute("mensaje", Constantes.YA_ACTIVADA);
                            request.setAttribute("mensaje2", Constantes.CUENTA_ACTIVADA_2);
                            break;
                        case -1:
                            request.setAttribute("mensaje", Constantes.ERROR_ACTIVAR);
                            request.setAttribute("mensaje2", Constantes.ERROR_ACTIVAR_2);
                            break;
                    }
                    break;

                case "login":
                    String nombreLogin = request.getParameter("nombreLogin");
                    String passLogin = request.getParameter("passLogin");
                    u = new User();
                    u.setNombre(nombreLogin);
                    u.setPassword(request.getParameter("passRegistro"));
                    
                    boolean error = false;
                    if (us.login(u)) {
                        request.getSession().setAttribute("nombreUsuario", nombreLogin);
                    }else{
                        request.setAttribute("errorLogin", Constantes.ERROR_LOGIN);
                    }
                    break;

                case "logout": {
                    request.getSession().invalidate();
                }
            }
        }
        request.getRequestDispatcher(Constantes.PINTAR_LOGIN).forward(request, response);
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
