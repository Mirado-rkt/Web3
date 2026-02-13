<div class="row justify-content-center">
  <div class="col-md-8 col-lg-7">
    <div class="card card-accent-amber overflow-hidden">
      <div class="card-header header-amber py-3">
        <h4 class="mb-0 text-white"><i class="bi bi-pencil me-2"></i>Éditer : <?= htmlspecialchars($item['title'] ?? '') ?></h4>
      </div>
      <div class="card-body p-4">
        <form method="post" action="/item/<?= $item['id'] ?>/update" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="title" class="form-label fw-bold">Titre *</label>
            <input type="text" class="form-control" id="title" name="title"
                   value="<?= htmlspecialchars($item['title'] ?? '') ?>" required>
          </div>
          <div class="mb-3">
            <label for="description" class="form-label fw-bold">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4"><?= htmlspecialchars($item['description'] ?? '') ?></textarea>
          </div>
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label for="category_id" class="form-label fw-bold">Catégorie</label>
              <select class="form-select" id="category_id" name="category_id">
                <option value="">-- Choisir --</option>
                <?php foreach ($categories ?? [] as $cat): ?>
                  <option value="<?= $cat['id'] ?>" <?= ((string)($item['category_id'] ?? '') === (string)$cat['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6">
              <label for="estimated_price" class="form-label fw-bold">Prix estimatif (Ar)</label>
              <input type="number" class="form-control" id="estimated_price" name="estimated_price" step="0.01" min="0"
                     value="<?= htmlspecialchars($item['estimated_price'] ?? 0) ?>">
            </div>
          </div>

          <?php if (!empty($item['photos'])): ?>
            <div class="mb-3">
              <label class="form-label fw-bold">Photos actuelles</label>
              <div class="d-flex gap-2 flex-wrap">
                <?php foreach ($item['photos'] as $photo): ?>
                  <div class="position-relative">
                    <img src="/<?= htmlspecialchars($photo['file_path']) ?>" class="rounded border" style="width:100px;height:100px;object-fit:cover;">
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>

          <div class="mb-3">
            <label for="photos" class="form-label fw-bold">Ajouter de nouvelles photos</label>
            <input type="file" class="form-control" id="photos" name="photos[]" multiple accept="image/*">
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-amber"><i class="bi bi-check-circle me-1"></i>Mettre à jour</button>
            <a href="/my/items" class="btn btn-outline-secondary">Annuler</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
