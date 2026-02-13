<?php $nonce = htmlspecialchars(\Flight::app()->get('csp_nonce')); ?>

<!-- Search bar -->
<div class="card mb-4 search-card card-accent-indigo">
  <div class="card-header header-multi py-3">
    <h5 class="mb-0"><i class="bi bi-search me-2"></i>Rechercher des Objets</h5>
  </div>
  <div class="card-body p-4">
    <form method="get" action="/items" class="row g-3 align-items-end">
      <div class="col-md-5">
        <label for="keyword" class="form-label fw-semibold">Mot-clé</label>
        <div class="input-group">
          <span class="input-group-text" style="background:var(--tk-light);"><i class="bi bi-type" style="color:var(--tk-coral);"></i></span>
          <input type="text" class="form-control" id="keyword" name="keyword"
                 value="<?= htmlspecialchars($keyword ?? '') ?>" placeholder="Titre, description...">
        </div>
      </div>
      <div class="col-md-4">
        <label for="category_id" class="form-label fw-semibold">Catégorie</label>
        <select class="form-select" id="category_id" name="category_id">
          <option value="">Toutes les catégories</option>
          <?php foreach ($categories ?? [] as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= ((string)($selected_category ?? '') === (string)$cat['id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($cat['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-teal flex-fill">
          <i class="bi bi-search me-1"></i>Rechercher
        </button>
        <a href="/items" class="btn btn-outline-secondary" title="Réinitialiser"><i class="bi bi-arrow-clockwise"></i></a>
      </div>
    </form>
  </div>
</div>

<h2 class="mb-4 section-title"><i class="bi bi-grid-3x3-gap me-2" style="color:var(--tk-teal);"></i>Objets Disponibles</h2>

<?php if (empty($items)): ?>
  <div class="card text-center py-5">
    <div class="card-body">
      <div class="icon-circle-lg mx-auto mb-3" style="background:#e0f2fe;">
        <i class="bi bi-inbox" style="color:var(--tk-sky);"></i>
      </div>
      <h5 class="fw-bold">Aucun objet trouvé</h5>
      <p class="text-muted mb-0">Essayez d'autres mots-clés ou catégories.</p>
    </div>
  </div>
<?php else: ?>
  <?php
    $accents = ['teal', 'coral', 'emerald', 'amber', 'indigo', 'rose'];
  ?>
  <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <?php foreach ($items as $idx => $it):
      $accent = $accents[$idx % count($accents)];
    ?>
      <div class="col">
        <div class="card h-100 card-accent-<?= $accent ?>">
          <?php if (!empty($it['photos'])): ?>
            <div class="position-relative">
              <img src="/<?= htmlspecialchars($it['photos'][0]['file_path']) ?>"
                   class="card-img-top obj-img" alt="<?= htmlspecialchars($it['title']) ?>">
              <?php if (count($it['photos']) > 1): ?>
                <span class="badge bg-dark bg-opacity-75 position-absolute top-0 end-0 m-2 rounded-pill">
                  <i class="bi bi-camera me-1"></i><?= count($it['photos']) ?>
                </span>
              <?php endif; ?>
            </div>
          <?php else: ?>
            <div class="d-flex align-items-center justify-content-center obj-img" style="background:#f1f5f9;">
              <i class="bi bi-image text-secondary" style="font-size:3rem;"></i>
            </div>
          <?php endif; ?>

          <div class="card-body d-flex flex-column">
            <h5 class="card-title fw-bold mb-2"><?= htmlspecialchars($it['title']) ?></h5>
            <div class="mb-2 d-flex flex-wrap gap-1">
              <span class="badge rounded-pill" style="background:var(--tk-<?= $accent ?>);"><i class="bi bi-tag me-1"></i><?= htmlspecialchars($it['category_name'] ?? 'Autre') ?></span>
              <span class="badge rounded-pill bg-secondary"><i class="bi bi-person me-1"></i><?= htmlspecialchars($it['owner_name'] ?? '') ?></span>
            </div>
            <p class="card-text text-muted small flex-grow-1">
              <?= htmlspecialchars(mb_substr($it['description'] ?? '', 0, 100)) ?><?= mb_strlen($it['description'] ?? '') > 100 ? '...' : '' ?>
            </p>
            <div class="price-tag mb-3">
              <small class="text-muted d-block">Prix estimé</small>
              <span class="price-amount"><?= number_format($it['estimated_price'] ?? 0, 2, ',', ' ') ?> Ar</span>
            </div>

            <div class="d-grid gap-2">
              <a href="/items/<?= $it['id'] ?>" class="btn btn-outline-primary">
                <i class="bi bi-eye me-1"></i>Voir les détails
              </a>
              <?php if (\app\utils\Session::get('user') && $it['owner_id'] != \app\utils\Session::get('user')['id']):
                      $cur = \app\utils\Session::get('user');
                      $already = \app\models\Exchange::hasPendingProposal($cur['id'], $it['id']);
              ?>
                <?php if ($already): ?>
                  <a href="/items/<?= $it['id'] ?>" class="btn btn-warning">
                    <i class="bi bi-check2-circle me-1"></i>Déjà proposé
                  </a>
                <?php else: ?>
                  <a href="/items/<?= $it['id'] ?>" class="btn btn-emerald">
                    <i class="bi bi-arrow-left-right me-1"></i>Proposer un Échange
                  </a>
                <?php endif; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php if (!\app\utils\Session::get('user') && !empty($items)): ?>
  <div class="alert mt-4 border-0 shadow-sm" style="background:#fff7ed; border-left:4px solid var(--tk-coral) !important;">
    <i class="bi bi-lock me-2" style="color:var(--tk-coral);"></i><a href="/login" class="alert-link fw-bold">Connectez-vous</a> pour proposer des échanges.
  </div>
<?php endif; ?>
