<?php
include 'includes/auth.php';

$arquivo = 'data/livros.json';

if (!file_exists($arquivo)) {
  @file_put_contents($arquivo, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

$conteudo = @file_get_contents($arquivo);
$livros = json_decode($conteudo, true);

if (!is_array($livros)) {
  $livros = [];
}

if (isset($_GET['q']) && trim($_GET['q']) !== '') {
  $q = mb_strtolower(trim($_GET['q']));

  $livros = array_filter($livros, function ($l) use ($q) {
    return
      strpos(mb_strtolower($l['titulo'] ?? ''), $q) !== false ||
      strpos(mb_strtolower($l['autor'] ?? ''), $q) !== false ||
      strpos(mb_strtolower((string) ($l['ano'] ?? '')), $q) !== false;
  });

  $livros = array_values($livros);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {

  foreach ($livros as &$liv) {
    if ($liv['id'] == $_POST['id']) {
      $liv['titulo'] = $_POST['titulo'] ?? '';
      $liv['autor'] = $_POST['autor'] ?? '';
      $liv['ano'] = $_POST['ano'] ?? '';
      $liv['isbn'] = $_POST['isbn'] ?? '';
    }
  }
  unset($liv);

  file_put_contents($arquivo, json_encode($livros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
  header('Location: livros.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titulo'], $_POST['autor']) && !isset($_POST['id'])) {
  $titulo = trim((string) $_POST['titulo']);
  $autor = trim((string) $_POST['autor']);
  $ano = trim((string) ($_POST['ano'] ?? ''));
  $isbn = trim((string) ($_POST['isbn'] ?? ''));

  if ($titulo !== '' && $autor !== '') {
    $novo = [
      'id' => uniqid('liv_', true),
      'titulo' => $titulo,
      'autor' => $autor,
      'ano' => $ano,
      'isbn' => $isbn,
    ];
    $livros[] = $novo;

    file_put_contents(
      $arquivo,
      json_encode($livros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
      LOCK_EX
    );
  }

  header('Location: livros.php');
  exit;
}

if (isset($_GET['del'])) {
  $id = (string) $_GET['del'];
  $livros = array_values(array_filter($livros, fn($l) => ($l['id'] ?? '') !== $id));

  file_put_contents(
    $arquivo,
    json_encode($livros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
    LOCK_EX
  );

  header('Location: livros.php');
  exit;
}

$editLivro = null;

if (isset($_GET['edit'])) {
  foreach ($livros as $l) {
    if ($l['id'] == $_GET['edit']) {
      $editLivro = $l;
      break;
    }
  }
}

$editId = "";
$editTitulo = "";
$editAutor = "";
$editAno = "";
$editIsbn = "";

if (isset($_GET['edit'])) {
  foreach ($livros as $l) {
    if ($l['id'] === $_GET['edit']) {
      $editId = $l['id'] ?? '';
      $editTitulo = $l['titulo'] ?? '';
      $editAutor = $l['autor'] ?? '';
      $editAno = $l['ano'] ?? '';
      $editIsbn = $l['isbn'] ?? '';

      break;
    }
  }
}

include 'livros.view.php';
