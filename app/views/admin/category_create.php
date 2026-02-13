<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card card-accent-emerald overflow-hidden">
      <div class="card-header header-emerald">
        <h4 class="mb-0 text-white"><i class="bi bi-plus-circle me-2"></i>Nouvelle Catégorie</h4>
      </div>
      <div class="card-body p-4">
        <form method="post" action="/admin/categories/new">
          <div class="mb-3">
            <label for="name" class="form-label fw-bold">Nom de la catégorie</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Ex: Électronique, Livres..." required autofocus>
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-emerald"><i class="bi bi-check-circle me-1"></i>Créer</button>
            <a href="/admin/categories" class="btn btn-outline-secondary">Annuler</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
