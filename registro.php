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

<section class="hero is-fullheight is-primary">
  <div class="hero-body">
    <div class="container">
      <div class="columns is-centered">
        <div class="column is-4">
          <div class="box">
            <h1 class="title has-text-white has-text-centered">Registrar</h1>

            <form action="validar_registro.php" method="post">

              <div class="field">
                <label class="label">Nome de Usuário</label>
                <div class="control">
                  <input class="input" type="text" name="usuario" required>
                </div>
              </div>

              <div class="field">
                <label class="label">Senha</label>
                <div class="control">
                  <input class="input" type="password" name="senha" required>
                </div>
              </div>

              <div class="field">
                <label class="label">Confirmar Senha</label>
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

            <p class="has-text-centered is-size-7 mt-3">
              <strong>Já tem conta? </strong> <a href="login.php">Clique Aqui</a>
            </p>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
