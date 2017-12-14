/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package model;

import java.time.LocalDateTime;

/**
 *
 * @author Miguel Angel Diaz
 */
public class User {
    private long id;
    private String nombre;
    private String password;
    private boolean activo;
    private String codigo_activacion;
    private LocalDateTime fecha_activacion;
    private String email;

    public User() {
    }

    public Long getId() {
        return id;
    }

    public void setId(Long id) {
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

    public boolean getActivo() {
        return activo;
    }

    public void setActivo(boolean activo) {
        this.activo = activo;
    }

    public String getCodigo_activacion() {
        return codigo_activacion;
    }

    public void setCodigo_activacion(String codigo_activacion) {
        this.codigo_activacion = codigo_activacion;
    }

    public LocalDateTime getFecha_activacion() {
        return fecha_activacion;
    }

    public void setFecha_activacion(LocalDateTime fecha_activacion) {
        this.fecha_activacion = fecha_activacion;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }
    
}
