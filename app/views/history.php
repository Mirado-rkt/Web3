<h2 class="mb-2 fw-bold section-title"><i class="bi bi-clock-history me-2" style="color:var(--tk-teal);"></i>Historique des Échanges</h2>
<p class="text-muted mb-4">Suivez tous les changements de propriétaires d'objets sur la plateforme.</p>

<?php if (empty($history)): ?>
  <div class="card card-accent-teal text-center py-5">
    <div class="card-body">
      <div class="icon-circle icon-circle-md mx-auto mb-3" style="background:linear-gradient(135deg,#ecfdf5,#ccfbf1);">
        <i class="bi bi-hourglass" style="color:var(--tk-teal); font-size:2rem;"></i>
      </div>
      <h5 class="fw-bold">Aucun historique</h5>
      <p class="text-muted mb-0">Les échanges effectués apparaîtront ici.</p>
    </div>
  </div>
<?php else: ?>
  <div class="card card-accent-teal overflow-hidden">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead>
          <tr style="background:linear-gradient(135deg,var(--tk-teal),var(--tk-emerald)); color:#fff;">
            <th><i class="bi bi-box-seam me-1"></i>Objet</th>
            <th><i class="bi bi-person-dash me-1"></i>Ancien Propriétaire</th>
            <th><i class="bi bi-person-plus me-1"></i>Nouveau Propriétaire</th>
            <th><i class="bi bi-calendar-event me-1"></i>Date & Heure</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($history as $h): ?>
            <tr>
              <td>
                <a href="/items/<?= $h['item_id'] ?>" class="fw-bold text-decoration-none" style="color:var(--tk-indigo);">
                  <?= htmlspecialchars($h['item_title'] ?? 'Objet #' . $h['item_id']) ?>
                </a>
              </td>
              <td><?= htmlspecialchars($h['previous_owner_name'] ?? '') ?></td>
              <td class="fw-bold" style="color:var(--tk-emerald);"><?= htmlspecialchars($h['new_owner_name'] ?? '') ?></td>
              <td><?= date('d/m/Y à H:i', strtotime($h['exchanged_at'])) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
<?php endif; ?>
