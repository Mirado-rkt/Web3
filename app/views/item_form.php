<div class="row justify-content-center">
  <div class="col-md-8 col-lg-7">
    <div class="card card-accent-emerald overflow-hidden">
      <div class="card-header header-emerald py-3">
        <h4 class="mb-0 text-white"><i class="bi bi-plus-circle me-2"></i>Ajouter un Objet</h4>
      </div>
      <div class="card-body p-4">
        <form method="post" action="/item/save" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="title" class="form-label fw-bold">Titre *</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Ex: Casque Bluetooth, Livre..." required>
          </div>
          <div class="mb-3">
            <label for="description" class="form-label fw-bold">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Décrivez votre objet..."></textarea>
          </div>
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label for="category_id" class="form-label fw-bold">Catégorie</label>
              <select class="form-select" id="category_id" name="category_id">
                <option value="">-- Choisir --</option>
                <?php foreach ($categories ?? [] as $cat): ?>
                  <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6">
              <label for="estimated_price" class="form-label fw-bold">Prix estimatif (Ar)</label>
              <input type="number" class="form-control" id="estimated_price" name="estimated_price" step="0.01" min="0" value="0">
            </div>
          </div>
          <div class="mb-3">
            <label for="photos" class="form-label fw-bold">Photos (plusieurs possibles)</label>
            <input type="file" class="form-control" id="photos" name="photos[]" multiple accept="image/*">
            <div class="form-text">Formats acceptés : JPG, PNG, GIF. Plusieurs photos possibles.</div>
          </div>

          <?php
            $existingImages = glob(__DIR__ . '/../../assets/images/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
            if (!empty($existingImages)):
          ?>
          <div class="mb-3">
            <label class="form-label fw-bold">Ou choisir parmi les images existantes</label>
            <div class="d-flex gap-3 flex-wrap">
              <?php foreach ($existingImages as $img):
                $basename = basename($img);
              ?>
                <label class="position-relative" style="cursor:pointer;">
                  <input type="checkbox" name="existing_photos[]" value="<?= htmlspecialchars($basename) ?>" class="position-absolute top-0 start-0 m-1">
                  <img src="/assets/images/<?= htmlspecialchars($basename) ?>" class="rounded border" style="width:80px;height:80px;object-fit:cover;">
                </label>
              <?php endforeach; ?>
            </div>
          </div>
          <?php endif; ?>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-emerald"><i class="bi bi-check-circle me-1"></i>Enregistrer</button>
            <a href="/my/items" class="btn btn-outline-secondary">Annuler</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
