<?php
header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . '/../routes/api.php';

// Obtener la URI y método
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Enrutar
route($uri, $method);
