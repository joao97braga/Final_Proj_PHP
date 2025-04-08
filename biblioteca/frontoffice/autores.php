<?php
include '../config.php';
include '../auth/session.php';

// Filtro de pesquisa
$pesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';

// Montar a consulta SQL com base nos filtros
$sql = "SELECT a.*, COUNT(la.Livro_ID) as total_livros FROM Autor a
        LEFT JOIN Livro_Autor la ON a.Autor_ID = la.Autor_ID
        WHERE 1=1";

if (!empty($pesquisa)) {
    $sql .= " AND (a.Primeiro_Nome LIKE '%$pesquisa%' OR a.Ultimo_Nome LIKE '%$pesquisa%')";
}

$sql .= " GROUP BY a.Autor_ID ORDER BY a.Ultimo_Nome, a.Primeiro_Nome";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Autores</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <?php include '../includes/navbar.php'; ?>
    
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Autores</h3>
            </div>
            <div class="card-body">
                <form method="GET" action="" class="mb-4">
                    <div class="row">
                        <div class="col-md-10">
                            <input type="text" name="pesquisa" class="form-control" placeholder="Pesquisar por nome do autor" value="<?php echo $pesquisa; ?>">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Pesquisar</button>
                        </div>
                    </div>
                </form>
                
                <div class="row">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $row['Primeiro_Nome'] . ' ' . $row['Ultimo_Nome']; ?></h5>
                                        <?php if ($row['Data_Aniversario']): ?>
                                            <p class="card-text"><strong>Data de Nascimento:</strong> <?php echo date('d/m/Y', strtotime($row['Data_Aniversario'])); ?></p>
                                        <?php endif; ?>
                                        <p class="card-text"><strong>Total de Livros:</strong> <?php echo $row['total_livros']; ?></p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="autor_livros.php?id=<?php echo $row['Autor_ID']; ?>" class="btn btn-primary btn-sm">Ver Livros</a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <p class="text-center">Nenhum autor encontrado</p>
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