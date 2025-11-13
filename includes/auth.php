<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}
