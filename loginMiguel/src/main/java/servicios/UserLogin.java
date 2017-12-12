/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package servicios;

import dao.UsersDAO;
import model.Users;

/**
 *
 * @author miguel
 */
public class UserLogin {

    public int registro(Users user) {
        UsersDAO u = new UsersDAO();
        return u.registrar(user);
    }

    public int activar(String code) {
        UsersDAO u = new UsersDAO();
        return u.activar(code);
    }

    public Users acceder(String nombre) {
        UsersDAO u = new UsersDAO();
        return u.acceder(nombre);
    }

    public int esActivo(String nombre) {
        UsersDAO u = new UsersDAO();
        return u.esActivo(nombre);
    }
}
