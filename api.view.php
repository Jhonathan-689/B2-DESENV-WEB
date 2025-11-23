<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<section class="section">
    <div class="container">
        <h1 class="title">Integração com API</h1>
        <p class="subtitle">Buscar dados de livros por ISBN (Open Library)</p>

        <div class="box">
            <h2 class="title is-5">Buscar Livro por ISBN</h2>

            <form method="get" class="mb-4" id="form-busca-api">
                <div class="field has-addons">
                    <div class="control is-expanded">
                        <input class="input" type="text" name="isbn" value="<?= htmlspecialchars($isbn) ?>"
                            placeholder="Ex.: 9780140328721">
                    </div>
                    <div class="control">
                        <button class="button is-link" id="botao-buscar">Buscar</button>
                    </div>
                </div>
            </form>

            <?php if ($erro): ?>
                <article class="message is-danger">
                    <div class="message-body"><?= htmlspecialchars($erro) ?></div>
                </article>
            <?php elseif ($book): ?>
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">Resultado para ISBN: <?= htmlspecialchars($book['isbn']) ?></p>
                    </header>
                    <div class="card-content">
                        <div class="content">
                            <p><strong>Título:</strong> <?= htmlspecialchars($book['title']) ?></p>
                            <p><strong>Autor(es):</strong> <?= $book['authors'] ?: '<em>Não informado</em>' ?></p>
                            <p><strong>Páginas:</strong> <?= $book['pages'] ?: '<em>—</em>' ?></p>
                            <p><strong>Publicação:</strong> <?= htmlspecialchars($book['date'] ?: '—') ?></p>
                            <p><strong>Ano:</strong> <?= htmlspecialchars($book['year'] ?: '—') ?></p>
                        </div>
                    </div>
                    <footer class="card-footer">
                        <form method="post" action="api.php" class="card-footer-item">
                            <input type="hidden" name="import" value="1">
                            <input type="hidden" name="titulo" value="<?= htmlspecialchars($book['title']) ?>">
                            <input type="hidden" name="autor" value="<?= htmlspecialchars($book['authors']) ?>">
                            <input type="hidden" name="ano" value="<?= htmlspecialchars($book['year']) ?>">
                            <input type="hidden" name="isbn" value="<?= htmlspecialchars($book['isbn']) ?>">
                            <button type="submit" class="button is-success">
                                Importar para a Biblioteca
                            </button>
                        </form>
                    </footer>
                </div>
            <?php else: ?>
                <article class="message is-info">
                    <div class="message-body">
                        Digite um ISBN e clique em <strong>Buscar</strong> para consultar o livro na Open Library.
                    </div>
                </article>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('form-busca-api');
        const botao = document.getElementById('botao-buscar');

        if (form && botao) {
            form.addEventListener('submit', function () {
                botao.classList.add('is-loading');
                botao.setAttribute('disabled', 'disabled');
            });
        }
    });
</script>