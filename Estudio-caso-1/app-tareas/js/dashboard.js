document.addEventListener('DOMContentLoaded', function () {
    const tasks = [{ 
        id: 1, 
        title: "Complete project report", 
        description: "Prepare and submit the project report", 
        dueDate: "2024-12-01", 
        comments: [] 
    },
    { 
        id: 2, 
        title: "Team Meeting", 
        description: "Get ready for the season", 
        dueDate: "2024-12-01", 
        comments: [] 
    },
    { 
        id: 3, 
        title: "Code Review", 
        description: "Check partners code", 
        dueDate: "2024-12-01", 
        comments: [] 
    }];

    function loadTasks() {
        const taskList = document.getElementById('task-list');
        taskList.innerHTML = '';

        tasks.forEach(task => {
            const taskCard = document.createElement('div');
            taskCard.className = 'col-md-4 mb-3';
            taskCard.innerHTML = `
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">${task.title}</h5>
                        <p class="card-text">${task.description}</p>
                        <p class="card-text"><small class="text-muted">Due: ${task.dueDate}</small></p>

                        <!-- Aquí hice lo de comentarios -->
                        <div class="comments-section">
                            <h6>Comments</h6>
                            <ul class="list-group list-group-flush" id="comment-list-${task.id}">
                                ${task.comments.map(comment => `
                                    <li class="list-group-item d-flex justify-content-between">
                                        ${comment} 
                                        <button class="btn btn-sm btn-danger delete-comment" data-task-id="${task.id}" data-comment="${comment}">X</button>
                                    </li>`).join('')}
                            </ul>
                            <div class="mt-3 d-flex flex-column align-items-center">
                            <input type="text" class="form-control mb-3 comment-input text-center" id="comment-input-${task.id}" placeholder="Add a comment">
                            <button class="btn btn-success btn-sm add-comment px-6 py-2 mb-3" data-task-id="${task.id}">Añadir comentario</button>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <button class="btn btn-secondary btn-sm edit-task" data-id="${task.id}">Edit</button>
                        <button class="btn btn-danger btn-sm delete-task" data-id="${task.id}">Delete</button>
                    </div>
                </div>
            `;
            taskList.appendChild(taskCard);
        });

        document.querySelectorAll('.add-comment').forEach(button => {
            button.addEventListener('click', handleAddComment);
        });

        document.querySelectorAll('.delete-comment').forEach(button => {
            button.addEventListener('click', handleDeleteComment);
        });

        document.querySelectorAll('.edit-task').forEach(button => {
            button.addEventListener('click', handleEditTask);
        });

        document.querySelectorAll('.delete-task').forEach(button => {
            button.addEventListener('click', handleDeleteTask);
        });
    }

    function handleAddComment(event) {
        const taskId = parseInt(event.target.dataset.taskId);
        const commentInput = document.getElementById(`comment-input-${taskId}`);
        const commentText = commentInput.value.trim();

        if (commentText !== "") {
            const task = tasks.find(t => t.id === taskId);
            task.comments.push(commentText);
            commentInput.value = '';
            loadTasks();
        }
    }

    function handleDeleteComment(event) {
        const taskId = parseInt(event.target.dataset.taskId);
        const commentText = event.target.dataset.comment;
        const task = tasks.find(t => t.id === taskId);

        if (task) {
            task.comments = task.comments.filter(comment => comment !== commentText);
            loadTasks();
        }
    }

    function handleEditTask(event) {
        const taskId = parseInt(event.target.dataset.id);
        const task = tasks.find(t => t.id === taskId);

        if (task) {
            document.getElementById('task-id').value = task.id;
            document.getElementById('task-title').value = task.title;
            document.getElementById('task-desc').value = task.description;
            document.getElementById('due-date').value = task.dueDate;

            const modal = new bootstrap.Modal(document.getElementById('taskModal'));
            modal.show();
        }
    }

    function handleDeleteTask(event) {
        const taskId = parseInt(event.target.dataset.id);
        const taskIndex = tasks.findIndex(t => t.id === taskId);

        if (taskIndex !== -1) {
            tasks.splice(taskIndex, 1);
            loadTasks();
        }
    }

    document.getElementById('task-form').addEventListener('submit', function (e) {
        e.preventDefault();
        let currentTaskId = document.getElementById('task-id').value;
        const taskTitle = document.getElementById('task-title').value;
        const taskDesc = document.getElementById('task-desc').value;
        const dueDate = document.getElementById('due-date').value;

        if (currentTaskId) {
            const taskIndex = tasks.findIndex(t => t.id === parseInt(currentTaskId));
            tasks[taskIndex] = { id: parseInt(currentTaskId), title: taskTitle, description: taskDesc, dueDate, comments: tasks[taskIndex].comments };
        } else {
            tasks.push({ id: tasks.length + 1, title: taskTitle, description: taskDesc, dueDate, comments: [] });
        }

        document.getElementById('task-id').value = '';
        e.target.reset();
        loadTasks();

        const modal = bootstrap.Modal.getInstance(document.getElementById('taskModal'));
        modal.hide();
    });

    loadTasks();
});
