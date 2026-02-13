<?php
namespace app\models;

class Exchange {
    public static function create($proposer_id, $proposer_item_id, $target_owner_id, $target_item_id) {
        $db = \Flight::db();
        // If a pending proposal already exists from this proposer for this target, update it (so user can "changer")
        $stmtCheck = $db->prepare('SELECT id FROM exchanges WHERE proposer_id = :p AND target_item_id = :ti AND status = "pending" LIMIT 1');
        $stmtCheck->execute([':p' => $proposer_id, ':ti' => $target_item_id]);
        $existing = $stmtCheck->fetch(\PDO::FETCH_ASSOC);
        if ($existing && !empty($existing['id'])) {
            $stmt = $db->prepare('UPDATE exchanges SET proposer_item_id = :pi, updated_at = NOW() WHERE id = :id');
            return $stmt->execute([':pi' => $proposer_item_id, ':id' => $existing['id']]);
        }

        $stmt = $db->prepare('INSERT INTO exchanges (proposer_id, proposer_item_id, target_owner_id, target_item_id, status) VALUES (:p, :pi, :t, :ti, "pending")');
        return $stmt->execute([
            ':p' => $proposer_id,
            ':pi' => $proposer_item_id,
            ':t' => $target_owner_id,
            ':ti' => $target_item_id
        ]);
    }

    // Find a pending exchange row for a proposer and target item
    public static function findPending($proposer_id, $target_item_id) {
        $db = \Flight::db();
        $stmt = $db->prepare('SELECT * FROM exchanges WHERE proposer_id = :p AND target_item_id = :ti AND status = "pending" LIMIT 1');
        $stmt->execute([':p' => $proposer_id, ':ti' => $target_item_id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function findByTargetOwner($owner_id) {
        $db = \Flight::db();
        $stmt = $db->prepare('SELECT e.*, u.name as proposer_name, i1.title as proposed_item_title, i1.description as proposed_item_desc, i2.title as target_item_title, i2.description as target_item_desc FROM exchanges e JOIN users u ON u.id = e.proposer_id JOIN items i1 ON i1.id = e.proposer_item_id JOIN items i2 ON i2.id = e.target_item_id WHERE e.target_owner_id = :owner ORDER BY e.created_at DESC');
        $stmt->execute([ ':owner' => $owner_id ]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function findByProposer($proposer_id) {
        $db = \Flight::db();
        $stmt = $db->prepare('SELECT e.*, u.name as target_owner_name, i1.title as proposed_item_title, i1.description as proposed_item_desc, i2.title as target_item_title, i2.description as target_item_desc FROM exchanges e JOIN users u ON u.id = e.target_owner_id JOIN items i1 ON i1.id = e.proposer_item_id JOIN items i2 ON i2.id = e.target_item_id WHERE e.proposer_id = :proposer ORDER BY e.created_at DESC');
        $stmt->execute([ ':proposer' => $proposer_id ]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        $db = \Flight::db();
        $stmt = $db->prepare('SELECT e.*, u.name as proposer_name FROM exchanges e JOIN users u ON u.id = e.proposer_id WHERE e.id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function updateStatus($id, $status) {
        $db = \Flight::db();
        $stmt = $db->prepare('UPDATE exchanges SET status = :status, updated_at = NOW() WHERE id = :id');
        $stmt->execute([':status' => $status, ':id' => $id]);
        
        // If accepted, swap owners and record history for both items
        if ($status === 'accepted') {
            $ex = self::find($id);

            // History for target item (goes to proposer)
            $stmtHist = $db->prepare('INSERT INTO item_history (item_id, previous_owner_id, new_owner_id) VALUES (:item_id, :prev_owner, :new_owner)');
            $stmtHist->execute([':item_id' => $ex['target_item_id'], ':prev_owner' => $ex['target_owner_id'], ':new_owner' => $ex['proposer_id']]);

            // History for proposer item (goes to target owner)
            $stmtHist2 = $db->prepare('INSERT INTO item_history (item_id, previous_owner_id, new_owner_id) VALUES (:item_id, :prev_owner, :new_owner)');
            $stmtHist2->execute([':item_id' => $ex['proposer_item_id'], ':prev_owner' => $ex['proposer_id'], ':new_owner' => $ex['target_owner_id']]);

            // Swap owners
            $stmtItem = $db->prepare('UPDATE items SET owner_id = :owner_id WHERE id = :id');
            $stmtItem->execute([':owner_id' => $ex['proposer_id'], ':id' => $ex['target_item_id']]);
            $stmtItem->execute([':owner_id' => $ex['target_owner_id'], ':id' => $ex['proposer_item_id']]);
        }
        return true;
    }

    public static function count() {
        $db = \Flight::db();
        $stmt = $db->prepare('SELECT COUNT(*) as cnt FROM exchanges WHERE status = "accepted"');
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['cnt'] ?? 0;
    }

    public static function countPendingForUser($user_id) {
        $db = \Flight::db();
        $stmt = $db->prepare('SELECT COUNT(*) as cnt FROM exchanges WHERE target_owner_id = :user_id AND status = "pending"');
        $stmt->execute([':user_id' => $user_id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['cnt'] ?? 0;
    }

    public static function all($limit = 100) {
        $db = \Flight::db();
        $stmt = $db->prepare('SELECT e.*, u1.name as proposer_name, u2.name as target_owner_name, i1.title as proposed_item_title, i2.title as target_item_title FROM exchanges e JOIN users u1 ON u1.id = e.proposer_id JOIN users u2 ON u2.id = e.target_owner_id JOIN items i1 ON i1.id = e.proposer_item_id JOIN items i2 ON i2.id = e.target_item_id ORDER BY e.created_at DESC LIMIT :limit');
        $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Returns true if proposer already has a pending proposal for the given target item
    public static function hasPendingProposal($proposer_id, $target_item_id) {
        $db = \Flight::db();
        $stmt = $db->prepare('SELECT COUNT(*) as cnt FROM exchanges WHERE proposer_id = :p AND target_item_id = :t AND status = "pending"');
        $stmt->execute([':p' => $proposer_id, ':t' => $target_item_id]);
        $res = $stmt->fetch(\PDO::FETCH_ASSOC);
        return (($res['cnt'] ?? 0) > 0);
    }
}
