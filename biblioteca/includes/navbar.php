<?php
// session_start();
$current_path = $_SERVER['PHP_SELF'];
$path_parts = explode('/', $current_path);
$depth = count(array_intersect($path_parts, ['includes', 'livros', 'autores', 'leitores', 'emprestimos', 'frontoffice', 'auth']));
$basePath = '';

for($i = 0; $i < $depth; $i++) {
    $basePath .= '../';
}
$basePath = rtrim($basePath, '/');

if ($basePath === '') {
    $basePath = ' .';
}

$isLoggedIn = isset($_SESSION['leitor_id']);
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-2">
    <div class="container">
        <a class="navbar-brand" href="<?php echo $basePath; ?>/index.php">Home</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">                
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $basePath; ?>/livros/list_books.php">Livros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $basePath; ?>/autores/list_authors.php">Autores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $basePath; ?>/leitores/list_readers.php">Leitores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $basePath; ?>/emprestimos/list_loans.php">Empréstimos</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php if ($isLoggedIn): ?>
                    <li class="nav-item">
                        <span class="nav-link">Olá, <?php echo $_SESSION['nome']; ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $basePath; ?>/auth/logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $basePath; ?>/auth/login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $basePath; ?>/frontoffice/conta/register.php">Registrar</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>