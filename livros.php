<?php
include 'includes/auth.php';

$arquivo = 'data/livros.json';

// garante que o arquivo exista e seja um JSON de array
if (!file_exists($arquivo)) {
  @file_put_contents($arquivo, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

$conteudo = @file_get_contents($arquivo);
$livros = json_decode($conteudo, true);

// fallback caso o JSON esteja inválido
if (!is_array($livros)) {
  $livros = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {

  foreach ($livros as &$liv) {
      if ($liv['id'] == $_POST['id']) {
          $liv['titulo'] = $_POST['titulo'];
          $liv['autor'] = $_POST['autor'];
          $liv['ano'] = $_POST['ano'];
      }
  }

  file_put_contents($arquivo, json_encode($livros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
  header('Location: livros.php');
  exit;
}

// adicionar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titulo'], $_POST['autor'])) {
  $titulo = trim((string)$_POST['titulo']);
  $autor  = trim((string)$_POST['autor']);
  $ano    = trim((string)($_POST['ano'] ?? ''));

  if ($titulo !== '' && $autor !== '') {
    $novo = [
      'id'     => uniqid('liv_', true),
      'titulo' => $titulo,
      'autor'  => $autor,
      'ano'    => $ano,
    ];
    $livros[] = $novo;

    // salva com LOCK_EX
    file_put_contents(
      $arquivo,
      json_encode($livros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
      LOCK_EX
    );
  }

  // evita reenvio do form
  header('Location: livros.php');
  exit;
}

if (isset($_GET['del'])) {
  $id = (string)$_GET['del'];

  // remove pelo id
  $livros = array_values(array_filter($livros, fn($l) => ($l['id'] ?? '') !== $id));

  file_put_contents(
    $arquivo,
    json_encode($livros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
    LOCK_EX
  );

  header('Location: livros.php');
  exit;
}

// (Opcional, futuro) busca/edição podem ser preparadas aqui e repassadas à view

$editLivro = null;

if (isset($_GET['edit'])) {
    foreach ($livros as $l) {
        if ($l['id'] == $_GET['edit']) {
            $editLivro = $l;
            break;
        }
    }
}


// chama a view (a view usará $livros)
include 'livros.view.php';
