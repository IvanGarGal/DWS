/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package dao;

import java.sql.Connection;
import model.Alumno;
import java.util.List;
import javax.sql.DataSource;
import org.springframework.dao.DataAccessException;
import org.springframework.jdbc.core.BeanPropertyRowMapper;
import org.springframework.jdbc.core.JdbcTemplate;

/**
 *
 * @author miguel palomares
 */
public class AlumnosDAO {

    JdbcTemplate jtm = null;

    /**
     * Obtenemos todos los alumnos de la BBDD
     *
     * @return un listado con todos los alumnos
     */
    public List<Alumno> getAllAlumnos() {
        String sql = "select * FROM ALUMNOS";
        List<Alumno> alumnos = null;
        jtm = new JdbcTemplate(DBConnection.getInstance().getDataSource());
        try {
            alumnos = jtm.query(sql, new BeanPropertyRowMapper(Alumno.class));
        } catch (DataAccessException e) {
            System.out.println("Error al obtener el listadon de alumnos");
        } finally {
            try {
                Connection conn = DBConnection.getInstance().getConnection();
                DBConnection.getInstance().cerrarConexion(conn);
            } catch (Exception e) {
                System.out.println("Error al cerrar la conexion con la bbdd");
            }
        }
        return alumnos;
    }

    /**
     * Insertamos un nuevo alumno
     *
     * @param a objeto de tipo alumno
     * @return el numero de filas insertadas
     */
    public int insertAlumno(Alumno a) {
        int state = 0;
        try {
            jtm = new JdbcTemplate(DBConnection.getInstance().getDataSource());
            state = jtm.update("INSERT INTO ALUMNOS (NOMBRE,FECHA_NACIMIENTO,MAYOR_EDAD) VALUES(?,?,?)", new Object[]{a.getNombre(),
                new java.sql.Date(a.getFecha_nacimiento().getTime()), a.getMayor_edad()});
        } catch (DataAccessException ex) {
            System.out.println(ex.getCause());
            System.out.println("Error al insertar un nuevo alumno");
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

    /**
     * Eliminamos el alumno
     *
     * @param id identificador del alumno
     * @return numero de filas eliminadas
     */
    public int delAlumno(long id) {
        int state = 0;
        try {
            jtm = new JdbcTemplate(DBConnection.getInstance().getDataSource());
            state = jtm.update("DELETE FROM ALUMNOS WHERE id=?", new Object[]{id});
        } catch (DataAccessException ex) {
            System.out.println(ex.getCause());
            System.out.println("Error al eliminar un alumno");
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

    /**
     * Actualizamos los datos del alumno
     *
     * @param a Objeto de tipo alumno
     * @return numero de filas actualizadas
     */
    public int updateAlumno(Alumno a) {
        int state = 0;
        try {
            jtm = new JdbcTemplate(DBConnection.getInstance().getDataSource());
            state = jtm.update("UPDATE ALUMNOS SET NOMBRE = ?, FECHA_NACIMIENTO = ?,MAYOR_EDAD = ? WHERE id = ?", new Object[]{
                a.getNombre(), new java.sql.Date(a.getFecha_nacimiento().getTime()), a.getMayor_edad(), a.getId()});
        } catch (DataAccessException ex) {
            System.out.println(ex.getCause());
            System.out.println("Error al actualizar un alumno");
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
