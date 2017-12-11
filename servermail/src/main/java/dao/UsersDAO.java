package dao;

import model.User;
import java.math.BigInteger;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.naming.Context;
import javax.naming.InitialContext;
import javax.sql.DataSource;
import org.apache.commons.dbutils.DbUtils;

import org.apache.commons.dbutils.QueryRunner;
import org.apache.commons.dbutils.ResultSetHandler;
import org.apache.commons.dbutils.handlers.BeanHandler;
import org.apache.commons.dbutils.handlers.BeanListHandler;
import org.apache.commons.dbutils.handlers.ScalarHandler;
import org.springframework.jdbc.core.BeanPropertyRowMapper;

import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.core.simple.SimpleJdbcInsert;
import org.springframework.jdbc.datasource.DataSourceTransactionManager;
import org.springframework.transaction.TransactionDefinition;
import org.springframework.transaction.TransactionStatus;
import org.springframework.transaction.support.DefaultTransactionDefinition;

public class UsersDAO {
    public List<User> getAllAlumnosJDBC() {
        List<User> lista = new ArrayList<>();
        User nuevo = null;
        Connection con = null;
        Statement stmt = null;
        ResultSet rs = null;
        try {
            con = DBConnection.getInstance().getConnection();
            stmt = con.createStatement();
            String sql;
            sql = "SELECT * FROM USERS";
            rs = stmt.executeQuery(sql);

            //STEP 5: Extract data from result set
            while (rs.next()) {
                //Retrieve by column name
                int id = rs.getInt("id");
                String nombre = rs.getString("nombre");
                String password = rs.getString("password");
                Boolean activo = rs.getBoolean("activo");
                String cod_activacion = rs.getString("cod_activacion");
                Date fecha_activacion = rs.getDate("fecha_activacion");
                String email = rs.getString("email");
                nuevo = new User();
                nuevo.setId(id);
                nuevo.setNombre(nombre);
                nuevo.setPassword(password);
                nuevo.setActivo(activo);
                nuevo.setCodActivacion(cod_activacion);
                nuevo.setFechaActivacion((java.sql.Date) fecha_activacion);
                nuevo.setEmail(email);
                
                lista.add(nuevo);
            }

        } catch (Exception ex) {
            Logger.getLogger(UsersDAO.class.getName()).log(Level.SEVERE, null, ex);
        } finally {
            try {
                if (rs != null) {
                    rs.close();
                }
                if (stmt != null) {
                    stmt.close();
                }
            } catch (SQLException ex) {
                Logger.getLogger(UsersDAO.class.getName()).log(Level.SEVERE, null, ex);
            }

            DBConnection.getInstance().cerrarConexion(con);
        }
        return lista;

    }

    public List<User> getAllAlumnosJDBCTemplate() {
     
        JdbcTemplate jtm = new JdbcTemplate(
          DBConnection.getInstance().getDataSource());
        List<User> users = jtm.query("Select * from ALUMNOS",
          new BeanPropertyRowMapper(User.class));
        
        
        return users;
    }
    
    public User insertUserJDBC(User u) {
        Connection con = null;
        try {
            con = DBConnection.getInstance().getConnection();
            PreparedStatement stmt = con.prepareStatement("INSERT INTO USERS (NOMBRE,PASSWORD,ACTIVO,CODIGO_ACTIVACION,FECHA_ACTIVACION,EMAIL) VALUES(?,?,?,?,?,?)", Statement.RETURN_GENERATED_KEYS);

            stmt.setString(1, u.getNombre());
            stmt.setString(2, u.getPassword());
            stmt.setBoolean(3, u.getActivo());
            stmt.setString(4, u.getCodActivacion());
            stmt.setDate(5, u.getFechaActivacion());
            stmt.setString(6, u.getEmail());

            int filas = stmt.executeUpdate();

            ResultSet rs = stmt.getGeneratedKeys();
            if (rs.next()) {
                u.setId(rs.getInt(1));
            }

        } catch (Exception ex) {
            Logger.getLogger(AlumnosDAO.class.getName()).log(Level.SEVERE, null, ex);
            u = null;
        } finally {
            DBConnection.getInstance().cerrarConexion(con);
        }

        return u;
    }
}
