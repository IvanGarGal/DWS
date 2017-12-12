package dao;

import java.sql.Connection;
import java.util.logging.Level;
import java.util.logging.Logger;
import model.Nota;
import org.apache.commons.dbutils.QueryRunner;
import org.apache.commons.dbutils.ResultSetHandler;
import org.apache.commons.dbutils.handlers.BeanHandler;

/**
 *
 * @author daw
 */
public class NotasDAO {

    /**
     * Obtenemos la nota
     *
     * @param n objeto de tipo Nota
     * @return devuelve un objeto Nota con todos los datos necesarios
     */
    public Nota getNota(Nota n) {
        DBConnection db = new DBConnection();
        Connection con = null;
        Nota notas = null;
        try {
            con = db.getConnection();
            QueryRunner qr = new QueryRunner();
            ResultSetHandler<Nota> h = new BeanHandler<>(Nota.class);
            notas = qr.query(con, "SELECT * FROM NOTA WHERE ID_ALUMNO = ? AND WHERE ID_ASIGNATURA = ?", h,
                    n.getIdAlumno(), n.getIdAsignatura());

        } catch (Exception ex) {
            Logger.getLogger(NotasDAO.class.getName()).log(Level.SEVERE, null, ex);
            System.out.println("Error al obtener la nota");
        } finally {
            db.cerrarConexion(con);
        }
        return notas;
    }

    /**
     * Actualizamos las notas en caso de que exista en la tabla, en caso
     * contrario añadimos la nota con su alumno y asignatura
     *
     * @param n objeto de tipo Nota con los datos necesarios para la tabla Notas
     * @return devulve un entero para saber si a sido un update o una insert
     */
    public int updNota(Nota n) {
        DBConnection db = new DBConnection();
        Connection con = null;
        int state = 0;
        try {
            con = db.getConnection();
            QueryRunner qr = new QueryRunner();

            state = qr.update(con,
                    "UPDATE NOTAS SET NOTA = ? WHERE ID_ALUMNO = ? AND ID_ASIGNATURA = ?",
                    n.getNota(), n.getIdAlumno(), n.getIdAsignatura());

            if (state == 0) {
                qr.update(con,
                        "INSERT INTO ASIGNATURAS (ID_ALUMNO,ID_ASIGNATURA,NOTA) VALUES (?,?,?)",
                        n.getIdAlumno(), n.getIdAsignatura(), n.getNota());
                state = 2;
            }

        } catch (Exception ex) {
            Logger.getLogger(NotasDAO.class.getName()).log(Level.SEVERE, null, ex);
        } finally {
            db.cerrarConexion(con);
        }
        return state;
    }

    public int rmNota(Nota n) {
        DBConnection db = new DBConnection();
        Connection con = null;
        int state = 0;
        try {
            con = db.getConnection();
            QueryRunner qr = new QueryRunner();

            state = qr.update(con,
                    "DELETE FROM NOTAS WHERE ID_ALUMNO = ? AND ID_ASIGNATURA = ?",
                    n.getIdAlumno(), n.getIdAsignatura());

        } catch (Exception ex) {
            Logger.getLogger(NotasDAO.class.getName()).log(Level.SEVERE, null, ex);
        } finally {
            db.cerrarConexion(con);
        }
        return state;
    }

}
