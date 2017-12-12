/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package dao;

import java.sql.Connection;
import java.util.logging.Level;
import java.util.logging.Logger;
import model.Nota;
import org.apache.commons.dbutils.QueryRunner;
import org.apache.commons.dbutils.ResultSetHandler;
import org.apache.commons.dbutils.handlers.BeanHandler;
import org.apache.commons.dbutils.handlers.ScalarHandler;

public class NotasDAO {

    public Nota guardarNota(Nota n) {
        Connection con = null;
        int filas = 0;
        try {
            con = DBConnection.getInstance().getConnection();
            QueryRunner qr = new QueryRunner();
            filas = qr.update(con, "UPDATE NOTAS SET NOTA = ? WHERE ID_ALUMNO = ? AND ID_ASIGNATURA = ?", n.getNota(), n.getIdAlumno(), n.getIdAsignatura());

            if (filas == 0) {
                con.setAutoCommit(false);
                Long id = qr.insert(con,
                        "INSERT INTO NOTAS (ID_ALUMNO,ID_ASIGNATURA,NOTA) VALUES(?,?,?)",
                        new ScalarHandler<Long>(), n.getIdAlumno(), n.getIdAsignatura(), n.getNota());
                con.commit();
            }
        } catch (Exception ex) {
            Logger.getLogger(NotasDAO.class.getName()).log(Level.SEVERE, null, ex);
            n = null;
        } finally {
            DBConnection.getInstance().cerrarConexion(con);
        }
        return n;
    }

    public int delNota(Nota n) {
        Connection con = null;
        int filas = 0;
        try {
            con = DBConnection.getInstance().getConnection();
            QueryRunner qr = new QueryRunner();
            filas = qr.update(con, "DELETE FROM NOTAS WHERE ID_ALUMNO = ? AND ID_ASIGNATURA = ?", n.getIdAlumno(), n.getIdAsignatura());

        } catch (Exception ex) {
            Logger.getLogger(NotasDAO.class.getName()).log(Level.SEVERE, null, ex);
        } finally {
            DBConnection.getInstance().cerrarConexion(con);
        }
        return filas;
    }

    public Nota getNota(Long idAlu, Long idAsig) {
        Connection con = null;
        Nota n = null;
        try {
            con = DBConnection.getInstance().getConnection();
            QueryRunner qr = new QueryRunner();
            ResultSetHandler<Nota> h = new BeanHandler<>(Nota.class);
            n = qr.query(con, "SELECT * FROM NOTAS WHERE ID_ALUMNO = ? AND ID_ASIGNATURA = ?", h, idAlu, idAsig);

        } catch (Exception ex) {
            Logger.getLogger(NotasDAO.class.getName()).log(Level.SEVERE, null, ex);
        } finally {
            DBConnection.getInstance().cerrarConexion(con);
        }
        return n;
    }
}
