/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package dao;

import java.sql.Connection;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
import model.Asignatura;
import org.apache.commons.dbutils.BaseResultSetHandler;
import org.apache.commons.dbutils.QueryRunner;
import org.apache.commons.dbutils.ResultSetHandler;
import org.apache.commons.dbutils.handlers.BeanHandler;
import org.apache.commons.dbutils.handlers.BeanListHandler;

/**
 *
 * @author oscar
 */
public class AsignaturasDAO {

    //la tabla asignaturas tiene los campos nombre, ciclo, curso
    public List getAllAsignaturas() {
        List<Asignatura> asignaturas = null;
        DBConnection db = new DBConnection();
        Connection con = null;
        try {
            con = db.getConnection();
            QueryRunner qr = new QueryRunner();
            ResultSetHandler<List<Asignatura>> h = new BeanListHandler<>(Asignatura.class);
            asignaturas = qr.query(con, "SELECT * FROM ASIGNATURAS", h);
        } catch (Exception ex) {
            Logger.getLogger(AlumnosDAO.class.getName()).log(Level.SEVERE, null, ex);
            System.out.println("Error al obtener el listado de asignaturas");
        } finally {
            db.cerrarConexion(con);
        }
        return asignaturas;
    }

    /**
     * Añadimos una nueva asignatura
     * @param a objeto de tipo Asignatura que contiene los datos del objeto
     */
    public void addAsignaturas(Asignatura a) {
        DBConnection db = new DBConnection();
        Connection con = null;
        try {
            con = db.getConnection();
            QueryRunner qr = new QueryRunner();

            qr.update(con,
                    "INSERT INTO ASIGNATURAS (NOMBRE,CICLO,CURSO) VALUES (?,?,?)",
                    a.getNombre(), a.getCiclo(), a.getCurso());

        } catch (Exception ex) {
            Logger.getLogger(AlumnosDAO.class.getName()).log(Level.SEVERE, null, ex);
        } finally {
            db.cerrarConexion(con);
        }
    }
    
    public void updateAsignaturas(Asignatura a) {
        DBConnection db = new DBConnection();
        Connection con = null;
        try {
            con = db.getConnection();
            QueryRunner qr = new QueryRunner();

            qr.update(con,
                    "UPDATE ASIGNATURAS SET NOMBRE = ?, CICLO = ?, CURSO = ? WHERE id = ?",
                    a.getNombre(), a.getCiclo(), a.getCurso(), a.getId());

        } catch (Exception ex) {
            Logger.getLogger(AlumnosDAO.class.getName()).log(Level.SEVERE, null, ex);
        } finally {
            db.cerrarConexion(con);
        }
    }
    
    public void removeAsignaturas(long id) {
        DBConnection db = new DBConnection();
        Connection con = null;
        try {
            con = db.getConnection();
            QueryRunner qr = new QueryRunner();

            qr.update(con,
                    "DELETE FROM ASIGNATURAS WHERE id=?",
                    id);

        } catch (Exception ex) {
            Logger.getLogger(AlumnosDAO.class.getName()).log(Level.SEVERE, null, ex);
        } finally {
            db.cerrarConexion(con);
        }
    }

}
