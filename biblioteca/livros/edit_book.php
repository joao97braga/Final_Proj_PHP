<?php
include '../config.php';

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Livro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include '../includes/header.php'; ?>
    <?php include '../includes/navbar.php'; ?>
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