<div class="d-flex justify-content-between align-items-center mb-4">
  <h2 class="fw-bold section-title"><i class="bi bi-tags me-2" style="color:var(--tk-coral);"></i>Gestion des Catégories</h2>
  <a href="/admin/categories/new" class="btn btn-emerald">
    <i class="bi bi-plus-circle me-1"></i>Nouvelle catégorie
  </a>
</div>

<?php if (empty($categories)): ?>
  <div class="card card-accent-coral text-center py-4">
    <div class="card-body">
      <div class="icon-circle icon-circle-md mx-auto mb-3" style="background:linear-gradient(135deg,#fff7ed,#ffedd5);">
        <i class="bi bi-info-circle" style="color:var(--tk-coral); font-size:1.5rem;"></i>
      </div>
      <p class="mb-0">Aucune catégorie pour le moment. Créez-en une !</p>
    </div>
  </div>
<?php else: ?>
  <div class="card card-accent-coral overflow-hidden">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead>
          <tr style="background:linear-gradient(135deg,var(--tk-coral),#fb923c); color:#fff;">
            <th>#</th><th>Nom de la catégorie</th><th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($categories as $cat): ?>
            <tr>
              <td class="fw-bold"><?= $cat['id'] ?></td>
              <td><?= htmlspecialchars($cat['name']) ?></td>
              <td class="text-end">
                <a href="/admin/categories/edit/<?= $cat['id'] ?>" class="btn btn-sm btn-amber me-1">
                  <i class="bi bi-pencil me-1"></i>Éditer
                </a>
                <a href="/admin/categories/delete/<?= $cat['id'] ?>" 
                   class="btn btn-sm" style="border-color:var(--tk-rose); color:var(--tk-rose);"
                   onclick="return confirm('Supprimer cette catégorie ?')">
                  <i class="bi bi-trash me-1"></i>Supprimer
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
<?php endif; ?>

<div class="mt-3">
  <a href="/admin" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Retour au dashboard</a>
</div>
