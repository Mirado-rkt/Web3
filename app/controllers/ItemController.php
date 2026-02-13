<?php
namespace app\controllers;

use app\models\Item;
use app\models\Photo;
use app\models\Category;
use app\utils\ViewHelper;
use app\utils\Session;

class ItemController {
    public static function list() {
        $app = \Flight::app();
        
        // Récupérer les paramètres de recherche
        $keyword = trim(\Flight::request()->query->keyword ?? '');
        $categoryId = \Flight::request()->query->category_id ?? null;
        
        // Chercher les items
        if (!empty($keyword) || $categoryId) {
            $items = Item::search($keyword, $categoryId, 100);
        } else {
            $items = Item::all(100);
        }
        
        // Charger les photos pour chaque item
        foreach ($items as &$item) {
            $item['photos'] = Photo::findByItem($item['id']);
        }
        
        // Charger les catégories pour le formulaire
        $categories = Category::all();
        
        ViewHelper::render($app, 'objets_list', [ 
            'items' => $items, 
            'title' => 'Objets disponibles',
            'categories' => $categories,
            'keyword' => $keyword,
            'selected_category' => $categoryId
        ]);
    }

    public static function view($id) {
        $app = \Flight::app();
        $item = Item::find($id);
        if (!$item) {
            \Flight::halt(404, 'Article non trouvé');
        }
        
        // Charger les photos
        $item['photos'] = Photo::findByItem($id);
        
        // Charger l'historique d'échanges
        $db = \Flight::db();
        $stmt = $db->prepare('SELECT ih.*, u1.name as previous_owner_name, u2.name as new_owner_name FROM item_history ih JOIN users u1 ON u1.id = ih.previous_owner_id JOIN users u2 ON u2.id = ih.new_owner_id WHERE ih.item_id = :item_id ORDER BY ih.exchanged_at DESC');
        $stmt->execute([':item_id' => $id]);
        $item['history'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        ViewHelper::render($app, 'objets_view', [ 'item' => $item, 'title' => $item['title'] ]);
    }

    public static function myItems() {
        $app = \Flight::app();
        $user = Session::get('user');
        if (!$user) { \Flight::redirect('/login'); }
        
        $items = Item::findByOwner($user['id']);
        
        // Charger les photos pour chaque item
        foreach ($items as &$item) {
            $item['photos'] = Photo::findByItem($item['id']);
        }
        
        ViewHelper::render($app, 'my_items', ['title' => 'Mes objets', 'items' => $items]);
    }
}
