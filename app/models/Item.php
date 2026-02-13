<?php
namespace app\models;

class Item {
    public static function all($limit = 50) {
        $db = \Flight::db();
        $stmt = $db->prepare('SELECT i.*, u.name as owner_name, c.name as category_name FROM items i LEFT JOIN users u ON u.id = i.owner_id LEFT JOIN categories c ON c.id = i.category_id ORDER BY i.created_at DESC LIMIT :limit');
        $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        $db = \Flight::db();
        $stmt = $db->prepare('SELECT i.*, u.name as owner_name, c.name as category_name FROM items i LEFT JOIN users u ON u.id = i.owner_id LEFT JOIN categories c ON c.id = i.category_id WHERE i.id = :id LIMIT 1');
        $stmt->execute([ ':id' => $id ]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function findByOwner($ownerId) {
        $db = \Flight::db();
        $stmt = $db->prepare('SELECT i.*, u.name as owner_name, c.name as category_name FROM items i LEFT JOIN users u ON u.id = i.owner_id LEFT JOIN categories c ON c.id = i.category_id WHERE i.owner_id = :owner_id ORDER BY i.created_at DESC');
        $stmt->execute([':owner_id' => $ownerId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function search($keyword = '', $categoryId = null, $limit = 50) {
        $db = \Flight::db();
        $query = 'SELECT i.*, u.name as owner_name, c.name as category_name FROM items i LEFT JOIN users u ON u.id = i.owner_id LEFT JOIN categories c ON c.id = i.category_id WHERE 1=1';
        $params = [];
        
        if (!empty($keyword)) {
            $query .= ' AND (i.title LIKE :keyword OR i.description LIKE :keyword)';
            $params[':keyword'] = '%' . $keyword . '%';
        }
        
        if ($categoryId) {
            $query .= ' AND i.category_id = :category_id';
            $params[':category_id'] = $categoryId;
        }
        
        $query .= ' ORDER BY i.created_at DESC LIMIT :limit';
        $stmt = $db->prepare($query);
        $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function create($ownerId, $categoryId, $title, $description, $estimatedPrice) {
        $db = \Flight::db();
        $stmt = $db->prepare('INSERT INTO items (owner_id, category_id, title, description, estimated_price) VALUES (:owner_id, :category_id, :title, :description, :estimated_price)');
        $stmt->execute([
            ':owner_id' => $ownerId,
            ':category_id' => $categoryId,
            ':title' => $title,
            ':description' => $description,
            ':estimated_price' => $estimatedPrice
        ]);
        return $db->lastInsertId();
    }

    public static function update($id, $categoryId, $title, $description, $estimatedPrice) {
        $db = \Flight::db();
        $stmt = $db->prepare('UPDATE items SET category_id = :category_id, title = :title, description = :description, estimated_price = :estimated_price WHERE id = :id');
        $stmt->execute([
            ':id' => $id,
            ':category_id' => $categoryId,
            ':title' => $title,
            ':description' => $description,
            ':estimated_price' => $estimatedPrice
        ]);
        return true;
    }

    public static function delete($id) {
        $db = \Flight::db();
        $stmt = $db->prepare('DELETE FROM items WHERE id = :id');
        $stmt->execute([':id' => $id]);
        return true;
    }
}
