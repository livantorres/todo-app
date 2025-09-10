<?php
require_once __DIR__ . '/../Helpers/DB.php';

class Todo {
    public static function all() {
        $stmt = DB::connect()->query("SELECT * FROM todos ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        $stmt = DB::connect()->prepare("SELECT * FROM todos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($title) {
        try {
            $stmt = DB::connect()->prepare("INSERT INTO todos (title, done) VALUES (?, 0)");
            $stmt->execute([$title]);
            return self::find(DB::connect()->lastInsertId());
        } catch (PDOException $e) {
            error_log("Error al crear todo: " . $e->getMessage());
            return null;
        }
    }

    public static function update($id, $data) {
        try {
            $stmt = DB::connect()->prepare("UPDATE todos SET title = ?, done = ? WHERE id = ?");
            $stmt->execute([$data['title'], $data['done'] ? 1 : 0, $id]);
            return self::find($id);
        } catch (PDOException $e) {
            error_log("Error al actualizar todo: " . $e->getMessage());
            return null;
        }
    }

    public static function toggle($id) {
        try {
            $todo = self::find($id);
            if (!$todo) return null;

            $newStatus = $todo['done'] ? 0 : 1;
            $stmt = DB::connect()->prepare("UPDATE todos SET done = ? WHERE id = ?");
            $stmt->execute([$newStatus, $id]);

            return self::find($id);
        } catch (PDOException $e) {
            error_log("Error al cambiar estado del todo: " . $e->getMessage());
            return null;
        }
    }

    public static function delete($id) {
        try {
            $stmt = DB::connect()->prepare("DELETE FROM todos WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error al eliminar todo: " . $e->getMessage());
            return false;
        }
    }
}
