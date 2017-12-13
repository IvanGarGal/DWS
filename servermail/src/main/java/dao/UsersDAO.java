package dao;

import java.io.PrintWriter;
import java.io.StringWriter;
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
import org.springframework.dao.DataAccessException;
import org.springframework.jdbc.core.BeanPropertyRowMapper;

import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.core.simple.SimpleJdbcInsert;
import org.springframework.jdbc.datasource.DataSourceTransactionManager;
import org.springframework.transaction.TransactionDefinition;
import org.springframework.transaction.TransactionStatus;
import org.springframework.transaction.support.DefaultTransactionDefinition;

public class UsersDAO {
    
    //insert spring jdbc template
    public User insertar(User a) {
 
        SimpleJdbcInsert jdbcInsert = new SimpleJdbcInsert(
        DBConnection.getInstance().getDataSource()).withTableName("USERS").usingGeneratedKeyColumns("ID");
        Map<String, Object> parameters = new HashMap<String, Object>();

        parameters.put("NOMBRE", a.getNombre());
        parameters.put("PASSWORD", a.getPassword());
        parameters.put("ACTIVO", a.getActivo());
        parameters.put("CODIGO_ACTIVACION", a.getCodActivacion());
        parameters.put("FECHA_ACTIVACION", a.getFechaActivacion());
        parameters.put("EMAIL", a.getEmail());
        a.setId(jdbcInsert.executeAndReturnKey(parameters).longValue());
        return a;
    }
    
    //update spring jdbc template
    public int activado(String cod) {
        int fila = 0;
        try {
            JdbcTemplate jdbcTemplate = new JdbcTemplate(
            DBConnection.getInstance().getDataSource());
            String sqlUpdate = "UPDATE USERS set ACTIVO = 1 where CODIGO_ACTIVACION = ?";
            fila = jdbcTemplate.update(sqlUpdate, cod);
        }
        catch (DataAccessException e) {
            StringWriter errors = new StringWriter();
            e.printStackTrace(new PrintWriter(errors));
            System.out.println("El error es: " + errors.toString());
        }
        return fila;
    }
    
    //select spring jdbc template
    public User seleccionar(String nombre) {
        User usuario = null;
        try {        
            JdbcTemplate jdbcTemplate = new JdbcTemplate(
            DBConnection.getInstance().getDataSource());
            String sqlSelect = "SELECT * FROM USERS WHERE NOMBRE= ?";
            usuario = (User) jdbcTemplate.queryForObject(sqlSelect, new Object[]{nombre}, new BeanPropertyRowMapper(User.class));
        }
        catch (DataAccessException e) {
            StringWriter errors = new StringWriter();
            e.printStackTrace(new PrintWriter(errors));
            System.out.println("El error es: " + errors.toString());
        }
        return usuario;
    }
}
