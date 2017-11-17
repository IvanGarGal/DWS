
// pintarListaAlumnos.jsp

function cargarAlumnos(id, nombre, fecha, mayor) {
    document.getElementById("idalumno").value = id;
    document.getElementById("nombre").value = nombre;
    document.getElementById("fecha").value = fecha;
    document.getElementById("mayor").checked = mayor;
    document.getElementById("actualizar").disabled = false;
    document.getElementById("borrar").disabled = false;
    document.getElementById("insertar").disabled = true;
}

// pintarListaAsignaturas.jsp

function cargarAsignaturas(id, nombre, curso, ciclo) {
    document.getElementById("idasignatura").value = id;
    document.getElementById("nombre").value = nombre;
    document.getElementById("curso").value = curso;
    document.getElementById("ciclo").checked = ciclo;
    document.getElementById("actualizar").disabled = false;
    document.getElementById("borrar").disabled = false;
    document.getElementById("insertar").disabled = true;
}

// pintarListaAsignaturas.jsp y pintarListaAsignaturas.jsp

function actualizarAccion() {
    document.getElementById("accion").value = "actualizar";
}
function insertarAccion() {
    document.getElementById("accion").value = "insertar";
}
function borrarAccion() {
    document.getElementById("accion").value = "borrar";
}

// pintarListaNotas.jsp

function cargarAlumno(id, nombre) {
    document.getElementById("idAlumno").value = id;
    document.getElementById("nombreAlumno").value = nombre;
}
function cargarAsignatura(id, nombre) {
    document.getElementById("idAsignatura").value = id;
    document.getElementById("nombreAsignatura").value = nombre;
}
function guardar() {
    document.getElementById("accion").value = "guardar";
}
function borrar() {
    document.getElementById("accion").value = "borrar";
}
function cargar() {
    document.getElementById("accion").value = "cargar";
}

