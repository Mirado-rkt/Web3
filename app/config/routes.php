<?php

use app\controllers\ApiExampleController;
use app\controllers\AuthController;
use app\controllers\ItemController;
use app\controllers\ExchangeController;
use app\utils\ViewHelper;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function(Router $router) use ($app) {

	$router->get('/', function() use ($app) {
		ViewHelper::render($app, 'welcome', [ 'title' => 'Accueil' ]);
	});

	// Auth
	$router->get('/register', [ AuthController::class, 'showRegister' ]);
	$router->post('/register', [ AuthController::class, 'register' ]);
	$router->get('/login', [ AuthController::class, 'showLogin' ]);
	$router->post('/login', [ AuthController::class, 'login' ]);
	$router->get('/logout', [ AuthController::class, 'logout' ]);

	// Items
	$router->get('/items', [ ItemController::class, 'list' ]);
	$router->get('/items/@id', [ ItemController::class, 'view' ]);
	$router->get('/my/items', [ ItemController::class, 'myItems' ]);

	// Item management (front) - use /item/* to avoid collision with /items/@id
	$router->get('/item/new', [ \app\controllers\ItemManagementController::class, 'showForm' ]);
	$router->post('/item/save', [ \app\controllers\ItemManagementController::class, 'save' ]);
	$router->get('/item/manage/@id', [ \app\controllers\ItemManagementController::class, 'detail' ]);
	$router->get('/item/@id/edit', [ \app\controllers\ItemManagementController::class, 'showEditForm' ]);
	$router->post('/item/@id/update', [ \app\controllers\ItemManagementController::class, 'update' ]);
	$router->post('/item/@id/delete', [ \app\controllers\ItemManagementController::class, 'delete' ]);

	// Exchanges
	$router->post('/exchanges/propose', [ ExchangeController::class, 'propose' ]);
	$router->get('/exchanges', [ ExchangeController::class, 'proposals' ]);
	$router->post('/exchanges/@id/accept', [ ExchangeController::class, 'accept' ]);
	$router->post('/exchanges/@id/refuse', [ ExchangeController::class, 'refuse' ]);

	// Admin & categories
	$router->get('/admin/login', [ \app\controllers\AdminController::class, 'showLogin' ]);
	$router->post('/admin/login', [ \app\controllers\AdminController::class, 'login' ]);
	$router->get('/admin/logout', [ \app\controllers\AdminController::class, 'logout' ]);
	$router->get('/admin', [ \app\controllers\AdminController::class, 'dashboard' ]);

	$router->get('/admin/categories', [ \app\controllers\CategoryController::class, 'list' ]);
	$router->get('/admin/categories/new', [ \app\controllers\CategoryController::class, 'showCreate' ]);
	$router->post('/admin/categories/new', [ \app\controllers\CategoryController::class, 'create' ]);
	$router->get('/admin/categories/edit/@id', [ \app\controllers\CategoryController::class, 'showEdit' ]);
	$router->post('/admin/categories/edit/@id', [ \app\controllers\CategoryController::class, 'update' ]);
	$router->get('/admin/categories/delete/@id', [ \app\controllers\CategoryController::class, 'delete' ]);
	
	$router->get('/admin/users', [ \app\controllers\AdminController::class, 'listUsers' ]);
	$router->get('/admin/exchanges', [ \app\controllers\AdminController::class, 'listExchanges' ]);

	// Public history + statistics pages
	$router->get('/history', function() use ($app) {
		$db = \Flight::db();
		$stmt = $db->prepare('SELECT ih.*, i.title as item_title, u1.name as previous_owner_name, u2.name as new_owner_name FROM item_history ih JOIN items i ON i.id = ih.item_id JOIN users u1 ON u1.id = ih.previous_owner_id JOIN users u2 ON u2.id = ih.new_owner_id ORDER BY ih.exchanged_at DESC LIMIT 100');
		$stmt->execute();
		$history = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		\app\utils\ViewHelper::render($app, 'history', ['title' => 'Historique', 'history' => $history]);
	});

	$router->get('/statistics', function() use ($app) {
		$userCount = \app\models\User::count();
		$exchangeCount = \app\models\Exchange::count();
		$db = \Flight::db();
		$stmt = $db->prepare('SELECT COUNT(*) as cnt FROM items');
		$stmt->execute();
		$itemCount = $stmt->fetch(\PDO::FETCH_ASSOC)['cnt'] ?? 0;
		$categoryCount = \app\models\Category::count();
		$recentExchanges = \app\models\Exchange::all(10);
		$recentItems = \app\models\Item::all(10);
		\app\utils\ViewHelper::render($app, 'statistics', [
			'title' => 'Statistiques',
			'user_count' => $userCount,
			'exchange_count' => $exchangeCount,
			'item_count' => $itemCount,
			'category_count' => $categoryCount,
			'recent_exchanges' => $recentExchanges,
			'recent_items' => $recentItems
		]);
	});

	$router->group('/api', function(Router $router) use ($app) {
		$router->get('/users', [ ApiExampleController::class, 'getUsers' ]);
		$router->get('/users/@id:[0-9]+', [ ApiExampleController::class, 'getUser' ]);
		$router->post('/users/@id:[0-9]+', [ ApiExampleController::class, 'updateUser' ]);
	});
	
}, [ SecurityHeadersMiddleware::class ]);