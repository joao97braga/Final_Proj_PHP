<?php
include '../config.php';
include '../auth/session.php';

requireLogin();

if (isset($_GET['id'])) {
    $autor_id = $_GET['id'];
    
    // Verificar se o autor tem livros associados
    $sql_check = "SELECT * FROM Livro_Autor WHERE Autor_ID = $autor_id";
    $result_check = $conn->query($sql_check);
    
    if ($result_check->num_rows > 0) {
        // O autor tem livros associados
        $_SESSION['error'] = "Não é possível eliminar o autor pois possui livros associados.";
    } else {
        // Excluir o autor
        $sql_delete = "DELETE FROM Autor WHERE Autor_ID = $autor_id";
        
        if ($conn->query($sql_delete) === TRUE) {
            $_SESSION['success'] = "Autor eliminado com sucesso!";
        } else {
            $_SESSION['error'] = "Erro ao eliminar autor: " . $conn->error;
        }
    }
}

$conn->close();
header('Location: list_authors.php');
exit;
?>