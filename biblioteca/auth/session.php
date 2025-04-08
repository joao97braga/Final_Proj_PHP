<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['leitor_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ../auth/login.php');
        exit;
    }
}

function getUserId() {
    return $_SESSION['leitor_id'] ?? null;
}

function getUserName() {
    return $_SESSION['nome'] ?? 'Visitante';
}

function isAdmin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == true;
}

function requireAdmin() {
    if (!isLoggedIn() || !isAdmin()) {
        header('Location: ../auth/login.php');
        exit;
    }
}
?>