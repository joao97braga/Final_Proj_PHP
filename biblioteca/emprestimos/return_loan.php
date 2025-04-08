<?php
include '../config.php';
include '../auth/session.php';

requireLogin();

if (isset($_GET['id'])) {
    $emprestimo_id = $_GET['id'];
    
    // Marcar como devolvido com a data atual
    $today = date('Y-m-d');
    $sql = "UPDATE Emprestimo SET Date_Entrega = '$today' WHERE Emprestimo_ID = $emprestimo_id";
    
    if ($conn->query($sql) === TRUE) {
        $_SESSION['success'] = "Livro devolvido com sucesso!";
    } else {
        $_SESSION['error'] = "Erro ao registrar devolução: " . $conn->error;
    }
} else {
    $_SESSION['error'] = "ID de empréstimo não especificado.";
}

$conn->close();
header('Location: list_loans.php');
exit;
?>