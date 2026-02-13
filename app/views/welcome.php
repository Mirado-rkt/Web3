<!-- Hero section -->
<div class="hero-section rounded-4 text-center mb-5 position-relative">
  <div class="container position-relative" style="z-index:2;">
    <h1 class="hero-title display-4 fw-bold animate-in"><i class="bi bi-arrow-left-right me-3"></i>Takalo-takalo</h1>
    <p class="hero-lead lead mx-auto animate-in animate-in-delay-1">Échangez vos objets avec d'autres utilisateurs, simplement et gratuitement.</p>
    <div class="d-flex gap-3 justify-content-center flex-wrap mt-4 animate-in animate-in-delay-2">
    <?php if (!\app\utils\Session::get('user')): ?>
      <a href="/register" class="btn btn-light btn-lg fw-bold px-4 shadow"><i class="bi bi-person-plus me-2"></i>S'inscrire</a>
      <a href="/login" class="btn btn-outline-light btn-lg px-4"><i class="bi bi-box-arrow-in-right me-2"></i>Se connecter</a>
    <?php else: ?>
      <a href="/items" class="btn btn-light btn-lg fw-bold px-4 shadow"><i class="bi bi-grid-3x3-gap me-2"></i>Voir les objets</a>
      <a href="/item/new" class="btn btn-outline-light btn-lg px-4"><i class="bi bi-plus-circle me-2"></i>Ajouter un objet</a>
    <?php endif; ?>
    </div>
  </div>
</div>

<!-- How it works -->
<h3 class="text-center mb-2 section-title mx-auto"><i class="bi bi-lightbulb me-2" style="color: var(--tk-amber);"></i>Comment ça marche ?</h3>
<p class="text-center text-muted mb-4">En 4 étapes simples, commencez à échanger !</p>
<div class="row g-4 mb-5">
  <?php
    $steps = [
      ['icon' => 'person-plus', 'color' => 'indigo', 'bg' => '#eef2ff', 'title' => '1. Inscrivez-vous', 'desc' => 'Créez votre compte gratuitement en quelques secondes.'],
      ['icon' => 'camera',      'color' => 'emerald','bg' => '#ecfdf5', 'title' => '2. Publiez vos objets', 'desc' => 'Ajoutez titre, description, photos et prix estimatif.'],
      ['icon' => 'arrow-left-right', 'color' => 'coral', 'bg' => '#fff7ed', 'title' => '3. Proposez un échange', 'desc' => 'Cliquez sur un objet et proposez un de vos objets en échange.'],
      ['icon' => 'check-circle','color' => 'amber',  'bg' => '#fffbeb', 'title' => '4. Acceptez / Refusez', 'desc' => 'Validez ou refusez les propositions d\'échange reçues.'],
    ];
    foreach ($steps as $i => $s):
  ?>
  <div class="col-md-6 col-lg-3">
    <div class="card h-100 text-center stat-card card-accent-<?= $s['color'] ?> animate-in animate-in-delay-<?= $i ?>">
      <div class="card-body py-4">
        <div class="icon-circle mb-3 mx-auto" style="background: <?= $s['bg'] ?>;">
          <i class="bi bi-<?= $s['icon'] ?>" style="color: var(--tk-<?= $s['color'] ?>);"></i>
        </div>
        <h5 class="fw-bold"><?= $s['title'] ?></h5>
        <p class="text-muted mb-0"><?= $s['desc'] ?></p>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>
