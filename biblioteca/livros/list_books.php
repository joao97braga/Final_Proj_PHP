<?php
include '../config.php';

$sql = "SELECT * FROM Livro";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Livros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include '../includes/header.php'; ?>
    <?php include '../includes/navbar.php'; ?>
    <h1>Lista de Livros</h1>
    <a href="add_book.php">Adicionar Livro</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Gênero</th>
            <th>Ano de Publicação</th>
            <th>ISBN</th>
            <th>Ações</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['LIVRO_ID']; ?></td>
                <td><?php echo $row['Titulo']; ?></td>
                <td><?php echo $row['Genero']; ?></td>
                <td><?php echo $row['Ano_Publicacao']; ?></td>
                <td><?php echo $row['ISBN']; ?></td>
                <td>
                    <a href="edit_book.php?id=<?php echo $row['LIVRO_ID']; ?>">Editar</a>
                    <a href="delete_book.php?id=<?php echo $row['LIVRO_ID']; ?>" onclick="return confirm('Tem certeza que deseja apagar este livro?');">Apagar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>

</html>

<?php
$conn->close();
?>