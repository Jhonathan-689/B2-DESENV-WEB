<?php if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); } ?>
<nav class="navbar is-link" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="index.php"><strong>Biblioteca</strong></a>
    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navMain">
      <span aria-hidden="true"></span><span aria-hidden="true"></span><span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navMain" class="navbar-menu">
    <div class="navbar-start">
      <a class="navbar-item" href="index.php">Início</a>
      <a class="navbar-item" href="livros.php">Livros</a>
      <a class="navbar-item" href="api.php">API</a>
      <a class="navbar-item" href="https://openlibrary.org/developers/api" >Documentação </a>
      <a class="navbar-item" href="sobre.php">Quem Somos</a>
    </div>
    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
          <!-- tag com contraste: fundo claro azul e texto escuro -->
          <span class="tag is-info is-light is-medium">
            <?php echo isset($_SESSION['usuario']) ? 'Olá, ' . htmlspecialchars($_SESSION['usuario']) : 'Visitante'; ?>
          </span>
          <a class="button is-danger" href="logout.php">Sair</a>
        </div>
      </div>
    </div>
  </div>
</nav>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const burgers = Array.from(document.querySelectorAll('.navbar-burger'));
    burgers.forEach(b => {
      b.addEventListener('click', () => {
        const target = document.getElementById(b.dataset.target);
        b.classList.toggle('is-active');
        target.classList.toggle('is-active');
      });
    });
  });
</script>
