<?php
header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . '/../src/Controllers/TodoController.php';

$controller = new TodoController();
$controller->store();
?>