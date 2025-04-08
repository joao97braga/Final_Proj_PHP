<?php
include 'config.php';

$sql = "SELECT * FROM Livro";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Lista de Livros</title>
</head>

<body>
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