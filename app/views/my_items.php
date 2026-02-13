<?php $accents = ['teal','coral','emerald','amber','indigo','rose']; ?>
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <div>
    <h2 class="mb-1 fw-bold section-title"><i class="bi bi-box-seam me-2" style="color:var(--tk-teal);"></i>Mes Objets</h2>
    <p class="text-muted mb-0">Gérez vos objets disponibles pour l'échange</p>
  </div>
  <a href="/item/new" class="btn btn-emerald shadow-sm"><i class="bi bi-plus-circle me-1"></i>Ajouter un Objet</a>
</div>

<?php if (empty($items)): ?>
  <div class="card card-accent-teal text-center py-5">
    <div class="card-body">
      <div class="icon-circle icon-circle-md mx-auto mb-3" style="background:linear-gradient(135deg,#ecfdf5,#d1fae5);">
        <i class="bi bi-inbox" style="color:var(--tk-teal); font-size:2rem;"></i>
      </div>
      <h5 class="fw-bold">Aucun objet publié</h5>
      <p class="text-muted">Commencez par ajouter votre premier objet !</p>
      <a href="/item/new" class="btn btn-teal"><i class="bi bi-plus-circle me-1"></i>Ajouter</a>
    </div>
  </div>
<?php else: ?>
  <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <?php foreach ($items as $i => $it): ?>
      <?php $accent = $accents[$i % count($accents)]; ?>
      <div class="col">
        <div class="card h-100 card-accent-<?= $accent ?> overflow-hidden">
          <?php if (!empty($it['photos'])): ?>
            <div class="position-relative">
              <img src="/<?= htmlspecialchars($it['photos'][0]['file_path']) ?>"
                   class="card-img-top obj-img" alt="<?= htmlspecialchars($it['title']) ?>">
              <?php if (count($it['photos']) > 1): ?>
                <span class="badge position-absolute top-0 end-0 m-2" style="background:var(--tk-<?= $accent ?>);">
                  <i class="bi bi-camera me-1"></i><?= count($it['photos']) ?>
                </span>
              <?php endif; ?>
            </div>
          <?php else: ?>
            <div class="d-flex align-items-center justify-content-center bg-light obj-img">
              <i class="bi bi-image text-secondary" style="font-size:3rem;"></i>
            </div>
          <?php endif; ?>
          <div class="card-body d-flex flex-column">
            <h5 class="card-title fw-bold"><?= htmlspecialchars($it['title']) ?></h5>
            <span class="badge rounded-pill mb-2 align-self-start" style="background:var(--tk-<?= $accent ?>);">
              <i class="bi bi-tag me-1"></i><?= htmlspecialchars($it['category_name'] ?? 'Autre') ?>
            </span>
            <p class="card-text text-muted small flex-grow-1">
              <?= htmlspecialchars(mb_substr($it['description'] ?? '', 0, 100)) ?>
            </p>
            <div class="price-tag mb-3">
              <i class="bi bi-cash-coin me-1"></i><?= number_format($it['estimated_price'] ?? 0, 2, ',', ' ') ?> Ar
            </div>
            <div class="btn-group mb-2">
              <a href="/items/<?= $it['id'] ?>" class="btn btn-sm" style="border-color:var(--tk-indigo); color:var(--tk-indigo);"><i class="bi bi-eye me-1"></i>Voir</a>
              <a href="/item/<?= $it['id'] ?>/edit" class="btn btn-sm" style="border-color:var(--tk-amber); color:var(--tk-amber);"><i class="bi bi-pencil me-1"></i>Éditer</a>
            </div>
            <form action="/item/<?= $it['id'] ?>/delete" method="POST">
              <button type="submit" class="btn btn-sm w-100" style="border-color:var(--tk-rose); color:var(--tk-rose);" onclick="return confirm('Supprimer cet objet ?')">
                <i class="bi bi-trash me-1"></i>Supprimer
              </button>
            </form>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
