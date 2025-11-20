<?php
session_start();


$caminhoArquivo = 'data/usuarios.json';


$usuario = trim($_POST['usuario'] ?? '');
$senha = trim($_POST['senha'] ?? '');
$confirmar = trim($_POST['confirmar_senha'] ?? '');




if ($usuario === '' || $senha === '' || $confirmar === '') {
    $_SESSION['erro_registro'] = "Preencha todos os campos.";
    header("Location: registro.php");
    exit;
}


if ($senha !== $confirmar) {
    $_SESSION['erro_registro'] = "As senhas não coincidem.";
    header("Location: registro.php");
    exit;
}


if (!file_exists($caminhoArquivo)) {
    file_put_contents($caminhoArquivo, json_encode([]));
}


$usuarios = json_decode(file_get_contents($caminhoArquivo), true);


if (!is_array($usuarios)) {
    $usuarios = [];
}


foreach ($usuarios as $u) {
    if ($u['usuario'] === $usuario) {
        $_SESSION['erro_registro'] = "Usuário já existe!";
        header("Location: registro.php");
        exit;
    }
}


$usuarios[] = [
    'usuario' => $usuario,
    'senha' => $senha
];


file_put_contents($caminhoArquivo, json_encode($usuarios, JSON_PRETTY_PRINT));


$_SESSION['sucesso_registro'] = "Registrado com sucesso! Faça login.";


header("Location: login.php");
exit;
?>
