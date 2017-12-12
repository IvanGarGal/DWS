/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package servicios;

import dao.AlumnosDAO;
import java.util.List;
import model.Alumno;

/**
 *
 * @author oscar
 */
public class AlumnosServicios {

    /**
     *Obtenemos el listado de todos los alumnos
     * 
     * @return listado con todos los alumnos
     */
    public List<Alumno> getAllAlumnos() {
        AlumnosDAO dao = new AlumnosDAO();
        return dao.getAllAlumnos();
    }


    /**
     * Añadimos un nuevo Alumno
     *
     * @param alumnoNuevo datos del nuevo alumno
     * @return Objeto de tipo alumno
     */
    public int addAlumno(Alumno alumnoNuevo) {
        AlumnosDAO dao = new AlumnosDAO();
        return dao.insertAlumno(alumnoNuevo);
    }
    
    public int updateAlumno(Alumno actualizar){
        AlumnosDAO dao =new AlumnosDAO();
        return dao.updateAlumno(actualizar);
    }
    
    public int deleteAlumno(long id){
        AlumnosDAO dao =new AlumnosDAO();
        return dao.delAlumno(id);
    }
}
