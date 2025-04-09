<?php
include '../config.php';
include '../auth/session.php';

requireLogin();

if (isset($_GET['id'])) {
    $livro_id = $_GET['id'];
    
    // First check if the book has any active loans
    $sql_check = "SELECT * FROM Emprestimo WHERE Livro_ID = $livro_id AND Date_Entrega IS NULL";
    $result_check = $conn->query($sql_check);
    
    if ($result_check->num_rows > 0) {
        // Book has active loans
        $_SESSION['error'] = "Não é possível eliminar o livro pois possui empréstimos ativos.";
    } else {
        // First delete from Livro_Autor (foreign key constraint)
        $sql_delete_la = "DELETE FROM Livro_Autor WHERE Livro_ID = $livro_id";
        $conn->query($sql_delete_la);
        
        // Then delete the book
        $sql_delete = "DELETE FROM Livro WHERE LIVRO_ID = $livro_id";
        
        if ($conn->query($sql_delete) === TRUE) {
            $_SESSION['success'] = "Livro eliminado com sucesso!";
        } else {
            $_SESSION['error'] = "Erro ao eliminar livro: " . $conn->error;
        }
    }
}

$conn->close();
header('Location: list_books.php');
exit;
?>