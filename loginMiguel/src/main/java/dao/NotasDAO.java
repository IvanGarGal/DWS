package dao;

import java.sql.Connection;
import model.Nota;
import org.springframework.dao.DataAccessException;
import org.springframework.jdbc.core.BeanPropertyRowMapper;
import org.springframework.jdbc.core.JdbcTemplate;

/**
 *
 * @author daw
 */
public class NotasDAO {

    JdbcTemplate jtm = null;

    /**
     * Obtenemos la nota
     *
     * @param n objeto de tipo Nota
     * @return devuelve un objeto Nota con todos los datos necesarios
     */
    public Nota getNota(Nota n) {
        String query = "SELECT * FROM NOTAS WHERE ID_ALUMNO = ? AND ID_ASIGNATURA = ?";
        Nota nota = null;
        try {
            jtm = new JdbcTemplate(DBConnection.getInstance().getDataSource());
            nota = (Nota) jtm.queryForObject(query, new Object[]{n.getIdAlumno(), n.getIdAsignatura()}, new BeanPropertyRowMapper(Nota.class));
        } catch (DataAccessException e) {
            System.out.println("Error al obtener la nota");
        }finally {
            try {
                Connection conn = DBConnection.getInstance().getConnection();
                DBConnection.getInstance().cerrarConexion(conn);
            } catch (Exception e) {
                System.out.println("Error al cerrar la conexion con la bbdd");
            }
        }
        return nota;
    }

    /**
     * Actualizamos las notas en caso de que exista en la tabla, en caso
     * contrario añadimos la nota con su alumno y asignatura
     *
     * @param n objeto de tipo Nota con los datos necesarios para la tabla Notas
     * @return devulve un entero para saber si a sido un update o una insert
     */
    public int updNota(Nota n) {
        int state = 0;
        try {
            jtm = new JdbcTemplate(DBConnection.getInstance().getDataSource());
            state = jtm.update("UPDATE NOTAS SET NOTA = ? WHERE ID_ALUMNO = ? AND ID_ASIGNATURA = ?", new Object[]{
                n.getNota(), n.getIdAlumno(), n.getIdAsignatura()});
            if (state == 0) {
                state = jtm.update("INSERT INTO NOTAS (ID_ALUMNO,ID_ASIGNATURA,NOTA) VALUES (?,?,?)", new Object[]{
                    n.getIdAlumno(), n.getIdAsignatura(), n.getNota()});
                state = 2;
            }
        } catch (DataAccessException ex) {
            System.out.println(ex.getCause());
            System.out.println("Error al actualizar o añadir una nota");
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

    /**
     * Eliminamos la nota por medio del id_alumno e id_asignatura
     *
     * @param n objeto de tipo Nota
     * @return deulve un entero para saber si se a eliminado correctamente la
     * nota
     */
    public int rmNota(Nota n) {
        int state = 0;
        try {
            jtm = new JdbcTemplate(DBConnection.getInstance().getDataSource());
            state = jtm.update("DELETE FROM NOTAS WHERE ID_ALUMNO = ? AND ID_ASIGNATURA = ?", new Object[]{
            n.getIdAlumno(),n.getIdAsignatura()});
        } catch (DataAccessException ex) {
            System.out.println(ex.getCause());
            System.out.println("Error al eliminar la nota");
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
