/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package dao;

import java.sql.Connection;
import java.sql.SQLException;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
import model.Asignatura;
import org.apache.commons.dbutils.QueryRunner;
import org.apache.commons.dbutils.ResultSetHandler;
import org.apache.commons.dbutils.handlers.BeanListHandler;
import org.apache.commons.dbutils.handlers.ScalarHandler;

/**
 *
 * @author Miguel Angel Diaz
 */
public class AsignaturasDAO {

    public List<Asignatura> getAllAsignaturas() {
        List<Asignatura> lista = null;
        DBConnection db = new DBConnection();
        Connection con = null;
        try {
            con = db.getConnection();
            QueryRunner qr = new QueryRunner();
            ResultSetHandler<List<Asignatura>> h = new BeanListHandler<Asignatura>(Asignatura.class);
            lista = qr.query(con, "select * FROM ASIGNATURAS", h);

        } catch (Exception ex) {
            Logger.getLogger(AsignaturasDAO.class.getName()).log(Level.SEVERE, null, ex);
        } finally {
            db.cerrarConexion(con);
        }
        return lista;
    }

    public Asignatura addAsignatura(Asignatura a) {
        DBConnection db = new DBConnection();
        Connection con = null;
        try {
            con = db.getConnection();
            con.setAutoCommit(false);
            QueryRunner qr = new QueryRunner();
            long id = qr.insert(con,
                    "INSERT INTO ASIGNATURAS (NOMBRE,CICLO,CURSO) VALUES(?,?,?)",
                    new ScalarHandler<Long>(), a.getNombre(), a.getCiclo(), a.getCurso());
           
            a.setId(id);
            con.commit();
        } catch (Exception ex) {
            Logger.getLogger(AsignaturasDAO.class.getName()).log(Level.SEVERE, null, ex);
            a = null;
        } finally {
            db.cerrarConexion(con);
        }
        return a;
    }

    public int updateAsignatura(Asignatura a) {
        DBConnection db = new DBConnection();
        Connection con = null;
        int filas = 0;
        try {
            con = db.getConnection();
            QueryRunner qr = new QueryRunner();
            filas = qr.update(con, "UPDATE ASIGNATURAS SET NOMBRE = ?, CICLO = ?, CURSO = ? WHERE ID = ?", a.getNombre(), a.getCiclo(), a.getCurso(), a.getId());

        } catch (Exception ex) {
            Logger.getLogger(AsignaturasDAO.class.getName()).log(Level.SEVERE, null, ex);
        } finally {
            db.cerrarConexion(con);
        }
        return filas;
    }

    public int delAsignatura(Asignatura a) {
        DBConnection db = new DBConnection();
        Connection con = null;
        int filas = 0;
        try {
            con = db.getConnection();
            QueryRunner qr = new QueryRunner();
            filas = qr.update(con, "DELETE FROM ASIGNATURAS WHERE ID = ?", a.getId());

        } catch (Exception ex) {
            if (ex.getMessage().contains("foreign")){
                filas = -1;
            }
            Logger.getLogger(AsignaturasDAO.class.getName()).log(Level.SEVERE, null, ex);
        } finally {
            db.cerrarConexion(con);
        }
        return filas;
    }
    
    public int delAsignatura2(Asignatura a) {
        DBConnection db = new DBConnection();
        Connection con = null;
        int filas = 0;
        try {
            con = db.getConnection();
            con.setAutoCommit(false);
            QueryRunner qr = new QueryRunner();
            filas += qr.update(con, "DELETE FROM NOTAS WHERE ID_ASIGNATURA = ?", a.getId());
            filas += qr.update(con, "DELETE FROM ASIGNATURAS WHERE ID = ?", a.getId());
            
            con.commit();

        } catch (Exception ex) {
            Logger.getLogger(AsignaturasDAO.class.getName()).log(Level.SEVERE, null, ex);
            try {
                if (con!=null)
                    con.rollback();
            } catch (SQLException ex1) {
                Logger.getLogger(AlumnosDAO.class.getName()).log(Level.SEVERE, null, ex1);
            }
        } finally {
            db.cerrarConexion(con);
        }
        return filas;
    }
}
