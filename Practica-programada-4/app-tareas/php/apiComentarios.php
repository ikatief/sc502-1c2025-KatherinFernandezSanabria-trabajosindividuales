<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT");
header("Access-Control-Allow-Headers: Content-Type");

$conn = new mysqli("localhost", "root", "", "apptareas");

if ($conn->connect_error) {
  http_response_code(500);
  echo json_encode(["error" => "Conexión fallida"]);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') { 
    if (isset($_GET['idComentario'])) {
      $idComentario = intval($_GET['idComentario']);
      $result = $conn->query("SELECT * FROM comentarios WHERE idComentario='$idComentario'");
      $comentario = $result->fetch_assoc();
      echo json_encode($comentario);
      exit;
    }

    if (isset($_GET['idTask'])) {
      $idTask = intval($_GET['idTask']);
      $result = $conn->query("SELECT * FROM comentarios WHERE idTask='$idTask'");
      $comentarios = [];
      while ($row = $result->fetch_assoc()) {
        $comentarios[] = $row;
      }
      echo json_encode($comentarios);
      exit;
    }
    $result = $conn->query("SELECT * FROM comentarios");
    $comentarios = [];
    while ($row = $result->fetch_assoc()) {
      $comentarios[] = $row;
    }
    echo json_encode($comentarios);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $data);
    if (!isset($data['idComentario'])) {
        http_response_code(400);
        echo json_encode(["success" => false, "error" => "id requerido"]);
        exit;
    }
  
    $idComentario = intval($data['idComentario']);
    if ($conn->query("DELETE FROM comentarios WHERE idComentario='$idComentario'")) {
      echo json_encode(["success" => true, "message" => "Comentario eliminado con éxito"]);
    } else {
      http_response_code(500);
      echo json_encode(["success" => false, "error" => "Error al eliminar el comentario"]);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'PUT') {
    $idComentario = intval($_POST['idComentario']);
    $comentario = $conn->real_escape_string($_POST['comentario']);
  
    $sql = "UPDATE comentarios SET comentario='$comentario' WHERE idComentario=$idComentario";
    if ($conn->query($sql)) {
      echo json_encode(["success" => true]);
    } else {
      echo json_encode(["success" => false, "error" => $conn->error]);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comentario = $conn->real_escape_string($_POST['comentario']);
    $idTask = intval($_POST['idTask']);
  
    $sql = "INSERT INTO comentarios (comentario, idTask) VALUES ('$comentario', '$idTask')";
    if ($conn->query($sql)) {
      echo json_encode(["success" => true]);
    } else {
      echo json_encode(["success" => false, "error" => $conn->error]);
    }
    exit;
}
?>

