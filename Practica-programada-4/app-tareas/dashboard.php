
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="#">Task Manager</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
              data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" 
              aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.html">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  
  <div class="container my-4">
    <h1 class="text-center mb-4">Your tasks</h1>
    <div class="d-flex justify-content-center mb-4">
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#taskModal">Add New Task</button>
    </div>
    <ul class="list-group" id="task-list">
        <h2 class="text-center mt-5 mb-3">Comentarios</h2>
        <ul class="list-group" id="comment-list"></ul>
        <div class="d-flex justify-content-center mt-3">
        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#commentModal">Agregar Comentario</button>
      </div>
    </ul>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="taskModalLabel">Add Task</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="task-form">
            <input type="hidden" id="task-id" name="idTask" value="">
            <div class="mb-3">
              <label for="taskTitle" class="form-label">Task Title</label>
              <input type="text" class="form-control" id="taskTitle"  name="title" required>
            </div>
            <div class="mb-3">
              <label for="taskDesc" class="form-label">Task Description</label>
              <textarea class="form-control" id="taskDesc" name="description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
              <label for="dueDate" class="form-label">Due Date</label>
              <input type="date" class="form-control" id="dueDate" name="dueDate" required>
            </div>
            <div class="d-flex justify-content-between">
              <button type="submit" class="btn btn-primary">Save Task</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal de Comentarios -->
<div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="commentModalLabel">Agregar Comentario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="comment-form">
          <input type="hidden" id="comment-id" name="idComentario" value="">
          <div class="mb-3">
            <label for="commentText" class="form-label">Comentario</label>
            <textarea class="form-control" id="commentText" name="comentario" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <label for="commentTaskId" class="form-label">ID Tarea</label>
            <input type="number" class="form-control" id="commentTaskId" name="idTask" required>
          </div>
          <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Guardar Comentario</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


  <script src="js/dashboard.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
