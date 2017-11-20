package servicios;

import dao.NotasDAO;
import model.Nota;

public class NotasServicios {
    public Nota guardarNota(Nota nota){
        NotasDAO dao = new NotasDAO();
        return dao.guardarNota(nota);
    }
    
    public Nota getNota(Long idalu, Long idasig){
        NotasDAO dao = new NotasDAO();
        return dao.getNota(idalu, idasig);
    }
    
    public int delNota(Nota nota){
        NotasDAO dao = new NotasDAO();
        return dao.delNota(nota);
    }
}
