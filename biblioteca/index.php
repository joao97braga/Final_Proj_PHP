<?php
include 'config.php';
include 'auth/session.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca - Sistema de Gestão</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include 'includes/header.php'; ?>
    <?php include 'includes/navbar.php'; ?>

    <div class="container mt-5">
        <div class="jumbotron">
            <h1 class="display-4">Bem-vindo à BookLib</h1>
            <p class="lead">Sistema de Gestão de Biblioteca para administrar livros, autores, leitores e empréstimos.</p>
            <hr class="my-4">
            <p>Utilize as opções abaixo para navegar pelo sistema.</p>
        </div>

        <div class="row mt-5">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Livros</h5>
                        <p class="card-text">Gerir catálogo de livros</p>
                        <a href="livros/list_books.php" class="btn btn-primary">Aceder</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Autores</h5>
                        <p class="card-text">Gerir autores de livros</p>
                        <a href="autores/list_authors.php" class="btn btn-primary">Aceder</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Leitores</h5>
                        <p class="card-text">Gerir registo de leitores</p>
                        <a href="leitores/list_readers.php" class="btn btn-primary">Aceder</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Empréstimos</h5>
                        <p class="card-text">Gerir empréstimos de livros</p>
                        <a href="emprestimos/list_loans.php" class="btn btn-primary">Aceder</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>

</html>