<?php include 'includes/auth.php'; ?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<section class="section">
  <div class="container">
    <section class="hero is-link">
      <div class="hero-body">
        <p class="title">Gerencie seu acervo de forma simples</p>
      </div>
    </section>

    <div class="columns mt-5 is-variable is-5">
      <div class="column is-half">
        <div class="card" style="height:100%;">
          <header class="card-header">
            <p class="card-header-title">Livros cadastrados</p>
          </header>
          <div class="card-content">
            <div class="content has-text-centered">
              <?php
              $livros = json_decode(@file_get_contents('data/livros.json'), true) ?? [];
              echo '<span class="tag is-info is-medium">' . count($livros) . '</span>';
              ?>
              <p class="is-size-7 mt-2">Total no acervo</p>
            </div>
          </div>
        </div>
      </div>

      <div class="column is-half">
        <div class="card" style="height:100%;">
          <header class="card-header">
            <p class="card-header-title">Ações rápidas</p>
          </header>
          <div class="card-content">
            <div class="buttons is-centered">
              <a class="button is-link" href="livros.php">Ir para Livros</a>
              <a class="button is-info" href="api.php">API</a>
              <a class="button is-light" href="sobre.php">Quem Somos</a>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>