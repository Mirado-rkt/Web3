<?php
namespace app\models;

class Photo {
    public static function findByItem($itemId) {
        $db = \Flight::db();
        $stmt = $db->prepare('SELECT * FROM photos WHERE item_id = :item_id ORDER BY created_at');
        $stmt->execute([':item_id' => $itemId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function create($itemId, $filePath) {
        $db = \Flight::db();
        $stmt = $db->prepare('INSERT INTO photos (item_id, file_path) VALUES (:item_id, :file_path)');
        $stmt->execute([':item_id' => $itemId, ':file_path' => $filePath]);
        return $db->lastInsertId();
    }

    public static function delete($id) {
        $db = \Flight::db();
        $stmt = $db->prepare('DELETE FROM photos WHERE id = :id');
        $stmt->execute([':id' => $id]);
        return true;
    }

    public static function deleteByItem($itemId) {
        $db = \Flight::db();
        $stmt = $db->prepare('DELETE FROM photos WHERE item_id = :item_id');
        $stmt->execute([':item_id' => $itemId]);
        return true;
    }
}
