<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }

$json = file_get_contents('data/usuarios.json');
$usuarios = json_decode($json, true) ?? [];

$usuario = $_POST['usuario'] ?? '';
$senha   = $_POST['senha'] ?? '';

$autenticado = false;
foreach ($usuarios as $u) {
    if ($u['usuario'] === $usuario && $u['senha'] === $senha) {
        $autenticado = true;
        break;
    }
}

if ($autenticado) {
    $_SESSION['usuario'] = $usuario;
    header('Location: index.php');
    exit;
}

header('Location: login.php');
exit;
