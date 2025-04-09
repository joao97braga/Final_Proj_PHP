<?php
include '../config.php';
include '../auth/session.php';

// Handle search and filtering
$search = isset($_GET['search']) ? $_GET['search'] : '';
$genero = isset($_GET['genero']) ? $_GET['genero'] : '';

// Build the SQL query
$sql = "SELECT l.*, 
        GROUP_CONCAT(CONCAT(a.Primeiro_Nome, ' ', a.Ultimo_Nome) SEPARATOR ', ') as autores
        FROM Livro l
        LEFT JOIN Livro_Autor la ON l.LIVRO_ID = la.Livro_ID
        LEFT JOIN Autor a ON la.Autor_ID = a.Autor_ID
        WHERE 1=1";

if (!empty($search)) {
    $sql .= " AND (l.Titulo LIKE '%$search%' OR l.ISBN LIKE '%$search%')";
}

if (!empty($genero)) {
    $sql .= " AND l.Genero = '$genero'";
}

$sql .= " GROUP BY l.LIVRO_ID ORDER BY l.Titulo";
$result = $conn->query($sql);

// Get unique genres for filter dropdown
$sql_generos = "SELECT DISTINCT Genero FROM Livro WHERE Genero IS NOT NULL AND Genero != '' ORDER BY Genero";
$result_generos = $conn->query($sql_generos);

// Success and error messages
$message = '';
if (isset($_SESSION['success'])) {
    $message = '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']);
} elseif (isset($_SESSION['error'])) {
    $message = '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Livros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <?php include '../includes/navbar.php'; ?>
    
    <div class="container mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>Lista de Livros</h3>
                <a href="add_book.php" class="btn btn-primary">Adicionar Livro</a>
            </div>
            <div class="card-body">
                <?php echo $message; ?>
                
                <div class="mb-4">
                    <form method="GET" action="" class="row g-3">
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="search" placeholder="Pesquisar por título ou ISBN" value="<?php echo $search; ?>">
                        </div>
                        <div class="col-md-5">
                            <select class="form-select" name="genero">
                                <option value="">Todos os Gêneros</option>
                                <?php while ($row_genero = $result_generos->fetch_assoc()): ?>
                                    <option value="<?php echo $row_genero['Genero']; ?>" <?php echo ($genero == $row_genero['Genero']) ? 'selected' : ''; ?>>
                                        <?php echo $row_genero['Genero']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                        </div>
                    </form>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Autores</th>
                                <th>Gênero</th>
                                <th>Ano</th>
                                <th>ISBN</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['LIVRO_ID']; ?></td>
                                        <td><?php echo $row['Titulo']; ?></td>
                                        <td><?php echo $row['autores'] ?: '-'; ?></td>
                                        <td><?php echo $row['Genero'] ?: '-'; ?></td>
                                        <td><?php echo $row['Ano_Publicacao'] ?: '-'; ?></td>
                                        <td><?php echo $row['ISBN']; ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="edit_book.php?id=<?php echo $row['LIVRO_ID']; ?>" class="btn btn-sm btn-primary">Editar</a>
                                                <a href="delete_book.php?id=<?php echo $row['LIVRO_ID']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja apagar este livro?');">Apagar</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">Nenhum livro encontrado</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <?php include '../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="../js/script.js"></script>
</body>
</html>

<?php
$conn->close();
?>