<?php

$conn = new mysqli("localhost", "root", "", "caso_estudio");

if ($conn->connect_error) {
  http_response_code(500);
  echo json_encode(["error" => "Conexión fallida"]);
  exit;
}

