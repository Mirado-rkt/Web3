<?php
  $nonce = htmlspecialchars(\Flight::app()->get('csp_nonce'));
  $currentUser = \app\utils\Session::get('user');
  $alreadyProposed = false;
  $pendingRow = null;
  if ($currentUser) {
    $alreadyProposed = \app\models\Exchange::hasPendingProposal($currentUser['id'], $item['id']);
    if ($alreadyProposed) {
      $pendingRow = \app\models\Exchange::findPending($currentUser['id'], $item['id']);
    }
  }
  $isOwner = $currentUser && ($item['owner_id'] ?? 0) == $currentUser['id'];
  $myItems = [];
  if ($currentUser && !$isOwner) {
    $myItems = \app\models\Item::findByOwner($currentUser['id']);
  }
?>

<div class="row g-4">
  <!-- Photo Gallery -->
  <div class="col-lg-7">
    <div class="card card-accent-coral">
      <div class="card-header header-coral py-3">
        <h5 class="mb-0"><i class="bi bi-images me-2"></i>Photos de l'objet</h5>
      </div>
      <div class="card-body p-3">
        <?php if (!empty($item['photos'])): ?>
          <div class="text-center mb-3 position-relative" style="min-height:300px;">
            <button id="prevPhoto" class="photo-nav-btn position-absolute" style="left:10px; top:50%; transform:translateY(-50%);">
              <i class="bi bi-chevron-left"></i>
            </button>
            <button id="nextPhoto" class="photo-nav-btn position-absolute" style="right:10px; top:50%; transform:translateY(-50%);">
              <i class="bi bi-chevron-right"></i>
            </button>
            <img id="mainPhoto" src="/<?= htmlspecialchars($item['photos'][0]['file_path']) ?>"
                 alt="<?= htmlspecialchars($item['title']) ?>"
                 class="img-fluid rounded-3" style="max-height:420px; object-fit:contain; width:100%;">
          </div>
          <?php if (count($item['photos']) > 1): ?>
            <div id="thumbs" class="d-flex gap-2 justify-content-center flex-wrap">
              <?php foreach ($item['photos'] as $idx => $photo): ?>
                <img data-index="<?= $idx ?>" src="/<?= htmlspecialchars($photo['file_path']) ?>"
                     alt="Photo <?= $idx + 1 ?>"
                     class="rounded thumb-photo <?= $idx === 0 ? 'active' : '' ?>"
                     style="width:75px; height:75px; object-fit:cover; cursor:pointer; opacity:<?= $idx === 0 ? '1' : '0.5' ?>;">
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        <?php else: ?>
          <div class="text-center py-5 text-muted">
            <div class="icon-circle-lg mx-auto mb-3" style="background:#fee2e2;">
              <i class="bi bi-image" style="color:var(--tk-rose);"></i>
            </div>
            <p class="mb-0">Aucune photo disponible.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Details -->
  <div class="col-lg-5">
    <div class="card card-accent-indigo mb-4">
      <div class="card-header header-indigo py-3">
        <h4 class="mb-0 fw-bold"><?= htmlspecialchars($item['title']) ?></h4>
      </div>
      <div class="card-body">
        <div class="mb-3">
          <span class="badge rounded-pill fs-6" style="background:var(--tk-teal);"><i class="bi bi-tag me-1"></i><?= htmlspecialchars($item['category_name'] ?? 'Autre') ?></span>
        </div>

        <div class="rounded-3 p-3 mb-3" style="background:#eef2ff; border-left:4px solid var(--tk-indigo);">
          <small class="text-muted d-block"><i class="bi bi-person me-1"></i>Propriétaire</small>
          <strong class="fs-5"><?= htmlspecialchars($item['owner_name'] ?? 'Utilisateur') ?></strong>
        </div>

        <div class="price-tag mb-3">
          <small class="text-muted d-block"><i class="bi bi-cash-stack me-1"></i>Prix estimé</small>
          <span class="price-amount"><?= number_format($item['estimated_price'] ?? 0, 2, ',', ' ') ?> Ar</span>
        </div>

        <h6 class="fw-bold"><i class="bi bi-card-text me-1" style="color:var(--tk-coral);"></i>Description</h6>
        <p class="mb-4 text-muted"><?= nl2br(htmlspecialchars($item['description'] ?? 'Aucune description.')) ?></p>

        <!-- Exchange buttons -->
        <?php if ($currentUser && !$isOwner): ?>
          <?php if (count($myItems) === 0): ?>
            <a href="/item/new" class="btn btn-coral btn-lg w-100 mb-2">
              <i class="bi bi-plus-circle me-2"></i>Ajoutez un objet d'abord
            </a>
          <?php elseif (count($myItems) === 1): ?>
            <!-- Single item: propose directly -->
            <form method="post" action="/exchanges/propose">
              <input type="hidden" name="target_item_id" value="<?= $item['id'] ?>">
              <input type="hidden" name="target_owner_id" value="<?= $item['owner_id'] ?>">
              <input type="hidden" name="proposer_item_id" value="<?= $myItems[0]['id'] ?>">
              <?php if ($alreadyProposed): ?>
                <button type="submit" class="btn btn-warning btn-lg w-100 mb-2">
                  <i class="bi bi-check2-circle me-2"></i>Déjà proposé (<?= htmlspecialchars($myItems[0]['title']) ?>)
                </button>
              <?php else: ?>
                <button type="submit" class="btn btn-emerald btn-lg w-100 mb-2">
                  <i class="bi bi-arrow-left-right me-2"></i>Proposer « <?= htmlspecialchars($myItems[0]['title']) ?> »
                </button>
              <?php endif; ?>
            </form>
          <?php else: ?>
            <!-- Multiple items: show modal -->
            <?php if ($alreadyProposed): ?>
              <button type="button" class="btn btn-warning btn-lg w-100 mb-2" data-bs-toggle="modal" data-bs-target="#proposeExchange">
                <i class="bi bi-check2-circle me-2"></i>Déjà proposé — Modifier
              </button>
            <?php else: ?>
              <button type="button" class="btn btn-emerald btn-lg w-100 mb-2" data-bs-toggle="modal" data-bs-target="#proposeExchange">
                <i class="bi bi-arrow-left-right me-2"></i>Proposer un Échange
              </button>
            <?php endif; ?>
          <?php endif; ?>
        <?php elseif (!$currentUser): ?>
          <a href="/login" class="btn btn-outline-primary btn-lg w-100 mb-2">
            <i class="bi bi-box-arrow-in-right me-2"></i>Connectez-vous pour proposer
          </a>
        <?php endif; ?>

        <a href="/items" class="btn btn-outline-secondary w-100">
          <i class="bi bi-arrow-left me-1"></i>Retour à la liste
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Ownership History -->
<?php if (!empty($item['history'])): ?>
  <div class="card card-accent-teal mt-4">
    <div class="card-header header-teal py-3">
      <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Historique d'Appartenance</h5>
    </div>
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th><i class="bi bi-person-dash me-1"></i>Ancien Propriétaire</th>
            <th class="text-center"><i class="bi bi-arrow-right"></i></th>
            <th><i class="bi bi-person-plus me-1"></i>Nouveau Propriétaire</th>
            <th><i class="bi bi-calendar me-1"></i>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($item['history'] as $h): ?>
            <tr>
              <td><?= htmlspecialchars($h['previous_owner_name'] ?? '') ?></td>
              <td class="text-center"><i class="bi bi-arrow-right" style="color:var(--tk-coral);"></i></td>
              <td class="fw-bold" style="color:var(--tk-emerald);"><?= htmlspecialchars($h['new_owner_name']) ?></td>
              <td><small class="text-muted"><?= date('d/m/Y à H:i', strtotime($h['exchanged_at'])) ?></small></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
