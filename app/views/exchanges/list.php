<h2 class="mb-4 fw-bold section-title"><i class="bi bi-arrow-left-right me-2" style="color:var(--tk-coral);"></i>Mes Échanges</h2>

<!-- Nav tabs -->
<ul class="nav nav-tabs mb-4" role="tablist">
  <li class="nav-item">
    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#received" type="button" style="color:var(--tk-coral);">
      <i class="bi bi-inbox me-1"></i>Propositions Reçues
      <?php if (!empty($exchanges)): ?>
        <span class="badge" style="background:var(--tk-coral);"><?= count($exchanges) ?></span>
      <?php endif; ?>
    </button>
  </li>
  <li class="nav-item">
    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#sent" type="button" style="color:var(--tk-indigo);">
      <i class="bi bi-send me-1"></i>Propositions Envoyées
      <?php if (!empty($sent_exchanges)): ?>
        <span class="badge" style="background:var(--tk-indigo);"><?= count($sent_exchanges ?? []) ?></span>
      <?php endif; ?>
    </button>
  </li>
</ul>

<div class="tab-content">
  <!-- Received -->
  <div class="tab-pane fade show active" id="received">
    <?php if (empty($exchanges)): ?>
      <div class="card card-accent-coral text-center py-5">
        <div class="card-body">
          <div class="icon-circle icon-circle-md mx-auto mb-3" style="background:linear-gradient(135deg,#fff7ed,#ffedd5);">
            <i class="bi bi-inbox" style="color:var(--tk-coral); font-size:2rem;"></i>
          </div>
          <h5 class="fw-bold">Aucune proposition reçue</h5>
        </div>
      </div>
    <?php else: ?>
      <div class="row row-cols-1 g-3">
        <?php foreach ($exchanges as $ex): ?>
          <div class="col">
            <div class="card card-accent-coral">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-md-4">
                    <small class="text-muted">Proposeur</small>
                    <div class="fw-bold"><?= htmlspecialchars($ex['proposer_name'] ?? '') ?></div>
                    <span class="badge mt-1" style="background:var(--tk-teal);"><?= htmlspecialchars($ex['proposed_item_title'] ?? '') ?></span>
                    <p class="text-muted small mt-1 mb-0"><?= htmlspecialchars(mb_substr($ex['proposed_item_desc'] ?? '', 0, 80)) ?></p>
                  </div>
                  <div class="col-md-1 text-center">
                    <i class="bi bi-arrow-left-right fs-3" style="color:var(--tk-coral);"></i>
                  </div>
                  <div class="col-md-4">
                    <small class="text-muted">Mon objet demandé</small>
                    <div><span class="badge" style="background:var(--tk-indigo);"><?= htmlspecialchars($ex['target_item_title'] ?? '') ?></span></div>
                    <p class="text-muted small mt-1 mb-0"><?= htmlspecialchars(mb_substr($ex['target_item_desc'] ?? '', 0, 80)) ?></p>
                  </div>
                  <div class="col-md-3 text-end">
                    <?php if (($ex['status'] ?? 'pending') === 'pending'): ?>
                      <div class="d-flex gap-2 justify-content-end">
                        <form method="post" action="/exchanges/<?= $ex['id'] ?>/accept">
                          <button class="btn btn-emerald btn-sm"><i class="bi bi-check-circle me-1"></i>Accepter</button>
                        </form>
                        <form method="post" action="/exchanges/<?= $ex['id'] ?>/refuse">
                          <button class="btn btn-sm" style="border-color:var(--tk-rose); color:var(--tk-rose);"><i class="bi bi-x-circle me-1"></i>Refuser</button>
                        </form>
                      </div>
                    <?php else: ?>
                      <?php
                        $sc = match($ex['status']) { 'accepted' => 'background:var(--tk-emerald)', 'refused' => 'background:var(--tk-rose)', default => 'background:var(--tk-amber); color:#000' };
                        $st = match($ex['status']) { 'accepted' => 'Accepté', 'refused' => 'Refusé', default => 'En attente' };
                      ?>
                      <span class="badge" style="<?= $sc ?>"><?= $st ?></span>
                    <?php endif; ?>
                    <div class="text-muted small mt-2"><?= date('d/m/Y H:i', strtotime($ex['created_at'])) ?></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

  <!-- Sent -->
  <div class="tab-pane fade" id="sent">
    <?php if (empty($sent_exchanges)): ?>
      <div class="card card-accent-indigo text-center py-5">
        <div class="card-body">
          <div class="icon-circle icon-circle-md mx-auto mb-3" style="background:linear-gradient(135deg,#eef2ff,#e0e7ff);">
            <i class="bi bi-send" style="color:var(--tk-indigo); font-size:2rem;"></i>
          </div>
          <h5 class="fw-bold">Aucune proposition envoyée</h5>
        </div>
      </div>
    <?php else: ?>
      <div class="row row-cols-1 g-3">
        <?php foreach ($sent_exchanges as $ex): ?>
          <div class="col">
            <div class="card card-accent-indigo">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-md-4">
                    <small class="text-muted">Mon objet proposé</small>
                    <div><span class="badge" style="background:var(--tk-teal);"><?= htmlspecialchars($ex['proposed_item_title'] ?? '') ?></span></div>
                  </div>
                  <div class="col-md-1 text-center">
                    <i class="bi bi-arrow-right fs-3" style="color:var(--tk-indigo);"></i>
                  </div>
                  <div class="col-md-4">
                    <small class="text-muted">Objet demandé (de <?= htmlspecialchars($ex['target_owner_name'] ?? '') ?>)</small>
                    <div><span class="badge" style="background:var(--tk-indigo);"><?= htmlspecialchars($ex['target_item_title'] ?? '') ?></span></div>
                  </div>
                  <div class="col-md-3 text-end">
                    <?php
                      $sc = match($ex['status'] ?? 'pending') { 'accepted' => 'background:var(--tk-emerald)', 'refused' => 'background:var(--tk-rose)', default => 'background:var(--tk-amber); color:#000' };
                      $st = match($ex['status'] ?? 'pending') { 'accepted' => 'Accepté', 'refused' => 'Refusé', default => 'En attente' };
                    ?>
                    <span class="badge" style="<?= $sc ?>"><?= $st ?></span>
                    <div class="text-muted small mt-2"><?= date('d/m/Y H:i', strtotime($ex['created_at'])) ?></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
