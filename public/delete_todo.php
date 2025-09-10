<?php
header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . '/../src/Controllers/TodoController.php';

$controller = new TodoController();
$id = $_GET['id'] ?? null;
if ($id) {
    $controller->destroy($id);
} else {
    http_response_code(400);
    echo json_encode(["error" => "ID requerido"]);
}
?>