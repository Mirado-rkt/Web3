<h2 class="mb-4 fw-bold section-title"><i class="bi bi-speedometer2 me-2" style="color:var(--tk-rose);"></i>Tableau de bord Admin</h2>

<div class="row g-4 mb-5">
  <div class="col-md-3">
    <div class="card text-center card-accent-indigo text-white" style="background:linear-gradient(135deg,var(--tk-indigo),#818cf8);">
      <div class="card-body py-4">
        <i class="bi bi-people fs-1 mb-2 d-block"></i>
        <h2 class="fw-bold mb-1"><?= $user_count ?? 0 ?></h2>
        <p class="mb-0 opacity-75">Utilisateurs inscrits</p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card text-center card-accent-emerald text-white" style="background:linear-gradient(135deg,var(--tk-emerald),#34d399);">
      <div class="card-body py-4">
        <i class="bi bi-arrow-left-right fs-1 mb-2 d-block"></i>
        <h2 class="fw-bold mb-1"><?= $exchange_count ?? 0 ?></h2>
        <p class="mb-0 opacity-75">Échanges effectués</p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card text-center card-accent-teal text-white" style="background:linear-gradient(135deg,var(--tk-teal),#22d3ee);">
      <div class="card-body py-4">
        <i class="bi bi-box-seam fs-1 mb-2 d-block"></i>
        <h2 class="fw-bold mb-1"><?= $item_count ?? 0 ?></h2>
        <p class="mb-0 opacity-75">Objets publiés</p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card text-center card-accent-coral text-white" style="background:linear-gradient(135deg,var(--tk-coral),#fb923c);">
      <div class="card-body py-4">
        <i class="bi bi-tags fs-1 mb-2 d-block"></i>
        <h2 class="fw-bold mb-1"><?= $category_count ?? 0 ?></h2>
        <p class="mb-0 opacity-75">Catégories</p>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-md-4">
    <a href="/admin/categories" class="text-decoration-none">
      <div class="card h-100 card-accent-coral" style="transition:transform .2s;">
        <div class="card-body text-center py-4">
          <div class="icon-circle icon-circle-md mx-auto mb-3" style="background:linear-gradient(135deg,#fff7ed,#ffedd5);">
            <i class="bi bi-tags" style="color:var(--tk-coral); font-size:1.5rem;"></i>
          </div>
          <h5 class="fw-bold">Gérer les Catégories</h5>
          <p class="text-muted mb-0">Ajouter, modifier ou supprimer des catégories</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-4">
    <a href="/admin/users" class="text-decoration-none">
      <div class="card h-100 card-accent-emerald" style="transition:transform .2s;">
        <div class="card-body text-center py-4">
          <div class="icon-circle icon-circle-md mx-auto mb-3" style="background:linear-gradient(135deg,#ecfdf5,#d1fae5);">
            <i class="bi bi-people" style="color:var(--tk-emerald); font-size:1.5rem;"></i>
          </div>
          <h5 class="fw-bold">Voir les Utilisateurs</h5>
          <p class="text-muted mb-0">Liste des membres inscrits</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-4">
    <a href="/admin/exchanges" class="text-decoration-none">
      <div class="card h-100 card-accent-indigo" style="transition:transform .2s;">
        <div class="card-body text-center py-4">
          <div class="icon-circle icon-circle-md mx-auto mb-3" style="background:linear-gradient(135deg,#eef2ff,#e0e7ff);">
            <i class="bi bi-arrow-repeat" style="color:var(--tk-indigo); font-size:1.5rem;"></i>
          </div>
          <h5 class="fw-bold">Historique Échanges</h5>
          <p class="text-muted mb-0">Tous les échanges de la plateforme</p>
        </div>
      </div>
    </a>
  </div>
</div>
