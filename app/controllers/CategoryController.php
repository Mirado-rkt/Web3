<?php
namespace app\controllers;

use app\models\Category;
use app\utils\ViewHelper;
use app\utils\Session;

class CategoryController {
    public static function list() {
        $app = \Flight::app();
        $admin = Session::get('admin');
        if (!$admin) { \Flight::redirect('/admin/login'); return; }
        
        $categories = Category::all();
        ViewHelper::render($app, 'admin/categories', ['title' => 'Gestion des catégories', 'categories' => $categories]);
    }

    public static function showCreate() {
        $app = \Flight::app();
        $admin = Session::get('admin');
        if (!$admin) { \Flight::redirect('/admin/login'); return; }
        
        ViewHelper::render($app, 'admin/category_create', ['title' => 'Nouvelle catégorie']);
    }

    public static function create() {
        $admin = Session::get('admin');
        if (!$admin) { \Flight::halt(403, 'Accès refusé'); return; }
        
        $name = trim(\Flight::request()->data->name ?? '');
        if (empty($name)) {
            Session::flash('error', 'Le nom est requis');
            \Flight::redirect('/admin/categories/new');
            return;
        }
        
        Category::create($name);
        Session::flash('success', 'Catégorie créée');
        \Flight::redirect('/admin/categories');
    }

    public static function showEdit($id) {
        $app = \Flight::app();
        $admin = Session::get('admin');
        if (!$admin) { \Flight::redirect('/admin/login'); return; }
        
        $category = Category::find($id);
        if (!$category) {
            \Flight::halt(404, 'Catégorie non trouvée');
            return;
        }
        
        ViewHelper::render($app, 'admin/category_edit', ['title' => 'Éditer la catégorie', 'category' => $category]);
    }

    public static function update($id) {
        $admin = Session::get('admin');
        if (!$admin) { \Flight::halt(403, 'Accès refusé'); return; }
        
        $name = trim(\Flight::request()->data->name ?? '');
        if (empty($name)) {
            Session::flash('error', 'Le nom est requis');
            \Flight::redirect('/admin/categories/edit/' . $id);
            return;
        }
        
        Category::updateName($id, $name);
        Session::flash('success', 'Catégorie mise à jour');
        \Flight::redirect('/admin/categories');
    }

    public static function delete($id) {
        $admin = Session::get('admin');
        if (!$admin) { \Flight::halt(403, 'Accès refusé'); return; }
        
        Category::delete($id);
        Session::flash('success', 'Catégorie supprimée');
        \Flight::redirect('/admin/categories');
    }
}
