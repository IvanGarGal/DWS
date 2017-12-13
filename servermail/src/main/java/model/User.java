package model;

import java.time.LocalDateTime;
import java.util.Date;

public class User {
    
    private long id;
    private String nombre;
    private String password;
    private Boolean activo;
    private String cod_activacion;
    private Date fecha_activacion;
    private String email;

    public long getId() {
        return id;
    }

    public void setId(long id) {
        this.id = id;
    }

    public String getNombre() {
        return nombre;
    }

    public void setNombre(String nombre) {
        this.nombre = nombre;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }
    
    public Boolean getActivo() {
        return activo;
    }

    public void setActivo(Boolean activo) {
        this.activo = activo;
    }
    
    public String getCodActivacion() {
        return cod_activacion;
    }

    public void setCodActivacion(String nombre) {
        this.nombre = nombre;
    }
    
    public Date getFechaActivacion() {
        return fecha_activacion;
    }
    
    public void setFechaActivacion(Date fecha_activacion) {
        this.fecha_activacion = fecha_activacion;
    }
    
    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }
    
    public User() {
    }



}
