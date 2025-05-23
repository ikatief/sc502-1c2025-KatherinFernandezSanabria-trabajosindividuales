<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

// Obtener el método de la solicitud
$method = $_SERVER['REQUEST_METHOD'];

// Lee el cuerpo de la solicitud 
$data = json_decode(file_get_contents("php://input"), true);

switch ($method) {
    case 'GET':
        $stmt = $conn->prepare("SELECT id, taskId, description, create_at FROM comments");
        $stmt->execute();
        $result = $stmt->get_result();
        $comments = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($comments);
        break;

    case 'POST':
        $taskId = $data['task_id'] ?? null;
        $description = $data['comment'] ?? '';

        if ($taskId && $description) {
            $stmt = $conn->prepare("INSERT INTO comments (taskId, description, create_at) VALUES (?, ?, NOW())");
            $stmt->bind_param("is", $taskId, $description);
            $stmt->execute();
            echo json_encode(['success' => true, 'comment_id' => $stmt->insert_id]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Campos incompletos']);
        }
        break;

    case 'DELETE':
        $taskId = $data['task_id'] ?? null;
        $commentIndex = $data['comment_index'] ?? null;

        //Tuve que agregar un select porque sino no me tirabq los comentarios
        //además de que tengo que saber los comentarios de una tareq especifica por su taskid, por eso lo hiecq
        if ($taskId !== null && $commentIndex !== null) {
            $stmt = $conn->prepare("SELECT id FROM comments WHERE taskId = ?");
            $stmt->bind_param("i", $taskId);
            $stmt->execute();
            $result = $stmt->get_result();
            $comments = $result->fetch_all(MYSQLI_ASSOC);

            if (isset($comments[$commentIndex])) {
                $commentId = $comments[$commentIndex]['id'];
                $deleteStmt = $conn->prepare("DELETE FROM comments WHERE id = ?");
                $deleteStmt->bind_param("i", $commentId);
                $deleteStmt->execute();
                echo json_encode(['success' => true]);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Comentario no fue enCOntrado']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Los parametros son invAlidoS']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
