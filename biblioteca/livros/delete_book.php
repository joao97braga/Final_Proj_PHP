<?php
include '../config.php';

$livro_id = $_GET['id'];
$sql = "DELETE FROM livro WHERE Livro_ID=$livro_id";

if ($conn->query($sql) === TRUE) {
    echo "Livro eliminado com sucesso!";
} else {
    echo "Erro ao eliminar: " . $conn->error;
}

$conn->close();
header('Location: list_books.php');
?>
