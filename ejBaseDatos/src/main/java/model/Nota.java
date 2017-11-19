package model;

public class Nota {
    
    private Long idAlumno;
    private Long idAsignatura;
    private int nota;
    
    public Nota(){
    }
    
    public void setIdAlumno(Long idAlumno){
        this.idAlumno=idAlumno;
    }
    public void setIdAsignatura(Long idAsignatura){
        this.idAsignatura=idAsignatura;
    }
    public void setNota(int nota){
        this.nota=nota;
    }
    
    public Long getIdAlumno(){
        return idAlumno;
    }
    public Long getIdAsignatura(){
        return idAsignatura;
    }
    public int getNota(){
        return nota;
    }
}
