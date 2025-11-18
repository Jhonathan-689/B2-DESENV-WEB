<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<?php 

$editando = false;
$editarLivro = null;

if (isset($_GET['edit'])) {
   $id = $_GET['edit'];
   foreach ($livros as $liv) {
      if ($liv['id'] == $id) {
      $editarLivro = $liv;
      $editando = true;
break;
}
}
}
?>

<section class="section">
    <div class="container">
        <h1 class="title">Livros</h1>
        <h2 class="subtitle">Gerencie o acervo</h2>

        <div class="columns">
            <div class="column is-5">
                <div class="box">
                    <h3 class="title is-5">Adicionar Livro</h3>
                    <form method="post" autocomplete="off">
                        <div class="field">
                            <label class="label">Título</label>
                            <div class="control">
                                <input class="input" name="titulo" value="<?= $editando ? htmlspecialchars($editarLivro['titulo']) : '' ?>" required>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Autor</label>
                            <div class="control">
                                <input class="input" name="autor" value="<?= $editando ? htmlspecialchars($editarLivro['autor']) : '' ?>" required>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Ano</label>
                            <div class="control">
                                <input class="input" name="ano" type="number" min="0" value= "<?=$editando ? htmlspecialchars($editarLivro['ano']) : '' ?>" placeholder="Opcional">
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <button class="button is-link">
                                    <?= $editando ? "Salvar Alterações" : "Salvar" ?>
                                </button>
                            </div>
                        </div>
                    </form>

                    </div>
            </div>

            <div class="column">
                <div class="box">
                    <h3 class="title is-5">Lista de Livros</h3>

                    <form method="get">
                       <input type="text" name="q" placeholder="Buscar..." value="<?= isset($_GET['q']) ? $_GET['q'] : '' ?>">
                       <button>Procurar</button>
                   </form>
                   <hr>

                    <table class="table is-fullwidth is-striped is-hoverable">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Autor</th>
                                <th>Ano</th>
                                <th class="has-text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($livros)): ?>
                                <tr>
                                    <td colspan="4">Nenhum livro cadastrado.</td>
                                </tr>
                                <?php else: foreach ($livros as $l): ?>
                                    <tr>
                                        <td><?= htmlspecialchars((string)($l['titulo'] ?? '')) ?></td>
                                        <td><?= htmlspecialchars((string)($l['autor'] ?? '')) ?></td>
                                        <td><?= htmlspecialchars((string)($l['ano'] ?? '')) ?></td>
                                        <td class="has-text-right">
                                        <a class="button is-small is-warning" href="livros.php?edit=<?= $l['id']; ?>">Editar</a>
                                            <a class="button is-small is-danger"
                                                href="livros.php?del=<?= urlencode((string)($l['id'] ?? '')) ?>"
                                                onclick="return confirm('Excluir este livro?')">
                                                Excluir
                                            </a>
                                        </td>
                                    </tr>
                            <?php endforeach;
                            endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>