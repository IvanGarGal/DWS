/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package dao;

import config.Configuration;
import java.time.LocalDateTime;
import java.util.logging.Level;
import java.util.logging.Logger;
import model.User;
import org.springframework.jdbc.core.BeanPropertyRowMapper;
import org.springframework.jdbc.core.JdbcTemplate;

/**
 *
 * @author Miguel Angel Diaz
 */
public class UsersDAO {

    private final String queryRegistrar = "INSERT INTO USERS (NOMBRE,PASSWORD,CODIGO_ACTIVACION,ACTIVO,FECHA_ACTIVACION,EMAIL) VALUES(?,?,?,0,?,?)";
    private final String queryComprobarNombres = "SELECT NOMBRE FROM USERS WHERE NOMBRE = ?";
    private final String queryUserByCodigoActivacion = "SELECT * FROM USERS WHERE CODIGO_ACTIVACION = ?";
    private final String queryActivar = "UPDATE USERS SET ACTIVO = TRUE WHERE CODIGO_ACTIVACION = ?";
    private final String queryBorrar = "DELETE FROM USERS WHERE CODIGO_ACTIVACION = ?";
    private final String queryUserByNombre = "SELECT * FROM USERS WHERE NOMBRE = ?";

    public User registrar(User u) {
        try {
            JdbcTemplate jtm = new JdbcTemplate(DBConnection.getInstance().getDataSource());
            int filas = jtm.update(queryRegistrar, u.getNombre(), u.getPassword(), u.getCodigo_activacion(), u.getFecha_activacion(), u.getEmail());
            if (filas == 0) {
                u = null;
            }
        } catch (Exception ex) {
            Logger.getLogger(UsersDAO.class.getName()).log(Level.SEVERE, null, ex);
            u = null;
        }
        return u;
    }

    public boolean comprobarNombres(String nombreUser) {
        boolean existe = false;
        try {
            JdbcTemplate jtm = new JdbcTemplate(DBConnection.getInstance().getDataSource());
            String nombres = jtm.queryForObject(queryComprobarNombres, String.class, nombreUser);

            if (nombres != null) {
                existe = true;
            }
        } catch (Exception ex) {
            Logger.getLogger(UsersDAO.class.getName()).log(Level.SEVERE, null, ex);
        }
        return existe;
    }

    public int updateValido(User user)
    {
        int valido = -1;
        JdbcTemplate jtm = new JdbcTemplate(DBConnection.getInstance().getDataSource());
        if(jtm.update(queryActivar, user.getCodigo_activacion())>0){
             valido = 1;
        }
        
        return valido;
    }
    
    public int borrarUserByCodigoActivacion(User user)
    {
        int valido = -1;
        JdbcTemplate jtm = new JdbcTemplate(DBConnection.getInstance().getDataSource());
        if(jtm.update(queryBorrar, user.getCodigo_activacion())>0){
             valido = 1;
        }
        
        return valido;
    }
    
    public User getUserByCodigoActivacion(String codigoActivacion) {
        User u;
        try {
            JdbcTemplate jtm = new JdbcTemplate(DBConnection.getInstance().getDataSource());
            u =(User) jtm.queryForObject(queryUserByCodigoActivacion, new Object[]{codigoActivacion}, new BeanPropertyRowMapper(User.class));
        } catch (Exception ex) {
            Logger.getLogger(UsersDAO.class.getName()).log(Level.SEVERE, null, ex);
            u = null;
        }
        return u;
    }
    
    public User getUserByNombre(String nombre) {
        User u;
        try {
            JdbcTemplate jtm = new JdbcTemplate(DBConnection.getInstance().getDataSource());
            u =(User) jtm.queryForObject(queryUserByNombre, new Object[]{nombre}, new BeanPropertyRowMapper(User.class));
        } catch (Exception ex) {
            Logger.getLogger(UsersDAO.class.getName()).log(Level.SEVERE, null, ex);
            u = null;
        }
        return u;
    }
}
