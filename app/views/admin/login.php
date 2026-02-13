<div class="row justify-content-center">
  <div class="col-md-5 col-lg-4">
    <div class="text-center mb-4 mt-3">
      <div class="auth-icon-circle mx-auto" style="background:linear-gradient(135deg,#1e1b4b,#312e81);">
        <i class="bi bi-shield-lock" style="color:var(--tk-amber);"></i>
      </div>
      <h3 class="fw-bold mt-3">Administration</h3>
      <p class="text-muted">Panneau d'administration Takalo-takalo</p>
    </div>
    <div class="card card-accent-amber">
      <div class="card-body p-4">
        <form method="post" action="/admin/login">
          <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Identifiant / E-mail</label>
            <div class="input-group">
              <span class="input-group-text" style="background:#fff7ed;"><i class="bi bi-person" style="color:var(--tk-amber);"></i></span>
              <input type="text" class="form-control" id="email" name="email" value="admin" required autofocus>
            </div>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Mot de passe</label>
            <div class="input-group">
              <span class="input-group-text" style="background:#fff7ed;"><i class="bi bi-lock" style="color:var(--tk-amber);"></i></span>
              <input type="password" class="form-control" id="password" name="password" value="admin" required>
            </div>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-lg btn-amber fw-bold">
              <i class="bi bi-shield-lock me-2"></i>Connexion Admin
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
