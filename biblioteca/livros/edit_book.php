<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $livro_id = $_POST['livro_id'];
    $titulo = $_POST['titulo'];
    $genero = $_POST['genero'];
    $ano_publicacao = $_POST['ano_publicacao'];
    $isbn = $_POST['isbn'];
    $sql = "UPDATE LIVRO SET Titulo='$titulo', Genero='$genero', Ano_Publicacao=$ano_publicacao, ISBN='$isbn' WHERE LIVRO_ID=$livro_id";

    if ($conn->query($sql) === TRUE) {
        echo "Livro atualizado com sucesso!";
        header('Location: list_books.php');
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
} else {
    $livro_id = $_GET['id'];
    $sql = "SELECT * FROM Livro WHERE LIVRO_ID=$livro_id";
    $result = $conn->query($sql);
    $livro = $result->fetch_assoc();
}

$conn->close();
?>

<!DOCTYPE html>
<html>

    <head>
        <title>Editar Livro</title>
    </head>

    <body>
        <h1>Editar Livro</h1>
        <form method="POST" action="">
            <input type="hidden" name="livro_id" value="<?php echo $livro['LIVRO_ID']; ?>">
            <label>Título:</label><br>
            <input type="text" name="titulo" value="<?php echo $livro['Titulo']; ?>" required><br>
            <label>Gênero:</label><br>
            <input type="text" name="genero" value="<?php echo $livro['Genero']; ?>"><br>
            <label>Ano de Publicação:</label><br>
            <input type="number" name="ano_publicacao" value="<?php echo $livro['Ano_Publicacao']; ?>"><br>
            <label>ISBN:</label><br>
            <input type="text" name="isbn" value="<?php echo $livro['ISBN']; ?>" required><br><br>
            <input type="submit" value="Atualizar">
        </form>
        <a href="list_books.php">Voltar para a Lista de Livros</a>
    </body>

</html>