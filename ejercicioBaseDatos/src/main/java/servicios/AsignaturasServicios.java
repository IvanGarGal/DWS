/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package servicios;

import dao.AsignaturasDAO;
import java.util.List;
import model.Asignatura;
/**
 *
 * @author daw
 */
public class AsignaturasServicios {
    public List<Asignatura> getAllAsignaturas(){
        AsignaturasDAO dao = new AsignaturasDAO();
        
        return dao.getAllAsignaturas();
    }
    
    public Asignatura getAsignaturaById(int id) {
        AsignaturasDAO dao = new AsignaturasDAO();
        
        return dao.getUserById(id);
    }
    
    public Asignatura addAsignatura(Asignatura asignaturaNuevo) {
        AsignaturasDAO dao = new AsignaturasDAO();
        
        return dao.insertAsignatura(asignaturaNuevo);
    }
    
    public void updateAsignatura(Asignatura asignaturaNuevo) {
        AsignaturasDAO dao = new AsignaturasDAO();
        dao.updateUser (asignaturaNuevo);
    }
    
    public void delAsignatura(Asignatura asignaturaNuevo){
        AsignaturasDAO dao = new AsignaturasDAO();
        dao.delUser(asignaturaNuevo);
    }
}
