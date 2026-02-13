<?php
namespace app\models;

class Category {
    public static function all() {
        $db = \Flight::db();
        $stmt = $db->prepare('SELECT * FROM categories ORDER BY name');
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        $db = \Flight::db();
        $stmt = $db->prepare('SELECT * FROM categories WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function create($name) {
        $db = \Flight::db();
        $stmt = $db->prepare('INSERT INTO categories (name) VALUES (:name)');
        $stmt->execute([':name' => $name]);
        return $db->lastInsertId();
    }

    public static function updateName($id, $name) {
        $db = \Flight::db();
        $stmt = $db->prepare('UPDATE categories SET name = :name WHERE id = :id');
        $stmt->execute([':name' => $name, ':id' => $id]);
        return true;
    }

    public static function delete($id) {
        $db = \Flight::db();
        $stmt = $db->prepare('DELETE FROM categories WHERE id = :id');
        $stmt->execute([':id' => $id]);
        return true;
    }

    public static function count() {
        $db = \Flight::db();
        $stmt = $db->prepare('SELECT COUNT(*) as cnt FROM categories');
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return (int) $result['cnt'];
    }
}
