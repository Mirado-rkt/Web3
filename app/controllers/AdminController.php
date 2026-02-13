<?php
namespace app\controllers;

use app\models\User;
use app\models\Exchange;
use app\models\Category;
use app\utils\ViewHelper;
use app\utils\Session;

class AdminController {
    public static function showLogin() {
        $app = \Flight::app();
        ViewHelper::render($app, 'admin/login', ['title' => 'Admin - Connexion']);
    }

    public static function login() {
        $data = \Flight::request()->data;
        $email = trim($data->email ?? '');
        $password = $data->password ?? '';

        // Try DB-based admin login first
        $user = User::findByEmail($email);
        if ($user && !empty($user['is_admin']) && password_verify($password, $user['password'])) {
            Session::set('admin', ['id' => $user['id'], 'name' => $user['name'], 'email' => $user['email']]);
            \Flight::redirect('/admin');
            return;
        }

        // Fallback: hardcoded admin/admin for development
        if ($email === 'admin' && $password === 'admin') {
            Session::set('admin', ['id' => 0, 'name' => 'Admin', 'email' => 'admin']);
            \Flight::redirect('/admin');
            return;
        }

        Session::flash('error', 'Identifiants admin invalides');
        \Flight::redirect('/admin/login');
    }

    public static function dashboard() {
        $app = \Flight::app();
        $admin = Session::get('admin');
        if (!$admin) { \Flight::redirect('/admin/login'); return; }

        $db = \Flight::db();
        $stmtItems = $db->prepare('SELECT COUNT(*) as cnt FROM items');
        $stmtItems->execute();
        $itemCount = $stmtItems->fetch(\PDO::FETCH_ASSOC)['cnt'] ?? 0;

        ViewHelper::render($app, 'admin/dashboard', [
            'title' => 'Admin - Dashboard',
            'user_count' => User::count(),
            'exchange_count' => Exchange::count(),
            'item_count' => $itemCount,
            'category_count' => Category::count()
        ]);
    }

    public static function logout() {
        Session::set('admin', null);
        \Flight::redirect('/');
    }

    public static function listUsers() {
        $app = \Flight::app();
        $admin = Session::get('admin');
        if (!$admin) { \Flight::redirect('/admin/login'); return; }

        ViewHelper::render($app, 'admin/users', [
            'title' => 'Admin - Utilisateurs',
            'users' => User::all()
        ]);
    }

    public static function listExchanges() {
        $app = \Flight::app();
        $admin = Session::get('admin');
        if (!$admin) { \Flight::redirect('/admin/login'); return; }

        ViewHelper::render($app, 'admin/exchanges', [
            'title' => 'Admin - Échanges',
            'exchanges' => Exchange::all()
        ]);
    }
}
