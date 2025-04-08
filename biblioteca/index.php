<?php
include 'config.php';
include 'auth/session.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Biblioteca - Sistema de Gestão</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <?php include 'includes/navbar.php'; ?>
    
    <div class="container mt-5">
        <div class="jumbotron">
            <h1 class="display-4">Bem-vindo à Biblioteca</h1>
            <p class="lead">Sistema de Gestão de Biblioteca para administrar livros, autores, leitores e empréstimos.</p>
            <hr class="my-4">
            <p>Utilize as opções abaixo para navegar pelo sistema.</p>
        </div>
        
        <div class="row mt-5">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Livros</h5>
                        <p class="card-text">Gerenciar catálogo de livros</p>
                        <a href="livros/list_books.php" class="btn btn-primary">Acessar</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Autores</h5>
                        <p class="card-text">Gerenciar autores de livros</p>
                        <a href="autores/list_authors.php" class="btn btn-primary">Acessar</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Leitores</h5>
                        <p class="card-text">Gerenciar cadastro de leitores</p>
                        <a href="leitores/list_readers.php" class="btn btn-primary">Acessar</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Empréstimos</h5>
                        <p class="card-text">Gerenciar empréstimos de livros</p>
                        <a href="emprestimos/list_loans.php" class="btn btn-primary">Acessar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>