<?php endif; ?>

<!-- Modal: only needed when user has multiple items -->
<?php if ($currentUser && !$isOwner && count($myItems) > 1): ?>
<div class="modal fade" id="proposeExchange" tabindex="-1" aria-labelledby="proposeExchangeLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header header-emerald">
        <h5 class="modal-title" id="proposeExchangeLabel"><i class="bi bi-arrow-left-right me-2"></i>Proposer un Échange</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <p>Échanger contre <strong style="color:var(--tk-coral);"><?= htmlspecialchars($item['title']) ?></strong> :</p>
        <form method="post" action="/exchanges/propose">
          <input type="hidden" name="target_item_id" value="<?= $item['id'] ?>">
          <input type="hidden" name="target_owner_id" value="<?= $item['owner_id'] ?>">
          <div class="mb-3">
            <label class="form-label fw-bold">Choisir mon objet à proposer</label>
            <select name="proposer_item_id" class="form-select form-select-lg" required>
              <?php foreach ($myItems as $mi):
                $sel = ($pendingRow && (int)$pendingRow['proposer_item_id'] === (int)$mi['id']) ? 'selected' : '';
              ?>
                <option value="<?= $mi['id'] ?>" <?= $sel ?>><?= htmlspecialchars($mi['title']) ?> (<?= number_format($mi['estimated_price'], 2, ',', ' ') ?> Ar)</option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-emerald btn-lg"><i class="bi bi-check-circle me-1"></i>Confirmer l'échange</button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- Photo navigation JS -->
<script nonce="<?= $nonce ?>">
(function(){
  var thumbs = document.querySelectorAll('.thumb-photo');
  if (!thumbs.length) return;
  var all = Array.from(thumbs);
  var main = document.getElementById('mainPhoto');
  var current = 0;
  function goTo(i) {
    current = ((i % all.length) + all.length) % all.length;
    all.forEach(function(t){ t.style.opacity='0.5'; t.classList.remove('active'); });
    all[current].style.opacity = '1';
    all[current].classList.add('active');
    main.src = all[current].src;
  }
  all.forEach(function(t){
    t.addEventListener('click', function(){ goTo(parseInt(this.getAttribute('data-index'))); });
  });
  var prev = document.getElementById('prevPhoto');
  var next = document.getElementById('nextPhoto');
  if (prev) prev.addEventListener('click', function(e){ e.preventDefault(); goTo(current - 1); });
  if (next) next.addEventListener('click', function(e){ e.preventDefault(); goTo(current + 1); });
})();
</script>
