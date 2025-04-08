<?php
include '../config.php';
include '../auth/session.php';

// Filtro de pesquisa
$pesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';
$genero = isset($_GET['genero']) ? $_GET['genero'] : '';

// Montar a consulta SQL com base nos filtros
$sql = "SELECT l.*, a.Primeiro_Nome, a.Ultimo_Nome FROM Livro l
        LEFT JOIN Livro_Autor la ON l.LIVRO_ID = la.Livro_ID
        LEFT JOIN Autor a ON la.Autor_ID = a.Autor_ID
        WHERE 1=1";

if (!empty($pesquisa)) {
    $sql .= " AND (l.Titulo LIKE '%$pesquisa%' OR l.ISBN LIKE '%$pesquisa%')";
}

if (!empty($genero)) {
    $sql .= " AND l.Genero = '$genero'";
}

$sql .= " GROUP BY l.LIVRO_ID ORDER BY l.Titulo";
$result = $conn->query($sql);

// Obter lista de gêneros para o filtro
$sql_generos = "SELECT DISTINCT Genero FROM Livro WHERE Genero IS NOT NULL AND Genero != '' ORDER BY Genero";
$result_generos = $conn->query($sql_generos);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Catálogo de Livros</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <?php include '../includes/navbar.php'; ?>
    
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Catálogo de Livros</h3>
            </div>
            <div class="card-body">
                <form method="GET" action="" class="mb-4">
                    <div class="row">
                        <div class="col-md-5">
                            <input type="text" name="pesquisa" class="form-control" placeholder="Pesquisar por título ou ISBN" value="<?php echo $pesquisa; ?>">
                        </div>
                        <div class="col-md-5">
                            <select name="genero" class="form-control">
                                <option value="">Todos os Gêneros</option>
                                <?php while ($row_genero = $result_generos->fetch_assoc()): ?>
                                    <option value="<?php echo $row_genero['Genero']; ?>" <?php echo ($genero == $row_genero['Genero']) ? 'selected' : ''; ?>><?php echo $row_genero['Genero']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                        </div>
                    </div>
                </form>
                
                <div class="row">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $row['Titulo']; ?></h5>
                                        <p class="card-text"><strong>ISBN:</strong> <?php echo $row['ISBN']; ?></p>
                                        <p class="card-text"><strong>Gênero:</strong> <?php echo $row['Genero'] ?: 'Não especificado'; ?></p>
                                        <p class="card-text"><strong>Ano:</strong> <?php echo $row['Ano_Publicacao'] ?: 'Não especificado'; ?></p>
                                        <?php if ($row['Primeiro_Nome'] && $row['Ultimo_Nome']): ?>
                                            <p class="card-text"><strong>Autor:</strong> <?php echo $row['Primeiro_Nome'] . ' ' . $row['Ultimo_Nome']; ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (isLoggedIn()): ?>
                                        <div class="card-footer">
                                            <a href="../frontoffice/conta/solicitar_emprestimo.php?livro=<?php echo $row['LIVRO_ID']; ?>" class="btn btn-primary btn-sm">Solicitar Empréstimo</a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <p class="text-center">Nenhum livro encontrado</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <?php include '../includes/footer.php'; ?>
</body>
</html>

<?php
$conn->close();
?>