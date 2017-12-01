/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package servicios;

import dao.NotasDAO;
import java.util.Iterator;
import java.util.Map;

import model.Nota;
import utils.SqlQuery;

/**
 *
 * @author daw
 */
public class NotasServicios {

    NotasDAO dao;

    public NotasServicios() {
        dao = new NotasDAO();
    }

    public Nota getNota(Nota nota) {
        return dao.getNotaJDBC((int) nota.getId_alumno(), (int) nota.getId_asignatura());
    }

    public boolean updateNota(Nota nota) {
        return dao.updateNotadbUtils(nota);
    }

    public boolean insertNota(Nota nota) {
        return dao.insertUserJDBC(nota);
    }

    public boolean deleteNota(int i) {
        return dao.deleteNotadbUtils(i);
    }

    public Nota tratarParametros(Map<String, String[]> parametros) {
        Nota claves = null;
        if (parametros != null && !parametros.isEmpty()) {

            claves = new Nota();

            Iterator<String> it = parametros.keySet().iterator();

            while (it.hasNext()) {
                String key = (String) it.next();
                String[] values = (String[]) parametros.get(key);
                if (values[0] != null && !values[0].isEmpty()) {

                    if (SqlQuery.ID_ALUMNO.equalsIgnoreCase(key)) {
                        claves.setId_alumno(Long.valueOf(values[0]));
                    } else if (SqlQuery.ID_ASIGNATURA.equalsIgnoreCase(key)) {
                        claves.setId_asignatura(Long.valueOf(values[0]));
                    } else if (SqlQuery.NOTA.equalsIgnoreCase(key)) {
                        claves.setNota(Integer.valueOf(values[0]));
                    }
                }

            }

        }
        return claves;
    }

}//fin clase
