<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $genero = $_POST['genero'];
    $ano_publicacao = $_POST['ano_publicacao'];
    $isbn = $_POST['isbn'];

    $sql = "INSERT INTO Livro (titulo, genero, ano_publicacao, isbn) VALUES ('$titulo', '$genero', $ano_publicacao, '$isbn')";

    if ($conn->query($sql) === TRUE) {
        echo "Livro adicionado com sucesso!";
        header('Location: list_books.php');
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Livro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include '../includes/header.php'; ?>
    <?php include '../includes/navbar.php'; ?>
    <h1>Adicionar Livro</h1>
    <form method="POST" action="">
        <label>Título:</label><br>
        <input type="text" name="titulo" required><br>
        <label>Gênero:</label><br>
        <input type="text" name="genero"><br>
        <label>Ano de Publicação:</label><br>
        <input type="number" name="ano_publicacao"><br>
        <label>ISBN:</label><br>
        <input type="text" name="isbn" required><br><br>
        <input type="submit" value="Adicionar">
    </form>
    <a href="list_books.php">Voltar para a Lista de Livros</a>
</body>

</html>