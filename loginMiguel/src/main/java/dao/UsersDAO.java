package dao;

import java.sql.Connection;
import model.Users;
import org.springframework.dao.DataAccessException;
import org.springframework.jdbc.core.BeanPropertyRowMapper;
import org.springframework.jdbc.core.JdbcTemplate;

public class UsersDAO {

    JdbcTemplate jtm = null;

    public int registrar(Users user) {
        int state = 0;
        String query = "SELECT COUNT(*) FROM USERS WHERE NOMBRE= ?";
        try {
            jtm = new JdbcTemplate(DBConnection.getInstance().getDataSource());
            int count = jtm.queryForObject(query, new Object[]{user.getNombre()}, Integer.class);
            if(count==0){
            state = jtm.update("INSERT INTO USERS (NOMBRE,PASSWORD,CODIGO_ACTIVACION,FECHA_ACTIVACION,EMAIL) VALUES(?,?,?,?,?)", new Object[]{user
                .getNombre(), user.getPassword(), user.getCodigo_activacion(), user.getFecha_activacion(), user.getEmail()});
            
            }
        } catch (DataAccessException ex) {
            System.out.println(ex.getCause());
            System.out.println("Error al insertar un nuevo usuario");
        } finally {
            try {
                Connection conn = DBConnection.getInstance().getConnection();
                DBConnection.getInstance().cerrarConexion(conn);
            } catch (Exception e) {
                System.out.println("Error al cerrar la conexion con la bbdd");
            }
        }
        return state;
    }

    public int activar(String codAct) {
        int state = 0;
        try {
            jtm = new JdbcTemplate(DBConnection.getInstance().getDataSource());
            state = jtm.update("UPDATE USERS SET ACTIVO = ? WHERE CODIGO_ACTIVACION = ?", new Object[]{
                1, codAct});
        } catch (DataAccessException e) {
            System.out.println(e.getCause());
            System.out.println("Error al activar el usuario");
        } finally {
            try {
                Connection conn = DBConnection.getInstance().getConnection();
                DBConnection.getInstance().cerrarConexion(conn);
            } catch (Exception e) {
                System.out.println("Error al cerrar la conexion con la bbdd");
            }
        }
        return state;
    }

    public Users acceder(String nombre) {
        String query = "SELECT * FROM USERS WHERE NOMBRE= ?";
        Users user = null;
        try {
            jtm = new JdbcTemplate(DBConnection.getInstance().getDataSource());
            user = (Users) jtm.queryForObject(query, new Object[]{nombre}, new BeanPropertyRowMapper(Users.class));
        } catch (DataAccessException e) {
            System.out.println("Error al obtener la contraseña del usuario");
        } finally {
            try {
                Connection conn = DBConnection.getInstance().getConnection();
                DBConnection.getInstance().cerrarConexion(conn);
            } catch (Exception e) {
                System.out.println("Error al cerrar la conexion con la bbdd");
            }
        }
        return user;
    }

    public int esActivo(String nombre) {
        String query = "SELECT * FROM USERS WHERE NOMBRE= ?";
        int state = 0;
        try {
            jtm = new JdbcTemplate(DBConnection.getInstance().getDataSource());
            Users user = (Users) jtm.queryForObject(query, new Object[]{nombre}, new BeanPropertyRowMapper(Users.class));
            if (user.getActivo() == 0) {
                state = jtm.update("DELETE FROM USERS WHERE NOMBRE = ?", new Object[]{nombre});
            }
        } catch (DataAccessException e) {
            System.out.println("Error al borrar el usuario");
        } finally {
            try {
                Connection conn = DBConnection.getInstance().getConnection();
                DBConnection.getInstance().cerrarConexion(conn);
            } catch (Exception e) {
                System.out.println("Error al cerrar la conexion con la bbdd");
            }
        }
        return state;
    }
}
