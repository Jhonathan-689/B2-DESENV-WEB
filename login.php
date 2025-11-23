<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
if (isset($_SESSION['usuario'])) {
  header('Location: index.php');
  exit;
}

include 'includes/header.php';
?>

<section class="hero is-fullheight" style="background: linear-gradient(135deg, #1e3a8a, #9333ea);">
  <div class="hero-body">
    <div class="container">
      <div class="columns is-centered">
        <div class="column is-4">
          <div class="box" style="background:#f5f5f5; border-radius:14px;">

            <h1 class="title has-text-centered" style="color:#000;">Login</h1>

            <?php if (isset($_SESSION['erro_login'])): ?>
              <div class="notification is-danger has-text-centered" style="border-radius: 0;">
                <?= $_SESSION['erro_login']; ?>
                <?php unset($_SESSION['erro_login']); ?>
              </div>
            <?php endif; ?>

            <form action="valida_login.php" method="post">
              <div class="field">
                <label class="label" style="color:#111;">Usuário</label>
                <div class="control">
                  <input class="input" type="text" name="usuario" required>
                </div>
              </div>

              <div class="field">
                <label class="label" style="color:#111;">Senha</label>
                <div class="control">
                  <input class="input" type="password" name="senha" required>
                </div>
              </div>

              <div class="field">
                <div class="control">
                  <button class="button is-link is-fullwidth" type="submit">Entrar</button>
                </div>
              </div>
            </form>

            <p class="has-text-centered is-size-7 mt-3" style="color:#111 !important;">
              <strong style="color:#111 !important;">Registrar-se: </strong>
              <a href="registro.php" style="color:#1d4ed8; font-weight:600;">Clique Aqui</a>
            </p>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>