package dao;

import model.Nota;
import model.Asignatura;
import model.Alumno;
import java.math.BigInteger;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.naming.Context;
import javax.naming.InitialContext;
import javax.sql.DataSource;

import org.apache.commons.dbutils.QueryRunner;
import org.apache.commons.dbutils.ResultSetHandler;
import org.apache.commons.dbutils.handlers.BeanHandler;
import org.apache.commons.dbutils.handlers.BeanListHandler;
import org.apache.commons.dbutils.handlers.ScalarHandler;

public class NotasDAO {

    public Nota guardarNota(Nota nota) {
        DBConnection db = new DBConnection();
        Connection con = null;
        int filas = 0;
        try {
            con = db.getConnection();
            QueryRunner qr = new QueryRunner();
            filas = qr.update(con, "UPDATE NOTAS SET NOTA = ? WHERE ID_ALUMNO = ? AND ID_ASIGNATURA = ?", nota.getNota(), nota.getIdAlumno(), nota.getIdAsignatura());

            if (filas == 0) {
                con.setAutoCommit(false);
                Long id = qr.insert(con,
                        "INSERT INTO NOTAS (ID_ALUMNO,ID_ASIGNATURA,NOTA) VALUES(?,?,?)",
                        new ScalarHandler<Long>(), nota.getIdAlumno(), nota.getIdAsignatura(), nota.getNota());
                con.commit();
            }
        } catch (Exception ex) {
            Logger.getLogger(NotasDAO.class.getName()).log(Level.SEVERE, null, ex);
            nota = null;
        } finally {
            db.cerrarConexion(con);
        }
        return nota;
    }

    public int delNota(Nota nota) {
        DBConnection db = new DBConnection();
        Connection con = null;
        int filas = 0;
        try {
            con = db.getConnection();
            QueryRunner qr = new QueryRunner();
            filas = qr.update(con, "DELETE FROM NOTAS WHERE ID_ALUMNO = ? AND ID_ASIGNATURA = ?", nota.getIdAlumno(), nota.getIdAsignatura());

        } catch (Exception ex) {
            Logger.getLogger(NotasDAO.class.getName()).log(Level.SEVERE, null, ex);
        } finally {
            db.cerrarConexion(con);
        }
        return filas;
    }

    public Nota getNota(Long idAlu, Long idAsig) {
        DBConnection db = new DBConnection();
        Connection con = null;
        Nota n = null;
        try {
            con = db.getConnection();
            QueryRunner qr = new QueryRunner();
            ResultSetHandler<Nota> h = new BeanHandler<>(Nota.class);
            n = qr.query(con, "SELECT * FROM NOTAS WHERE ID_ALUMNO = ? AND ID_ASIGNATURA = ?", h, idAlu, idAsig);

        } catch (Exception ex) {
            Logger.getLogger(NotasDAO.class.getName()).log(Level.SEVERE, null, ex);
        } finally {
            db.cerrarConexion(con);
        }
        return n;
    }
}