<?php
namespace app\controllers;

use app\models\Exchange;
use app\models\Item;
use app\utils\ViewHelper;
use app\utils\Session;

class ExchangeController {
    public static function propose() {
        $user = Session::get('user');
        if (!$user) { \Flight::halt(403, 'Connexion requise'); }
        
        $data = \Flight::request()->data;
        $myItemId = $data->proposer_item_id ?? null;
        $targetItemId = $data->target_item_id ?? null;
        $targetOwnerId = $data->target_owner_id ?? null;
        
        if (!$myItemId || !$targetItemId || !$targetOwnerId) {
            Session::flash('error', 'Données de proposition invalides');
            \Flight::redirect('/items');
            return;
        }
        
        Exchange::create($user['id'], $myItemId, $targetOwnerId, $targetItemId);
        Session::flash('success', 'Proposition envoyée');
        // Redirect back to the target item's detail page for better UX
        \Flight::redirect('/items/' . $targetItemId);
    }

    public static function proposals() {
        $app = \Flight::app();
        $user = Session::get('user');
        if (!$user) { \Flight::redirect('/login'); }
        
        $received = Exchange::findByTargetOwner($user['id']);
        $sent = Exchange::findByProposer($user['id']);
        ViewHelper::render($app, 'exchanges/list', [ 
            'exchanges' => $received,
            'sent_exchanges' => $sent,
            'title' => 'Mes Échanges' 
        ]);
    }

    public static function accept($id) {
        $user = Session::get('user');
        if (!$user) { \Flight::halt(403, 'Connexion requise'); }
        
        $ex = Exchange::find($id);
        if (!$ex || $ex['target_owner_id'] !== $user['id']) {
            \Flight::halt(403, 'Non autorisé');
        }
        
        Exchange::updateStatus($id, 'accepted');
        Session::flash('success', 'Proposition acceptée');
        \Flight::redirect('/exchanges');
    }

    public static function refuse($id) {
        $user = Session::get('user');
        if (!$user) { \Flight::halt(403, 'Connexion requise'); }
        
        $ex = Exchange::find($id);
        if (!$ex || $ex['target_owner_id'] !== $user['id']) {
            \Flight::halt(403, 'Non autorisé');
        }
        
        Exchange::updateStatus($id, 'refused');
        Session::flash('success', 'Proposition refusée');
        \Flight::redirect('/exchanges');
    }
}
