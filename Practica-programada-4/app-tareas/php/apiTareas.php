<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT");
header("Access-Control-Allow-Headers: Content-Type");


// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "apptareas");

if ($conn->connect_error) {
  http_response_code(500);
  echo json_encode(["error" => "Conexión fallida"]);
  exit;
}

//Select (get) tareas
if ($_SERVER['REQUEST_METHOD'] === 'GET') { 
    if (isset($_GET['idTask'])) {
      $idTask = intval($_GET['idTask']);
      $result = $conn->query("SELECT * FROM tareas WHERE idTask='$idTask'");
      $task = $result->fetch_assoc();
      echo json_encode($task);
      exit;
    }
    $result = $conn->query("SELECT * FROM tareas");
    $tareas = [];
    while ($row = $result->fetch_assoc()) {
      $tareas[] = $row;
    }
    echo json_encode($tareas);
    exit;
  }
  

//Eliminar (delete) tareas
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $data);
    if (!isset($data['idTask'])) {
      http_response_code(400);
      echo json_encode(["success" => false, "error" => "ID requerido"]);
      exit;
    }
  
    $id = intval($data['idTask']);
    if ($conn->query("DELETE FROM tareas WHERE idTask='$id'")) {
      echo json_encode(["success" => true, "message" => "Tarea eliminada con éxito"]);
    } else {
      http_response_code(500);
      echo json_encode(["success" => false, "error" => "Error al eliminar la tarea"]);
    }
    exit;
  }
  

//Hace un put mientrqs el registro sea existente, si no hace un post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'PUT') {
    $id = intval($_POST['idTask']);
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $dueDate = $conn->real_escape_string($_POST['dueDate']);
  
    $sql = "UPDATE tareas SET title='$title', description='$description', dueDate='$dueDate' WHERE idTask=$id";
    if ($conn->query($sql)) {
      echo json_encode(["success" => true]);
    } else {
      echo json_encode(["success" => false, "error" => $conn->error]);
    }
    exit;
  }

  //Crea un nuevo task
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $dueDate = $conn->real_escape_string($_POST['dueDate']);
  
    $sql = "INSERT INTO tareas (title, description, dueDate) VALUES ('$title', '$description', '$dueDate')";
    if ($conn->query($sql)) {
      echo json_encode(["success" => true]);
    } else {
      echo json_encode(["success" => false, "error" => $conn->error]);
    }
    exit;
  }
  
?>