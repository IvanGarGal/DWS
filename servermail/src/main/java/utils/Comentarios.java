/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package utils;

/**
 *
 * @author rafa
 */
public class Comentarios {
    
    //LO QUE HAY EN ESTE DOCUMENTO NO SE DEBE TENER EN CUENTA. SON TROZOS DEL PROGRAMA QUE NO ME INTERESA PERDER
    
    /**
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
    */
    
        /*
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
    */
    
    /*
        public User addUserSimpleJDBCTemplate(User a) {

        TransactionDefinition txDef = new DefaultTransactionDefinition();
        DataSourceTransactionManager transactionManager = new DataSourceTransactionManager(DBConnection.getInstance().getDataSource());
        TransactionStatus txStatus = transactionManager.getTransaction(txDef);
        
        try {
            
            SimpleJdbcInsert jdbcInsert = new SimpleJdbcInsert(DBConnection.getInstance().getDataSource()).withTableName("ALUMNOS").usingGeneratedKeyColumns("ID");
            Map<String, Object> parameters = new HashMap<String, Object>();

            parameters.put("NOMBRE", a.getNombre());
            parameters.put("PASSWORD", a.getPassword());
            parameters.put("ACTIVO", a.getActivo());
            parameters.put("CODIGO_ACTIVACION", a.getCodActivacion());
            parameters.put("FECHA_ACTIVACION", a.getFechaActivacion());
            parameters.put("EMAIL", a.getEmail());
            
            
            a.setId(jdbcInsert.executeAndReturnKey(parameters).longValue());
            transactionManager.commit(txStatus);

        } catch (Exception e) {

            transactionManager.rollback(txStatus);

            throw e;

        }

        return a;
    }
    */
    
    /*
        public List<User> getAllAlumnosJDBCTemplate() {
     
        JdbcTemplate jtm = new JdbcTemplate(
          DBConnection.getInstance().getDataSource());
        List<User> users = jtm.query("Select * from ALUMNOS",
          new BeanPropertyRowMapper(User.class));
        
        
        return users;
    }


    */
}
