<?php
include '../config.php';
include '../auth/session.php';

requireLogin();

if (isset($_GET['id'])) {
    $leitor_id = $_GET['id'];
    
    // Verificar se o leitor tem empréstimos pendentes
    $sql_check = "SELECT * FROM Emprestimo WHERE Leitor_ID = $leitor_id AND Date_Entrega IS NULL";
    $result_check = $conn->query($sql_check);
    
    if ($result_check->num_rows > 0) {
        // Leitor tem empréstimos pendentes
        $_SESSION['error'] = "Não é possível eliminar o leitor pois possui empréstimos pendentes.";
    } else {
        // Excluir o leitor
        $sql_delete = "DELETE FROM Leitor WHERE Leitor_ID = $leitor_id";
        
        if ($conn->query($sql_delete) === TRUE) {
            $_SESSION['success'] = "Leitor eliminado com sucesso!";
        } else {
            $_SESSION['error'] = "Erro ao eliminar leitor: " . $conn->error;
        }
    }
}

$conn->close();
header('Location: list_readers.php');
exit;
?>