<?php

namespace app\utils;

class Session {
    public static function get($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
        return true;
    }

    public static function has($key) {
        return isset($_SESSION[$key]);
    }

    public static function flash($key, $value = null) {
        if ($value === null) {
            $val = $_SESSION['_flash'][$key] ?? null;
            unset($_SESSION['_flash'][$key]);
            return $val;
        }
        $_SESSION['_flash'][$key] = $value;
        return true;
    }

    public static function destroy() {
        // Clear server-side session
        session_destroy();
        // Clear $_SESSION array for the current request
        $_SESSION = [];
        // Also clear session cookie in the browser for cleanliness
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params['path'], $params['domain'], $params['secure'], $params['httponly']
            );
        }
    }
}
