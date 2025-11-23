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
          <div class="box has-background-light">

            <h1 class="title has-text-centered" style="color:#111 !important;">Registrar</h1>

            <form action="validar_registro.php" method="post">

              <div class="field">
                <label class="label" style="color:#111 !important;">Nome de Usuário</label>
                <div class="control">
                  <input class="input" type="text" name="usuario" required>
                </div>
              </div>

              <div class="field">
                <label class="label" style="color:#111 !important;">Senha</label>
                <div class="control">
                  <input class="input" type="password" name="senha" required>
                </div>
              </div>

              <div class="field">
                <label class="label" style="color:#111 !important;">Confirmar Senha</label>
                <div class="control">
                  <input class="input" type="password" name="confirmar_senha" required>
                </div>
              </div>

              <div class="field">
                <div class="control">
                  <button class="button is-link is-fullwidth" type="submit">Registrar</button>
                </div>
              </div>

            </form>

            <p class="has-text-centered is-size-7 mt-3" style="color:#111 !important;">
              <strong style="color:#111 !important;">Já tem conta?</strong>
              <a href="login.php" style="color:#1d4ed8; font-weight:600;">Clique Aqui</a>
            </p>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>