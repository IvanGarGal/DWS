/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package servicios;

import dao.NotasDAO;
import model.Nota;

/**
 *
 * @author daw
 */
public class NotasServicios {

    /**
     * Actualizamos las notas
     *
     * @param n objeto de tipo Nota
     * @return devuelve un entero paran saber si la nota se a actualizado o añadido 
     */
    public int updateNota(Nota n) {
        NotasDAO dao = new NotasDAO();
        return dao.updNota(n);
    }

    /**
     * Obtenemos la nota por medio del id de alumno y el id de asignatura
     *
     * @param n objeto de tipo Nota
     * @return valor de la nota
     */
    public Nota getNota(Nota n) {
        NotasDAO dao = new NotasDAO();
        return dao.getNota(n);
        
    }

    /**
     * Eliminamos la nota por medio del id del alumno y el id de la asignatura
     *
     * @param n objeto de tipo Nota
     * @return devuelve un 0 si la sentencia no se a completado y 1 si se a completado 
     */
    public int removeNota(Nota n) {
        NotasDAO dao = new NotasDAO();
        return dao.rmNota(n);
    }

   

}
