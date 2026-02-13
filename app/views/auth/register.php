<div class="row justify-content-center">
  <div class="col-md-5 col-lg-4">
    <div class="text-center mb-4">
      <div class="auth-icon-circle mx-auto" style="background:linear-gradient(135deg,#ecfdf5,#d1fae5);">
        <i class="bi bi-person-plus" style="color:var(--tk-emerald);"></i>
      </div>
      <h3 class="fw-bold mt-3">Inscription</h3>
      <p class="text-muted">Rejoignez la communauté Takalo-takalo</p>
    </div>
    <div class="card card-accent-emerald">
      <div class="card-body p-4">
        <form method="post" action="/register">
          <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Nom complet</label>
            <div class="input-group">
              <span class="input-group-text" style="background:#ecfdf5;"><i class="bi bi-person" style="color:var(--tk-emerald);"></i></span>
              <input type="text" class="form-control" id="name" name="name" placeholder="Votre nom" required autofocus>
            </div>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Adresse e-mail</label>
            <div class="input-group">
              <span class="input-group-text" style="background:#ecfdf5;"><i class="bi bi-envelope" style="color:var(--tk-emerald);"></i></span>
              <input type="email" class="form-control" id="email" name="email" placeholder="votre@email.com" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Mot de passe</label>
            <div class="input-group">
              <span class="input-group-text" style="background:#ecfdf5;"><i class="bi bi-lock" style="color:var(--tk-emerald);"></i></span>
              <input type="password" class="form-control" id="password" name="password" placeholder="Choisissez un mot de passe" required>
            </div>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-lg" style="background:linear-gradient(135deg,var(--tk-emerald),var(--tk-teal)); color:#fff;">
              <i class="bi bi-person-plus me-2"></i>Créer mon compte
            </button>
          </div>
        </form>
        <hr>
        <p class="text-center mb-0">
          Déjà inscrit ? <a href="/login" class="fw-bold text-decoration-none" style="color:var(--tk-indigo);">Se connecter</a>
        </p>
      </div>
    </div>
  </div>
</div>
