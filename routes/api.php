<?php
require_once __DIR__ . '/../src/Controllers/TodoController.php';

function route($uri, $method) {
    $controller = new TodoController();

    if ($uri === '/api/todos' && $method === 'GET') {
        $controller->index();
        return;
    } elseif ($uri === '/api/todos' && $method === 'POST') {
        $controller->store();
        return;
    } elseif (preg_match('#^/api/todos/(\d+)$#', $uri, $matches) && $method === 'PUT') {
        $controller->update($matches[1]);
        return;
    } elseif (preg_match('#^/api/todos/(\d+)/toggle$#', $uri, $matches) && $method === 'PATCH') {
        $controller->toggle($matches[1]);
        return;
    } elseif (preg_match('#^/api/todos/(\d+)$#', $uri, $matches) && $method === 'DELETE') {
        $controller->destroy($matches[1]);
        return;
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Ruta no encontrada", "uri" => $uri]);
        return;
    }
}
