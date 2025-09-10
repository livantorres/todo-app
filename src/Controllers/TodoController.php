<?php
require_once __DIR__ . '/../Models/Todo.php';

class TodoController {
    public function index() {
        echo json_encode(Todo::all());
    }

    public function store() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['title']) || empty(trim($data['title']))) {
            http_response_code(400);
            echo json_encode(["error" => "El título es obligatorio"]);
            return;
        }
        echo json_encode(Todo::create($data['title']));
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        
        // Validar que el ID sea numérico
        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(["error" => "ID inválido"]);
            return;
        }
        
        // Validar que el todo exista
        $existingTodo = Todo::find($id);
        if (!$existingTodo) {
            http_response_code(404);
            echo json_encode(["error" => "Todo no encontrado"]);
            return;
        }
        
        // Validar datos de entrada
        if (!isset($data['title']) || empty(trim($data['title']))) {
            http_response_code(400);
            echo json_encode(["error" => "El título es obligatorio"]);
            return;
        }
        
        if (!isset($data['done']) || !is_bool($data['done'])) {
            http_response_code(400);
            echo json_encode(["error" => "El campo 'done' debe ser un booleano"]);
            return;
        }
        
        $todo = Todo::update($id, $data);
        echo json_encode($todo);
    }

    public function toggle($id) {
        // Validar que el ID sea numérico
        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(["error" => "ID inválido"]);
            return;
        }
        
        $todo = Todo::toggle($id);
        if ($todo) {
            echo json_encode($todo);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Todo no encontrado"]);
        }
    }

    public function destroy($id) {
        // Validar que el ID sea numérico
        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(["error" => "ID inválido"]);
            return;
        }
        
        // Verificar que el todo exista antes de eliminar
        $existingTodo = Todo::find($id);
        if (!$existingTodo) {
            http_response_code(404);
            echo json_encode(["error" => "Todo no encontrado"]);
            return;
        }
        
        if (Todo::delete($id)) {
            echo json_encode(["success" => true]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al eliminar el todo"]);
        }
    }
}
