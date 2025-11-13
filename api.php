<?php
include 'includes/auth.php';

// Importar livro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['import'])) {
  $arquivo = 'data/livros.json';
  if (!file_exists($arquivo)) {
    file_put_contents($arquivo, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
  }

  $livros = json_decode(file_get_contents($arquivo), true);
  if (!is_array($livros)) $livros = [];

  $titulo = trim($_POST['titulo'] ?? '');
  $autor  = trim($_POST['autor'] ?? '');
  $ano    = trim($_POST['ano'] ?? '');

  if ($titulo !== '' && $autor !== '') {
    $novo = [
      'id'     => uniqid('liv_', true),
      'titulo' => $titulo,
      'autor'  => $autor,
      'ano'    => $ano,
    ];
    $livros[] = $novo;
    file_put_contents($arquivo, json_encode($livros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    header('Location: livros.php');
    exit;
  }
}

// Função auxiliar
function buscarNomesAutores(array $autores): array
{
  $nomes = [];
  foreach ($autores as $a) {
    $key = $a['key'] ?? '';
    if (!$key) continue;
    $dadosAutor = @file_get_contents('https://openlibrary.org' . $key . '.json');
    if ($dadosAutor) {
      $obj = json_decode($dadosAutor, true);
      if (isset($obj['name'])) $nomes[] = $obj['name'];
    }
    if (count($nomes) >= 3) break;
  }
  return $nomes;
}

// Buscar livro
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
      $titulo = $dados['title'] ?? '';
      $pages  = $dados['number_of_pages'] ?? '';
      $pub    = $dados['publish_date'] ?? '';
      $ano    = (preg_match('/\b(\d{4})\b/', $pub, $m)) ? $m[1] : '';
      $autores = !empty($dados['authors']) ? buscarNomesAutores($dados['authors']) : [];
      $autorStr = implode(', ', $autores);

      $book = [
        'isbn'   => $isbn,
        'title'  => $titulo,
        'authors' => $autorStr,
        'pages'  => $pages,
        'date'   => $pub,
        'year'   => $ano,
      ];
    }
  }
}
// Inclui a view
include 'api.view.php';
