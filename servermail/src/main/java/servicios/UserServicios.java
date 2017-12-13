package servicios;

import dao.UsersDAO;
import model.User;

public class UserServicios {
    public User anadir(User user) {
        UsersDAO usuario = new UsersDAO();
        return usuario.insertar(user);
    }

    public int activar(String code) {
        UsersDAO usuario = new UsersDAO();
        return usuario.activado(code);
    }

    public User ver(String nombre) {
        UsersDAO usuario = new UsersDAO();
        return usuario.seleccionar(nombre);
    }
}
