/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package dao;

import java.sql.Connection;
import java.util.List;
import model.Asignatura;
import org.springframework.dao.DataAccessException;
import org.springframework.jdbc.core.BeanPropertyRowMapper;
import org.springframework.jdbc.core.JdbcTemplate;

/**
 *
 * @author oscar
 */
public class AsignaturasDAO {

    JdbcTemplate jtm = null;

    //la tabla asignaturas tiene los campos nombre, ciclo, curso
    public List<Asignatura> getAllAsignaturas() {
        String sql = "SELECT * FROM ASIGNATURAS";
        List<Asignatura> asignaturas = null;
        jtm = new JdbcTemplate(DBConnection.getInstance().getDataSource());
        try {
            asignaturas = jtm.query(sql, new BeanPropertyRowMapper(Asignatura.class));
        } catch (DataAccessException e) {
            System.out.println("Error al obtener el listado de asignaturas");
        }finally {
            try {
                Connection conn = DBConnection.getInstance().getConnection();
                DBConnection.getInstance().cerrarConexion(conn);
            } catch (Exception e) {
                System.out.println("Error al cerrar la conexion con la bbdd");
            }
        }
        return asignaturas;
    }

    /**
     * Añadimos una nueva asignatura
     *
     * @param a objeto de tipo Asignatura que contiene los datos del objeto
     */
    public int addAsignaturas(Asignatura a) {
        int state = 0;
        try {
            jtm = new JdbcTemplate(DBConnection.getInstance().getDataSource());
            state = jtm.update("INSERT INTO ASIGNATURAS (NOMBRE,CICLO,CURSO) VALUES (?,?,?)", new Object[]{
                a.getNombre(), a.getCiclo(), a.getCurso()});
        } catch (DataAccessException ex) {
            System.out.println(ex.getCause());
            System.out.println("Error al insertar una nueva asignatura");
        }finally {
            try {
                Connection conn = DBConnection.getInstance().getConnection();
                DBConnection.getInstance().cerrarConexion(conn);
            } catch (Exception e) {
                System.out.println("Error al cerrar la conexion con la bbdd");
            }
        }
        return state;
    }

    public int updateAsignaturas(Asignatura a) {
        int state = 0;
        try {
            jtm = new JdbcTemplate(DBConnection.getInstance().getDataSource());
            state = jtm.update("UPDATE ASIGNATURAS SET NOMBRE = ?, CICLO = ?, CURSO = ? WHERE id = ?", new Object[]{
                a.getNombre(), a.getCiclo(), a.getCurso(), a.getId()});
        } catch (DataAccessException ex) {
            System.out.println(ex.getCause());
            System.out.println("Error al actualizar la asignatura");
        }finally {
            try {
                Connection conn = DBConnection.getInstance().getConnection();
                DBConnection.getInstance().cerrarConexion(conn);
            } catch (Exception e) {
                System.out.println("Error al cerrar la conexion con la bbdd");
            }
        }
        return state;
    }

    public int removeAsignaturas(long id) {
        int state = 0;
        try {
            jtm = new JdbcTemplate(DBConnection.getInstance().getDataSource());
            state = jtm.update("DELETE FROM ASIGNATURAS WHERE id=?", new Object[]{id});
        } catch (DataAccessException ex) {
            System.out.println(ex.getCause());
            System.out.println("Error al eliminar la asignatura");
        }finally {
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
