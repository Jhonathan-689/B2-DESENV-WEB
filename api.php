<?php
include 'includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['import'])) {

  $arquivo = 'data/livros.json';

  if (!file_exists($arquivo)) {
    file_put_contents($arquivo, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
  }

  $livros = json_decode(file_get_contents($arquivo), true);
  if (!is_array($livros)) {
    $livros = [];
  }

  $titulo = trim($_POST['titulo'] ?? '');
  $autor = trim($_POST['autor'] ?? '');
  $ano = trim($_POST['ano'] ?? '');

  $autorNormalizado = $autor !== '' ? $autor : 'Autor não informado';

  if ($titulo !== '') {

    $duplicado = false;
    foreach ($livros as $livro) {
      $tituloExistente = mb_strtolower($livro['titulo'] ?? '');
      $autorExistente = mb_strtolower($livro['autor'] ?? '');

      if (
        $tituloExistente === mb_strtolower($titulo)
        && $autorExistente === mb_strtolower($autorNormalizado)
      ) {
        $duplicado = true;
        break;
      }
    }

    if ($duplicado) {
      header('Location: api.php?duplicado=1&titulo=' . urlencode($titulo));
      exit;
    }

    $livros[] = [
      'id' => uniqid('liv_', true),
      'titulo' => $titulo,
      'autor' => $autorNormalizado,
      'ano' => $ano,
    ];

    file_put_contents(
      $arquivo,
      json_encode($livros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
    );

    header('Location: livros.php');
    exit;
  }

  header('Location: api.php');
  exit;
}
function buscarNomesAutores(array $autores): array
{
  $nomes = [];
  foreach ($autores as $a) {
    $key = $a['key'] ?? '';
    if (!$key) {
      continue;
    }

    $jsonAutor = @file_get_contents('https://openlibrary.org' . $key . '.json');
    if ($jsonAutor) {
      $obj = json_decode($jsonAutor, true);
      if (isset($obj['name'])) {
        $nomes[] = $obj['name'];
      }
    }

    if (count($nomes) >= 3) {
      break;
    }
  }

  return $nomes;
}

$isbn = trim($_GET['isbn'] ?? '');
$book = null;
$erro = '';

if ($isbn !== '') {
  $json = @file_get_contents('https://openlibrary.org/isbn/' . urlencode($isbn) . '.json');

  if (!$json) {
    $erro = 'Não foi possível acessar a API.';
  } else {
    $dados = json_decode($json, true);

    if (!is_array($dados) || isset($dados['error'])) {
      $erro = 'Livro não encontrado.';
    } else {
      $autores = !empty($dados['authors']) ? buscarNomesAutores($dados['authors']) : [];

      $book = [
        'isbn' => $isbn,
        'title' => $dados['title'] ?? '',
        'authors' => implode(', ', $autores),
        'pages' => $dados['number_of_pages'] ?? '',
        'date' => $dados['publish_date'] ?? '',
        'year' => preg_match('/\b(\d{4})\b/', $dados['publish_date'] ?? '', $m) ? $m[1] : '',
      ];
    }
  }
}

include 'api.view.php';
