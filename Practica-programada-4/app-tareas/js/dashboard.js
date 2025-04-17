
//Este domcontentloaded se ejecuta cuando el DOM está completamente cargado
// y se asegura de que el código JavaScript no se ejecute hasta que el DOM esté listo, esto para evitar tambien
//que no se ejecuten las tareas y comentarios antes de que el DOM (que es como un puente que conecta el HTML y el JavaScript)
//se cargue completamentqw
document.addEventListener('DOMContentLoaded', function () {
  const taskForm = document.getElementById("task-form");
  const taskList = document.getElementById("task-list");
  //Estos taskModal y commentModal son los modales que se utilizan para agregar o editar tareas y comentarios
  //El modal de tareas es el que se utiliza para agregar o editar tareas
  //El modal de comentarios es el que se utiliza para agregar o editar comentarios
  const taskModal = new bootstrap.Modal(document.getElementById('taskModal'));

  //Esto carga las tareas
  async function loadTasks() {
    try {
      const response = await fetch("php/apiTareas.php");
      const tasks = await response.json();

      taskList.innerHTML = ""; //Limpiq

      tasks.forEach(task => {
        const li = document.createElement("li");
        li.classList.add("list-group-item", "d-flex", "justify-content-between", "align-items-start", "flex-column", "flex-sm-row");

        li.innerHTML = `
          <div>
            <strong>${task.title}</strong><br>
            <small class="text-muted">Vence el: ${new Date(task.dueDate).toLocaleString("es-ES")}</small>
            <p>${task.description}</p>
          </div>
          <div>
            <button class="btn btn-sm btn-outline-primary mt-2 mt-sm-0" onclick="editTask(${task.idTask})">Editar</button>
            <button class="btn btn-sm btn-outline-danger mt-2 mt-sm-0" onclick="deleteTask(${task.idTask})">Eliminar</button>
          </div>
        `;

        taskList.appendChild(li);
      });
    } catch (error) {
      console.error("Error al cargar tareas:", error);
    }
  }

  //Guardar una nueva tarea
  taskForm.addEventListener("submit", async function (e) {
    e.preventDefault();
  
    //Aquí se obtiene el formulario de tareas y se crea un nuevo FormData para enviar los datos
    //El FormData es un objeto que se utiliza para enviar datos de formularios
    const formData = new FormData(taskForm);
    const idTask = formData.get("idTask");
  
    //Si el idTask existe, significa que se está editando una tarea existente, osea que utilizara el put
    if (idTask) {
      formData.append("_method", "PUT");
    }
  
    //sino se utilizara el post, si el idTask no existe
    try {
      const response = await fetch("php/apiTareas.php", {
        method: "POST", 
        body: formData
      });
  
      //Aquí se obtiene la respuesta del servidor
      // y se convierte a JSON
      const result = await response.json();
  
      //Si la respuesta es sucess se limpian los campos y se cierra el modal que cree
      if (result.success) {
        taskForm.reset();
        document.getElementById("task-id").value = "";
        taskModal.hide();
        loadTasks(); 
      } else {
        alert("Error al guardar la tarea, favor intentar de nuevo");
      }
    } catch (error) {
      console.error("Error al enviar tarea, mira el error:", error);
    }
  });
  
  

  //Elimiqr la tarea
  //El window es para que deleteTask sea algp global y se pueda utilizar en el dashboard.php
  window.deleteTask = async function (id) {
    if (!confirm("¿Estás seguro de eliminar esta tarea? No se puede revertir")) return;

    //Esto es un try que intenta eliminar la tarea
    //Si no se puede eliminar la tarea, se muestra un mensaje de error
    try {
      const response = await fetch("php/apiTareas.php", {
        method: "DELETE",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `idTask=${id}`
      });

      const result = await response.json();

      if (result.success) {
        loadTasks();
      } else {
        alert("Error al eliminar la tarea, favor intentqr de nuevo");
      }
    } catch (error) {
      console.error("Error al eliminar tarea, ver errqr:", error);
    }
  };

  //Esto es para editar la tarea
  window.editTask = async function (id) {
    try {
      const response = await fetch(`php/apiTareas.php?idTask=${id}`);
      const task = await response.json();
  
      //Aquí se cargan los datos de la tarea en el formulario
      document.getElementById("taskTitle").value = task.title;
      document.getElementById("taskDesc").value = task.description;
      document.getElementById("dueDate").value = task.dueDate;
      document.getElementById("task-id").value = task.idTask;
      console.log(task.idTask);
  
      //Estq es para mostrar el modal de la tarea, el que creamos al principiqo del docuemnto
      const taskModal = new bootstrap.Modal(document.getElementById('taskModal'));
      taskModal.show();
  
    } catch (error) {
      console.error("Error al cargar la tarea para editar, ver:", error);
    }
  };

  loadTasks();
});

  