/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package dao;

import model.Alumno;

import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

import java.util.ArrayList;
import java.sql.Date;
import java.sql.PreparedStatement;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;

import org.apache.commons.dbutils.QueryRunner;

import utils.ConstantesError;

import utils.SqlQuery;

public class AlumnosDAO {

    public List<Alumno> getAllAlumnosJDBC() {
        List<Alumno> lista = new ArrayList<>();
        Alumno nuevo = null;
        DBConnection db = new DBConnection();
        Connection con = null;
        Statement stmt = null;
        ResultSet rs = null;
        try {
            con = db.getConnection();
            stmt = con.createStatement();

            rs = stmt.executeQuery(SqlQuery.SELECT_ALL_ALUMNOS);

            //STEP 5: Extract data from result set
            while (rs.next()) {
                //Retrieve by column name
                int id = rs.getInt(SqlQuery.ID);
                String nombre = rs.getString(SqlQuery.NOMBRE);
                Date fn = rs.getDate(SqlQuery.FECHA_NACIMIENTO);
                Boolean mayor = rs.getBoolean(SqlQuery.MAYOR_EDAD);
                nuevo = new Alumno();
                nuevo.setFecha_nacimiento(fn);
                nuevo.setId(id);
                nuevo.setMayor_edad(mayor);
                nuevo.setNombre(nombre);
                lista.add(nuevo);
            }

        } catch (Exception ex) {
            Logger.getLogger(AlumnosDAO.class.getName()).log(Level.SEVERE, null, ex);
        } finally {
            try {
                if (rs != null) {
                    rs.close();
                }
                if (stmt != null) {
                    stmt.close();
                }
            } catch (SQLException ex) {
                Logger.getLogger(AlumnosDAO.class.getName()).log(Level.SEVERE, null, ex);
            }

            db.cerrarConexion(con);
        }
        return lista;

    }

    public boolean updateUserJDBC(Alumno alumno) {
        boolean updated = false;
        DBConnection dBConnection = new DBConnection();
        Connection connection = null;

        PreparedStatement stmt = null;
        try {
            connection = dBConnection.getConnection();

            stmt = connection.prepareStatement(SqlQuery.UPDATE_ALUMNO);

            stmt.setString(1, alumno.getNombre());
            stmt.setDate(2, new java.sql.Date(alumno.getFecha_nacimiento().getTime()));
            stmt.setBoolean(3, alumno.getMayor_edad());
            stmt.setInt(4, (int) alumno.getId());

            if (stmt.executeUpdate() > 0) {
                updated = Boolean.TRUE;
            }
        } catch (Exception e) {
            Logger.getLogger(AlumnosDAO.class.getName()).log(Level.SEVERE, null, e);
        } finally {
            try {
                if (stmt != null) {
                    stmt.close();
                }
            } catch (SQLException ex) {
                Logger.getLogger(AlumnosDAO.class.getName()).log(Level.SEVERE, null, ex);
            }

            dBConnection.cerrarConexion(connection);
        }
        return updated;
    }//fin update

    public boolean insertUserJDBC(Alumno alumno) {
        DBConnection dBConnection = new DBConnection();
        Connection connection = null;
        boolean insertado = false;
        PreparedStatement stmt = null;
        try {
            connection = dBConnection.getConnection();

            stmt = connection.prepareStatement(SqlQuery.INSERT_ALUMNO, Statement.RETURN_GENERATED_KEYS);

            stmt.setString(1, alumno.getNombre());
            stmt.setDate(2, new java.sql.Date(alumno.getFecha_nacimiento().getTime()));
            stmt.setBoolean(3, alumno.getMayor_edad());

            if (stmt.executeUpdate() > 0) {
                insertado = Boolean.TRUE;
            }
            ResultSet rs = stmt.getGeneratedKeys();
            if (rs.next()) {
                alumno.setId(rs.getInt(1));
            }

        } catch (Exception e) {
            Logger.getLogger(AlumnosDAO.class.getName()).log(Level.SEVERE, null, e);
        } finally {
            try {
                if (stmt != null) {
                    stmt.close();
                }
            } catch (SQLException ex) {
                Logger.getLogger(AlumnosDAO.class.getName()).log(Level.SEVERE, null, ex);
            }

            dBConnection.cerrarConexion(connection);

        }
        return insertado;

    }//fin insert

    public int deleteUserByIdJDBC(String id) {

        int filasErased = -1;
        DBConnection dBConnection = new DBConnection();
        Connection connection = null;

        PreparedStatement stmt = null;
        try {
            connection = dBConnection.getConnection();

            stmt = connection.prepareStatement(SqlQuery.DELETE_ALUMNO);

            stmt.setInt(1, Integer.valueOf(id));

            filasErased = stmt.executeUpdate();

        } catch (Exception e) {

            if (e.getMessage().contains(ConstantesError.errorForeingkey)) {
                filasErased = ConstantesError.CodeErrorClaveForanea;
            }
            Logger.getLogger(AlumnosDAO.class.getName()).log(Level.SEVERE, null, e);
        } finally {
            try {
                if (stmt != null) {
                    stmt.close();
                }
            } catch (SQLException ex) {
                Logger.getLogger(AlumnosDAO.class.getName()).log(Level.SEVERE, null, ex);
            }

            dBConnection.cerrarConexion(connection);
        }
        return filasErased;
    }

    //DELETE_FORCE
    public boolean deleteUserByIdForce(int id) throws SQLException {

        int filasNota = -1;
        int filasAlumno = -1;
        boolean borrado = Boolean.FALSE;
        DBConnection db = new DBConnection();
        Connection con = null;
        PreparedStatement stmt = null;

        try {
            con = db.getConnection();
            con.setAutoCommit(Boolean.FALSE);

            stmt = con.prepareStatement(SqlQuery.DELETE_NOTA_ALUMNO);
            stmt.setInt(1, id);
            filasNota = stmt.executeUpdate();

            stmt = con.prepareStatement(SqlQuery.DELETE_ALUMNO);
            stmt.setInt(1, id);
            filasAlumno = stmt.executeUpdate();

            if (filasNota > 0 && filasAlumno > 0) {
                borrado = Boolean.TRUE;
                con.commit();
            } else {
                con.rollback();
            }

        } catch (Exception ex) {
            if (con != null) {
                con.rollback();
            }
            Logger.getLogger(AlumnosDAO.class.getName()).log(Level.SEVERE, null, ex);
        } finally {
            db.cerrarConexion(con);
        }
        return borrado;

    }

}//fin clase
