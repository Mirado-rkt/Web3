<?php
namespace app\models;

use flight\Engine;

class User {
    public static function findByEmail($email) {
        $db = \Flight::db();
        $stmt = $db->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute([ ':email' => $email ]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        $db = \Flight::db();
        $stmt = $db->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $stmt->execute([ ':id' => $id ]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function findById($id) {
        return self::find($id);
    }

    public static function create($name, $email, $password, $isAdmin = false) {
        $db = \Flight::db();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare('INSERT INTO users (name, email, password, is_admin) VALUES (:name, :email, :password, :is_admin)');
        $stmt->execute([':name' => $name, ':email' => $email, ':password' => $hash, ':is_admin' => $isAdmin ? 1 : 0]);
        return $db->lastInsertId();
    }

    public static function count() {
        $db = \Flight::db();
        $stmt = $db->prepare('SELECT COUNT(*) as cnt FROM users WHERE is_admin = 0');
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['cnt'] ?? 0;
    }

    public static function all() {
        $db = \Flight::db();
        $stmt = $db->prepare('SELECT * FROM users WHERE is_admin = 0 ORDER BY created_at DESC');
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
