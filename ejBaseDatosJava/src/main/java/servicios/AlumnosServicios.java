package servicios;

import dao.AlumnosDAO;
import java.util.List;
import model.Alumno;

public class AlumnosServicios {

    public List<Alumno> getAllAlumnos() {
        AlumnosDAO dao = new AlumnosDAO();

        return dao.getAllAlumnosJDBC();
    }

    public Alumno getAlumnoById(int id) {
        AlumnosDAO dao = new AlumnosDAO();

        return dao.getUserById(id);

    }

    public Alumno addAlumno(Alumno alumnoNuevo) {
        AlumnosDAO dao = new AlumnosDAO();

        return dao.insertAlumnoJDBC(alumnoNuevo);
    }

    public int updateAlumno(Alumno alumnoNuevo) {
        AlumnosDAO dao = new AlumnosDAO();
        return dao.updateUser(alumnoNuevo);
    }
    
    public int delAlumno(Alumno alumnoNuevo){
        AlumnosDAO dao = new AlumnosDAO();
        return dao.delUser(alumnoNuevo);
    }

    public int delAlumno2(Alumno alumnoNuevo){
        AlumnosDAO dao = new AlumnosDAO();
        return dao.delUser2(alumnoNuevo);
    }
}
