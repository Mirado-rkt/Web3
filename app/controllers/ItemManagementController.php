<?php
namespace app\controllers;

use app\models\Item;
use app\models\Photo;
use app\utils\ViewHelper;
use app\utils\Session;

class ItemManagementController {
    public static function showForm() {
        $app = \Flight::app();
        $user = Session::get('user');
        if (!$user) { \Flight::redirect('/login'); }
        
        // Charger catégories
        $db = \Flight::db();
        $stmt = $db->prepare('SELECT * FROM categories ORDER BY name');
        $stmt->execute();
        $categories = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        ViewHelper::render($app, 'item_form', ['title' => 'Ajouter un objet', 'categories' => $categories]);
    }

    public static function save() {
        $user = Session::get('user');
        if (!$user) { \Flight::halt(403, 'Connexion requise'); }
        
        $title = trim(\Flight::request()->data->title ?? '');
        $description = trim(\Flight::request()->data->description ?? '');
        $price = trim(\Flight::request()->data->estimated_price ?? '0');
        $categoryId = \Flight::request()->data->category_id ?? null;
        
        if (empty($title)) { 
            Session::flash('error', 'Le titre est requis');
            \Flight::redirect('/item/new');
            return;
        }
        
        // Créer l'objet
        $itemId = Item::create($user['id'], $categoryId, $title, $description, $price);
        
        // Traiter les photos uploadées
        $files = $_FILES['photos'] ?? null;
        if ($files && !empty($files['tmp_name'])) {
            for ($i = 0; $i < count($files['tmp_name']); $i++) {
                if (is_uploaded_file($files['tmp_name'][$i])) {
                    $name = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($files['name'][$i]));
                    $destDir = __DIR__ . '/../../public/uploads/';
                    if (!is_dir($destDir)) mkdir($destDir, 0755, true);
                    $dest = $destDir . $name;
                    move_uploaded_file($files['tmp_name'][$i], $dest);
                    Photo::create($itemId, '/uploads/' . $name);
                }
            }
        }
        
        // Traiter les images existantes sélectionnées from assets/images
        $existing = \Flight::request()->data->{'existing_photos'} ?? [];
        if (!empty($existing)) {
            foreach ((array)$existing as $ename) {
                Photo::create($itemId, 'assets/images/' . basename($ename));
            }
        }
        
        Session::flash('success', 'Objet ajouté avec succès');
        \Flight::redirect('/my/items');
    }

    public static function detail($id) {
        $app = \Flight::app();
        $item = Item::find($id);
        
        if (!$item) {
            \Flight::halt(404, 'Objet non trouvé');
        }
        
        // Charger les photos
        $photos = Photo::findByItem($id);
        $item['photos'] = $photos;
        
        // Charger l'historique d'échanges
        $db = \Flight::db();
        $stmt = $db->prepare('SELECT ih.*, u1.name as previous_owner_name, u2.name as new_owner_name FROM item_history ih JOIN users u1 ON u1.id = ih.previous_owner_id JOIN users u2 ON u2.id = ih.new_owner_id WHERE ih.item_id = :item_id ORDER BY ih.exchanged_at DESC');
        $stmt->execute([':item_id' => $id]);
        $history = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $item['history'] = $history;
        
        ViewHelper::render($app, 'item_detail', ['title' => $item['title'], 'item' => $item]);
    }

    public static function showEditForm($id) {
        $app = \Flight::app();
        $user = Session::get('user');
        if (!$user) { \Flight::redirect('/login'); }
        
        $item = Item::find($id);
        if (!$item || $item['owner_id'] !== $user['id']) {
            \Flight::halt(403, 'Non autorisé');
        }
        
        // Charger les photos
        $item['photos'] = Photo::findByItem($id);
        
        // Charger catégories
        $db = \Flight::db();
        $stmt = $db->prepare('SELECT * FROM categories ORDER BY name');
        $stmt->execute();
        $categories = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        ViewHelper::render($app, 'item_edit', ['title' => 'Éditer ' . $item['title'], 'item' => $item, 'categories' => $categories]);
    }

    public static function update($id) {
        $user = Session::get('user');
        if (!$user) { \Flight::halt(403, 'Connexion requise'); }
        
        $item = Item::find($id);
        if (!$item || $item['owner_id'] !== $user['id']) {
            \Flight::halt(403, 'Non autorisé');
        }
        
        $title = trim(\Flight::request()->data->title ?? '');
        $description = trim(\Flight::request()->data->description ?? '');
        $price = trim(\Flight::request()->data->estimated_price ?? '0');
        $categoryId = \Flight::request()->data->category_id ?? null;
        
        if (empty($title)) { 
            Session::flash('error', 'Le titre est requis');
            \Flight::redirect('/item/' . $id . '/edit');
            return;
        }
        
        // Mettre à jour l'objet
        Item::update($id, $categoryId, $title, $description, $price);
        
        // Traiter les photos uploadées
        $files = $_FILES['photos'] ?? null;
        if ($files && !empty($files['tmp_name'][0])) {
            for ($i = 0; $i < count($files['tmp_name']); $i++) {
                if (!empty($files['tmp_name'][$i]) && is_uploaded_file($files['tmp_name'][$i])) {
                    $name = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($files['name'][$i]));
                    $destDir = __DIR__ . '/../../public/uploads/';
                    if (!is_dir($destDir)) mkdir($destDir, 0755, true);
                    $dest = $destDir . $name;
                    move_uploaded_file($files['tmp_name'][$i], $dest);
                    Photo::create($id, '/uploads/' . $name);
                }
            }
        }
        
        Session::flash('success', 'Objet mis à jour avec succès');
        \Flight::redirect('/my/items');
    }

    public static function delete($id) {
        $user = Session::get('user');
        if (!$user) { \Flight::halt(403, 'Connexion requise'); }
        
        $item = Item::find($id);
        if (!$item || $item['owner_id'] !== $user['id']) {
            \Flight::halt(403, 'Non autorisé');
        }
        
        // Supprimer les photos associées
        Photo::deleteByItem($id);
        
        // Supprimer l'objet
        Item::delete($id);
        
        Session::flash('success', 'Objet supprimé avec succès');
        \Flight::redirect('/my/items');
    }
}
