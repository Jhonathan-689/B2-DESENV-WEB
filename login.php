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
          <h1 class="title has-text-white has-text-centered">Login</h1>

            <!--Aqui a Parte do Erro !-->

            <?php if (isset($_GET['erro'])): ?>

               <div class="notification is-danger">Usuário ou senha incorretos.</div>

            <?php endif; ?>


             <form action="valida_login.php" method="post">
              <div class="field">
                <label class="label">Usuário</label>
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
                <div class="control">
                  <button class="button is-link is-fullwidth" type="submit">Entrar</button>
                </div>
              </div>
            </form>

            <p class="has-text-centered is-size-7 mt-3">
              <strong>Dica:</strong> veja <code>data/usuarios.json</code>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>