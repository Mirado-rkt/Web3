<?php
require __DIR__ . '/../vendor/autoload.php';

// Emulate bootstrap context variables
$ds = DIRECTORY_SEPARATOR;

$app = Flight::app();
$config = require __DIR__ . '/../app/config/config.php';
require __DIR__ . '/../app/config/services.php';

try {
    $s = Flight::session();
    echo "session mapped: ";
    var_dump(is_object($s));
    echo "has get method: ";
    var_dump(method_exists($s, 'get'));
    echo "call get: ";
    var_dump($s->get('nonexistent', 'default'));
} catch (Throwable $e) {
    echo "Exception: " . $e->getMessage() . PHP_EOL;
}
