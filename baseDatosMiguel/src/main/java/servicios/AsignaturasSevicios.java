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
public class AsignaturasSevicios {

    /**
     * Obtenemos todas las asignaturas
     *
     * @return un objeto de tipo List con todas las asignaturas
     */
    public List<Asignatura> getAllAsignaturas() {
        AsignaturasDAO dao = new AsignaturasDAO();
        return dao.getAllAsignaturas();
    }

    /**
     * Actualizamos la asignatura
     *
     * @param a objeto de tipo Asignatura con los valores del objeto
     */
    public void updateAsignatura(Asignatura a) {
        AsignaturasDAO dao = new AsignaturasDAO();
        dao.updateAsignaturas(a);
    }

    /**
     * Borramos las asignaturas
     * @param id identificador de la asignatura
     */
    public void deleteAsignatura(long id) {
        AsignaturasDAO dao = new AsignaturasDAO();
        dao.removeAsignaturas(id);

    }

    /**
     * Añadimos una nueva asignatura
     * @param a Objeto de tipo Asignatura con los valores del objeto
     */
    public void addAsignatura(Asignatura a) {
        AsignaturasDAO dao = new AsignaturasDAO();
        dao.addAsignaturas(a);
    }

}
