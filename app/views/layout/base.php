<?php use app\utils\Session; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($title ?? 'Takalo-takalo') ?> - Takalo-takalo</title>
  <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/css/bootstrap-icons.css" rel="stylesheet">
  <link href="/assets/css/theme.css" rel="stylesheet">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg sticky-top shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="/">
        <i class="bi bi-arrow-left-right me-2"></i>Takalo-takalo
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="/"><i class="bi bi-house-door me-1"></i>Accueil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/items"><i class="bi bi-grid-3x3-gap me-1"></i>Objets</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/history"><i class="bi bi-clock-history me-1"></i>Historique</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/statistics"><i class="bi bi-bar-chart-line me-1"></i>Statistiques</a>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
          <?php
            $user = Session::get('user');
            $admin = Session::get('admin');
          ?>
          <?php if ($user): ?>
            <li class="nav-item">
              <a class="nav-link" href="/my/items"><i class="bi bi-box-seam me-1"></i>Mes Objets</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/item/new"><i class="bi bi-plus-circle me-1"></i>Ajouter</a>
            </li>
            <li class="nav-item">
              <a class="nav-link position-relative" href="/exchanges">
                <i class="bi bi-bell me-1"></i>Propositions
                <?php
                  $pendingCount = \app\models\Exchange::countPendingForUser($user['id'] ?? 0);
                  if ($pendingCount > 0):
                ?>
                  <span class="badge bg-danger rounded-pill ms-1"><?= $pendingCount ?></span>
                <?php endif; ?>
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle me-1"></i><?= htmlspecialchars($user['name'] ?? 'Utilisateur') ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                <li><a class="dropdown-item" href="/my/items"><i class="bi bi-box-seam me-2"></i>Mes Objets</a></li>
                <li><a class="dropdown-item" href="/exchanges"><i class="bi bi-arrow-left-right me-2"></i>Mes Échanges</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Déconnexion</a></li>
              </ul>
            </li>
          <?php endif; ?>

          <?php if ($admin): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: var(--tk-coral) !important;">
                <i class="bi bi-shield-lock me-1"></i>Admin
              </a>
              <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                <li><a class="dropdown-item" href="/admin"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                <li><a class="dropdown-item" href="/admin/categories"><i class="bi bi-tags me-2"></i>Catégories</a></li>
                <li><a class="dropdown-item" href="/admin/users"><i class="bi bi-people me-2"></i>Utilisateurs</a></li>
                <li><a class="dropdown-item" href="/admin/exchanges"><i class="bi bi-arrow-repeat me-2"></i>Échanges</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="/admin/logout"><i class="bi bi-box-arrow-right me-2"></i>Déco. Admin</a></li>
              </ul>
            </li>
          <?php endif; ?>

          <?php if (!$user && !$admin): ?>
            <li class="nav-item">
              <a class="nav-link" href="/login"><i class="bi bi-box-arrow-in-right me-1"></i>Connexion</a>
            </li>
            <li class="nav-item ms-lg-2">
              <a class="btn btn-primary btn-sm px-3" href="/register"><i class="bi bi-person-plus me-1"></i>S'inscrire</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Flash messages + Content -->
  <main class="container py-4">
    <?php $successMsg = Session::flash('success'); if ($successMsg): ?>
      <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($successMsg) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>
    <?php $errorMsg = Session::flash('error'); if ($errorMsg): ?>
      <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($errorMsg) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <?= $content ?>
  </main>

  <!-- Footer -->
  <footer class="text-light py-5 mt-auto">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-4 text-center text-md-start mb-3 mb-md-0">
          <span class="footer-brand fs-5"><i class="bi bi-arrow-left-right me-2"></i>Takalo-takalo</span>
          <p class="text-secondary mb-0 mt-1 small">Plateforme d'échange d'objets</p>
        </div>
        <div class="col-md-4 text-center mb-3 mb-md-0">
          <p class="mb-0 text-secondary">Réalisé par : <strong class="text-light">Mirindra</strong> (ETU3927)</p>
        </div>
        <div class="col-md-4 text-center text-md-end">
          <small class="text-secondary">FlightPHP &bull; MySQL &bull; Bootstrap 5 &bull; &copy; 2026</small>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap 5 Bundle JS (includes Popper) -->
  <script src="/assets/js/bootstrap.bundle.min.js" nonce="<?= htmlspecialchars(\Flight::app()->get('csp_nonce')) ?>"></script>
</body>
</html>
