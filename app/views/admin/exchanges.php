<h2 class="mb-4 fw-bold section-title"><i class="bi bi-arrow-repeat me-2" style="color:var(--tk-indigo);"></i>Historique des Échanges</h2>

<?php if (empty($exchanges)): ?>
  <div class="card card-accent-indigo text-center py-4">
    <div class="card-body"><p class="mb-0 text-muted">Aucun échange enregistré.</p></div>
  </div>
<?php else: ?>
  <div class="card card-accent-indigo overflow-hidden">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead>
          <tr style="background:linear-gradient(135deg,var(--tk-indigo),#818cf8); color:#fff;">
            <th>#</th><th>Proposeur</th><th>Objet proposé</th><th>Destinataire</th><th>Objet demandé</th><th>Statut</th><th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($exchanges as $ex): ?>
            <tr>
              <td><?= $ex['id'] ?></td>
              <td><?= htmlspecialchars($ex['proposer_name'] ?? '') ?></td>
              <td><?= htmlspecialchars($ex['proposed_item_title'] ?? '') ?></td>
              <td><?= htmlspecialchars($ex['target_owner_name'] ?? '') ?></td>
              <td><?= htmlspecialchars($ex['target_item_title'] ?? '') ?></td>
              <td>
                <?php
                  $statusClass = match($ex['status'] ?? 'pending') {
                    'accepted' => 'background:var(--tk-emerald)',
                    'refused' => 'background:var(--tk-rose)',
                    default => 'background:var(--tk-amber); color:#000'
                  };
                  $statusText = match($ex['status'] ?? 'pending') {
                    'accepted' => 'Accepté',
                    'refused' => 'Refusé',
                    default => 'En attente'
                  };
                ?>
                <span class="badge" style="<?= $statusClass ?>"><?= $statusText ?></span>
              </td>
              <td><?= date('d/m/Y H:i', strtotime($ex['created_at'])) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
<?php endif; ?>

<div class="mt-3">
  <a href="/admin" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Retour au dashboard</a>
</div>
