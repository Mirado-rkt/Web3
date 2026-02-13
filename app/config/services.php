<?php

use flight\Engine;
use flight\database\PdoWrapper;
use flight\debug\database\PdoQueryCapture;
use flight\debug\tracy\TracyExtensionLoader;
use Tracy\Debugger;

/*********************************************
 *         FlightPHP Service Setup           *
 *********************************************
 * This file registers services and integrations
 * for your FlightPHP application. Edit as needed.
 *
 * @var array  $config  From config.php
 * @var Engine $app     FlightPHP app instance
 **********************************************/



/*********************************************
 *           Session Service Setup           *
 *********************************************
 * To enable sessions in FlightPHP, register the session service.
 * Docs: https://docs.flightphp.com/awesome-plugins/session

 
 * Example:
 *   $app->register('session', \flight\Session::class, [
 *       [
 *           'prefix' 		=> 'flight_session_', 	  // Prefix for the session cookie
 *           'save_path'    => 'path/to/my/sessions', // Path to save session files
 *           // ...other options...
 *       ]
 *   ]);
 *
 * For advanced options, see the plugin documentation above.
 **********************************************/

/*********************************************
 *           Tracy Debugger Setup            *
 *********************************************
 * Tracy is a powerful error handler and debugger for PHP.
 * Docs: https://tracy.nette.org/
 *
 * Key Tracy configuration options:
 *   - Debugger::enable([mode], [ip]);
 *       - mode: Debugger::Development or Debugger::Production
 *       - ip: restrict debug bar to specific IP(s)
 *   - Debugger::$logDirectory: where error logs are stored
 *   - Debugger::$strictMode: show all errors (true/E_ALL), or filter out deprecated notices
 *   - Debugger::$showBar: show/hide debug bar (auto-detected, can be forced)
 *   - Debugger::$maxLen: max length of dumped variables
 *   - Debugger::$maxDepth: max depth of dumped structures
 *   - Debugger::$editor: configure clickable file links (see docs)
 *   - Debugger::$email: send error notifications to email
 *
 * Example Tracy setups:
 *   Debugger::enable(); // Auto-detects environment
 *   Debugger::enable(Debugger::Development); // Explicitly set environment
 *   Debugger::enable('23.75.345.200'); // Restrict debug bar to specific IPs
 *
 * For more options, see https://tracy.nette.org/en/configuration
 **********************************************/
// Map a session accessor to our static Session helper so Flight::session() works
$app->map('session', function () {
	return new class {
		public function get($key, $default = null) {
			return \app\utils\Session::get($key, $default);
		}

		public function set($key, $value) {
			return \app\utils\Session::set($key, $value);
		}

		public function has($key) {
			return \app\utils\Session::has($key);
		}

		public function flash($key, $value = null) {
			return \app\utils\Session::flash($key, $value);
		}

		public function destroy() {
			return \app\utils\Session::destroy();
		}
	};
});

Debugger::enable(); // Auto-detects environment
// Debugger::enable(Debugger::Development); // Explicitly set environment
// Debugger::enable('23.75.345.200'); // Restrict debug bar to specific IPs
Debugger::$logDirectory = __DIR__ . $ds . '..' . $ds . 'log'; // Log directory
Debugger::$strictMode = true; // Show all errors (set to E_ALL & ~E_DEPRECATED for less noise)
// Debugger::$maxLen = 1000; // Max length of dumped variables (default: 150)
// Debugger::$maxDepth = 5; // Max depth of dumped structures (default: 3)
// Debugger::$editor = 'vscode'; // Enable clickable file links in debug bar
// Debugger::$email = 'your@email.com'; // Send error notifications
if (Debugger::$showBar === true && php_sapi_name() !== 'cli') {
	(new TracyExtensionLoader($app)); // Load FlightPHP Tracy extensions
}

/**********************************************
 *           Database Service Setup           *
 **********************************************/
// Register Flight::db() service for use in models/controllers
if (isset($config['database']['host'])) {
	// MySQL Configuration
	$dsn = 'mysql:host=' . $config['database']['host'] . ';dbname=' . $config['database']['dbname'] . ';charset=utf8mb4';
	$pdoClass = Debugger::$showBar === true ? PdoQueryCapture::class : PdoWrapper::class;
	$app->register('db', $pdoClass, [ $dsn, $config['database']['user'] ?? null, $config['database']['password'] ?? null ]);
} elseif (isset($config['database']['file_path'])) {
	// SQLite Configuration
	$dsn = 'sqlite:' . $config['database']['file_path'];
	$pdoClass = Debugger::$showBar === true ? PdoQueryCapture::class : PdoWrapper::class;
	$app->register('db', $pdoClass, [ $dsn ]);
}

/**********************************************
 *         Third-Party Integrations           *
 **********************************************/
// Google OAuth Example:
// $app->register('google_oauth', Google_Client::class, [ $config['google_oauth'] ]);

// Redis Example:
// $app->register('redis', Redis::class, [ $config['redis']['host'], $config['redis']['port'] ]);

// Add more service registrations below as needed
