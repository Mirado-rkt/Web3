<?php $nonce = htmlspecialchars(\Flight::app()->get('csp_nonce')); ?>
<div class="row justify-content-center">
  <div class="col-md-5 col-lg-4">
    <div class="text-center mb-4">
      <div class="auth-icon-circle mx-auto" style="background:linear-gradient(135deg,#eef2ff,#e0e7ff);">
        <i class="bi bi-box-arrow-in-right" style="color:var(--tk-indigo);"></i>
      </div>
      <h3 class="fw-bold mt-3">Connexion</h3>
      <p class="text-muted">Accédez à votre compte Takalo-takalo</p>
    </div>
    <div class="card card-accent-indigo">
      <div class="card-body p-4">
        <form method="post" action="/login">
          <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Adresse e-mail</label>
            <div class="input-group">
              <span class="input-group-text" style="background:#eef2ff;"><i class="bi bi-envelope" style="color:var(--tk-indigo);"></i></span>
              <input type="email" class="form-control" id="email" name="email" placeholder="votre@email.com" required autofocus>
            </div>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Mot de passe</label>
            <div class="input-group">
              <span class="input-group-text" style="background:#eef2ff;"><i class="bi bi-lock" style="color:var(--tk-indigo);"></i></span>
              <input type="password" class="form-control" id="password" name="password" placeholder="Votre mot de passe" required>
            </div>
          </div>
          <div class="d-grid mb-3">
            <button type="submit" class="btn btn-lg" style="background:linear-gradient(135deg,var(--tk-indigo),var(--tk-teal)); color:#fff;">
              <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
            </button>
          </div>
        </form>
        <div class="text-center">
          <button id="prefillAdmin" class="btn btn-sm btn-amber"><i class="bi bi-shield-lock me-1"></i>Test Admin</button>
        </div>
        <hr>
        <p class="text-center mb-0">
          Pas encore de compte ? <a href="/register" class="fw-bold text-decoration-none" style="color:var(--tk-coral);">S'inscrire</a>
        </p>
      </div>
    </div>
  </div>
</div>

<script nonce="<?= $nonce ?>">
  document.getElementById('prefillAdmin').addEventListener('click', function(e){
    e.preventDefault();
    document.getElementById('email').value = 'admin';
    document.getElementById('password').value = 'admin';
    document.getElementById('email').focus();
  });
</script>
