<?php
include '../config.php';
include '../auth/session.php';

// Obter livros recentes
$sql_livros = "SELECT * FROM Livro ORDER BY LIVRO_ID DESC LIMIT 5";
$result_livros = $conn->query($sql_livros);

// Obter autores
$sql_autores = "SELECT * FROM Autor ORDER BY Ultimo_Nome, Primeiro_Nome LIMIT 5";
$result_autores = $conn->query($sql_autores);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Biblioteca - Portal</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <?php include '../includes/navbar.php'; ?>
    
    <div class="container mt-5">
        <div class="jumbotron">
            <h1 class="display-4">Bem-vindo à Biblioteca</h1>
            <p class="lead">Explore nosso catálogo de livros e conheça nossos autores.</p>
            <hr class="my-4">
            <p>Crie uma conta para emprestar livros e gerenciar seus empréstimos.</p>
            <?php if (!isLoggedIn()): ?>
                <a class="btn btn-primary btn-lg" href="../frontoffice/conta/login.php" role="button">Login</a>
                <a class="btn btn-secondary btn-lg" href="../frontoffice/conta/register.php" role="button">Criar Conta</a>
            <?php endif; ?>
        </div>
        
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Livros Recentes</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <?php if ($result_livros->num_rows > 0): ?>
                                <?php while ($livro = $result_livros->fetch_assoc()): ?>
                                    <li class="list-group-item">
                                        <h5><?php echo $livro['Titulo']; ?></h5>
                                        <p>Gênero: <?php echo $livro['Genero'] ?: 'Não especificado'; ?></p>
                                        <p>Ano: <?php echo $livro['Ano_Publicacao'] ?: 'Não especificado'; ?></p>
                                    </li>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <li class="list-group-item">Nenhum livro encontrado</li>
                            <?php endif; ?>
                        </ul>
                        <div class="mt-3">
                            <a href="livros.php" class="btn btn-primary">Ver Todos os Livros</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Autores em Destaque</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <?php if ($result_autores->num_rows > 0): ?>
                                <?php while ($autor = $result_autores->fetch_assoc()): ?>
                                    <li class="list-group-item">
                                        <h5><?php echo $autor['Primeiro_Nome'] . ' ' . $autor['Ultimo_Nome']; ?></h5>
                                    </li>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <li class="list-group-item">Nenhum autor encontrado</li>
                            <?php endif; ?>
                        </ul>
                        <div class="mt-3">
                            <a href="autores.php" class="btn btn-primary">Ver Todos os Autores</a>
                        </div>
                    </div>
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