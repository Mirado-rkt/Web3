<?php
namespace app\controllers;

use app\models\User;
use app\utils\ViewHelper;
use app\utils\Session;

class AuthController {
    public static function showRegister() {
        $app = \Flight::app();
        ViewHelper::render($app, 'auth/register', ['title' => 'S\'inscrire']);
    }

    public static function register() {
        $data = \Flight::request()->data;
        $pwd = password_hash($data->password ?? 'password', PASSWORD_DEFAULT);
        $db = \Flight::db();
        $stmt = $db->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :pwd)');
        $stmt->execute([ ':name' => $data->name, ':email' => $data->email, ':pwd' => $pwd ]);
        \Flight::redirect('/login');
    }

    public static function showLogin() {
        $app = \Flight::app();
        ViewHelper::render($app, 'auth/login', ['title' => 'Se connecter']);
    }

    public static function login() {
        $data = \Flight::request()->data;
        $user = User::findByEmail($data->email ?? '');
        if ($user && password_verify($data->password ?? '', $user['password'])) {
            Session::set('user', $user);
            \Flight::redirect('/items');
            return;
        }
        Session::flash('error', 'Identifiants invalides');
        \Flight::redirect('/login');
    }

    public static function logout() {
        Session::destroy();
        \Flight::redirect('/');
    }
}
