<h2 class="mb-4 fw-bold section-title"><i class="bi bi-people me-2" style="color:var(--tk-emerald);"></i>Liste des Utilisateurs</h2>

<?php if (empty($users)): ?>
  <div class="card card-accent-emerald text-center py-4">
    <div class="card-body"><p class="mb-0 text-muted">Aucun utilisateur inscrit.</p></div>
  </div>
<?php else: ?>
  <div class="card card-accent-emerald overflow-hidden">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead>
          <tr style="background:linear-gradient(135deg,var(--tk-emerald),var(--tk-teal)); color:#fff;">
            <th>#</th><th>Nom</th><th>E-mail</th><th>Inscrit le</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users as $u): ?>
            <tr>
              <td><?= $u['id'] ?></td>
              <td class="fw-bold"><?= htmlspecialchars($u['name']) ?></td>
              <td><?= htmlspecialchars($u['email']) ?></td>
              <td><?= date('d/m/Y H:i', strtotime($u['created_at'])) ?></td>
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
