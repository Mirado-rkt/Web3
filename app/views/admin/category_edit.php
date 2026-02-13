<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card card-accent-amber overflow-hidden">
      <div class="card-header header-amber">
        <h4 class="mb-0 text-white"><i class="bi bi-pencil me-2"></i>Éditer la Catégorie</h4>
      </div>
      <div class="card-body p-4">
        <form method="post" action="/admin/categories/edit/<?= $category['id'] ?>">
          <div class="mb-3">
            <label for="name" class="form-label fw-bold">Nom de la catégorie</label>
            <input type="text" class="form-control" id="name" name="name" 
                   value="<?= htmlspecialchars($category['name'] ?? '') ?>" required autofocus>
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-amber"><i class="bi bi-check-circle me-1"></i>Mettre à jour</button>
            <a href="/admin/categories" class="btn btn-outline-secondary">Annuler</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
