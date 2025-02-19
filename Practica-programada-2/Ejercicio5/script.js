const estudiantes = [
    { nombre: "Katherin", apellido: "Fernández", nota: 98 },
    { nombre: "Félix", apellido: "Barboza", nota: 100 },
    { nombre: "Wendy", apellido: "Cuendis", nota: 92.5 },
    { nombre: "Sebastián", apellido: "Sallow", nota: 80.7 }
];

const listaEstudiantes = document.getElementById('listaEstudiantes');
const promedioDiv = document.getElementById('promedio');
const botonPromedio = document.getElementById('botonPromedio');

function mostrarEstudiantes() {
    listaEstudiantes.innerHTML = ''; 

    estudiantes.forEach(estudiante => {
        const fila = document.createElement('tr');
        
        const columnaNombre = document.createElement('td');
        columnaNombre.textContent = estudiante.nombre;
        fila.appendChild(columnaNombre);

        const columnaApellido = document.createElement('td');
        columnaApellido.textContent = estudiante.apellido;
        fila.appendChild(columnaApellido);

        const columnaNota = document.createElement('td');
        columnaNota.textContent = estudiante.nota;
        fila.appendChild(columnaNota);

        listaEstudiantes.appendChild(fila);
    });
}

function calcularPromedio() {
    let sumaNotas = 0;

    estudiantes.forEach(estudiante => {
        sumaNotas += estudiante.nota;
    });

    const promedio = sumaNotas / estudiantes.length;
    promedioDiv.textContent = "Promedio de notas: " + promedio.toFixed(2);
}

mostrarEstudiantes();

botonPromedio.addEventListener('click', calcularPromedio);

