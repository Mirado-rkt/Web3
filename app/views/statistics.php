<h2 class="mb-4 fw-bold section-title"><i class="bi bi-bar-chart-line me-2" style="color:var(--tk-indigo);"></i>Statistiques de la Plateforme</h2>

<div class="row g-4 mb-5">
  <div class="col-md-3">
    <div class="card text-center card-accent-indigo">
      <div class="card-body py-4">
        <div class="icon-circle icon-circle-md mx-auto mb-2" style="background:linear-gradient(135deg,#eef2ff,#e0e7ff);">
          <i class="bi bi-people" style="color:var(--tk-indigo); font-size:1.5rem;"></i>
        </div>
        <h2 class="fw-bold mb-1" style="color:var(--tk-indigo);"><?= $user_count ?? 0 ?></h2>
        <p class="text-muted mb-0">Utilisateurs inscrits</p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card text-center card-accent-emerald">
      <div class="card-body py-4">
        <div class="icon-circle icon-circle-md mx-auto mb-2" style="background:linear-gradient(135deg,#ecfdf5,#d1fae5);">
          <i class="bi bi-arrow-left-right" style="color:var(--tk-emerald); font-size:1.5rem;"></i>
        </div>
        <h2 class="fw-bold mb-1" style="color:var(--tk-emerald);"><?= $exchange_count ?? 0 ?></h2>
        <p class="text-muted mb-0">Échanges effectués</p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card text-center card-accent-teal">
      <div class="card-body py-4">
        <div class="icon-circle icon-circle-md mx-auto mb-2" style="background:linear-gradient(135deg,#ecfeff,#cffafe);">
          <i class="bi bi-box-seam" style="color:var(--tk-teal); font-size:1.5rem;"></i>
        </div>
        <h2 class="fw-bold mb-1" style="color:var(--tk-teal);"><?= $item_count ?? 0 ?></h2>
        <p class="text-muted mb-0">Objets publiés</p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card text-center card-accent-coral">
      <div class="card-body py-4">
        <div class="icon-circle icon-circle-md mx-auto mb-2" style="background:linear-gradient(135deg,#fff7ed,#ffedd5);">
          <i class="bi bi-tags" style="color:var(--tk-coral); font-size:1.5rem;"></i>
        </div>
        <h2 class="fw-bold mb-1" style="color:var(--tk-coral);"><?= $category_count ?? 0 ?></h2>
        <p class="text-muted mb-0">Catégories</p>
      </div>
    </div>
  </div>
</div>

<!-- Échanges récents -->
<div class="card card-accent-indigo mb-4 overflow-hidden">
  <div class="card-header header-indigo">
    <h5 class="mb-0 text-white"><i class="bi bi-clock-history me-2"></i>Derniers Échanges</h5>
  </div>
  <?php if (empty($recent_exchanges)): ?>
    <div class="card-body text-center text-muted py-4">Aucun échange récent.</div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="table-light">
          <tr>
            <th>Proposeur</th><th>Objet proposé</th><th>Destinataire</th><th>Objet demandé</th><th>Statut</th><th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($recent_exchanges as $ex): ?>
            <tr>
              <td><?= htmlspecialchars($ex['proposer_name'] ?? '') ?></td>
              <td><?= htmlspecialchars($ex['proposed_item_title'] ?? '') ?></td>
              <td><?= htmlspecialchars($ex['target_owner_name'] ?? '') ?></td>
              <td><?= htmlspecialchars($ex['target_item_title'] ?? '') ?></td>
              <td>
                <?php
                  $sc = match($ex['status'] ?? 'pending') { 'accepted' => 'background:var(--tk-emerald)', 'refused' => 'background:var(--tk-rose)', default => 'background:var(--tk-amber); color:#000' };
                  $st = match($ex['status'] ?? 'pending') { 'accepted' => 'Accepté', 'refused' => 'Refusé', default => 'En attente' };
                ?>
                <span class="badge" style="<?= $sc ?>"><?= $st ?></span>
              </td>
              <td class="small"><?= date('d/m/Y H:i', strtotime($ex['created_at'])) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<!-- Objets les plus récents -->
<div class="card card-accent-emerald overflow-hidden">
  <div class="card-header header-emerald">
    <h5 class="mb-0 text-white"><i class="bi bi-box-seam me-2"></i>Derniers Objets Ajoutés</h5>
  </div>
  <?php if (empty($recent_items)): ?>
    <div class="card-body text-center text-muted py-4">Aucun objet récent.</div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="table-light">
          <tr>
            <th>Titre</th><th>Propriétaire</th><th>Catégorie</th><th>Prix estimé</th><th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($recent_items as $it): ?>
            <tr>
              <td><a href="/items/<?= $it['id'] ?>" class="fw-bold text-decoration-none" style="color:var(--tk-indigo);"><?= htmlspecialchars($it['title']) ?></a></td>
              <td><?= htmlspecialchars($it['owner_name'] ?? '') ?></td>
              <td><span class="badge" style="background:var(--tk-teal);"><?= htmlspecialchars($it['category_name'] ?? 'Autre') ?></span></td>
              <td class="price-tag d-inline-block"><?= number_format($it['estimated_price'] ?? 0, 2, ',', ' ') ?> Ar</td>
              <td class="small"><?= date('d/m/Y', strtotime($it['created_at'])) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>
