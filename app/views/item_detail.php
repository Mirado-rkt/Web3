<?php $nonce = htmlspecialchars(\Flight::app()->get('csp_nonce')); ?>
<div class="row g-4">
  <div class="col-lg-7">
    <div class="card card-accent-coral overflow-hidden">
      <div class="card-header header-coral">
        <h5 class="mb-0 text-white"><i class="bi bi-images me-2"></i>Photos</h5>
      </div>
      <div class="card-body">
        <?php if (!empty($item['photos'])): ?>
          <div class="text-center mb-3">
            <img id="mainPhoto" src="/<?= htmlspecialchars($item['photos'][0]['file_path']) ?>"
                 class="img-fluid rounded" style="max-height:400px;object-fit:contain;width:100%;"
                 alt="<?= htmlspecialchars($item['title']) ?>">
          </div>
          <?php if (count($item['photos']) > 1): ?>
            <div id="thumbRow" class="d-flex gap-2 justify-content-center flex-wrap">
              <?php foreach ($item['photos'] as $idx => $photo): ?>
                <img src="/<?= htmlspecialchars($photo['file_path']) ?>"
                     class="thumb-photo rounded border"
                     data-idx="<?= $idx ?>"
                     style="width:80px;height:80px;object-fit:cover;cursor:pointer; opacity:<?= $idx === 0 ? '1' : '0.6' ?>;">
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        <?php else: ?>
          <div class="text-center py-4 text-muted">
            <i class="bi bi-image fs-1 d-block mb-2"></i>Aucune photo.
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="col-lg-5">
    <div class="card card-accent-indigo overflow-hidden">
      <div class="card-header header-indigo">
        <h4 class="mb-0 text-white"><?= htmlspecialchars($item['title']) ?></h4>
      </div>
      <div class="card-body">
        <span class="badge mb-3 fs-6" style="background:var(--tk-teal);"><i class="bi bi-tag me-1"></i><?= htmlspecialchars($item['category_name'] ?? 'Autre') ?></span>
        <div class="border rounded p-3 mb-3" style="background:#eef2ff;">
          <small class="text-muted"><i class="bi bi-person me-1"></i>Propriétaire</small><br>
          <strong><?= htmlspecialchars($item['owner_name'] ?? 'Utilisateur') ?></strong>
        </div>
        <div class="price-tag p-3 mb-3 rounded">
          <small class="d-block mb-1"><i class="bi bi-cash me-1"></i>Prix estimé</small>
          <strong class="fs-4"><?= number_format($item['estimated_price'] ?? 0, 2, ',', ' ') ?> Ar</strong>
        </div>
        <h6 class="fw-bold"><i class="bi bi-card-text me-1"></i>Description</h6>
        <p><?= nl2br(htmlspecialchars($item['description'] ?? 'Aucune description.')) ?></p>
        <a href="/my/items" class="btn btn-outline-secondary w-100"><i class="bi bi-arrow-left me-1"></i>Retour</a>
      </div>
    </div>
  </div>
</div>

<?php if (!empty($item['history'])): ?>
<div class="card card-accent-teal mt-4 overflow-hidden">
  <div class="card-header header-teal">
    <h5 class="mb-0 text-white"><i class="bi bi-clock-history me-2"></i>Historique d'Appartenance</h5>
  </div>
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead class="table-light">
        <tr>
          <th>Ancien Propriétaire</th><th></th><th>Nouveau Propriétaire</th><th>Date & Heure</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($item['history'] as $h): ?>
          <tr>
            <td><?= htmlspecialchars($h['previous_owner_name'] ?? '') ?></td>
            <td class="text-center"><i class="bi bi-arrow-right" style="color:var(--tk-coral);"></i></td>
            <td class="fw-bold" style="color:var(--tk-emerald);"><?= htmlspecialchars($h['new_owner_name']) ?></td>
            <td><?= date('d/m/Y à H:i', strtotime($h['exchanged_at'])) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php endif; ?>

<script nonce="<?= $nonce ?>">
document.querySelectorAll('.thumb-photo').forEach(function(img){
  img.addEventListener('click', function(){
    document.getElementById('mainPhoto').src = this.src;
    document.querySelectorAll('.thumb-photo').forEach(function(i){ i.style.opacity = '0.6'; });
    this.style.opacity = '1';
  });
});
</script>
