/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package utils;

/**
 *
 * @author daw
 */
public class SqlQuery {

    //Nombre columnas tabla Alumnos
    public static String ID = "ID";
    public final static String NOMBRE = "NOMBRE";
    public static String FECHA_NACIMIENTO = "FECHA_NACIMIENTO";
    public static String MAYOR_EDAD = "MAYOR_EDAD";

    //columnas tabla Asignaturas
    public static String CURSO = "CURSO";
    public static String CICLO = "CICLO";

    //columnas tabla notas
    public static String ID_ALUMNO = "ID_ALUMNO";
    public static String ID_ASIGNATURA = "ID_ASIGNATURA";
    public static String NOTA = "NOTA";

    public static String SELECT_ALL_ALUMNOS = "SELECT * FROM ALUMNOS";
    public static String UPDATE_ALUMNO = "UPDATE ALUMNOS SET NOMBRE = ? , FECHA_NACIMIENTO = ?, MAYOR_EDAD = ? WHERE ID = ?";
    public static String INSERT_ALUMNO = "INSERT INTO ALUMNOS (NOMBRE, FECHA_NACIMIENTO, MAYOR_EDAD)  VALUES ( ?, ?, ?)";
    public static String DELETE_ALUMNO = "DELETE FROM ALUMNOS WHERE ID = ? ";

    public static String SELECT_ALL_ASIGNATURAS = "SELECT * FROM ASIGNATURAS";
    public static String INSERT_ASIGNATURA = "INSERT INTO ASIGNATURAS (NOMBRE, CURSO, CICLO) VALUES(?,?,?)";
    public static String UPDATE_ASIGNATURA = "UPDATE ASIGNATURAS SET NOMBRE= ? , CURSO = ? , CICLO = ? WHERE ID = ?";
    public static String DELETE_ASIGNATURA = "DELETE FROM ASIGNATURAS WHERE ID = ? ";

    public static String SELECT_NOTA = "SELECT NOTAS.ID_ALUMNO,NOTAS.ID_ASIGNATURA,NOTAS.NOTA FROM NOTAS, ALUMNOS, ASIGNATURAS "
            + "WHERE NOTAS.ID_ALUMNO = ALUMNOS.ID AND ASIGNATURAS.ID = NOTAS.ID_ASIGNATURA "
            + "AND NOTAS.ID_ASIGNATURA = ? AND NOTAS.ID_ALUMNO = ?";
    public static String UPDATE_NOTA = "UPDATE NOTAS "
            + "SET NOTA = ? "
            + "WHERE ID_ALUMNO = ? AND ID_ASIGNATURA = ?";
    public static String INSERT_NOTAS = "INSERT INTO NOTAS (ID_ALUMNO, ID_ASIGNATURA, NOTA) VALUES (?,?,?)";

    //FORCE-DELETE
    public static String DELETE_NOTA_ALUMNO = "DELETE FROM NOTAS WHERE ID_ALUMNO = ? ";
    public static String DELETE_NOTA_ASIGNATURA = "DELETE FROM NOTAS WHERE ID_ASIGNATURA = ? ";
    
    
}
