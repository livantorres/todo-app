<?php
class DB {
    private static $pdo;

    public static function connect() {
        if (!self::$pdo) {
            try {
                $config = include __DIR__ . '/../../config/config.php';
                
                if (!$config || !isset($config['db'])) {
                    throw new Exception("Configuración de base de datos no encontrada");
                }
                
                $dsn = "mysql:host={$config['db']['host']};dbname={$config['db']['name']};charset={$config['db']['charset']}";
                self::$pdo = new PDO($dsn, $config['db']['user'], $config['db']['pass']);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                error_log("Error de conexión a la base de datos: " . $e->getMessage());
                http_response_code(500);
                echo json_encode(["error" => "Error de conexión a la base de datos"]);
                exit;
            } catch (Exception $e) {
                error_log("Error de configuración: " . $e->getMessage());
                http_response_code(500);
                echo json_encode(["error" => "Error de configuración"]);
                exit;
            }
        }
        return self::$pdo;
    }
}
